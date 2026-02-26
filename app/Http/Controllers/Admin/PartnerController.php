<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReorderPartnerRequest;
use App\Http\Requests\Admin\StorePartnerRequest;
use App\Http\Requests\Admin\UpdatePartnerRequest;
use App\Models\Partner;
use App\Services\PartnerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function __construct(private readonly PartnerService $partnerService)
    {
    }

    public function index(): View
    {
        $partners = Partner::query()
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.partners.index', compact('partners'));
    }

    public function create(): View
    {
        return view('admin.partners.create');
    }

    public function store(StorePartnerRequest $request): RedirectResponse
    {
        $payload = $request->validated();
        $payload['is_active'] = $request->boolean('is_active');

        $this->partnerService->create($payload);

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Partner created successfully.');
    }

    public function edit(Partner $partner): View
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(UpdatePartnerRequest $request, Partner $partner): RedirectResponse
    {
        $payload = $request->validated();
        $payload['is_active'] = $request->boolean('is_active');

        $this->partnerService->update($partner, $payload);

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Partner updated successfully.');
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        $this->partnerService->delete($partner);

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Partner deleted successfully.');
    }

    public function toggleStatus(Partner $partner): JsonResponse
    {
        $partner->update(['is_active' => ! $partner->is_active]);

        return response()->json([
            'message' => 'Partner status updated.',
            'is_active' => $partner->is_active,
        ]);
    }

    public function reorder(ReorderPartnerRequest $request): JsonResponse
    {
        $this->partnerService->reorder($request->validated('ordered_ids'));

        return response()->json(['message' => 'Partners reordered successfully.']);
    }
}
