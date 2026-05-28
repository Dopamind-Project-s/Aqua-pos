<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceRequestController extends Controller
{
    public function index(Request $request): View
    {
        $tab = (string) $request->query('tab', 'demo_request');
        $allowedTabs = ['demo_request', 'support_request', 'contact_request'];

        if (! in_array($tab, $allowedTabs, true)) {
            $tab = 'demo_request';
        }

        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'in:new,in_progress,closed'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        $demoRequests = $this->queryByType('demo_request', $validated)
            ->paginate(10, ['*'], 'demo_page')
            ->withQueryString();

        $supportRequests = $this->queryByType('support_request', $validated)
            ->paginate(10, ['*'], 'support_page')
            ->withQueryString();

        $contactRequests = $this->queryByType('contact_request', $validated)
            ->paginate(10, ['*'], 'contact_page')
            ->withQueryString();

        return view('admin.requests.index', [
            'tab' => $tab,
            'demoRequests' => $demoRequests,
            'supportRequests' => $supportRequests,
            'contactRequests' => $contactRequests,
            'filters' => $validated,
            'statusOptions' => [
                'new' => 'New',
                'in_progress' => 'In Progress',
                'closed' => 'Closed',
            ],
        ]);
    }

    public function updateStatus(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,in_progress,closed'],
        ]);

        $serviceRequest->update(['status' => $validated['status']]);

        return back()->with('success', 'Request status updated successfully.');
    }

    private function queryByType(string $type, array $filters): Builder
    {
        return ServiceRequest::query()
            ->with('selectedPartner')
            ->where('type', $type)
            ->when(! empty($filters['search']), function (Builder $query) use ($filters): void {
                $search = trim((string) $filters['search']);
                $query->where(function (Builder $inner) use ($search): void {
                    $inner->where('full_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%")
                        ->orWhereHas('selectedPartner', function (Builder $partnerQuery) use ($search): void {
                            $partnerQuery->where('name_ar', 'like', "%{$search}%")
                                ->orWhere('name_en', 'like', "%{$search}%")
                                ->orWhere('map_location_ar', 'like', "%{$search}%")
                                ->orWhere('map_location_en', 'like', "%{$search}%");
                        });
                });
            })
            ->when(! empty($filters['status']), fn (Builder $query) => $query->where('status', $filters['status']))
            ->when(! empty($filters['date_from']), fn (Builder $query) => $query->whereDate('created_at', '>=', $filters['date_from']))
            ->when(! empty($filters['date_to']), fn (Builder $query) => $query->whereDate('created_at', '<=', $filters['date_to']))
            ->latest();
    }
}
