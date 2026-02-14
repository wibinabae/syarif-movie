<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Syarif App</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>

    <div class="login-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-8 col-md-6 col-lg-4">

                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-primary">SYARIF MOVIES</h2>
                        <p class="text-muted">Please sign in to your account</p>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ url('/login') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="username" class="form-label small fw-bold">Username</label>
                                    <input type="text" name="username" id="username" class="form-control"
                                        placeholder="aldmic" required autofocus>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label small fw-bold">Password</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="••••••••" required>
                                </div>

                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary fw-bold">
                                        Login
                                    </button>
                                </div>
                            </form>

                        </div>

                    </div>

                    <p class="text-center text-muted small mt-4">
                        &copy; {{ date('Y') }} Syarif Hidayat - Movie Test
                    </p>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
