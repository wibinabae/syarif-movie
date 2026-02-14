<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Syarif App | Movie Experience</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #00d2ff;
            --secondary-color: #3a7bd5;
            --dark-bg: #0f172a;
        }

        body {
            background-color: var(--dark-bg);
            font-family: 'Inter', sans-serif;
            color: #ffffff;
            overflow-x: hidden;
        }

        /* Modern Navbar Glassmorphism */
        .navbar-custom {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 800;
            letter-spacing: -1px;
            font-size: 1.5rem;
            background: linear-gradient(to right, var(--primary-color), #fff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-favorite {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
            color: white;
            border-radius: 8px;
            padding: 0.5rem 1.2rem;
        }

        .btn-favorite:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            transform: translateY(-2px);
            color: black;
        }

        .username-badge {
            background: rgba(255, 255, 255, 0.05);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logout-link {
            text-decoration: none;
            color: #ff4b5c;
            font-size: 0.85rem;
            font-weight: 600;
            transition: 0.3s;
        }

        .logout-link:hover {
            color: #ff8e99;
        }
    </style>
    {{-- Gabung sama tailwind biar lebij menarik tampilamya --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    @yield('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/movies') }}">SYARIF<span style="color:white">MOVIES</span></a>

            <div class="ms-auto d-flex align-items-center gap-2 gap-md-3">
                <a href="{{ url('/favorites') }}" class="btn btn-favorite d-none d-md-block">
                    <span data-key="nav_fav">⭐ My Favorites</span>
                </a>

            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')

</body>

</html>
