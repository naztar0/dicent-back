<?php

namespace App\Filters;

class UserFilters extends QueryFilter
{
    // sorting
    public function ordDate($order='asc')
    {
        return $this->builder->orderBy('created_at', $order);
    }

    // filtering
    public function search($text)
    {
        return $this->builder->where('name', 'like', "%$text%");
    }
    public function role($role)
    {
        return $this->builder->where('role', '=', $role);
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
