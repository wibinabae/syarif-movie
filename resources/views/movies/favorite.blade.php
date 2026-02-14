@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-10">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                {{ __('movie.favorites_list') }}
            </h1>
            <p class="text-slate-500 text-sm mt-1">Movies you've saved to watch later.</p>
        </div>
        <a href="{{ url('/movies') }}" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 font-semibold rounded-2xl hover:bg-slate-50 transition-all shadow-sm">
            ← {{ __('movie.back') }}
        </a>
    </div>

    {{-- Grid Container (Akan diisi oleh JS) --}}
    <div id="favorite-container" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8">
        </div>

    {{-- Empty State (Akan muncul jika kosong) --}}
    <div id="empty-state" class="hidden py-32 text-center">
        <div class="inline-flex items-center justify-center w-24 h-24 mb-6 rounded-full bg-slate-100 text-slate-300">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-slate-800">Your library is empty</h3>
        <p class="text-slate-500 mb-8">Start adding movies you love to see them here.</p>
        <a href="{{ url('/movies') }}" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">
            Browse Movies
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        const STORAGE_KEY = 'movie_favorites';
        const container = $('#favorite-container');
        const emptyState = $('#empty-state');

        function renderFavorites() {
            const favorites = JSON.parse(localStorage.getItem(STORAGE_KEY)) || {};
            const keys = Object.keys(favorites);

            container.empty();

            if (keys.length === 0) {
                emptyState.removeClass('hidden');
                return;
            }

            emptyState.addClass('hidden');

            keys.forEach(id => {
                const movie = favorites[id];
                const card = `
                    <div class="movie-item group relative" id="fav-${movie.imdbID}">
                        <div class="relative bg-slate-900 rounded-3xl overflow-hidden shadow-xl transition-all duration-500 hover:-translate-y-2 h-full">
                            <div class="aspect-[2/3] relative overflow-hidden">
                                <img src="${movie.Poster !== 'N/A' ? movie.Poster : 'https://via.placeholder.com/400x600'}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent opacity-80"></div>
                                
                                <div class="absolute top-4 right-4">
                                    <button class="remove-favorite p-2 bg-red-500/20 backdrop-blur-md text-red-500 rounded-xl border border-red-500/30 hover:bg-red-500 hover:text-white transition-all" 
                                            data-id="${movie.imdbID}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="p-5">
                                <h6 class="text-white font-semibold truncate mb-4">${movie.Title}</h6>
                                <a href="{{ url('/movies') }}/${movie.imdbID}" class="block w-full py-2.5 bg-slate-800 text-slate-300 text-center text-xs font-bold rounded-xl border border-slate-700 hover:bg-slate-700 hover:text-white transition-all">
                                    {{ __('movie.detail') }}
                                </a>
                            </div>
                        </div>
                    </div>
                `;
                container.append(card);
            });
        }

        // Handle Remove
        $(document).on('click', '.remove-favorite', function() {
            const id = $(this).data('id');
            let favorites = JSON.parse(localStorage.getItem(STORAGE_KEY)) || {};
            
            $(`#fav-${id}`).addClass('scale-95 opacity-0 transition-all duration-300');
            
            setTimeout(() => {
                delete favorites[id];
                localStorage.setItem(STORAGE_KEY, JSON.stringify(favorites));
                renderFavorites();
            }, 300);
        });

        renderFavorites();
    });
</script>
@endsection