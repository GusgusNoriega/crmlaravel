<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function show () {
        $products = Product::get();
        return view('welcome')->with('products', $products);
    }
  
}