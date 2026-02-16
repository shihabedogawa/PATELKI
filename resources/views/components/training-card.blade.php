@props(['event'])

<div class="border border-emerald-100 rounded-xl bg-emerald-50 p-3 text-xs">
    <p class="uppercase text-[11px] text-emerald-700 font-semibold">
        {{ $event['category'] }}
    </p>
    <p class="text-sm font-semibold">{{ $event['title'] }}</p>
    <p class="text-slate-600 mt-1">
        {{ $event['time'] }} • {{ $event['location'] }}
    </p>

    <div class="flex flex-wrap gap-2 mt-3">
        <x-ui.badge type="success">Pendaftaran Dibuka</x-ui.badge>
        <x-ui.badge>Kuota {{ $event['quota'] }}</x-ui.badge>
    </div>
</div>
