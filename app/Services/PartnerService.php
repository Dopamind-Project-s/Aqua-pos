<?php

namespace App\Services;

use App\Models\Partner;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PartnerService
{
    public function create(array $data): Partner
    {
        return DB::transaction(function () use ($data): Partner {
            $data['name'] = $data['name_en'] ?? $data['name_ar'] ?? null;
            $data['description'] = $data['description_en'] ?? $data['description_ar'] ?? null;
            $data['slug'] = $this->generateUniqueSlug($data['name']);
            $data['sort_order'] = $data['sort_order'] ?? (Partner::max('sort_order') + 1);

            if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
                $data['logo'] = $this->storeLogo($data['logo']);
            } else {
                unset($data['logo']);
            }

            return Partner::query()->create($data);
        });
    }

    public function update(Partner $partner, array $data): Partner
    {
        return DB::transaction(function () use ($partner, $data): Partner {
            $data['name'] = $data['name_en'] ?? $data['name_ar'] ?? $partner->name;
            $data['description'] = $data['description_en'] ?? $data['description_ar'] ?? $partner->description;

            if ($data['name'] !== $partner->name) {
                $data['slug'] = $this->generateUniqueSlug($data['name'], $partner->id);
            }

            if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
                $newLogo = $this->storeLogo($data['logo']);
                $this->deleteLogo($partner->logo);
                $data['logo'] = $newLogo;
            } else {
                unset($data['logo']);
            }

            $partner->update($data);

            return $partner->fresh();
        });
    }

    public function delete(Partner $partner): void
    {
        DB::transaction(function () use ($partner): void {
            $this->deleteLogo($partner->logo);
            $partner->delete();
        });
    }

    public function reorder(array $orderedIds): void
    {
        DB::transaction(function () use ($orderedIds): void {
            foreach ($orderedIds as $index => $id) {
                Partner::query()->whereKey($id)->update(['sort_order' => $index + 1]);
            }
        });
    }

    private function storeLogo(UploadedFile $file): string
    {
        return $file->store('partners', 'public');
    }

    private function deleteLogo(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Partner::query()
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
