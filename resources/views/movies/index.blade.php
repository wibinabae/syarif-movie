@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">

        <div class="max-w-4xl mx-auto mb-16 text-center">
            <h1 class="text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">
                {{ __('movie.explore') }}
            </h1>
            <p class="text-slate-500 mb-8">
                @if (app()->getLocale() == 'id')
                    Menampilkan hasil pencarian untuk <span
                        class="text-indigo-600 font-semibold">"{{ $query }}"</span>
                @else
                    Showing results for <span class="text-indigo-600 font-semibold">"{{ $query }}"</span>
                @endif
            </p>

            <form action="{{ url('/movies') }}" method="GET" class="relative group max-w-2xl mx-auto">
                <div
                    class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl blur opacity-20 group-focus-within:opacity-40 transition duration-1000">
                </div>
                <div
                    class="relative flex items-center bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="pl-5 text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="q"
                        class="w-full py-4 px-4 text-slate-700 focus:outline-none font-medium placeholder:text-slate-400"
                        placeholder="{{ __('movie.search_placeholder') }}" value="{{ $query }}">
                    <button type="submit"
                        class="mr-2 px-6 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-indigo-600 transition-colors">
                        {{ __('movie.search_button') }}
                    </button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8" id="movie-container">
            @forelse($movies as $movie)
                <div class="movie-item group">
                    <div
                        class="relative bg-slate-900 rounded-3xl overflow-hidden shadow-xl transition-all duration-500 hover:shadow-indigo-500/20 hover:-translate-y-3 h-full flex flex-col">

                        <div class="relative aspect-[2/3] overflow-hidden">
                            {{-- Gunakan src langsung agar gambar muncul seketika --}}
                            <img src="{{ $movie['Poster'] !== 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/400x600?text=No+Image' }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                alt="{{ $movie['Title'] }}">

                            <div
                                class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent opacity-80">
                            </div>

                            <div class="absolute top-4 left-4">
                                <span
                                    class="px-3 py-1 text-[10px] font-bold tracking-widest text-white bg-white/10 backdrop-blur-md border border-white/20 rounded-full">
                                    {{ $movie['Year'] }}
                                </span>
                            </div>
                        </div>

                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="text-white font-semibold text-sm md:text-base leading-tight truncate mb-4"
                                title="{{ $movie['Title'] }}">
                                {{ $movie['Title'] }}
                            </h3>

                            <div class="mt-auto space-y-2">
                                <a href="{{ url('/movies/' . $movie['imdbID']) }}"
                                    class="block w-full py-2 bg-white text-slate-900 text-[11px] font-bold rounded-xl text-center hover:bg-indigo-500 hover:text-white transition-all transform active:scale-95">
                                    {{ __('movie.detail') }}
                                </a>

                                {{-- Tombol Favorit dengan ID unik untuk memudahkan JS --}}
                                <button
                                    class="btn-favorite w-full flex items-center justify-center gap-2 py-2 rounded-xl bg-slate-800 text-slate-300 text-[11px] font-medium hover:bg-slate-700 transition-all border border-slate-700/50"
                                    data-id="{{ $movie['imdbID'] }}" data-title="{{ $movie['Title'] }}"
                                    data-poster="{{ $movie['Poster'] }}" data-year="{{ $movie['Year'] }}">
                                    <span class="star-icon text-sm">☆</span> <span
                                        class="btn-text">{{ __('movie.add_favorite') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-32 text-center">
                    <div
                        class="inline-flex items-center justify-center w-24 h-24 mb-6 rounded-full bg-slate-100 text-slate-300">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">{{ __('movie.no_data') }}</h3>
                    <p class="text-slate-500">Try searching for something more popular like "Avengers".</p>
                </div>
            @endforelse
        </div>

        <div id="scroll-loader" class="hidden flex justify-center py-12">
            <div class="w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        const STORAGE_KEY = 'movie_favorites';

        // 1. Fungsi Sinkronisasi Tombol (Biar warna kuning kalau sudah favorit)
        function updateFavoriteButtons() {
            const favorites = JSON.parse(localStorage.getItem(STORAGE_KEY)) || {};
            $('.btn-favorite').each(function() {
                const id = $(this).attr('data-id');
                if (favorites[id]) {
                    $(this).addClass('bg-yellow-500 text-white border-yellow-500').removeClass('bg-slate-800 text-slate-300');
                    $(this).find('.star-icon').text('★');
                    $(this).find('.btn-text').text("{{ __('movie.remove_favorite') ?? 'Favorited' }}");
                } else {
                    $(this).removeClass('bg-yellow-500 text-white border-yellow-500').addClass('bg-slate-800 text-slate-300');
                    $(this).find('.star-icon').text('☆');
                    $(this).find('.btn-text').text("{{ __('movie.add_favorite') }}");
                }
            });
        }

        // 2. Logika Klik Tombol (Event Delegation)
        $(document).on('click', '.btn-favorite', function(e) {
            e.preventDefault();
            const btn = $(this);
            const id = btn.attr('data-id');
            const movieData = {
                imdbID: id,
                Title: btn.attr('data-title'),
                Poster: btn.attr('data-poster'),
                Year: btn.attr('data-year')
            };

            let favorites = JSON.parse(localStorage.getItem(STORAGE_KEY)) || {};

            if (favorites[id]) {
                delete favorites[id];
            } else {
                favorites[id] = movieData;
            }

            localStorage.setItem(STORAGE_KEY, JSON.stringify(favorites));
            updateFavoriteButtons();
        });

        // Jalankan saat load pertama
        updateFavoriteButtons();

        // 3. Infinite Scroll (Pastikan gambar muncul & tombol update)
        let page = 1;
        let isLoading = false;
        let hasMore = true;
        const query = "{{ $query }}";

        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 600) {
                if (!isLoading && hasMore) {
                    loadMoreMovies();
                }
            }
        });

        function loadMoreMovies() {
            isLoading = true;
            page++;
            $('#scroll-loader').removeClass('hidden');

            $.ajax({
                url: "{{ url('/movies') }}",
                data: { q: query, page: page },
                type: 'GET',
                success: function(response) {
                    if (response.Response === "True" && response.Search.length > 0) {
                        appendMovies(response.Search);
                        isLoading = false;
                    } else {
                        hasMore = false;
                    }
                    $('#scroll-loader').addClass('hidden');
                }
            });
        }

        function appendMovies(movies) {
            movies.forEach(movie => {
                const poster = movie.Poster !== 'N/A' ? movie.Poster : 'https://via.placeholder.com/400x600?text=No+Image';
                const html = `
                <div class="movie-item group">
                    <div class="relative bg-slate-900 rounded-3xl overflow-hidden shadow-xl h-full flex flex-col transition-all duration-500 hover:-translate-y-3">
                        <div class="relative aspect-[2/3] overflow-hidden">
                            <img src="${poster}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent opacity-80"></div>
                        </div>
                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="text-white font-semibold text-sm truncate mb-4">${movie.Title}</h3>
                            <div class="mt-auto space-y-2">
                                <a href="{{ url('/movies') }}/${movie.imdbID}" class="block w-full py-2 bg-white text-slate-900 text-[11px] font-bold rounded-xl text-center">Detail</a>
                                <button class="btn-favorite w-full flex items-center justify-center gap-2 py-2 rounded-xl bg-slate-800 text-slate-300 text-[11px] font-medium border border-slate-700/50" 
                                        data-id="${movie.imdbID}" data-title="${movie.Title}" data-poster="${movie.Poster}" data-year="${movie.Year}">
                                    <span class="star-icon text-sm">☆</span> <span class="btn-text">Favorit</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>`;
                $('#movie-container').append(html);
            });
            updateFavoriteButtons();
        }
    });
</script>
@endsection
