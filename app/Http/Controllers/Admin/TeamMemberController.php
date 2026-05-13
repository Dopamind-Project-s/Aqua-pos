<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeamMemberRequest;
use App\Http\Requests\Admin\UpdateTeamMemberRequest;
use App\Models\TeamMember;
use App\Services\TeamMemberService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    public function __construct(private readonly TeamMemberService $teamMemberService)
    {
    }

    public function index(): View
    {
        $teamMembers = TeamMember::query()
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.team-members.index', compact('teamMembers'));
    }

    public function create(): View
    {
        return view('admin.team-members.create');
    }

    public function store(StoreTeamMemberRequest $request): RedirectResponse
    {
        $payload = $request->validated();
        $payload['is_active'] = $request->boolean('is_active');

        $this->teamMemberService->create($payload);

        return redirect()
            ->route('admin.team-members.index')
            ->with('success', 'Team member created successfully.');
    }

    public function edit(TeamMember $teamMember): View
    {
        return view('admin.team-members.edit', compact('teamMember'));
    }

    public function update(UpdateTeamMemberRequest $request, TeamMember $teamMember): RedirectResponse
    {
        $payload = $request->validated();
        $payload['is_active'] = $request->boolean('is_active');

        $this->teamMemberService->update($teamMember, $payload);

        return redirect()
            ->route('admin.team-members.index')
            ->with('success', 'Team member updated successfully.');
    }

    public function destroy(TeamMember $teamMember): RedirectResponse
    {
        $this->teamMemberService->delete($teamMember);

        return redirect()
            ->route('admin.team-members.index')
            ->with('success', 'Team member deleted successfully.');
    }

    public function toggleStatus(TeamMember $teamMember): JsonResponse
    {
        $teamMember->update(['is_active' => ! $teamMember->is_active]);

        return response()->json([
            'message' => 'Team member status updated.',
            'is_active' => $teamMember->is_active,
        ]);
    }

    public function reorder(\App\Http\Requests\Admin\ReorderPartnerRequest $request): JsonResponse
    {
        $this->teamMemberService->reorder($request->validated('ordered_ids'));

        return response()->json(['message' => 'Team members reordered successfully.']);
    }
}
