#  Movie App (Laravel 5)

Aplikasi web untuk kebutuhan test interview di salah satu perusahaan, aplikasi ini berbasis **Laravel 5** yang terhubung ke API film eksternal (OMDB) menggunakan **Guzzle**, memungkinkan pengguna menyimpan film favorit menggunakan **Local Storage**, serta menampilkan tampilan modern dengan kombinasi **Bootstrap** dan **Tailwind CSS (CDN)**.

---

## Teknologi yang Digunakan

### Backend
- Laravel 5
- Guzzle HTTP Client
- PHP 7.3

### Frontend
- HTML
- JavaScript
- Bootstrap (CDN)
- Tailwind CSS (CDN)
- Local Storage (untuk menyimpan film favorit)

---

## Integrasi API Menggunakan Guzzle

Data film diambil dari API eksternal menggunakan **Guzzle HTTP Client** di dalam controller Laravel.

Contoh penggunaan:

```php
use GuzzleHttp\Client;

public function search(Request $request)
{
    $client = new Client();

    $response = $client->request('GET', 'https://www.omdbapi.com/', [
        'query' => [
            'apikey' => env('OMDB_API_KEY'),
            's' => $request->keyword
        ]
    ]);

    $data = json_decode($response->getBody(), true);

    return view('movies.index', compact('data'));
}
```

---

## Fitur Film Favorit (Menggunakan Local Storage)

Film favorit disimpan di browser menggunakan **Local Storage**, sehingga:

- Tidak memerlukan database
- Data tetap tersimpan meskipun halaman direfresh
- Data tersimpan berdasarkan browser dan device pengguna

Contoh implementasi:

```javascript
let favorites = JSON.parse(localStorage.getItem("favorites")) || [];

function tambahKeFavorit(movie) {
    favorites.push(movie);
    localStorage.setItem("favorites", JSON.stringify(favorites));
}
```

---

## Tampilan (UI)

Aplikasi ini menggunakan kombinasi:

### Bootstrap (CDN)
Digunakan untuk:
- Sistem grid
- Tombol
- Struktur layout

### Tailwind CSS (CDN)
Digunakan untuk:
- Styling card modern
- Rounded image
- Hover effect
- Utility styling

Contoh CDN yang digunakan:

```html
<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>
```

---

## Konsep Aplikasi

- Laravel 5 digunakan untuk mengambil data dari API menggunakan Guzzle.
- Data dikirim ke Blade view untuk ditampilkan.
- Film favorit disimpan menggunakan Local Storage (tanpa database).
- Tampilan menggunakan kombinasi Bootstrap dan Tailwind CDN.

---

## Catatan

- Pastikan versi PHP sesuai dengan kebutuhan Laravel 5.
- API key harus valid.
- Data favorit hanya tersimpan di browser pengguna (tidak tersimpan di server).

---
