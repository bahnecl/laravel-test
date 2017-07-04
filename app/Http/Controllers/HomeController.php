<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Product;
use App\Invoice;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $title = "Heftige App";
        
        $products = Product::orderBy('price', 'DESC')->get();
        $invoices = Invoice::orderBy('date', 'DESC')->get();

        return view ('templates.home', compact('title', 'products', 'invoices'));
    }
}
