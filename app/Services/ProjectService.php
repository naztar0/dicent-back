<?php

namespace App\Services;

use App\Events\ProjectEvent;
use App\Models\Project;
use App\Models\Transcribe;
use App\Jobs\UploadProjectFile;
use Aws\S3\S3Client;
use Aws\TranscribeService\TranscribeServiceClient;
use Aws\TranscribeService\Exception\TranscribeServiceException;
use Illuminate\Http\UploadedFile;

class ProjectService
{
    public function __construct(
        private S3Client $s3Client,
        private TranscribeServiceClient $tsClient
    ) {
    }

    public function saveAudiofile(UploadedFile $audiofile, Project $project)
    {
        $fileName = $audiofile->hashName();
        $audiofile->move(public_path('storage/audio'), $fileName);
        $project->update(['audiofile' => $fileName]);

        UploadProjectFile::dispatch($project->id);
    }

    public function uploadAudiofile(Project $project)
    {
        $file = public_path('storage/audio/' . $project->audiofile);

        $this->s3Client->putObject([
            'Bucket' => env('AWS_BUCKET'),
            'Key' => $project->audiofile,
            'SourceFile' => $file
        ]);

        unlink($file);
    }

    public function processAudiofile(Project $project)
    {
        $project = tap($project)->update(['job' => uniqid()]);
        $args = [
            'IdentifyLanguage' => true,
            'Media' => [
                'MediaFileUri' => "s3://" . env('AWS_BUCKET') . "/$project->audiofile",
            ],
            'OutputBucketName' => env('AWS_BUCKET'),
            'TranscriptionJobName' => $project->job,
        ];

        if ($project->speakers) {
            $args['Settings'] = [
                'ShowSpeakerLabels' => true,
                'MaxSpeakerLabels' => $project->speakers,
            ];
        }

        $this->tsClient->startTranscriptionJob($args);
    }

    public function checkResult(Project $project)
    {
        try {
            $result = $this->tsClient->getTranscriptionJob([
                'TranscriptionJobName' => $project->job
            ]);
            $project = tap($project)->update([
                'status' => $result['TranscriptionJob']['TranscriptionJobStatus']
            ]);
        } catch (TranscribeServiceException) {
            $project = tap($project)->update(['status' => Project::STATUS_FAILED]);
        }

        event(new ProjectEvent($project->id, $project->status));
    }

    public function processResult(Project $project)
    {
        $result = $this->s3Client->getObject([
            'Bucket' => env('AWS_BUCKET'),
            'Key' => "$project->job.json"
        ]);
        $data = json_decode($result['Body']->getContents(), true);

        if ($project->speakers) {
            $transcribes = array_map(function ($trans) use ($project) {
                $trans['project_id'] = $project->id;
                return $trans;
            }, $this->parseSpeakers($data));
            Transcribe::insert($transcribes);
        } else {
            Transcribe::create([
                'project_id' => $project->id, 'speaker' => 'spk',
                'content' => $data['results']['transcripts'][0]['transcript']
            ]);
        }
    }

    private function parseSpeakers($data)
    {
        $transcribes = [];
        $curr_trans = [];
        $segments = $data['results']['speaker_labels']['segments'];
        foreach ($data['results']['items'] as $item) {
            if ($item['type'] == 'pronunciation') {
                $found = false;
                foreach ($segments as $speakers) {
                    foreach ($speakers['items'] as $speaker) {
                        if ($item['start_time'] == $speaker['start_time']) {
                            $content = $item['alternatives'][0]['content'];
                            if ($curr_trans && $curr_trans['speaker'] == $speaker['speaker_label']) {
                                $curr_trans['content'] .= ' ' . $content;
                            } else {
                                if ($curr_trans) {
                                    $transcribes[] = $curr_trans;
                                }
                                $curr_trans['speaker'] = $speaker['speaker_label'];
                                $curr_trans['content'] = $content;
                            }
                            $found = true;
                            break;
                        }
                    }
                    if ($found) {
                        break;
                    }
                }
            } else {
                $curr_trans['content'] .= $item['alternatives'][0]['content'];
            }
        }
        return $transcribes;
    }
}
