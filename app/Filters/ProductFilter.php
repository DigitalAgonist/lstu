<?php

namespace App\Filters;
use Illuminate\Support\Arr;

class ProductFilter extends QueryFilter {
   public function search($search = null) {
        return $this->builder->when($search, function($query) use($search) {
            $query ->where('name', 'ILIKE', '%'.$search[0].'%')
            ->orWhere('description', 'ILIKE', '%'.$search[0].'%');
        });

   }
}
