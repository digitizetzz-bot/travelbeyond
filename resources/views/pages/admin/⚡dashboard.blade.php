<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.admin')] #[Title('Bookings - Travel & Beyond Admin')] class extends Component
{
    /** @var array<int, string> */
    public array $selected = [];

    public string $search = '';

    public string $serviceFilter = 'all';

    public string $statusFilter = 'all';

    public ?string $activeBookingModal = null;

    public string $activeModalTab = 'items';

    /**
     * Get the active booking selected for the modal.
     *
     * @return array<string, mixed>|null
     */
    public function getSelectedBookingProperty(): ?array
    {
        if (! $this->activeBookingModal) {
            return null;
        }

        foreach ($this->bookings as $b) {
            if ($b['id'] === $this->activeBookingModal) {
                return $b;
            }
        }

        return [
            'id' => $this->activeBookingModal,
            'customer' => 'Esther Howard',
            'initials' => 'EH',
            'avatar' => null,
            'package' => '7-Day Serengeti Wildebeest Safari (Private 4x4)',
            'total' => '$1,927.89',
        ];
    }

    /**
     * Get all sample travel bookings.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getBookingsProperty(): array
    {
        $bookings = [
            [
                'id' => '#TB-192541',
                'customer' => 'Esther Howard',
                'initials' => 'EH',
                'avatar' => null,
                'avatar_bg' => 'bg-neutral-200 text-neutral-700',
                'package' => '7-Day Serengeti & Ngorongoro Safari',
                'service' => 'Safari',
                'status' => 'Confirmed',
                'products' => ['/images/tours/serengeti.jpg', '/images/tours/zanzibar.jpg'],
                'total' => '$3,127.00',
                'date' => 'Jun 19',
                'has_comment' => true,
            ],
            [
                'id' => '#TB-192540',
                'customer' => 'David Miller',
                'initials' => 'DM',
                'avatar' => null,
                'avatar_bg' => 'bg-neutral-300 text-neutral-800',
                'package' => 'Azam Marine Fast Ferry: Dar to Zanzibar (VIP)',
                'service' => 'Ferry',
                'status' => 'Confirmed',
                'products' => ['/images/tours/zanzibar.jpg'],
                'total' => '$420.00',
                'date' => 'Jun 19',
                'has_comment' => false,
            ],
            [
                'id' => '#TB-192539',
                'customer' => 'James Moore',
                'initials' => 'JM',
                'avatar' => null,
                'avatar_bg' => 'bg-stone-300 text-stone-800',
                'package' => 'Mt. Kilimanjaro Machame Route (6 Days)',
                'service' => 'Trekking',
                'status' => 'Confirmed',
                'products' => ['/images/tours/serengeti.jpg'],
                'total' => '$1,890.00',
                'date' => 'Jun 19',
                'has_comment' => false,
            ],
            [
                'id' => '#TB-192538',
                'customer' => 'Robert Anderson',
                'initials' => 'RA',
                'avatar' => null,
                'avatar_bg' => 'bg-zinc-200 text-zinc-800',
                'package' => 'Mikumi National Park 2-Day Wildlife Safari',
                'service' => 'Safari',
                'status' => 'Confirmed',
                'products' => ['/images/tours/serengeti.jpg'],
                'total' => '$640.00',
                'date' => 'Jun 19',
                'has_comment' => false,
            ],
            [
                'id' => '#TB-192537',
                'customer' => 'Jessica Martinez',
                'initials' => 'JM',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&h=100&fit=crop&crop=face',
                'avatar_bg' => '',
                'package' => 'Zanzibar Spice Tour & Sunset Dhow Cruise',
                'service' => 'Hotel',
                'status' => 'Cancelled',
                'products' => ['/images/tours/zanzibar.jpg'],
                'total' => '$1,120.00',
                'date' => 'Jun 19',
                'has_comment' => false,
            ],
            [
                'id' => '#TB-192536',
                'customer' => 'William Jackson',
                'initials' => 'WJ',
                'avatar' => null,
                'avatar_bg' => 'bg-slate-200 text-slate-700',
                'package' => 'Precision Air Flight: Kilimanjaro (JRO) to Zanzibar (ZNZ)',
                'service' => 'Flight',
                'status' => 'Confirmed',
                'products' => ['/images/tours/zanzibar.jpg'],
                'total' => '$780.00',
                'date' => 'Jun 19',
                'has_comment' => false,
            ],
            [
                'id' => '#TB-192535',
                'customer' => 'Christopher Harris',
                'initials' => 'CH',
                'avatar' => null,
                'avatar_bg' => 'bg-neutral-300 text-neutral-800',
                'package' => 'Tarangire & Lake Manyara Luxury Tented Camp (4 Days)',
                'service' => 'Safari',
                'status' => 'Confirmed',
                'products' => ['/images/tours/serengeti.jpg'],
                'total' => '$2,450.00',
                'date' => 'Jun 18',
                'has_comment' => false,
            ],
            [
                'id' => '#TB-192534',
                'customer' => 'Marcus Kenter',
                'initials' => 'MK',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face',
                'avatar_bg' => '',
                'package' => 'Stone Town Heritage Walk & Prison Island Tortoise Tour',
                'service' => 'Hotel',
                'status' => 'Confirmed',
                'products' => ['/images/tours/zanzibar.jpg'],
                'total' => '$890.00',
                'date' => 'Jun 18',
                'has_comment' => false,
            ],
            [
                'id' => '#TB-192533',
                'customer' => 'Joshua Thompson',
                'initials' => 'JT',
                'avatar' => null,
                'avatar_bg' => 'bg-stone-200 text-stone-700',
                'package' => 'Arusha National Park Walking Safari & Mount Meru Views',
                'service' => 'Safari',
                'status' => 'Pending',
                'products' => ['/images/tours/serengeti.jpg'],
                'total' => '$530.00',
                'date' => 'Jun 18',
                'has_comment' => false,
            ],
            [
                'id' => '#TB-192532',
                'customer' => 'Megan Martin',
                'initials' => 'MM',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop&crop=face',
                'avatar_bg' => '',
                'package' => 'Complete Tanzania Circuit: Serengeti, Ngorongoro & Nungwi Beach',
                'service' => 'Safari',
                'status' => 'Confirmed',
                'products' => ['/images/tours/serengeti.jpg', '/images/tours/zanzibar.jpg'],
                'total' => '$1,528.60',
                'date' => 'Jun 18',
                'has_comment' => false,
            ],
            [
                'id' => '#TB-192531',
                'customer' => 'Daniel Garcia',
                'initials' => 'DG',
                'avatar' => null,
                'avatar_bg' => 'bg-zinc-300 text-zinc-800',
                'package' => 'Zanzibar Airport Transfer & Private Chauffeur Day Pass',
                'service' => 'Ferry',
                'status' => 'Confirmed',
                'products' => ['/images/tours/zanzibar.jpg'],
                'total' => '$158.00',
                'date' => 'Jun 18',
                'has_comment' => false,
            ],
            [
                'id' => '#TB-192530',
                'customer' => 'Olivia Reed',
                'initials' => 'OR',
                'avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=100&h=100&fit=crop&crop=face',
                'avatar_bg' => '',
                'package' => 'Kilimanjaro Marangu Route "Coca-Cola" Hut Trek (5 Days)',
                'service' => 'Trekking',
                'status' => 'Confirmed',
                'products' => ['/images/tours/serengeti.jpg'],
                'total' => '$2,100.00',
                'date' => 'Jun 18',
                'has_comment' => false,
            ],
        ];

        return array_filter($bookings, function (array $booking): bool {
            if ($this->serviceFilter !== 'all' && strtolower($booking['service']) !== strtolower($this->serviceFilter)) {
                return false;
            }

            if ($this->statusFilter !== 'all' && strtolower($booking['status']) !== strtolower($this->statusFilter)) {
                return false;
            }

            if ($this->search !== '') {
                $term = strtolower($this->search);
                $matchesId = str_contains(strtolower($booking['id']), $term);
                $matchesCustomer = str_contains(strtolower($booking['customer']), $term);
                $matchesPackage = str_contains(strtolower($booking['package']), $term);

                return $matchesId || $matchesCustomer || $matchesPackage;
            }

            return true;
        });
    }

    /**
     * Toggle selection of a booking.
     */
    public function toggleSelect(string $bookingId): void
    {
        if (in_array($bookingId, $this->selected, true)) {
            $this->selected = array_values(array_diff($this->selected, [$bookingId]));
        } else {
            $this->selected[] = $bookingId;
        }
    }

    /**
     * Select or deselect all visible bookings.
     */
    public function toggleSelectAll(): void
    {
        $allIds = array_column($this->bookings, 'id');
        if (count($this->selected) === count($allIds)) {
            $this->selected = [];
        } else {
            $this->selected = $allIds;
        }
    }

    /**
     * Deselect all bookings.
     */
    public function clearSelection(): void
    {
        $this->selected = [];
    }

    /**
     * Open detailed modal for a booking.
     */
    public function openBookingModal(string $bookingId): void
    {
        $this->activeBookingModal = $bookingId;
    }

    /**
     * Close detailed modal.
     */
    public function closeBookingModal(): void
    {
        $this->activeBookingModal = null;
    }

    /**
     * Set active tab in modal.
     */
    public function setModalTab(string $tab): void
    {
        $this->activeModalTab = $tab;
    }
};
?>

<div class="flex flex-col lg:flex-row min-h-screen bg-white dark:bg-zinc-900 text-neutral-800 dark:text-neutral-100">
    <!-- CENTER COLUMN: Table & Operations -->
    <div class="flex-1 min-w-0 p-6 lg:p-8 relative">
        <!-- Top Title & Global Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-neutral-100 dark:border-neutral-800">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-white">Bookings</h1>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">Manage domestic safari packages, island tours, and ticketing</p>
            </div>
            <div class="flex items-center gap-2.5">
                <button 
                    type="button" 
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-800 hover:bg-neutral-50 dark:hover:bg-zinc-700 text-xs font-semibold text-neutral-800 dark:text-neutral-200 shadow-xs transition"
                >
                    <svg class="size-3.5 text-neutral-500 dark:text-neutral-400" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                    </svg>
                    Import
                </button>
                <button 
                    type="button" 
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-800 hover:bg-neutral-50 dark:hover:bg-zinc-700 text-xs font-semibold text-neutral-800 dark:text-neutral-200 shadow-xs transition"
                >
                    <svg class="size-3.5 text-neutral-500 dark:text-neutral-400" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
                    </svg>
                    Export
                </button>
            </div>
        </div>

        <!-- Filters Bar -->
        <div class="flex flex-wrap items-center gap-2 pt-4 pb-6" x-data="{ openServiceDropdown: false, openStatusDropdown: false }">
            <!-- Service Pill -->
            <div class="relative">
                <button 
                    @click="openServiceDropdown = !openServiceDropdown" 
                    type="button"
                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-medium bg-[#111217] dark:bg-zinc-800 text-white hover:bg-neutral-800 dark:hover:bg-zinc-700 border border-transparent dark:border-zinc-700 transition"
                >
                    <span>Service</span>
                    <span class="size-4 rounded-full bg-neutral-700 dark:bg-zinc-600 text-[10px] flex items-center justify-center font-bold">4</span>
                    <svg class="size-3 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div 
                    x-show="openServiceDropdown" 
                    @click.outside="openServiceDropdown = false" 
                    x-transition 
                    class="absolute top-full left-0 mt-1.5 w-40 rounded-lg bg-white dark:bg-zinc-800 border border-neutral-200 dark:border-zinc-700 shadow-lg py-1 z-20 text-xs text-neutral-700 dark:text-neutral-200"
                >
                    <button wire:click="$set('serviceFilter', 'all'); openServiceDropdown = false" class="w-full text-left px-3 py-1.5 hover:bg-neutral-100 dark:hover:bg-zinc-700 {{ $serviceFilter === 'all' ? 'font-bold text-neutral-900 dark:text-white' : '' }}">All Services</button>
                    <button wire:click="$set('serviceFilter', 'safari'); openServiceDropdown = false" class="w-full text-left px-3 py-1.5 hover:bg-neutral-100 dark:hover:bg-zinc-700 {{ $serviceFilter === 'safari' ? 'font-bold text-neutral-900 dark:text-white' : '' }}">Safari</button>
                    <button wire:click="$set('serviceFilter', 'trekking'); openServiceDropdown = false" class="w-full text-left px-3 py-1.5 hover:bg-neutral-100 dark:hover:bg-zinc-700 {{ $serviceFilter === 'trekking' ? 'font-bold text-neutral-900 dark:text-white' : '' }}">Trekking</button>
                    <button wire:click="$set('serviceFilter', 'ferry'); openServiceDropdown = false" class="w-full text-left px-3 py-1.5 hover:bg-neutral-100 dark:hover:bg-zinc-700 {{ $serviceFilter === 'ferry' ? 'font-bold text-neutral-900 dark:text-white' : '' }}">Ferry Transfers</button>
                    <button wire:click="$set('serviceFilter', 'flight'); openServiceDropdown = false" class="w-full text-left px-3 py-1.5 hover:bg-neutral-100 dark:hover:bg-zinc-700 {{ $serviceFilter === 'flight' ? 'font-bold text-neutral-900 dark:text-white' : '' }}">Flights</button>
                </div>
            </div>

            <!-- Status Pill -->
            <div class="relative">
                <button 
                    @click="openStatusDropdown = !openStatusDropdown" 
                    type="button"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium border border-neutral-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:bg-neutral-50 dark:hover:bg-zinc-700 text-neutral-700 dark:text-neutral-200 transition"
                >
                    <span>Status</span>
                    @if($statusFilter !== 'all')
                        <span class="font-bold text-neutral-900 dark:text-white">({{ ucfirst($statusFilter) }})</span>
                    @endif
                    <svg class="size-3 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div 
                    x-show="openStatusDropdown" 
                    @click.outside="openStatusDropdown = false" 
                    x-transition 
                    class="absolute top-full left-0 mt-1.5 w-36 rounded-lg bg-white dark:bg-zinc-800 border border-neutral-200 dark:border-zinc-700 shadow-lg py-1 z-20 text-xs text-neutral-700 dark:text-neutral-200"
                >
                    <button wire:click="$set('statusFilter', 'all'); openStatusDropdown = false" class="w-full text-left px-3 py-1.5 hover:bg-neutral-100 dark:hover:bg-zinc-700 {{ $statusFilter === 'all' ? 'font-bold text-neutral-900 dark:text-white' : '' }}">All Statuses</button>
                    <button wire:click="$set('statusFilter', 'confirmed'); openStatusDropdown = false" class="w-full text-left px-3 py-1.5 hover:bg-neutral-100 dark:hover:bg-zinc-700 {{ $statusFilter === 'confirmed' ? 'font-bold text-neutral-900 dark:text-white' : '' }}">Confirmed</button>
                    <button wire:click="$set('statusFilter', 'pending'); openStatusDropdown = false" class="w-full text-left px-3 py-1.5 hover:bg-neutral-100 dark:hover:bg-zinc-700 {{ $statusFilter === 'pending' ? 'font-bold text-neutral-900 dark:text-white' : '' }}">Pending</button>
                    <button wire:click="$set('statusFilter', 'cancelled'); openStatusDropdown = false" class="w-full text-left px-3 py-1.5 hover:bg-neutral-100 dark:hover:bg-zinc-700 {{ $statusFilter === 'cancelled' ? 'font-bold text-neutral-900 dark:text-white' : '' }}">Cancelled</button>
                </div>
            </div>

            <!-- Travel Date Pill -->
            <button 
                type="button"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium border border-neutral-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:bg-neutral-50 dark:hover:bg-zinc-700 text-neutral-700 dark:text-neutral-200 transition"
            >
                <span>Travel date</span>
                <svg class="size-3 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>

            <!-- All Filters Pill -->
            <button 
                type="button"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium border border-neutral-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:bg-neutral-50 dark:hover:bg-zinc-700 text-neutral-700 dark:text-neutral-200 transition"
            >
                <span>All filters</span>
                <svg class="size-3 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
        </div>

        <!-- Bookings Table Wrapper -->
        <div class="overflow-x-auto pb-24">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-neutral-200 dark:border-zinc-800 text-[11px] font-semibold text-neutral-400 dark:text-neutral-500 uppercase tracking-wider">
                        <th class="py-3 px-3 w-8">
                            <input 
                                type="checkbox" 
                                wire:click="toggleSelectAll" 
                                @checked(count($selected) > 0 && count($selected) === count($this->bookings))
                                class="size-4 rounded border-neutral-300 dark:border-zinc-700 dark:bg-zinc-800 text-neutral-900 focus:ring-neutral-900 cursor-pointer"
                            />
                        </th>
                        <th class="py-3 px-3">
                            <button type="button" class="inline-flex items-center gap-1 hover:text-neutral-700 dark:hover:text-neutral-300">
                                <span>Booking ID</span>
                                <svg class="size-3 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                        </th>
                        <th class="py-3 px-3">Traveler / Client</th>
                        <th class="py-3 px-3">Tour / Service</th>
                        <th class="py-3 px-3">Type</th>
                        <th class="py-3 px-3">Status</th>
                        <th class="py-3 px-3">Package</th>
                        <th class="py-3 px-3">Total</th>
                        <th class="py-3 px-3">Travel Date</th>
                        <th class="py-3 px-3 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 dark:divide-zinc-800/60 text-xs">
                    @forelse($this->bookings as $booking)
                        <tr 
                            wire:key="{{ $booking['id'] }}" 
                            class="hover:bg-neutral-50/80 dark:hover:bg-zinc-800/50 transition-colors group {{ in_array($booking['id'], $selected, true) ? 'bg-neutral-50/50 dark:bg-zinc-800/30' : '' }}"
                        >
                            <!-- Checkbox -->
                            <td class="py-3.5 px-3">
                                <input 
                                    type="checkbox" 
                                    wire:click="toggleSelect('{{ $booking['id'] }}')" 
                                    @checked(in_array($booking['id'], $selected, true))
                                    class="size-4 rounded border-neutral-300 dark:border-zinc-700 dark:bg-zinc-800 text-neutral-900 focus:ring-neutral-900 cursor-pointer"
                                />
                            </td>

                            <!-- Booking ID -->
                            <td class="py-3.5 px-3 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <button 
                                        wire:click="openBookingModal('{{ $booking['id'] }}')" 
                                        class="font-semibold text-neutral-900 dark:text-neutral-100 hover:text-emerald-700 dark:hover:text-emerald-400 transition"
                                    >
                                        {{ $booking['id'] }}
                                    </button>
                                    @if($booking['has_comment'])
                                        <svg class="size-3.5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.502 49.188 49.188 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v7.518Z" />
                                        </svg>
                                    @endif
                                </div>
                            </td>

                            <!-- Client -->
                            <td class="py-3.5 px-3 whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    @if($booking['avatar'])
                                        <img src="{{ $booking['avatar'] }}" alt="{{ $booking['customer'] }}" class="size-7 rounded-full object-cover shrink-0" />
                                    @else
                                        <div class="size-7 rounded-full flex items-center justify-center font-bold text-[10px] shrink-0 {{ $booking['avatar_bg'] }}">
                                            {{ $booking['initials'] }}
                                        </div>
                                    @endif
                                    <span class="font-medium text-neutral-800 dark:text-neutral-200">{{ $booking['customer'] }}</span>
                                </div>
                            </td>

                            <!-- Tour / Service Name -->
                            <td class="py-3.5 px-3 max-w-[220px] truncate text-neutral-700 dark:text-neutral-300" title="{{ $booking['package'] }}">
                                {{ $booking['package'] }}
                            </td>

                            <!-- Service Type -->
                            <td class="py-3.5 px-3 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded text-[11px] font-medium bg-neutral-100 dark:bg-zinc-800 text-neutral-600 dark:text-neutral-400">
                                    {{ $booking['service'] }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="py-3.5 px-3 whitespace-nowrap">
                                @if($booking['status'] === 'Confirmed')
                                    <span class="inline-flex items-center gap-1 font-semibold text-emerald-600 dark:text-emerald-400">
                                        <svg class="size-3.5 text-emerald-600 dark:text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                                        </svg>
                                        Confirmed
                                    </span>
                                @elseif($booking['status'] === 'Pending')
                                    <span class="inline-flex items-center gap-1 font-semibold text-amber-600 dark:text-amber-400">
                                        <svg class="size-3.5 text-amber-500 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        Pending
                                    </span>
                                @elseif($booking['status'] === 'Cancelled')
                                    <span class="inline-flex items-center gap-1 font-semibold text-rose-500 dark:text-rose-400">
                                        <svg class="size-3.5 text-rose-500 dark:text-rose-400" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                        </svg>
                                        Cancelled
                                    </span>
                                @endif
                            </td>

                            <!-- Package Thumbnails -->
                            <td class="py-3.5 px-3 whitespace-nowrap">
                                <div class="flex items-center gap-1.5">
                                    @foreach($booking['products'] as $productImg)
                                        <div class="size-7 rounded-md border border-neutral-200 dark:border-zinc-700 bg-neutral-50 dark:bg-zinc-800 overflow-hidden shrink-0">
                                            <img src="{{ $productImg }}" alt="Tour" class="size-full object-cover" />
                                        </div>
                                    @endforeach
                                </div>
                            </td>

                            <!-- Total -->
                            <td class="py-3.5 px-3 whitespace-nowrap font-medium text-neutral-800 dark:text-neutral-200">
                                {{ $booking['total'] }}
                            </td>

                            <!-- Travel Date -->
                            <td class="py-3.5 px-3 whitespace-nowrap text-neutral-500 dark:text-neutral-400">
                                {{ $booking['date'] }}
                            </td>

                            <!-- Row Action Menu -->
                            <td class="py-3.5 px-3 whitespace-nowrap text-right">
                                <button 
                                    wire:click="openBookingModal('{{ $booking['id'] }}')" 
                                    class="p-1 rounded text-neutral-400 hover:text-neutral-700 dark:hover:text-neutral-200 hover:bg-neutral-100 dark:hover:bg-zinc-800 transition"
                                >
                                    <svg class="size-4" fill="currentColor" viewBox="0 0 20 20">
                                        <circle cx="5" cy="10" r="1.5"/>
                                        <circle cx="10" cy="10" r="1.5"/>
                                        <circle cx="15" cy="10" r="1.5"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="py-8 text-center text-neutral-400 dark:text-neutral-500">
                                No bookings found matching your search.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Floating Selection Action Bar (Appears when items are selected) -->
        @if(count($selected) > 0)
            <div 
                x-data 
                x-transition:enter="transition ease-out duration-200" 
                x-transition:enter-start="opacity-0 translate-y-4" 
                x-transition:enter-end="opacity-100 translate-y-0"
                class="fixed bottom-6 left-1/2 -translate-x-1/2 z-40 bg-[#111217] text-white rounded-xl shadow-2xl px-3 py-2 flex items-center gap-3 border border-[#272b36]"
            >
                <!-- Deselect X -->
                <button 
                    wire:click="clearSelection" 
                    type="button" 
                    title="Deselect all"
                    class="p-1.5 rounded-lg text-neutral-400 hover:text-white hover:bg-[#20242e] transition"
                >
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="h-4 w-px bg-neutral-700"></div>

                <!-- Selected Count -->
                <span class="text-xs font-semibold text-neutral-300">
                    Selected: {{ count($selected) }}
                </span>

                <div class="h-4 w-px bg-neutral-700"></div>

                <!-- Export Action -->
                <button 
                    type="button" 
                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium hover:bg-[#20242e] transition text-neutral-200 hover:text-white"
                >
                    <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
                    </svg>
                    Export
                </button>

                <!-- Print Vouchers Action -->
                <button 
                    type="button" 
                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium hover:bg-[#20242e] transition text-neutral-200 hover:text-white"
                >
                    <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24-1.076-.641-2.072-1.18-2.969M15.75 6.75h.008v.008H15.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM6.75 6.75h.008v.008H6.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM6.75 18a2.25 2.25 0 0 0 2.25 2.25h6A2.25 2.25 0 0 0 17.25 18v-3.75H6.75V18ZM19.5 9.75h-15A2.25 2.25 0 0 0 2.25 12v3.75a2.25 2.25 0 0 0 2.25 2.25h.75V15h13.5v3h.75a2.25 2.25 0 0 0 2.25-2.25V12a2.25 2.25 0 0 0-2.25-2.25Z" />
                    </svg>
                    Print Vouchers
                </button>

                <!-- Duplicate Action -->
                <button 
                    type="button" 
                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium hover:bg-[#20242e] transition text-neutral-200 hover:text-white"
                >
                    <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                    </svg>
                    Duplicate
                </button>

                <!-- More Options -->
                <button 
                    type="button" 
                    class="p-1.5 rounded-lg text-neutral-400 hover:text-white hover:bg-[#20242e] transition"
                >
                    <svg class="size-4" fill="currentColor" viewBox="0 0 20 20">
                        <circle cx="5" cy="10" r="1.5"/>
                        <circle cx="10" cy="10" r="1.5"/>
                        <circle cx="15" cy="10" r="1.5"/>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Floating Booking Detail Popover (Faithful to Reference Card) -->
        @if($activeBookingModal)
            <div 
                class="absolute top-28 left-1/2 -translate-x-1/2 w-full max-w-sm sm:max-w-md bg-white dark:bg-zinc-800 rounded-xl shadow-2xl border border-neutral-200 dark:border-zinc-700 z-30 overflow-hidden text-neutral-800 dark:text-neutral-100"
                x-data
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
            >
                <!-- Popover Header -->
                <div class="flex items-center justify-between px-4 py-3 bg-[#111217] dark:bg-zinc-900 text-white">
                    <div class="flex items-center gap-2">
                        <!-- Drag Handle -->
                        <div class="text-neutral-500 cursor-grab">
                            <svg class="size-4" fill="currentColor" viewBox="0 0 20 20">
                                <circle cx="7" cy="5" r="1.2"/>
                                <circle cx="13" cy="5" r="1.2"/>
                                <circle cx="7" cy="10" r="1.2"/>
                                <circle cx="13" cy="10" r="1.2"/>
                                <circle cx="7" cy="15" r="1.2"/>
                                <circle cx="13" cy="15" r="1.2"/>
                            </svg>
                        </div>
                        <span class="font-semibold text-xs text-white tracking-wide">
                            Booking {{ $activeBookingModal }}
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" class="text-neutral-400 hover:text-white transition">
                            <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                        </button>
                        <button wire:click="closeBookingModal" type="button" class="text-neutral-400 hover:text-white transition">
                            <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Client Details Card -->
                <div class="p-4 border-b border-neutral-100 dark:border-zinc-700 bg-neutral-50/50 dark:bg-zinc-800/60">
                    <div class="flex items-center gap-3 mb-2.5">
                        <div class="size-8 rounded-full bg-emerald-100 dark:bg-emerald-900/60 text-emerald-800 dark:text-emerald-300 flex items-center justify-center font-bold text-xs shrink-0">
                            {{ $this->selectedBooking['initials'] ?? 'EH' }}
                        </div>
                        <div>
                            <p class="font-semibold text-xs text-neutral-900 dark:text-white">{{ $this->selectedBooking['customer'] ?? 'Esther Howard' }}</p>
                            <p class="text-[10px] text-neutral-500 dark:text-neutral-400">Lead Traveler (Party of 2)</p>
                        </div>
                    </div>
                    <div class="space-y-1 text-xs text-neutral-600 dark:text-neutral-300">
                        <div class="flex items-center gap-2">
                            <svg class="size-3.5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                            <span>brodrigues@gmail.com</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="size-3.5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                            </svg>
                            <span>+1 (415) 555-2671</span>
                        </div>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="flex border-b border-neutral-200 dark:border-zinc-700 px-4 text-xs font-semibold">
                    <button 
                        wire:click="setModalTab('items')" 
                        class="py-2.5 px-3 border-b-2 transition {{ $activeModalTab === 'items' ? 'border-neutral-900 dark:border-white text-neutral-900 dark:text-white' : 'border-transparent text-neutral-500 hover:text-neutral-800 dark:hover:text-neutral-200' }}"
                    >
                        Booked Items
                    </button>
                    <button 
                        wire:click="setModalTab('delivery')" 
                        class="py-2.5 px-3 border-b-2 transition {{ $activeModalTab === 'delivery' ? 'border-neutral-900 dark:border-white text-neutral-900 dark:text-white' : 'border-transparent text-neutral-500 hover:text-neutral-800 dark:hover:text-neutral-200' }}"
                    >
                        Travel Details
                    </button>
                    <button 
                        wire:click="setModalTab('docs')" 
                        class="py-2.5 px-3 border-b-2 transition {{ $activeModalTab === 'docs' ? 'border-neutral-900 dark:border-white text-neutral-900 dark:text-white' : 'border-transparent text-neutral-500 hover:text-neutral-800 dark:hover:text-neutral-200' }}"
                    >
                        Docs & Vouchers
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="p-4 space-y-3.5 max-h-60 overflow-y-auto">
                    @if($activeModalTab === 'items')
                        <!-- Item 1 -->
                        <div class="flex items-start gap-3">
                            <div class="size-10 rounded-md border border-neutral-200 dark:border-zinc-700 bg-neutral-50 dark:bg-zinc-800 overflow-hidden shrink-0">
                                <img src="/images/tours/serengeti.jpg" alt="Serengeti Safari" class="size-full object-cover" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-neutral-900 dark:text-white leading-snug">7-Day Serengeti Wildebeest Safari (Private 4x4)</p>
                                <p class="text-[11px] text-neutral-500 dark:text-neutral-400 mt-0.5">1 × <span class="font-semibold text-neutral-800 dark:text-neutral-200">$1,590.00</span></p>
                            </div>
                        </div>

                        <!-- Item 2 -->
                        <div class="flex items-start gap-3">
                            <div class="size-10 rounded-md border border-neutral-200 dark:border-zinc-700 bg-neutral-50 dark:bg-zinc-800 overflow-hidden shrink-0">
                                <img src="/images/tours/zanzibar.jpg" alt="Zanzibar Island" class="size-full object-cover" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-neutral-900 dark:text-white leading-snug">Zanzibar Beach Resort & Stone Town Add-on</p>
                                <p class="text-[11px] text-neutral-500 dark:text-neutral-400 mt-0.5">1 × <span class="font-semibold text-neutral-800 dark:text-neutral-200">$337.89</span></p>
                            </div>
                        </div>

                        <!-- Subtotal / Total -->
                        <div class="pt-3 border-t border-neutral-200 dark:border-zinc-700 flex items-center justify-between text-xs">
                            <span class="text-neutral-500 dark:text-neutral-400">Total:</span>
                            <span class="font-bold text-neutral-900 dark:text-white text-sm">$1,927.89</span>
                        </div>
                    @elseif($activeModalTab === 'delivery')
                        <div class="space-y-2 text-xs text-neutral-700 dark:text-neutral-300">
                            <div class="flex justify-between py-1 border-b border-neutral-100 dark:border-zinc-700/60">
                                <span class="text-neutral-500 dark:text-neutral-400">Departure</span>
                                <span class="font-semibold text-neutral-900 dark:text-white">Jun 22, 2026 (Kilimanjaro JRO)</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-neutral-100 dark:border-zinc-700/60">
                                <span class="text-neutral-500 dark:text-neutral-400">Transfer Flight</span>
                                <span class="font-mono text-emerald-600 dark:text-emerald-400">Coastal Air #CQ-142</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-neutral-100 dark:border-zinc-700/60">
                                <span class="text-neutral-500 dark:text-neutral-400">Accommodation</span>
                                <span class="font-medium text-right text-neutral-900 dark:text-white">Serengeti Serena Safari Lodge<br/>(Full Board, 2 Nights)</span>
                            </div>
                        </div>
                    @else
                        <div class="space-y-2 text-xs">
                            <a href="#" class="flex items-center justify-between p-2 rounded border border-neutral-200 dark:border-zinc-700 hover:bg-neutral-50 dark:hover:bg-zinc-700 text-neutral-700 dark:text-neutral-300">
                                <span>Booking Voucher #TB-4567</span>
                                <span class="text-neutral-400">PDF</span>
                            </a>
                            <a href="#" class="flex items-center justify-between p-2 rounded border border-neutral-200 dark:border-zinc-700 hover:bg-neutral-50 dark:hover:bg-zinc-700 text-neutral-700 dark:text-neutral-300">
                                <span>Detailed Safari Itinerary.pdf</span>
                                <span class="text-neutral-400">PDF</span>
                            </a>
                            <a href="#" class="flex items-center justify-between p-2 rounded border border-neutral-200 dark:border-zinc-700 hover:bg-neutral-50 dark:hover:bg-zinc-700 text-neutral-700 dark:text-neutral-300">
                                <span>National Park Entry Permits</span>
                                <span class="text-neutral-400">PDF</span>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Popover Action Footer -->
                <div class="flex items-center justify-between px-4 py-2.5 bg-neutral-50 dark:bg-zinc-900 border-t border-neutral-200 dark:border-zinc-700 text-xs">
                    <div class="flex items-center gap-3">
                        <button type="button" class="inline-flex items-center gap-1 font-medium text-neutral-700 dark:text-neutral-300 hover:text-neutral-900 dark:hover:text-white">
                            <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
                            </svg>
                            Export
                        </button>
                        <button type="button" class="inline-flex items-center gap-1 font-medium text-neutral-700 dark:text-neutral-300 hover:text-neutral-900 dark:hover:text-white">
                            <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                            </svg>
                            Duplicate
                        </button>
                        <button type="button" class="inline-flex items-center gap-1 font-medium text-neutral-700 dark:text-neutral-300 hover:text-neutral-900 dark:hover:text-white">
                            <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24-1.076-.641-2.072-1.18-2.969M15.75 6.75h.008v.008H15.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM6.75 6.75h.008v.008H6.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM6.75 18a2.25 2.25 0 0 0 2.25 2.25h6A2.25 2.25 0 0 0 17.25 18v-3.75H6.75V18ZM19.5 9.75h-15A2.25 2.25 0 0 0 2.25 12v3.75a2.25 2.25 0 0 0 2.25 2.25h.75V15h13.5v3h.75a2.25 2.25 0 0 0 2.25-2.25V12a2.25 2.25 0 0 0-2.25-2.25Z" />
                            </svg>
                            Print
                        </button>
                    </div>

                    <button type="button" class="text-neutral-400 hover:text-neutral-700 dark:hover:text-white">
                        <svg class="size-4" fill="currentColor" viewBox="0 0 20 20">
                            <circle cx="5" cy="10" r="1.5"/>
                            <circle cx="10" cy="10" r="1.5"/>
                            <circle cx="15" cy="10" r="1.5"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- RIGHT COLUMN: Analytics & Metrics Rail -->
    <div class="w-full lg:w-[320px] shrink-0 border-t lg:border-t-0 lg:border-l border-neutral-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 space-y-7">
        <!-- 1. BOOKING REVENUE (Semi-circular Donut Chart) -->
        <div class="space-y-4">
            <h3 class="text-[11px] font-bold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                Booking Revenue
            </h3>

            <!-- Semi-circle Gauge -->
            <div class="relative flex flex-col items-center justify-center">
                <svg viewBox="0 0 200 110" class="w-48 overflow-visible">
                    <!-- Background Track Arc (180 degrees) -->
                    <path 
                        d="M 20 100 A 80 80 0 0 1 180 100" 
                        fill="none" 
                        stroke="currentColor"
                        class="text-neutral-200 dark:text-zinc-800"
                        stroke-width="14" 
                        stroke-linecap="round"
                    />
                    <!-- Progress Arc -->
                    <path 
                        d="M 20 100 A 80 80 0 0 1 180 100" 
                        fill="none" 
                        stroke="#2d5f47" 
                        stroke-width="14" 
                        stroke-linecap="round"
                        stroke-dasharray="251.2"
                        stroke-dashoffset="88"
                    />
                </svg>
                <!-- Center Metrics in Arc -->
                <div class="absolute bottom-1 text-center">
                    <p class="text-2xl font-bold text-neutral-900 dark:text-white tracking-tight">$2.2m</p>
                    <p class="text-[11px] text-neutral-500 dark:text-neutral-400">242 bookings</p>
                </div>
            </div>

            <!-- Gauge Breakdown Legend -->
            <div class="grid grid-cols-2 gap-4 pt-2">
                <div class="flex items-start gap-2">
                    <span class="size-2 rounded-xs bg-[#2d5f47] shrink-0 mt-1"></span>
                    <div>
                        <p class="text-xs font-bold text-neutral-900 dark:text-white">$864,600</p>
                        <p class="text-[10px] text-neutral-500 dark:text-neutral-400">95 Safaris & Tours</p>
                    </div>
                </div>
                <div class="flex items-start gap-2">
                    <span class="size-2 rounded-xs bg-neutral-300 dark:bg-zinc-700 shrink-0 mt-1"></span>
                    <div>
                        <p class="text-xs font-bold text-neutral-900 dark:text-white">$1.34m</p>
                        <p class="text-[10px] text-neutral-500 dark:text-neutral-400">147 Ticketing & Hotels</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="h-px bg-neutral-100 dark:bg-zinc-800"></div>

        <!-- 2. BOOKINGS STATUS -->
        <div class="space-y-3.5">
            <div class="flex items-center justify-between">
                <h3 class="text-[11px] font-bold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                    Bookings Status
                </h3>
                <button type="button" class="inline-flex items-center gap-1 text-xs text-neutral-700 dark:text-neutral-300 font-medium hover:text-neutral-900 dark:hover:text-white">
                    <span>Active</span>
                    <svg class="size-3 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
            </div>

            <!-- Segmented Progress Bar -->
            <div class="w-full h-2.5 rounded-full overflow-hidden flex bg-neutral-100 dark:bg-zinc-800 gap-0.5">
                <div class="bg-[#2d5f47] h-full" style="width: 89%" title="Confirmed: 89%"></div>
                <div class="bg-amber-500 h-full" style="width: 8%" title="Pending: 8%"></div>
                <div class="bg-neutral-300 dark:bg-zinc-700 h-full" style="width: 3%" title="Cancelled: 3%"></div>
            </div>

            <!-- Status Breakdown Legend -->
            <div class="space-y-1.5 text-xs">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="size-2 rounded-xs bg-[#2d5f47]"></span>
                        <span class="text-neutral-600 dark:text-neutral-400">Confirmed</span>
                    </div>
                    <span class="font-bold text-neutral-900 dark:text-white">89%</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="size-2 rounded-xs bg-amber-500"></span>
                        <span class="text-neutral-600 dark:text-neutral-400">Pending</span>
                    </div>
                    <span class="font-bold text-neutral-900 dark:text-white">8%</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="size-2 rounded-xs bg-neutral-300 dark:bg-zinc-700"></span>
                        <span class="text-neutral-600 dark:text-neutral-400">Cancelled</span>
                    </div>
                    <span class="font-bold text-neutral-900 dark:text-white">3%</span>
                </div>
            </div>
        </div>

        <div class="h-px bg-neutral-100 dark:bg-zinc-800"></div>

        <!-- 3. OVERVIEW METRICS GRID -->
        <div class="space-y-3.5">
            <div class="flex items-center justify-between">
                <h3 class="text-[11px] font-bold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                    Overview
                </h3>
                <button type="button" class="inline-flex items-center gap-1 text-xs text-neutral-700 dark:text-neutral-300 font-medium hover:text-neutral-900 dark:hover:text-white">
                    <span>This month</span>
                    <svg class="size-3 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
            </div>

            <!-- 2x3 Metric Cards Grid -->
            <div class="grid grid-cols-2 gap-y-4 gap-x-3 text-xs">
                <div>
                    <p class="text-sm font-bold text-neutral-900 dark:text-white">$2,246.75</p>
                    <p class="text-[10px] text-neutral-500 dark:text-neutral-400 mt-0.5">Average booking</p>
                </div>
                <div>
                    <p class="text-sm font-bold text-neutral-900 dark:text-white">$2.2m</p>
                    <p class="text-[10px] text-neutral-500 dark:text-neutral-400 mt-0.5">Total revenue</p>
                </div>
                <div>
                    <p class="text-sm font-bold text-neutral-900 dark:text-white">16 min</p>
                    <p class="text-[10px] text-neutral-500 dark:text-neutral-400 mt-0.5">Response time</p>
                </div>
                <div>
                    <p class="text-sm font-bold text-neutral-900 dark:text-white">2.4</p>
                    <p class="text-[10px] text-neutral-500 dark:text-neutral-400 mt-0.5">Avg. travelers/trip</p>
                </div>
                <div>
                    <p class="text-sm font-bold text-neutral-900 dark:text-white">0.32%</p>
                    <p class="text-[10px] text-neutral-500 dark:text-neutral-400 mt-0.5">Pending inquiries</p>
                </div>
                <div>
                    <p class="text-sm font-bold text-neutral-900 dark:text-white">0.51%</p>
                    <p class="text-[10px] text-neutral-500 dark:text-neutral-400 mt-0.5">Cancellation rate</p>
                </div>
            </div>
        </div>

        <div class="h-px bg-neutral-100 dark:bg-zinc-800"></div>

        <!-- 4. TOP PACKAGES -->
        <div class="space-y-3.5">
            <div class="flex items-center justify-between">
                <h3 class="text-[11px] font-bold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                    Top Packages
                </h3>
                <button type="button" class="inline-flex items-center gap-1 text-xs text-neutral-700 dark:text-neutral-300 font-medium hover:text-neutral-900 dark:hover:text-white">
                    <span>This month</span>
                    <svg class="size-3 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
            </div>

            <!-- Top Package Item -->
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-2.5 overflow-hidden">
                    <div class="size-9 rounded-md border border-neutral-200 dark:border-zinc-700 bg-neutral-50 dark:bg-zinc-800 overflow-hidden shrink-0">
                        <img src="/images/tours/serengeti.jpg" alt="Serengeti Safari" class="size-full object-cover" />
                    </div>
                    <div class="truncate">
                        <p class="text-xs font-medium text-neutral-900 dark:text-white truncate">
                            7-Day Serengeti & Ngorongoro Safari
                        </p>
                    </div>
                </div>
                <span class="text-xs font-semibold text-neutral-500 dark:text-neutral-400 shrink-0">14</span>
            </div>
        </div>
    </div>
</div>