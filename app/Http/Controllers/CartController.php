<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CartController extends Controller
{
    public function index()
    {
        return view('cart');
    }

    public function checkout()
    {
        return view('checkout');
    }
}
