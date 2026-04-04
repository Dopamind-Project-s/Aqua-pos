<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreClientRequest;
use App\Http\Requests\Admin\UpdateClientRequest;
use App\Models\Category;
use App\Models\Client;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function __construct(private readonly ClientService $clientService)
    {
    }

    public function index(): View
    {
        $clients = Client::query()->with('category')->orderBy('sort_order')->orderByDesc('created_at')->paginate(20);

        return view('admin.clients.index', compact('clients'));
    }

    public function create(): View
    {
        $categories = Category::query()->where('is_active', true)->whereNull('deleted_at')->orderBy('sort_order')->orderBy('name_en')->get();

        return view('admin.clients.create', compact('categories'));
    }

    public function store(StoreClientRequest $request): RedirectResponse
    {
        $payload = $request->validated();
        $payload['is_active'] = $request->boolean('is_active');

        $this->clientService->create($payload);

        return redirect()->route('admin.clients.index')->with('success', 'Client created successfully.');
    }

    public function edit(Client $client): View
    {
        $categories = Category::query()->where('is_active', true)->whereNull('deleted_at')->orderBy('sort_order')->orderBy('name_en')->get();

        return view('admin.clients.edit', compact('client', 'categories'));
    }

    public function update(UpdateClientRequest $request, Client $client): RedirectResponse
    {
        $payload = $request->validated();
        $payload['is_active'] = $request->boolean('is_active');

        $this->clientService->update($client, $payload);

        return redirect()->route('admin.clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client): RedirectResponse
    {
        $this->clientService->delete($client);

        return redirect()->route('admin.clients.index')->with('success', 'Client deleted successfully.');
    }

    public function toggleStatus(Client $client): JsonResponse
    {
        $client->update(['is_active' => ! $client->is_active]);

        return response()->json(['message' => 'Client status updated.', 'is_active' => $client->is_active]);
    }
}
