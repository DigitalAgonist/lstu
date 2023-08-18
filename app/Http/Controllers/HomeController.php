<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Http\Controllers\Auth;
use App\Filters\ProductFilter;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('index', ['data' => Product::orderBy('created_at', 'asc')->paginate(config('variable.paginate.product'))]);
    }

    public function filter(ProductFilter $filter) {
        $products = Product::filter($filter)->orderBy('created_at', 'asc')->paginate(config('variable.paginate.product'));
        return view('index', ['data' => $products]);
    }

}
