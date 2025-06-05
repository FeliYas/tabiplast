@extends('layouts.guest')
@section('meta')
    <meta name="{{ $metadatos->seccion }}" content="{{ $metadatos->keyword }}">
@endsection

@section('title', __('Novedades'))

@section('content')
    <div>
        <div class="overflow-hidden">
            <div class="relative max-w-[90%] lg:max-w-[1224px] mx-auto">
                <div class="absolute top-6 left-0">
                    <div class="flex gap-1 text-xs">
                        <a href="{{ route('home') }}" class="font-bold hover:underline">{{ __('Inicio') }}</a>
                        <span>></span>
                        <a href="{{ route('novedades') }}" class="hover:underline">{{ __('Novedades') }}</a>
                    </div>
                </div>
                <div class="absolute top-40">
                    <h2 class=" font-bold text-[40px]">{{ __('Novedades') }}</h2>
                </div>
            </div>
            <img src="{{ $banner->path }}" alt="{{ __('Banner de Novedades') }}" class="w-full h-[310px] object-cover">
        </div>
        <div class="bg-gray-100">
            <div class="max-w-[90%] lg:max-w-[1224px] mx-auto py-20 grid lg:grid-cols-3 gap-6">
                @foreach ($novedadesDestacadas as $novedad)
                    <x-tarjeta-novedades :novedad="$novedad" />
                @endforeach
            </div>
        </div>

        <!-- Nueva sección con sidebar para filtros -->
        <div class="bg-white">
            <div class="max-w-[90%] lg:max-w-[1224px] mx-auto py-20">
                <div class="grid lg:grid-cols-4 gap-6">
                    <!-- Contenido principal -->
                    <div class="lg:col-span-3">
                        <div id="novedades-grid" class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach ($novedades->take(6) as $novedad)
                                <div class="novedad-item" data-epigrafe="{{ Str::slug($novedad->epigrafe) }}"
                                    data-month="{{ \Carbon\Carbon::parse($novedad->created_at)->format('Y-m') }}"
                                    data-titulo="{{ strtolower($novedad->titulo) }}"
                                    data-descripcion="{{ strtolower(strip_tags($novedad->descripcion)) }}">
                                    <x-tarjeta-novedades :novedad="$novedad" />
                                </div>
                            @endforeach
                        </div>

                        <!-- Mensaje cuando no hay resultados -->
                        <div id="no-results" class="text-center py-12 hidden">
                            <div class="text-gray-400 text-lg">
                                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <p>No se encontraron novedades</p>
                            </div>
                        </div>

                        <!-- Botón cargar más -->
                        <div class="text-center mt-8">
                            <button id="load-more"
                                class="bg-main-color text-white px-8 py-3 rounded-lg hover:bg-orange-600 transition-colors {{ $novedades->count() <= 6 ? 'hidden' : '' }}">
                                Cargar más
                            </button>
                        </div>
                    </div>
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl text-black">
                            <!-- Buscador -->
                            <div class="mb-6">
                                <div class="relative">
                                    <input type="text" id="search-novedades" placeholder="Buscar..."
                                        class="w-full px-4 py-2 pr-10 border border-gray-200 rounded-full placeholder:text-sm">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Categorías -->
                            <div x-data="{ open: true }" class="mb-6">
                                <div class="flex items-center justify-between cursor-pointer select-none"
                                    @click="open = !open">
                                    <h3 class="font-bold text-xl mb-2">Categorías</h3>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path d="M18 15L12 9L6 15" stroke="#353C47" stroke-opacity="0.5" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <hr class="mb-2 border-gray-200">
                                <div x-show="open" x-transition>
                                    <div class="space-y-2">
                                        @php
                                            $epigrafes = $novedades->groupBy('epigrafe');
                                        @endphp
                                        @foreach ($epigrafes as $epigrafe => $novedadesGrupo)
                                            <div class="filter-item cursor-pointer flex items-center justify-between  bg-gray-50 text-gray-400 hover:text-black rounded-full px-4 py-2 hover:bg-gray-100 transition-colors h-12.5"
                                                data-filter="{{ Str::slug($epigrafe) }}">
                                                <span class="font-medium">{{ ucfirst(mb_strtolower($epigrafe)) }}</span>
                                                <span class="text-black font-bold text-base">
                                                    {{ $novedadesGrupo->count() }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Archivo -->
                            <div x-data="{ open: true }">
                                <div class="flex items-center justify-between cursor-pointer select-none"
                                    @click="open = !open">
                                    <h3 class="font-bold text-xl mb-2">Archivo</h3>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path d="M18 15L12 9L6 15" stroke="#353C47" stroke-opacity="0.5" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <hr class="mb-2 border-gray-200">
                                <div x-show="open" x-transition>
                                    <div class="space-y-2">
                                        @php
                                            \Carbon\Carbon::setLocale('es');
                                            $novedadesPorMes = $novedades
                                                ->groupBy(function ($novedad) {
                                                    return \Carbon\Carbon::parse($novedad->created_at)->format('Y-m');
                                                })
                                                ->sortKeysDesc();
                                        @endphp
                                        @foreach ($novedadesPorMes->take(6) as $mes => $novedadesMes)
                                            @php
                                                $fechaMes = \Carbon\Carbon::createFromFormat('Y-m', $mes);
                                            @endphp
                                            <div class="archive-item cursor-pointer flex items-center justify-between bg-gray-50 text-gray-400 hover:text-black rounded-full px-4 py-2 hover:bg-gray-100 transition-colors h-12.5"
                                                data-month="{{ $mes }}">
                                                <span class="font-medium capitalize">
                                                    {{ $fechaMes->translatedFormat('F') }} {{ $fechaMes->year }}
                                                </span>
                                                <span class="text-black font-bold text-base">
                                                    {{ $novedadesMes->count() }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const novedades = @json($novedades);
            let currentFilter = null; // Cambiado de 'all' a null
            let currentMonth = 'all';
            let currentSearch = '';
            let visibleCount = 6;

            const novedadesGrid = document.getElementById('novedades-grid');
            const noResultsDiv = document.getElementById('no-results');
            const loadMoreBtn = document.getElementById('load-more');
            const searchInput = document.getElementById('search-novedades');

            // Función para renderizar novedades
            function renderNovedades(filteredNovedades, showCount = visibleCount) {
                novedadesGrid.innerHTML = '';

                if (filteredNovedades.length === 0) {
                    noResultsDiv.classList.remove('hidden');
                    loadMoreBtn.classList.add('hidden');
                    return;
                }

                noResultsDiv.classList.add('hidden');

                const toShow = filteredNovedades.slice(0, showCount);

                toShow.forEach(novedad => {
                    const novedadDiv = document.createElement('div');
                    novedadDiv.className = 'novedad-item';
                    novedadDiv.innerHTML = `
                        <div class="h-[488px] rounded-[10px] border border-gray-200 transition-transform duration-300 hover:shadow-2xl hover:-translate-y-1 transform group">
                            <div>
                                <img src="${novedad.path}" alt="${novedad.titulo}" class="object-cover w-full h-[260px] rounded-t-[10px] overflow-hidden">
                            </div>
                            <div class="p-4 flex flex-col justify-between h-[228px]">
                                <p class="text-main-color font-bold uppercase">${novedad.epigrafe}</p>
                                <h3 class="font-bold text-2xl text-black line-clamp-2">${novedad.titulo}</h3>
                                <div class="custom-summernote lg:text-left text-black line-clamp-2">
                                    <p>${novedad.descripcion}</p>
                                </div>
                                <a href="/novedad/${novedad.id}" class="text-gray-400 transition-colors duration-300 group-hover:text-[#F79E1C]">
                                    Leer más
                                </a>
                            </div>
                        </div>
                    `;
                    novedadesGrid.appendChild(novedadDiv);
                });

                // Mostrar/ocultar botón cargar más
                if (filteredNovedades.length > showCount) {
                    loadMoreBtn.classList.remove('hidden');
                } else {
                    loadMoreBtn.classList.add('hidden');
                }
            }

            // Función para filtrar novedades
            function filterNovedades() {
                let filtered = novedades;

                // Filtrar por epígrafe solo si hay uno seleccionado
                if (currentFilter) {
                    filtered = filtered.filter(novedad =>
                        novedad.epigrafe.toLowerCase().replace(/\s+/g, '-').replace(/[^\w-]/g, '') ===
                        currentFilter
                    );
                }

                // Filtrar por mes
                if (currentMonth !== 'all') {
                    filtered = filtered.filter(novedad => {
                        const novedadMonth = new Date(novedad.created_at).toISOString().slice(0, 7);
                        return novedadMonth === currentMonth;
                    });
                }

                // Filtrar por búsqueda
                if (currentSearch) {
                    filtered = filtered.filter(novedad =>
                        novedad.titulo.toLowerCase().includes(currentSearch) ||
                        novedad.descripcion.toLowerCase().includes(currentSearch) ||
                        novedad.epigrafe.toLowerCase().includes(currentSearch)
                    );
                }

                visibleCount = 6; // Reset visible count
                renderNovedades(filtered);
            }

            // Event listeners para filtros de categoría
            document.querySelectorAll('.filter-item').forEach(item => {
                item.addEventListener('click', function() {
                    // Remover clase activa de todos
                    document.querySelectorAll('.filter-item').forEach(f => f.classList.remove(
                        'text-main-color', 'font-bold'));

                    // Agregar clase activa al seleccionado
                    this.classList.add('text-main-color', 'font-bold');

                    currentFilter = this.dataset.filter;
                    filterNovedades();
                });
            });

            // Event listeners para archivo
            document.querySelectorAll('.archive-item').forEach(item => {
                item.addEventListener('click', function() {
                    // Remover clase activa de todos
                    document.querySelectorAll('.archive-item').forEach(f => f.classList.remove(
                        'text-main-color', 'font-bold'));

                    // Agregar clase activa al seleccionado
                    this.classList.add('text-main-color', 'font-bold');

                    currentMonth = this.dataset.month;
                    filterNovedades();
                });
            });

            // Event listener para búsqueda
            searchInput.addEventListener('input', function() {
                currentSearch = this.value.toLowerCase();
                filterNovedades();
            });

            // Event listener para cargar más
            loadMoreBtn.addEventListener('click', function() {
                visibleCount += 6;
                filterNovedades();
            });

            // Ya no hay "Todos" para marcar activo por defecto
        });
    </script>

@endsection
