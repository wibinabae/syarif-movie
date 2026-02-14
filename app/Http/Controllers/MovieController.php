<?php

namespace App\Http\Controllers;

use App\Services\OmdbService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', 'One Piece');
        $page = $request->get('page', 1);

        $omdb = new OmdbService();
        $data = $omdb->search($query, $page);

        if ($request->ajax()) {
            return response()->json($data);
        }

        return view('movies.index', [
            'movies' => $data['Search'] ?? [],
            'query' => $query,
            'total' => $data['totalResults'] ?? 0
        ]);
    }

    public function show($id)
    {
        $omdb = new OmdbService();
        $movie = $omdb->detail($id);

        if (!isset($movie['imdbID']) || $movie['Response'] === 'False') {
            return redirect('/movies')->with('error', 'Movie detail not found.');
        }

        $favorites = session()->get('favorites', []);
        $isFavorite = isset($favorites[$id]);

        return view('movies.show', compact('movie', 'isFavorite'));
    }
    public function favorit_index()
    {
        return view('movies.favorite');
    }
}
