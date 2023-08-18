<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use \Illuminate\Support\Arr;
use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class Order extends Model
{
    use HasFactory;

    public function products() {
        return $this->belongsToMany(Product::class)->withPivot('quantity')->withTimestamps();
    }

    public function cost() {
        $cost = 0;

        foreach ($this->products as $products) {
           $cost += $products->price * $products->pivot->quantity;
        }

        return $cost;
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public static function forecast($begin, $end, $nYear) {
        $orders = null;
        $begin->subYears($nYear);
        $end->subYears($nYear);

        for($i = 0; $i < $nYear; $i++) {
           if($orders == null) {
            $orders = Order::whereDate('dateAndTime', '>=', $begin)->whereDate('dateAndTime', '<=', $end)->get();
           }
           else {
            $orders = $orders->concat(Order::whereDate('dateAndTime', '>=', $begin)->whereDate('dateAndTime', '<=', $end)->get());
           }

           $begin->addYear();
           $end->addYear();
        }

        $productCatalog = Product::all(); // получаем каталог продукции


        foreach ($orders as $order) {
           $products = $order->products;

           foreach ($products as $product) {
            $productCatalog->find($product)->count += $product->pivot->quantity;
           }
        }

        foreach ($productCatalog as $product) {
            $product->count = $product->count / $nYear;
        }

        return $productCatalog;
    }

    public function scopeFilter(Builder $builder, QueryFilter $filter){
        return $filter->apply($builder);
    }
}
