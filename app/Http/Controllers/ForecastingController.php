<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ForecastingRequest;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;

class ForecastingController extends Controller
{
    public function showPage() {
        return view('forecasting');
    }

    public function forecasting(ForecastingRequest $request) {
        $begin = Carbon::parse($request->input('dateBegin'));
        $end = Carbon::parse($request->input('dateEnd'));
        $nYear = 5; // сделать принимаемым параметром

        $products = Order::forecast($begin, $end, $nYear);
        $raws = Product::forecast($products);

        return view('forecasting', compact('products', 'raws'));
    }
}
