<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Filters\OrderFilter;

class OrderController extends Controller
{
    public function ordersFromUser($id, $title = null) {
        if($id == Auth::id() || Auth::user()->role_id > 1) {
            $orders = User::find($id)->orders()->where('status', '>',  0)->paginate(config('variable.paginate.table'));

            if($orders->count() == 0) {
                session()->flash('warning', 'Список заказов пуст!');
                return redirect()->route('index');
            }
            return view('orders', ['orders' =>  $orders, 'title' => "Заказы пользователя " .$title]);
        }
        else {
            session()->flash('warning', 'У Вас недостаточно прав');
            return redirect()->route('index');
        }
    }

    public function order($id) {
        $order = Order::find($id);

        if($order == null) {
            session()->flash('warning', 'Заказ не найден');
            return redirect()->route('index');
        }

        if($order->user->id == Auth::id() || Auth::user()->role_id > 1) {
            return view('order', ['order' =>  $order]);
        }
        else {
            session()->flash('warning', 'У Вас недостаточно прав');
            return redirect()->route('index');
        }

    }

    public function allOrders() {
        return view('admin.orders', ['orders' => Order::where('status' ,'>', 0)->orderBy('id', 'asc')->paginate(config('variable.paginate.table'))]);
    }

    public function complete($orderId, Request $request) {
        $order = Order::find($orderId);
        $order->status = 2;
        $order->save();
        return redirect()->back();
    }

    public function confirm($orderId, Request $request) {
        $order = Order::find($orderId);

        if($order->user->id != Auth::id()) {
            session()->flash('warning', 'У Вас нет прав на закрытие заказа других пользователей');
            return redirect()->route('index');
        }

        $order->status = 3;
        $order->save();
        return redirect()->back();
    }

    public function applyFilter(OrderFilter $request) {
        return view('admin.orders', ['orders' => Order::filter($request)->where('status' , '>', 0)->orderBy('id', 'asc')->paginate(config('variable.paginate.table')), 'request' => $request]);
    }

}
