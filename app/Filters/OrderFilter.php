<?php

namespace App\Filters;


class OrderFilter extends QueryFilter {
    public function dateBegin($date = null) {
        return $this->builder->when($date, function($query) use($date) {
            $query->whereDate('dateAndTime', '>=', $date);
        });
    }

    public function dateEnd($date = null) {
        return $this->builder->when($date, function($query) use($date) {
            $query->whereDate('dateAndTime', '<=', $date);
        });
    }

    public function status($status) {
        return $this->builder->when($status, function($query) use($status) {
            $query->whereIn('status', $status);
        });
    }
}
