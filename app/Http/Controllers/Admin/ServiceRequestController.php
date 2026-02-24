<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceRequestController extends Controller
{
    public function index(Request $request): View
    {
        $tab = (string) $request->query('tab', 'demo_request');
        $allowed = ['demo_request', 'support_request', 'contact_request'];

        if (! in_array($tab, $allowed, true)) {
            $tab = 'demo_request';
        }

        $demoRequests = ServiceRequest::query()->where('type', 'demo_request')->latest()->paginate(10, ['*'], 'demo_page')->withQueryString();
        $supportRequests = ServiceRequest::query()->where('type', 'support_request')->latest()->paginate(10, ['*'], 'support_page')->withQueryString();
        $contactRequests = ServiceRequest::query()->where('type', 'contact_request')->latest()->paginate(10, ['*'], 'contact_page')->withQueryString();

        return view('admin.requests.index', compact('tab', 'demoRequests', 'supportRequests', 'contactRequests'));
    }
}
