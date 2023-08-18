<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BasketController extends Controller
{
    public function basket() {
        $order = Auth::user()->orders->where('status', 0)->first();

        if($order === null || $order->products()->count() == 0) {
            session()->flash('warning', 'Ваша корзина пуста!');
        }

        return view('basket', compact('order'));
    }

    public function addToBasket($productId) {
        $order = Auth::user()->orders->where('status', 0)->first();

        if(is_null($order)) {
            $order = Order::create();
            $order->user_id = Auth::id();
            $order->save();
        }

        if($order->products->contains($productId)) {
            $pivotRow = $order->products()->where('product_id', $productId)->first()->pivot;
            $pivotRow->quantity++;
            $pivotRow->update();
        }
        else {
            $order->products()->attach($productId);
        }

        return redirect()->route('basket');
    }

    public function removeFromBasket($productId) {
        $order = Auth::user()->orders->where('status', 0)->first();

        if (is_null($order)) {
            return redirect()->route('basket');
        }

        if ($order->products->contains($productId)) {
            $pivotRow = $order->products()->where('product_id', $productId)->first()->pivot;
            if ($pivotRow->quantity < 2) {
                $order->products()->detach($productId);
            }
            else {
                $pivotRow->quantity--;
                $pivotRow->update();
            }
        }

        return redirect()->route('basket');
    }

    public function order(Request $request) {

       //dd($request);
        $order = Auth::user()->orders->where('status', 0)->first();

        if ($order === null || $order->products()->count() == 0) {
            return redirect()->route('basket')->with('error', 'Заказ не найден в базе данных');
        }



        if($request->input('date') != null) {
            $order->preorder= $request->input('date');
        }

        $order->dateAndTime = Carbon::now();
        $order->commentary = $request->input('commentary');
        $order->status = 1;
        $order->save();

        return redirect()->route('index');
    }
}
