<?php

namespace App\Services;

use App\Models\TeamMember;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TeamMemberService
{
    public function create(array $data): TeamMember
    {
        return DB::transaction(function () use ($data): TeamMember {
            if (($data['photo'] ?? null) instanceof UploadedFile) {
                $data['photo'] = $this->storePhoto($data['photo']);
            }

            $data['sort_order'] = $data['sort_order'] ?? ((TeamMember::query()->max('sort_order') ?? 0) + 1);

            return TeamMember::query()->create($data);
        });
    }

    public function update(TeamMember $teamMember, array $data): TeamMember
    {
        return DB::transaction(function () use ($teamMember, $data): TeamMember {
            if (($data['photo'] ?? null) instanceof UploadedFile) {
                $newPhoto = $this->storePhoto($data['photo']);
                $this->deletePhoto($teamMember->photo);
                $data['photo'] = $newPhoto;
            } else {
                unset($data['photo']);
            }

            $teamMember->update($data);

            return $teamMember->fresh();
        });
    }

    public function delete(TeamMember $teamMember): void
    {
        DB::transaction(function () use ($teamMember): void {
            $this->deletePhoto($teamMember->photo);
            $teamMember->delete();
        });
    }

    public function reorder(array $orderedIds): void
    {
        DB::transaction(function () use ($orderedIds): void {
            foreach ($orderedIds as $index => $id) {
                TeamMember::query()->whereKey($id)->update(['sort_order' => $index + 1]);
            }
        });
    }

    private function storePhoto(UploadedFile $file): string
    {
        return $file->store('team-members', 'public');
    }

    private function deletePhoto(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
