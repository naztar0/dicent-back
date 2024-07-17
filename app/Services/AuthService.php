<?php

namespace App\Services;

use Carbon\Carbon;

class AuthService
{
    public function resetPasswordToken(int $bytes = 32)
    {
        return substr(bin2hex(random_bytes($bytes)), 0, $bytes);
    }

    public function isTokenValid(int|string $created_at, int $hours = 1)
    {
        $now = Carbon::createFromFormat('m/d/Y H:i:s', Carbon::now());
        $created = Carbon::createFromFormat('m/d/Y H:i:s', $created_at);
        return $now->gte($created->addHours($hours));
    }
}
