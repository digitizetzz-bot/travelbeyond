<?php

use App\Models\Destination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.admin')] #[Title('Destinations - Travel & Beyond Admin')] class extends Component
{
    use WithPagination;

    public string $search = '';

    public string $regionFilter = 'all';

    public string $categoryFilter = 'all';

    public string $statusFilter = 'all';

    public bool $showDeleteModal = false;

    public ?int $deletingDestinationId = null;

    /**
     * Quick toggle active status.
     */
    public function toggleActive(int $id): void
    {
        $dest = Destination::findOrFail($id);
        $dest->is_active = ! $dest->is_active;
        $dest->save();
    }

    /**
     * Quick toggle featured status.
     */
    public function toggleFeatured(int $id): void
    {
        $dest = Destination::findOrFail($id);
        $dest->is_featured = ! $dest->is_featured;
        $dest->save();
    }

    /**
     * Confirm delete destination.
     */
    public function confirmDelete(int $id): void
    {
        $this->deletingDestinationId = $id;
        $this->showDeleteModal = true;
    }

    /**
     * Delete destination.
     */
    public function deleteDestination(): void
    {
        if ($this->deletingDestinationId) {
            Destination::where('id', $this->deletingDestinationId)->delete();
            $this->deletingDestinationId = null;
        }

        $this->showDeleteModal = false;
    }

    /**
     * Query destinations with filters.
     */
    public function with(): array
    {
        $query = Destination::query();

        if ($this->search !== '') {
            $term = $this->search;
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('region', 'like', "%{$term}%")
                  ->orWhere('category', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%")
                  ->orWhere('highlights', 'like', "%{$term}%");
            });
        }

        if ($this->regionFilter !== 'all') {
            $query->where('region', $this->regionFilter);
        }

        if ($this->categoryFilter !== 'all') {
            $query->where('category', $this->categoryFilter);
        }

        if ($this->statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->statusFilter === 'inactive') {
            $query->where('is_active', false);
        } elseif ($this->statusFilter === 'featured') {
            $query->where('is_featured', true);
        }

        $destinations = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->paginate(10);

        return [
            'destinations' => $destinations,
            'totalCount' => Destination::count(),
            'activeCount' => Destination::where('is_active', true)->count(),
            'featuredCount' => Destination::where('is_featured', true)->count(),
            'regions' => Destination::whereNotNull('region')->distinct()->pluck('region'),
            'categories' => Destination::whereNotNull('category')->distinct()->pluck('category'),
        ];
    }
};
?>

<div class="flex flex-col min-h-screen bg-white dark:bg-zinc-900 text-neutral-800 dark:text-neutral-100 p-6 lg:p-8">
    <!-- Header / Title -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-neutral-100 dark:border-zinc-800">
        <div>
            <div class="flex items-center gap-2.5">
                <h1 class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-white">Destinations</h1>
                <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-neutral-100 dark:bg-zinc-800 text-neutral-700 dark:text-neutral-300 border border-neutral-200 dark:border-zinc-700">
                    {{ $totalCount }} total
                </span>
            </div>
            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                Manage iconic parks, reserves, islands, and mountain expeditions across Tanzania
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a 
                href="{{ route('admin.destinations.create') }}" 
                class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-[#111217] dark:bg-white text-white dark:text-neutral-900 text-xs font-semibold hover:bg-neutral-800 dark:hover:bg-neutral-100 transition shadow-xs"
            >
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Add Destination</span>
            </a>
        </div>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 py-5">
        <!-- Search Input -->
        <div class="relative w-full lg:w-72">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-neutral-400">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
            <input 
                wire:model.live.debounce.250ms="search" 
                type="text" 
                placeholder="Search destinations, highlights..." 
                class="w-full pl-9 pr-3 py-2 rounded-lg text-xs bg-neutral-50 dark:bg-zinc-800/80 border border-neutral-200 dark:border-zinc-700 text-neutral-900 dark:text-neutral-100 placeholder-neutral-400 focus:outline-none focus:ring-1 focus:ring-neutral-800 dark:focus:ring-white transition"
            />
        </div>

        <!-- Filter Dropdowns & Status Tabs -->
        <div class="flex flex-wrap items-center gap-2">
            <!-- Region Filter -->
            <select 
                wire:model.live="regionFilter" 
                class="px-2.5 py-1.5 rounded-lg text-xs bg-neutral-50 dark:bg-zinc-800 border border-neutral-200 dark:border-zinc-700 text-neutral-700 dark:text-neutral-300 focus:outline-none"
            >
                <option value="all">All Regions</option>
                @foreach($regions as $reg)
                    <option value="{{ $reg }}">{{ $reg }}</option>
                @endforeach
            </select>

            <!-- Category Filter -->
            <select 
                wire:model.live="categoryFilter" 
                class="px-2.5 py-1.5 rounded-lg text-xs bg-neutral-50 dark:bg-zinc-800 border border-neutral-200 dark:border-zinc-700 text-neutral-700 dark:text-neutral-300 focus:outline-none"
            >
                <option value="all">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                @endforeach
            </select>

            <!-- Status Tabs -->
            <div class="flex items-center gap-1 bg-neutral-100 dark:bg-zinc-800/70 p-0.5 rounded-lg border border-neutral-200/60 dark:border-zinc-700/60">
                <button 
                    wire:click="$set('statusFilter', 'all')" 
                    class="px-2.5 py-1 rounded-md text-xs font-medium transition {{ $statusFilter === 'all' ? 'bg-white dark:bg-zinc-700 text-neutral-900 dark:text-white shadow-xs' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}"
                >
                    All
                </button>
                <button 
                    wire:click="$set('statusFilter', 'active')" 
                    class="px-2.5 py-1 rounded-md text-xs font-medium transition {{ $statusFilter === 'active' ? 'bg-white dark:bg-zinc-700 text-neutral-900 dark:text-white shadow-xs' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}"
                >
                    Active ({{ $activeCount }})
                </button>
                <button 
                    wire:click="$set('statusFilter', 'inactive')" 
                    class="px-2.5 py-1 rounded-md text-xs font-medium transition {{ $statusFilter === 'inactive' ? 'bg-white dark:bg-zinc-700 text-neutral-900 dark:text-white shadow-xs' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}"
                >
                    Inactive
                </button>
            </div>
        </div>
    </div>

    <!-- Destinations Table -->
    <div class="overflow-x-auto rounded-xl border border-neutral-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-neutral-200 dark:border-zinc-800 bg-neutral-50/75 dark:bg-zinc-800/40 text-[11px] font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                    <th class="py-3 px-4 w-12 text-center">Order</th>
                    <th class="py-3 px-4">Destination</th>
                    <th class="py-3 px-4">Region / Category</th>
                    <th class="py-3 px-4">Gallery</th>
                    <th class="py-3 px-4">Highlights</th>
                    <th class="py-3 px-4">Best Time</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100 dark:divide-zinc-800/60 text-xs">
                @forelse($destinations as $dest)
                    <tr wire:key="dest-{{ $dest->id }}" class="hover:bg-neutral-50/70 dark:hover:bg-zinc-800/50 transition">
                        <!-- Order -->
                        <td class="py-3.5 px-4 text-center font-mono text-neutral-500 dark:text-neutral-400 font-semibold">
                            {{ $dest->sort_order }}
                        </td>

                        <!-- Name & Photo / Initials -->
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                @if($dest->photo)
                                    <img src="{{ $dest->photo }}" alt="{{ $dest->name }}" class="size-10 rounded-lg object-cover border border-neutral-200 dark:border-zinc-700 shrink-0" />
                                @else
                                    <div class="size-10 rounded-lg bg-neutral-100 dark:bg-zinc-800 border border-neutral-200 dark:border-zinc-700 flex items-center justify-center font-bold text-xs text-neutral-700 dark:text-neutral-300 shrink-0">
                                        {{ strtoupper(substr($dest->name, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <a href="{{ route('admin.destinations.edit', $dest->id) }}" class="font-semibold text-neutral-900 dark:text-white hover:underline">
                                        {{ $dest->name }}
                                    </a>
                                    <p class="text-[10px] text-neutral-400 dark:text-neutral-500 font-mono">{{ $dest->slug }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Region / Category -->
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <div>
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-neutral-100 dark:bg-zinc-800 text-neutral-700 dark:text-neutral-300">
                                    {{ $dest->category ?? 'Destination' }}
                                </span>
                                <p class="text-[11px] text-neutral-500 dark:text-neutral-400 mt-1">{{ $dest->region ?? '—' }}</p>
                            </div>
                        </td>

                        <!-- Gallery Count -->
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            @php $galleryCount = count($dest->gallery ?? []); @endphp
                            @if($galleryCount > 0)
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800">
                                    <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>
                                    <span>{{ $galleryCount }} photos</span>
                                </span>
                            @else
                                <span class="text-neutral-400 dark:text-neutral-500 text-[11px]">—</span>
                            @endif
                        </td>

                        <!-- Highlights -->
                        <td class="py-3.5 px-4 max-w-xs truncate text-neutral-600 dark:text-neutral-300" title="{{ $dest->highlights }}">
                            {{ $dest->highlights ?? '—' }}
                        </td>

                        <!-- Best Time -->
                        <td class="py-3.5 px-4 whitespace-nowrap text-neutral-500 dark:text-neutral-400">
                            {{ $dest->best_time_to_visit ?? 'Year-round' }}
                        </td>

                        <!-- Status Toggle -->
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <button 
                                wire:click="toggleActive({{ $dest->id }})" 
                                type="button" 
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold transition {{ $dest->is_active ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800' : 'bg-neutral-100 dark:bg-zinc-800 text-neutral-500 dark:text-neutral-400 border border-neutral-200 dark:border-zinc-700' }}"
                            >
                                <span class="size-1.5 rounded-full {{ $dest->is_active ? 'bg-emerald-600 dark:bg-emerald-400' : 'bg-neutral-400 dark:bg-neutral-500' }}"></span>
                                <span>{{ $dest->is_active ? 'Active' : 'Inactive' }}</span>
                            </button>
                        </td>

                        <!-- Actions -->
                        <td class="py-3.5 px-4 whitespace-nowrap text-right">
                            <div class="inline-flex items-center gap-1">
                                <a 
                                    href="{{ route('admin.destinations.edit', $dest->id) }}" 
                                    title="Edit destination"
                                    class="p-1.5 rounded-md text-neutral-400 hover:text-neutral-900 dark:hover:text-white hover:bg-neutral-100 dark:hover:bg-zinc-800 transition"
                                >
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                                <button 
                                    wire:click="confirmDelete({{ $dest->id }})" 
                                    type="button" 
                                    title="Delete destination"
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
                        <td colspan="8" class="py-10 text-center text-neutral-400 dark:text-neutral-500">
                            No destinations found matching your criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if($destinations->hasPages())
            <div class="p-4 border-t border-neutral-100 dark:border-zinc-800">
                {{ $destinations->links() }}
            </div>
        @endif
    </div>

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
                        <h3 class="text-sm font-bold text-neutral-900 dark:text-white">Delete Destination</h3>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                            Are you sure you want to delete this destination? This action cannot be undone.
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
                            wire:click="deleteDestination" 
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
