<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        if (! Schema::hasTable('team_members')) {
            return view('team', ['teamMembers' => collect()]);
        }

        $teamMembers = TeamMember::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get();

        return view('team', compact('teamMembers'));
    }
}
