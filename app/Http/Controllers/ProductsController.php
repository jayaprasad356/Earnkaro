<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    // Show Works List Page
    public function index()
    {
   
        return view('my_products.index');
    }
    
}
