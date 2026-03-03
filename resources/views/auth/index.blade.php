<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Faiz Fashion</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-wrapper {
            min-height: 100vh;
        }

        .login-card {
            border: none;
            border-radius: 16px;
        }

        .form-control {
            border-radius: 8px;
            height: 45px;
        }

        .btn-login {
            border-radius: 8px;
            height: 45px;
            font-weight: 500;
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>

<body>

    <div class="container login-wrapper d-flex justify-content-center align-items-center">
        <div class="col-12 col-sm-10 col-md-6 col-lg-4">
            <div class="card shadow-sm login-card">
                <div class="card-body p-4 p-md-5">

                    <h4 class="text-center fw-semibold mb-4">Login</h4>

                    {{-- Error Message --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label small">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Masukkan email"
                                required>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label small">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan password"
                                required>
                        </div>

                        <!-- Remember -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="remember">
                            <label class="form-check-label small">Remember me</label>
                        </div>

                        <!-- Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark btn-login">
                                Login
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</body>

</html>
