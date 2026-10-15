<?php

use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

new #[Layout('layouts.admin')] #[Title('Services - Travel & Beyond Admin')] class extends Component
{
    use WithFileUploads;
    use WithPagination;

    public string $search = '';

    public string $statusFilter = 'all';

    public bool $showFormModal = false;

    public bool $showDeleteModal = false;

    public ?int $editingServiceId = null;

    public ?int $deletingServiceId = null;

    // Form inputs
    public string $title = '';

    public string $slug = '';

    public string $subtitle = '';

    public string $description = '';

    public ?string $photo = null;

    public mixed $photoUpload = null;

    public bool $is_active = true;

    public int $sort_order = 0;

    /**
     * Auto-generate slug when title updates if creating a new service.
     */
    public function updatedTitle(string $value): void
    {
        if (! $this->editingServiceId) {
            $this->slug = Str::slug($value);
        }
    }

    /**
     * Open modal to create a new service.
     */
    public function openCreateModal(): void
    {
        $this->resetValidation();
        $this->editingServiceId = null;
        $this->title = '';
        $this->slug = '';
        $this->subtitle = '';
        $this->description = '';
        $this->photo = null;
        $this->photoUpload = null;
        $this->is_active = true;
        $this->sort_order = ((int) Service::max('sort_order')) + 1;
        $this->showFormModal = true;
    }

    /**
     * Open modal to edit an existing service.
     */
    public function openEditModal(int $id): void
    {
        $this->resetValidation();
        $service = Service::findOrFail($id);

        $this->editingServiceId = $service->id;
        $this->title = $service->title;
        $this->slug = $service->slug;
        $this->subtitle = $service->subtitle ?? '';
        $this->description = $service->description ?? '';
        $this->photo = $service->photo;
        $this->photoUpload = null;
        $this->is_active = (bool) $service->is_active;
        $this->sort_order = (int) $service->sort_order;

        $this->showFormModal = true;
    }

    /**
     * Remove current photo.
     */
    public function removePhoto(): void
    {
        $this->photo = null;
        $this->photoUpload = null;
    }

    /**
     * Save (create or update) the service.
     */
    public function save(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('services', 'slug')->ignore($this->editingServiceId),
            ],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'photo' => ['nullable', 'string', 'max:500'],
            'photoUpload' => ['nullable', 'image', 'max:4096'],
            'is_active' => ['boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);

        if ($this->photoUpload) {
            $path = $this->photoUpload->store('services', 'public');
            $validated['photo'] = Storage::url($path);
        } else {
            $validated['photo'] = $this->photo;
        }

        unset($validated['photoUpload']);

        if ($this->editingServiceId) {
            $service = Service::findOrFail($this->editingServiceId);
            $service->update($validated);
        } else {
            Service::create($validated);
        }

        $this->showFormModal = false;
        $this->reset(['editingServiceId', 'title', 'slug', 'subtitle', 'description', 'photo', 'photoUpload', 'is_active', 'sort_order']);
    }

    /**
     * Quick toggle of active status directly from table row.
     */
    public function toggleActive(int $id): void
    {
        $service = Service::findOrFail($id);
        $service->is_active = ! $service->is_active;
        $service->save();
    }

    /**
     * Open confirmation modal to delete a service.
     */
    public function confirmDelete(int $id): void
    {
        $this->deletingServiceId = $id;
        $this->showDeleteModal = true;
    }

    /**
     * Delete the service.
     */
    public function deleteService(): void
    {
        if ($this->deletingServiceId) {
            Service::where('id', $this->deletingServiceId)->delete();
            $this->deletingServiceId = null;
        }

        $this->showDeleteModal = false;
    }

    /**
     * Query services for rendering.
     */
    public function with(): array
    {
        $query = Service::query();

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('title', 'like', '%'.$this->search.'%')
                  ->orWhere('subtitle', 'like', '%'.$this->search.'%')
                  ->orWhere('description', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->statusFilter === 'inactive') {
            $query->where('is_active', false);
        }

        $services = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->paginate(10);

        return [
            'services' => $services,
            'totalCount' => Service::count(),
            'activeCount' => Service::where('is_active', true)->count(),
        ];
    }
};
?>

<div class="flex flex-col min-h-screen bg-white dark:bg-zinc-900 text-neutral-800 dark:text-neutral-100 p-6 lg:p-8">
    <!-- Header / Title -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-neutral-100 dark:border-zinc-800">
        <div>
            <div class="flex items-center gap-2.5">
                <h1 class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-white">Services</h1>
                <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-neutral-100 dark:bg-zinc-800 text-neutral-700 dark:text-neutral-300 border border-neutral-200 dark:border-zinc-700">
                    {{ $totalCount }} total
                </span>
            </div>
            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                Manage travel services provided to clients (Flights, Tours, Visas, Transfers, Expeditions, Hotels)
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <button 
                wire:click="openCreateModal" 
                type="button" 
                class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-[#111217] dark:bg-white text-white dark:text-neutral-900 text-xs font-semibold hover:bg-neutral-800 dark:hover:bg-neutral-100 transition shadow-xs"
            >
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Add New Service</span>
            </button>
        </div>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 py-5">
        <!-- Search Input -->
        <div class="relative w-full sm:w-72">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-neutral-400">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
            <input 
                wire:model.live.debounce.250ms="search" 
                type="text" 
                placeholder="Search services..." 
                class="w-full pl-9 pr-3 py-2 rounded-lg text-xs bg-neutral-50 dark:bg-zinc-800/80 border border-neutral-200 dark:border-zinc-700 text-neutral-900 dark:text-neutral-100 placeholder-neutral-400 focus:outline-none focus:ring-1 focus:ring-neutral-800 dark:focus:ring-white transition"
            />
        </div>

        <!-- Status Filter Buttons -->
        <div class="flex items-center gap-1.5 self-start sm:self-auto">
            <button 
                wire:click="$set('statusFilter', 'all')" 
                class="px-3 py-1.5 rounded-lg text-xs font-medium transition {{ $statusFilter === 'all' ? 'bg-[#111217] text-white dark:bg-zinc-800 dark:text-white' : 'text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-zinc-800' }}"
            >
                All ({{ $totalCount }})
            </button>
            <button 
                wire:click="$set('statusFilter', 'active')" 
                class="px-3 py-1.5 rounded-lg text-xs font-medium transition {{ $statusFilter === 'active' ? 'bg-[#111217] text-white dark:bg-zinc-800 dark:text-white' : 'text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-zinc-800' }}"
            >
                Active ({{ $activeCount }})
            </button>
            <button 
                wire:click="$set('statusFilter', 'inactive')" 
                class="px-3 py-1.5 rounded-lg text-xs font-medium transition {{ $statusFilter === 'inactive' ? 'bg-[#111217] text-white dark:bg-zinc-800 dark:text-white' : 'text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-zinc-800' }}"
            >
                Inactive ({{ $totalCount - $activeCount }})
            </button>
        </div>
    </div>

    <!-- Services Table -->
    <div class="overflow-x-auto rounded-xl border border-neutral-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-neutral-200 dark:border-zinc-800 bg-neutral-50/75 dark:bg-zinc-800/40 text-[11px] font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                    <th class="py-3 px-4 w-12 text-center">Order</th>
                    <th class="py-3 px-4">Service</th>
                    <th class="py-3 px-4">Subtitle</th>
                    <th class="py-3 px-4">Description</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100 dark:divide-zinc-800/60 text-xs">
                @forelse($services as $service)
                    <tr wire:key="service-{{ $service->id }}" class="hover:bg-neutral-50/70 dark:hover:bg-zinc-800/50 transition">
                        <!-- Sort Order -->
                        <td class="py-3.5 px-4 text-center font-mono text-neutral-500 dark:text-neutral-400 font-semibold">
                            {{ $service->sort_order }}
                        </td>

                        <!-- Title & Slug -->
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                @if($service->photo)
                                    <img src="{{ $service->photo }}" alt="{{ $service->title }}" class="size-9 rounded-lg object-cover border border-neutral-200 dark:border-zinc-700 shrink-0" />
                                @else
                                    <div class="size-9 rounded-lg bg-neutral-100 dark:bg-zinc-800 border border-neutral-200 dark:border-zinc-700 flex items-center justify-center font-bold text-xs text-neutral-700 dark:text-neutral-300 shrink-0">
                                        {{ strtoupper(substr($service->title, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-neutral-900 dark:text-white">{{ $service->title }}</p>
                                    <p class="text-[10px] text-neutral-400 dark:text-neutral-500 font-mono">{{ $service->slug }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Subtitle -->
                        <td class="py-3.5 px-4 max-w-xs truncate text-neutral-600 dark:text-neutral-300">
                            {{ $service->subtitle ?? '—' }}
                        </td>

                        <!-- Description -->
                        <td class="py-3.5 px-4 max-w-md truncate text-neutral-500 dark:text-neutral-400" title="{{ $service->description }}">
                            {{ $service->description ?? '—' }}
                        </td>

                        <!-- Status Toggle -->
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <button 
                                wire:click="toggleActive({{ $service->id }})" 
                                type="button" 
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold transition {{ $service->is_active ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800' : 'bg-neutral-100 dark:bg-zinc-800 text-neutral-500 dark:text-neutral-400 border border-neutral-200 dark:border-zinc-700' }}"
                            >
                                <span class="size-1.5 rounded-full {{ $service->is_active ? 'bg-emerald-600 dark:bg-emerald-400' : 'bg-neutral-400 dark:bg-neutral-500' }}"></span>
                                <span>{{ $service->is_active ? 'Active' : 'Inactive' }}</span>
                            </button>
                        </td>

                        <!-- Actions -->
                        <td class="py-3.5 px-4 whitespace-nowrap text-right">
                            <div class="inline-flex items-center gap-1">
                                <button 
                                    wire:click="openEditModal({{ $service->id }})" 
                                    type="button" 
                                    title="Edit service"
                                    class="p-1.5 rounded-md text-neutral-400 hover:text-neutral-900 dark:hover:text-white hover:bg-neutral-100 dark:hover:bg-zinc-800 transition"
                                >
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </button>
                                <button 
                                    wire:click="confirmDelete({{ $service->id }})" 
                                    type="button" 
                                    title="Delete service"
                                    class="p-1.5 rounded-md text-neutral-400 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition"
                                >
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center text-neutral-400 dark:text-neutral-500">
                            No services found matching your criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if($services->hasPages())
            <div class="p-4 border-t border-neutral-100 dark:border-zinc-800">
                {{ $services->links() }}
            </div>
        @endif
    </div>

    <!-- Create / Edit Service Modal -->
    @if($showFormModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-xs transition-opacity" wire:click="$set('showFormModal', false)"></div>

            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-lg rounded-2xl bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-zinc-800 p-6 shadow-2xl space-y-5">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between pb-3 border-b border-neutral-100 dark:border-zinc-800">
                        <h2 class="text-base font-bold text-neutral-900 dark:text-white">
                            {{ $editingServiceId ? 'Edit Service' : 'Add New Service' }}
                        </h2>
                        <button wire:click="$set('showFormModal', false)" type="button" class="text-neutral-400 hover:text-neutral-700 dark:hover:text-white">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Form -->
                    <form wire:submit="save" class="space-y-4 text-xs">
                        <!-- Title -->
                        <div>
                            <label class="block font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Title *</label>
                            <input 
                                wire:model.live.debounce.300ms="title" 
                                type="text" 
                                placeholder="e.g. Flight Booking, Tour Planning" 
                                class="w-full px-3 py-2 rounded-lg bg-neutral-50 dark:bg-zinc-800 border border-neutral-300 dark:border-zinc-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-neutral-800 dark:focus:ring-white"
                            />
                            @error('title') <span class="text-rose-500 text-[11px] mt-0.5 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Slug -->
                        <div>
                            <label class="block font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Slug *</label>
                            <input 
                                wire:model="slug" 
                                type="text" 
                                placeholder="flight-booking" 
                                class="w-full px-3 py-2 rounded-lg font-mono bg-neutral-50 dark:bg-zinc-800 border border-neutral-300 dark:border-zinc-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-neutral-800 dark:focus:ring-white"
                            />
                            @error('slug') <span class="text-rose-500 text-[11px] mt-0.5 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Subtitle -->
                        <div>
                            <label class="block font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Subtitle</label>
                            <input 
                                wire:model="subtitle" 
                                type="text" 
                                placeholder="Short catchy overview" 
                                class="w-full px-3 py-2 rounded-lg bg-neutral-50 dark:bg-zinc-800 border border-neutral-300 dark:border-zinc-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-neutral-800 dark:focus:ring-white"
                            />
                            @error('subtitle') <span class="text-rose-500 text-[11px] mt-0.5 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Description</label>
                            <textarea 
                                wire:model="description" 
                                rows="3" 
                                placeholder="Detailed overview of what this service covers..." 
                                class="w-full px-3 py-2 rounded-lg bg-neutral-50 dark:bg-zinc-800 border border-neutral-300 dark:border-zinc-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-neutral-800 dark:focus:ring-white"
                            ></textarea>
                            @error('description') <span class="text-rose-500 text-[11px] mt-0.5 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Service Photo (Upload or URL) -->
                        <div class="space-y-2 p-3.5 rounded-xl border border-neutral-200 dark:border-zinc-700/80 bg-neutral-50/50 dark:bg-zinc-800/40">
                            <label class="block font-semibold text-neutral-700 dark:text-neutral-300">
                                Service Photo
                            </label>

                            <!-- Photo Preview (if uploaded or URL set) -->
                            @if($photoUpload)
                                <div class="flex items-center gap-3">
                                    <img src="{{ $photoUpload->temporaryUrl() }}" alt="Preview" class="size-16 rounded-lg object-cover border border-neutral-200 dark:border-zinc-700" />
                                    <div class="space-y-1">
                                        <p class="text-[11px] font-semibold text-emerald-600 dark:text-emerald-400">New photo selected (ready to save)</p>
                                        <button wire:click="removePhoto" type="button" class="text-[11px] text-rose-500 hover:text-rose-600 underline">Remove photo</button>
                                    </div>
                                </div>
                            @elseif($photo)
                                <div class="flex items-center gap-3">
                                    <img src="{{ $photo }}" alt="Current Photo" class="size-16 rounded-lg object-cover border border-neutral-200 dark:border-zinc-700" />
                                    <div class="space-y-1">
                                        <p class="text-[11px] text-neutral-500 dark:text-neutral-400 truncate max-w-xs">{{ $photo }}</p>
                                        <button wire:click="removePhoto" type="button" class="text-[11px] text-rose-500 hover:text-rose-600 underline">Remove photo</button>
                                    </div>
                                </div>
                            @endif

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                                <!-- File Upload -->
                                <div>
                                    <span class="block text-[11px] text-neutral-500 dark:text-neutral-400 mb-1">Upload image file</span>
                                    <input 
                                        wire:model="photoUpload" 
                                        type="file" 
                                        accept="image/png,image/jpeg,image/webp,image/svg+xml"
                                        class="block w-full text-xs text-neutral-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-neutral-800 file:text-white dark:file:bg-zinc-700 hover:file:bg-neutral-700 cursor-pointer"
                                    />
                                    @error('photoUpload') <span class="text-rose-500 text-[11px] mt-0.5 block">{{ $message }}</span> @enderror
                                </div>

                                <!-- Photo Path or URL -->
                                <div>
                                    <span class="block text-[11px] text-neutral-500 dark:text-neutral-400 mb-1">Or paste image URL / path</span>
                                    <input 
                                        wire:model="photo" 
                                        type="text" 
                                        placeholder="https://... or /images/..." 
                                        class="w-full px-3 py-1.5 rounded-lg text-xs bg-white dark:bg-zinc-800 border border-neutral-300 dark:border-zinc-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-neutral-800 dark:focus:ring-white"
                                    />
                                    @error('photo') <span class="text-rose-500 text-[11px] mt-0.5 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Sort Order & Active Status -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Sort Order</label>
                                <input 
                                    wire:model="sort_order" 
                                    type="number" 
                                    min="0"
                                    class="w-full px-3 py-2 rounded-lg font-mono bg-neutral-50 dark:bg-zinc-800 border border-neutral-300 dark:border-zinc-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-neutral-800 dark:focus:ring-white"
                                />
                                @error('sort_order') <span class="text-rose-500 text-[11px] mt-0.5 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-center pt-5">
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input 
                                        wire:model="is_active" 
                                        type="checkbox" 
                                        class="size-4 rounded border-neutral-300 dark:border-zinc-700 dark:bg-zinc-800 text-neutral-900 focus:ring-neutral-900 cursor-pointer"
                                    />
                                    <span class="font-semibold text-neutral-700 dark:text-neutral-300">Active Service</span>
                                </label>
                            </div>
                        </div>

                        <!-- Modal Actions -->
                        <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-neutral-100 dark:border-zinc-800">
                            <button 
                                wire:click="$set('showFormModal', false)" 
                                type="button" 
                                class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-zinc-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-zinc-800 transition"
                            >
                                Cancel
                            </button>
                            <button 
                                type="submit" 
                                class="px-4 py-2 rounded-lg bg-[#111217] dark:bg-white text-white dark:text-neutral-900 font-semibold hover:bg-neutral-800 dark:hover:bg-neutral-100 transition shadow-xs"
                            >
                                {{ $editingServiceId ? 'Save Changes' : 'Create Service' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-xs transition-opacity" wire:click="$set('showDeleteModal', false)"></div>

            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-sm rounded-2xl bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-zinc-800 p-6 shadow-2xl space-y-4">
                    <div class="size-10 rounded-full bg-rose-100 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-sm font-bold text-neutral-900 dark:text-white">Delete Service</h3>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                            Are you sure you want to delete this service? This action cannot be undone.
                        </p>
                    </div>

                    <div class="flex items-center justify-end gap-2.5 pt-2">
                        <button 
                            wire:click="$set('showDeleteModal', false)" 
                            type="button" 
                            class="px-3 py-1.5 rounded-lg border border-neutral-200 dark:border-zinc-700 text-xs font-medium text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-zinc-800 transition"
                        >
                            Cancel
                        </button>
                        <button 
                            wire:click="deleteService" 
                            type="button" 
                            class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold transition"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
