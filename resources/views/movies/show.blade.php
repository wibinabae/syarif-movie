@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/movies') }}" class="text-decoration-none">Explore</a></li>
                <li class="breadcrumb-item active">{{ $movie['Title'] }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <div class="col-md-4">
                <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 20px;">
                    <img src="{{ $movie['Poster'] !== 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/400x600' }}"
                        class="img-fluid w-100" alt="{{ $movie['Title'] }}">
                </div>
            </div>

            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h1 class="fw-bold mb-1">{{ $movie['Title'] }}</h1>
                        <p class="text-muted fs-5">{{ $movie['Year'] }} • {{ $movie['Rated'] }} • {{ $movie['Runtime'] }}
                        </p>
                    </div>
                    <button id="btn-fav-detail" class="btn {{ $isFavorite ? 'btn-warning' : 'btn-outline-warning' }} btn-lg"
                        data-id="{{ $movie['imdbID'] }}" data-title="{{ $movie['Title'] }}"
                        data-poster="{{ $movie['Poster'] }}" data-year="{{ $movie['Year'] }}">
                        <i class="{{ $isFavorite ? 'fas' : 'far' }} fa-star me-2"></i>
                        <span id="fav-text">{{ $isFavorite ? 'Saved' : 'Add Favorite' }}</span>
                    </button>
                </div>

                <div class="mb-4">
                    @foreach (explode(', ', $movie['Genre']) as $genre)
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 me-1">{{ $genre }}</span>
                    @endforeach
                </div>

                <div class="row mb-4 text-center g-3">
                    @foreach ($movie['Ratings'] as $rating)
                        <div class="col-4">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted d-block text-truncate">{{ $rating['Source'] }}</small>
                                <span class="fw-bold">{{ $rating['Value'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <h5 class="fw-bold">Storyline</h5>
                <p class="text-secondary lh-lg mb-4">{{ $movie['Plot'] }}</p>

                <table class="table table-borderless small">
                    <tr>
                        <td class="text-muted ps-0" style="width: 120px;">Director</td>
                        <td class="fw-semibold">{{ $movie['Director'] }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0">Writers</td>
                        <td class="fw-semibold">{{ $movie['Writer'] }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0">Cast</td>
                        <td class="fw-semibold">{{ $movie['Actors'] }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0">Country</td>
                        <td class="fw-semibold">{{ $movie['Country'] }} ({{ $movie['Language'] }})</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#btn-fav-detail').click(function() {
            const btn = $(this);
            const icon = btn.find('i');
            const text = $('#fav-text');

            $.ajax({
                url: "{{ url('/favorites/toggle') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    imdbID: btn.data('id'),
                    Title: btn.data('title'),
                    Poster: btn.data('poster'),
                    Year: btn.data('year')
                },
                success: function(response) {
                    if (response.status === 'added') {
                        btn.removeClass('btn-outline-warning').addClass('btn-warning');
                        icon.removeClass('far').addClass('fas');
                        text.text('Saved');
                    } else {
                        btn.removeClass('btn-warning').addClass('btn-outline-warning');
                        icon.removeClass('fas').addClass('far');
                        text.text('Add Favorite');
                    }
                }
            });
        });
    </script>
@endsection
