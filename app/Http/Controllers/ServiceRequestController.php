<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Mail\DemoRequestSubmitted;
use App\Models\Partner;
use App\Models\ServiceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ServiceRequestController extends Controller
{
    public function contactForm(Request $request): View
    {
        $selectedPartner = null;

        if ($request->filled('partner')) {
            $selectedPartner = Partner::query()
                ->where('slug', $request->string('partner')->toString())
                ->where('is_active', true)
                ->first();
        }

        return view('requests.contact', compact('selectedPartner'));
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
        $payload = $request->validated();

        if (! empty($payload['selected_partner_id'])) {
            $partner = Partner::query()->find($payload['selected_partner_id']);

            if ($partner) {
                $payload['selected_partner_snapshot'] = [
                    'id' => $partner->id,
                    'slug' => $partner->slug,
                    'name_ar' => $partner->name_ar,
                    'name_en' => $partner->name_en,
                    'map_location_ar' => $partner->map_location_ar,
                    'map_location_en' => $partner->map_location_en,
                    'map_latitude' => $partner->map_latitude,
                    'map_longitude' => $partner->map_longitude,
                ];
            }
        }

        $serviceRequest = ServiceRequest::query()->create($payload);

        $mailSent = true;
        if (in_array($serviceRequest->type, ['demo_request', 'support_request'], true)) {
            try {
                Mail::to(config('services.demo_requests.recipient'))
                    ->send(new DemoRequestSubmitted($serviceRequest));
            } catch (\Throwable $exception) {
                $mailSent = false;
                try {
                    Log::error('Service request notification email failed.', [
                        'service_request_id' => $serviceRequest->id,
                        'type' => $serviceRequest->type,
                        'exception' => $exception,
                    ]);
                } catch (\Throwable) {
                    // A logging backend issue must not undo or interrupt the stored request.
                }
            }
        }

        $response = back()
            ->with('success', $mailSent
                ? 'Your request has been submitted successfully.'
                : 'Your request was saved, but the email notification could not be sent. Please contact us if this is urgent.')
            ->with('tracking_event', [
                'event' => 'generate_lead',
                'form_type' => $serviceRequest->type,
                'source_page' => $serviceRequest->source_page,
            ]);

        return $response;
    }
}
