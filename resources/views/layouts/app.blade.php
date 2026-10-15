@if(auth()->user()?->hasRole('admin'))
    <x-layouts::admin :title="$title ?? null">
        <div class="p-6 lg:p-8 max-w-4xl">
            {{ $slot }}
        </div>
    </x-layouts::admin>
@else
    <x-layouts::app.sidebar :title="$title ?? null">
        <flux:main>
            {{ $slot }}
        </flux:main>
    </x-layouts::app.sidebar>
@endif
