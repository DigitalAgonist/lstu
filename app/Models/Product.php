<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;
    public $count = 0; //для прогнозирования

    public function raws() {
        return $this->belongsToMany(Raw::class)->withPivot('weight_g')->withTimestamps();
    }

    public static function forecast($products) {

        $rawCatalog = Raw::all(); // получаем каталог сырья


        foreach ($products as $product) {
           foreach ($product->raws as $raw) {
            $rawCatalog->find($raw)->weight += $raw->pivot->weight_g * $product->count;
           }
        }

        return $rawCatalog;
    }

    public function scopeFilter(Builder $builder, QueryFilter $filter){
        return $filter->apply($builder);
    }
}
