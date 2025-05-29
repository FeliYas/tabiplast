@props(['novedad'])

<div class="h-[521px] rounded-[10px] border border-gray-200">
    <div class="p-2.5">
        <img src="{{ $novedad->path }}" alt="{{ getLocalizedField($novedad, 'titulo') }}"
            class="object-cover w-full h-[242px] rounded-[10px] overflow-hidden">
    </div>
    <div class="py-1 px-4 h-[270px] flex flex-col justify-between">
        <div class="flex flex-col gap-2">
            <h3 class="text-xl font-semibold text-black line-clamp-3">{{ getLocalizedField($novedad, 'titulo') }}</h3>
            <hr class="w-full border-t border-[#E4E4E4] opacity-40">
            <div class="text-black line-clamp-3 h-[76px]">{!! getLocalizedField($novedad, 'descripcion') !!}</div>
        </div>
        <div class="flex gap-6 text-black h-15 mb-3.5">
            <a href="{{ route('novedad', $novedad->id) }}"
                class="hover:underline text-[#F9363E] mt-8 text-sm font-semibold">{{ __('LEER MÁS') }}</a>
        </div>
    </div>
</div>
