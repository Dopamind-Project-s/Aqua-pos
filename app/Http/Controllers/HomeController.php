<?php

namespace App\Http\Controllers;

use App\Models\Client;

class HomeController extends Controller
{
    public function index()
    {
        $clients = Client::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name_en')
            ->get();

        return view('home', compact('clients'));
    }
}
