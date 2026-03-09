<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ClientService
{
    public function create(array $data): Client
    {
        return DB::transaction(function () use ($data): Client {
            $data['slug'] = $this->generateUniqueSlug($data['name']);
            $data['logo'] = $this->storeLogo($data['logo']);
            $data['sort_order'] = $data['sort_order'] ?? (Client::max('sort_order') + 1);

            return Client::query()->create($data);
        });
    }

    public function update(Client $client, array $data): Client
    {
        return DB::transaction(function () use ($client, $data): Client {
            if (isset($data['name']) && $data['name'] !== $client->name) {
                $data['slug'] = $this->generateUniqueSlug($data['name'], $client->id);
            }

            if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
                $newLogo = $this->storeLogo($data['logo']);
                $this->deleteLogo($client->logo);
                $data['logo'] = $newLogo;
            } else {
                unset($data['logo']);
            }

            $client->update($data);

            return $client->fresh();
        });
    }

    public function delete(Client $client): void
    {
        DB::transaction(function () use ($client): void {
            $this->deleteLogo($client->logo);
            $client->delete();
        });
    }

    private function storeLogo(UploadedFile $file): string
    {
        return $file->store('clients', 'public');
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
            Client::query()
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
