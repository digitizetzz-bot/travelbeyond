<?php

use App\Models\Destination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts.admin')] #[Title('Add Destination - Travel & Beyond Admin')] class extends Component
{
    use WithFileUploads;

    public string $name = '';

    public string $slug = '';

    public string $region = 'Northern Safari Circuit';

    public string $category = 'National Park';

    public string $description = '';

    public string $highlights = '';

    public string $best_time_to_visit = '';

    public string $climate = '';

    public string $entry_fee_info = '';

    public ?string $photo = null;

    public mixed $photoUpload = null;

    /** @var array<int, string> */
    public array $gallery = [];

    /** @var array<int, mixed> */
    public array $galleryUploads = [];

    public string $newGalleryUrl = '';

    public bool $is_featured = false;

    public bool $is_active = true;

    public int $sort_order = 1;

    public function mount(): void
    {
        $this->sort_order = ((int) Destination::max('sort_order')) + 1;
    }

    public function updatedName(string $value): void
    {
        $this->slug = Str::slug($value);
    }

    public function removePhoto(): void
    {
        $this->photo = null;
        $this->photoUpload = null;
    }

    public function addGalleryUrl(): void
    {
        $url = trim($this->newGalleryUrl);
        if ($url !== '' && ! in_array($url, $this->gallery, true)) {
            $this->gallery[] = $url;
            $this->newGalleryUrl = '';
        }
    }

    public function removeGalleryItem(int $index): void
    {
        if (isset($this->gallery[$index])) {
            unset($this->gallery[$index]);
            $this->gallery = array_values($this->gallery);
        }
    }

    public function removePendingUpload(int $index): void
    {
        if (isset($this->galleryUploads[$index])) {
            unset($this->galleryUploads[$index]);
            $this->galleryUploads = array_values($this->galleryUploads);
        }
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:destinations,slug'],
            'region' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'highlights' => ['nullable', 'string'],
            'best_time_to_visit' => ['nullable', 'string', 'max:255'],
            'climate' => ['nullable', 'string', 'max:255'],
            'entry_fee_info' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'string', 'max:500'],
            'photoUpload' => ['nullable', 'image', 'max:4096'],
            'galleryUploads.*' => ['nullable', 'image', 'max:4096'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);

        // Main photo
        if ($this->photoUpload) {
            $path = $this->photoUpload->store('destinations', 'public');
            $validated['photo'] = Storage::url($path);
        } else {
            $validated['photo'] = $this->photo;
        }

        // Gallery uploads
        $finalGallery = $this->gallery;
        if (! empty($this->galleryUploads)) {
            foreach ($this->galleryUploads as $upload) {
                if ($upload) {
                    $path = $upload->store('destinations/gallery', 'public');
                    $finalGallery[] = Storage::url($path);
                }
            }
        }
        $validated['gallery'] = array_values($finalGallery);

        unset($validated['photoUpload'], $validated['galleryUploads']);

        Destination::create($validated);

        session()->flash('status', 'Destination created successfully!');
        $this->redirect(route('admin.destinations'), navigate: true);
    }
};
?>

<div class="p-6 lg:p-8 max-w-5xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between pb-4 border-b border-neutral-100 dark:border-zinc-800">
        <div class="flex items-center gap-3">
            <a 
                href="{{ route('admin.destinations') }}" 
                class="p-2 rounded-lg border border-neutral-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:bg-neutral-50 dark:hover:bg-zinc-700 text-neutral-600 dark:text-neutral-300 transition"
                title="Back to destinations"
            >
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-white">Add Destination</h1>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Create a new national park, game reserve, island, or safari attraction</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a 
                href="{{ route('admin.destinations') }}" 
                class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-zinc-700 text-xs font-medium text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-zinc-800 transition"
            >
                Cancel
            </a>
            <button 
                wire:click="save" 
                type="button" 
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-[#111217] dark:bg-white text-white dark:text-neutral-900 text-xs font-semibold hover:bg-neutral-800 dark:hover:bg-neutral-100 transition shadow-xs"
            >
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
                <span>Save Destination</span>
            </button>
        </div>
    </div>

    <!-- Main Form Grid -->
    <form wire:submit="save" class="grid grid-cols-1 lg:grid-cols-3 gap-6 text-xs">
        <!-- Left 2 Cols: Core Details & Gallery -->
        <div class="lg:col-span-2 space-y-6">
            <!-- General Information Card -->
            <div class="p-6 rounded-2xl border border-neutral-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-xs space-y-4">
                <h2 class="text-sm font-bold text-neutral-900 dark:text-white pb-2 border-b border-neutral-100 dark:border-zinc-800">
                    Destination Information
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Name -->
                    <div>
                        <label class="block font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Destination Name *</label>
                        <input 
                            wire:model.live.debounce.300ms="name" 
                            type="text" 
                            placeholder="e.g. Serengeti National Park" 
                            class="w-full px-3 py-2 rounded-lg bg-neutral-50 dark:bg-zinc-800 border border-neutral-300 dark:border-zinc-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-neutral-800 dark:focus:ring-white"
                        />
                        @error('name') <span class="text-rose-500 text-[11px] mt-0.5 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label class="block font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Slug *</label>
                        <input 
                            wire:model="slug" 
                            type="text" 
                            placeholder="serengeti-national-park" 
                            class="w-full px-3 py-2 rounded-lg font-mono bg-neutral-50 dark:bg-zinc-800 border border-neutral-300 dark:border-zinc-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-neutral-800 dark:focus:ring-white"
                        />
                        @error('slug') <span class="text-rose-500 text-[11px] mt-0.5 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Region -->
                    <div>
                        <label class="block font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Region / Circuit</label>
                        <input 
                            wire:model="region" 
                            type="text" 
                            placeholder="e.g. Northern Safari Circuit" 
                            class="w-full px-3 py-2 rounded-lg bg-neutral-50 dark:bg-zinc-800 border border-neutral-300 dark:border-zinc-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-neutral-800 dark:focus:ring-white"
                        />
                        @error('region') <span class="text-rose-500 text-[11px] mt-0.5 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Category</label>
                        <select 
                            wire:model="category" 
                            class="w-full px-3 py-2 rounded-lg bg-neutral-50 dark:bg-zinc-800 border border-neutral-300 dark:border-zinc-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-neutral-800 dark:focus:ring-white"
                        >
                            <option value="National Park">National Park</option>
                            <option value="Conservation Area">Conservation Area</option>
                            <option value="Beach Island">Beach Island</option>
                            <option value="Mountain">Mountain</option>
                            <option value="Game Reserve">Game Reserve</option>
                            <option value="Cultural Heritage">Cultural Heritage</option>
                        </select>
                        @error('category') <span class="text-rose-500 text-[11px] mt-0.5 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Overview Description</label>
                    <textarea 
                        wire:model="description" 
                        rows="4" 
                        placeholder="Comprehensive destination details and wildlife highlights..." 
                        class="w-full px-3 py-2 rounded-lg bg-neutral-50 dark:bg-zinc-800 border border-neutral-300 dark:border-zinc-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-neutral-800 dark:focus:ring-white"
                    ></textarea>
                    @error('description') <span class="text-rose-500 text-[11px] mt-0.5 block">{{ $message }}</span> @enderror
                </div>

                <!-- Highlights -->
                <div>
                    <label class="block font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Key Highlights</label>
                    <input 
                        wire:model="highlights" 
                        type="text" 
                        placeholder="e.g. Great Wildebeest Migration, Big Five sightings, Hot air ballooning" 
                        class="w-full px-3 py-2 rounded-lg bg-neutral-50 dark:bg-zinc-800 border border-neutral-300 dark:border-zinc-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-neutral-800 dark:focus:ring-white"
                    />
                    @error('highlights') <span class="text-rose-500 text-[11px] mt-0.5 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Practical Travel Information Card -->
            <div class="p-6 rounded-2xl border border-neutral-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-xs space-y-4">
                <h2 class="text-sm font-bold text-neutral-900 dark:text-white pb-2 border-b border-neutral-100 dark:border-zinc-800">
                    Visitor & Logistics Info
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Best Time to Visit</label>
                        <input 
                            wire:model="best_time_to_visit" 
                            type="text" 
                            placeholder="June - October (Dry Season)" 
                            class="w-full px-3 py-2 rounded-lg bg-neutral-50 dark:bg-zinc-800 border border-neutral-300 dark:border-zinc-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-neutral-800 dark:focus:ring-white"
                        />
                    </div>
                    <div>
                        <label class="block font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Climate</label>
                        <input 
                            wire:model="climate" 
                            type="text" 
                            placeholder="Warm 21°C - 28°C" 
                            class="w-full px-3 py-2 rounded-lg bg-neutral-50 dark:bg-zinc-800 border border-neutral-300 dark:border-zinc-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-neutral-800 dark:focus:ring-white"
                        />
                    </div>
                    <div>
                        <label class="block font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Entry Fee Info</label>
                        <input 
                            wire:model="entry_fee_info" 
                            type="text" 
                            placeholder="$82.60 / 24 hrs" 
                            class="w-full px-3 py-2 rounded-lg bg-neutral-50 dark:bg-zinc-800 border border-neutral-300 dark:border-zinc-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-neutral-800 dark:focus:ring-white"
                        />
                    </div>
                </div>
            </div>

            <!-- Destination Photo Gallery Card -->
            <div class="p-6 rounded-2xl border border-neutral-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-xs space-y-4">
                <div class="flex items-center justify-between pb-2 border-b border-neutral-100 dark:border-zinc-800">
                    <div>
                        <h2 class="text-sm font-bold text-neutral-900 dark:text-white">Photo Gallery</h2>
                        <p class="text-[11px] text-neutral-500 dark:text-neutral-400 mt-0.5">Upload multiple scenery photos, wildlife shots, or lodges for this destination</p>
                    </div>
                    <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-neutral-100 dark:bg-zinc-800 text-neutral-600 dark:text-neutral-300">
                        {{ count($gallery) + count($galleryUploads) }} photos
                    </span>
                </div>

                <!-- Existing & Uploaded Gallery Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <!-- Current Gallery Items -->
                    @foreach($gallery as $index => $item)
                        <div class="relative group rounded-xl overflow-hidden border border-neutral-200 dark:border-zinc-700 aspect-video bg-neutral-100 dark:bg-zinc-800">
                            <img src="{{ $item }}" alt="Gallery photo" class="size-full object-cover" />
                            <button 
                                wire:click="removeGalleryItem({{ $index }})" 
                                type="button" 
                                class="absolute top-1.5 right-1.5 p-1 rounded-md bg-black/70 hover:bg-rose-600 text-white transition opacity-0 group-hover:opacity-100"
                                title="Remove photo"
                            >
                                <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endforeach

                    <!-- Staged Temporary Uploads -->
                    @foreach($galleryUploads as $index => $upload)
                        @if($upload)
                            <div class="relative group rounded-xl overflow-hidden border-2 border-dashed border-emerald-500 aspect-video bg-neutral-100 dark:bg-zinc-800">
                                <img src="{{ $upload->temporaryUrl() }}" alt="Pending upload" class="size-full object-cover" />
                                <span class="absolute bottom-1 left-1 bg-emerald-600 text-white text-[9px] px-1.5 py-0.5 rounded font-bold">New</span>
                                <button 
                                    wire:click="removePendingUpload({{ $index }})" 
                                    type="button" 
                                    class="absolute top-1.5 right-1.5 p-1 rounded-md bg-black/70 hover:bg-rose-600 text-white transition"
                                    title="Cancel upload"
                                >
                                    <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Gallery Upload Controls -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <!-- Multi-file Upload -->
                    <div>
                        <label class="block font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Upload multiple photos</label>
                        <input 
                            wire:model="galleryUploads" 
                            type="file" 
                            multiple 
                            accept="image/png,image/jpeg,image/webp" 
                            class="block w-full text-xs text-neutral-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-neutral-800 file:text-white dark:file:bg-zinc-700 hover:file:bg-neutral-700 cursor-pointer"
                        />
                        <span class="text-[10px] text-neutral-400 mt-1 block">You can select multiple photos at once</span>
                    </div>

                    <!-- URL Add -->
                    <div>
                        <label class="block font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Or add photo by URL</label>
                        <div class="flex gap-2">
                            <input 
                                wire:model="newGalleryUrl" 
                                type="text" 
                                placeholder="https://... or /images/..." 
                                class="flex-1 px-3 py-1.5 rounded-lg bg-neutral-50 dark:bg-zinc-800 border border-neutral-300 dark:border-zinc-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-neutral-800 dark:focus:ring-white"
                            />
                            <button 
                                wire:click="addGalleryUrl" 
                                type="button" 
                                class="px-3 py-1.5 rounded-lg bg-neutral-800 dark:bg-zinc-700 text-white font-medium hover:bg-neutral-700 transition shrink-0"
                            >
                                Add
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right 1 Col: Cover Photo & Publishing Settings -->
        <div class="space-y-6">
            <!-- Cover Photo Card -->
            <div class="p-6 rounded-2xl border border-neutral-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-xs space-y-4">
                <h2 class="text-sm font-bold text-neutral-900 dark:text-white pb-2 border-b border-neutral-100 dark:border-zinc-800">
                    Primary Cover Photo
                </h2>

                @if($photoUpload)
                    <div class="relative group rounded-xl overflow-hidden border border-neutral-200 dark:border-zinc-700 aspect-video">
                        <img src="{{ $photoUpload->temporaryUrl() }}" alt="Cover Preview" class="size-full object-cover" />
                        <button 
                            wire:click="removePhoto" 
                            type="button" 
                            class="absolute top-2 right-2 p-1.5 rounded-md bg-black/75 hover:bg-rose-600 text-white transition"
                        >
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @elseif($photo)
                    <div class="relative group rounded-xl overflow-hidden border border-neutral-200 dark:border-zinc-700 aspect-video">
                        <img src="{{ $photo }}" alt="Cover" class="size-full object-cover" />
                        <button 
                            wire:click="removePhoto" 
                            type="button" 
                            class="absolute top-2 right-2 p-1.5 rounded-md bg-black/75 hover:bg-rose-600 text-white transition"
                        >
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @else
                    <div class="rounded-xl border-2 border-dashed border-neutral-300 dark:border-zinc-700 p-6 flex flex-col items-center justify-center text-center">
                        <svg class="size-10 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-2">No cover image uploaded</p>
                    </div>
                @endif

                <div class="space-y-3 pt-1">
                    <div>
                        <span class="block text-[11px] text-neutral-500 dark:text-neutral-400 mb-1">Upload cover photo</span>
                        <input 
                            wire:model="photoUpload" 
                            type="file" 
                            accept="image/png,image/jpeg,image/webp" 
                            class="block w-full text-xs text-neutral-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-neutral-800 file:text-white dark:file:bg-zinc-700 hover:file:bg-neutral-700 cursor-pointer"
                        />
                    </div>
                    <div>
                        <span class="block text-[11px] text-neutral-500 dark:text-neutral-400 mb-1">Or paste image URL</span>
                        <input 
                            wire:model="photo" 
                            type="text" 
                            placeholder="https://... or /images/..." 
                            class="w-full px-3 py-1.5 rounded-lg bg-neutral-50 dark:bg-zinc-800 border border-neutral-300 dark:border-zinc-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-neutral-800 dark:focus:ring-white"
                        />
                    </div>
                </div>
            </div>

            <!-- Publishing & Status Card -->
            <div class="p-6 rounded-2xl border border-neutral-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-xs space-y-4">
                <h2 class="text-sm font-bold text-neutral-900 dark:text-white pb-2 border-b border-neutral-100 dark:border-zinc-800">
                    Publishing Settings
                </h2>

                <div>
                    <label class="block font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Display Sort Order</label>
                    <input 
                        wire:model="sort_order" 
                        type="number" 
                        min="0"
                        class="w-full px-3 py-2 rounded-lg font-mono bg-neutral-50 dark:bg-zinc-800 border border-neutral-300 dark:border-zinc-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-neutral-800 dark:focus:ring-white"
                    />
                </div>

                <div class="space-y-3 pt-2">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input 
                            wire:model="is_featured" 
                            type="checkbox" 
                            class="size-4 rounded border-neutral-300 dark:border-zinc-700 dark:bg-zinc-800 text-neutral-900 focus:ring-neutral-900 cursor-pointer"
                        />
                        <div>
                            <span class="font-semibold text-neutral-800 dark:text-neutral-200">Featured Destination</span>
                            <p class="text-[10px] text-neutral-400 dark:text-neutral-500">Showcases prominently on homepage & tour filters</p>
                        </div>
                    </label>

                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input 
                            wire:model="is_active" 
                            type="checkbox" 
                            class="size-4 rounded border-neutral-300 dark:border-zinc-700 dark:bg-zinc-800 text-neutral-900 focus:ring-neutral-900 cursor-pointer"
                        />
                        <div>
                            <span class="font-semibold text-neutral-800 dark:text-neutral-200">Active Status</span>
                            <p class="text-[10px] text-neutral-400 dark:text-neutral-500">Visible to clients and package planners</p>
                        </div>
                    </label>
                </div>

                <div class="pt-4 border-t border-neutral-100 dark:border-zinc-800">
                    <button 
                        wire:click="save" 
                        type="button" 
                        class="w-full py-2.5 rounded-lg bg-[#111217] dark:bg-white text-white dark:text-neutral-900 text-xs font-semibold hover:bg-neutral-800 dark:hover:bg-neutral-100 transition shadow-xs text-center"
                    >
                        Save & Publish
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
