<?php

namespace App\Filters;

class ProjectFilters extends QueryFilter
{
    // sorting
    public function ordDate($order='asc')
    {
        return $this->builder->orderBy('created_at', $order);
    }

    // filtering
    public function search($text)
    {
        return $this->builder->where('title', 'like', "%$text%");
    }
    public function status($status)
    {
        return $this->builder->where('status', '=', $status);
    }
    public function group($id)
    {
        return $this->builder->where('group_id', '=', $id);
    }
    public function speakersFrom($num)
    {
        return $this->builder->where('speakers', '>=', $num);
    }
    public function speakersTo($num)
    {
        return $this->builder->where('speakers', '<=', $num);
    }

    // paginate
    public function page($num)
    {
        $this->pageNum = $num;
    }
    public function perPage($num)
    {
        $this->itemsNum = $num;
    }
}
