<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Models\ServiceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceRequestController extends Controller
{
    public function contactForm(): View
    {
        return view('requests.contact');
    }

    public function supportForm(): View
    {
        return view('requests.support');
    }

    public function demoForm(): View
    {
        return view('requests.demo');
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        $serviceRequest = ServiceRequest::query()->create($request->validated());

        return back()
            ->with('success', 'Your request has been submitted successfully.')
            ->with('tracking_event', [
                'event' => 'generate_lead',
                'form_type' => $serviceRequest->type,
                'source_page' => $serviceRequest->source_page,
            ]);
    }
}
