<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(): View
    {
        $clients = Client::query()
            ->where('is_active', true)
            ->with('category')
            ->orderBy('sort_order')
            ->orderBy('name_en')
            ->paginate(12)
            ->withQueryString();

        return view('clients', compact('clients'));
    }
}
