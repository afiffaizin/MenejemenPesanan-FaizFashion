<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login — FaizFashion Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Login ke FaizFashion Management System">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.svg') }}">

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="font-sans bg-gray-50 antialiased">

    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-md">

            {{-- Logo --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 mb-4">
                    <img src="{{ asset('images/logo.svg') }}" alt="FaizFashion Logo" class="w-full h-full object-contain">
                </div>
                <h1 class="text-xl font-bold text-gray-900">FaizFashion</h1>
                <p class="text-sm text-gray-500 mt-1">Management System</p>
            </div>

            {{-- Login Card --}}
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-lg font-bold text-gray-900 text-center mb-6">Masuk ke Akun Anda</h2>

                {{-- Error --}}
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700 flex items-center gap-2">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-600 mb-1.5">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-envelope text-gray-400"></i>
                            </div>
                            <input type="email" name="email" id="email"
                                   class="w-full pl-10 pr-4 py-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   placeholder="Masukkan email" required autofocus>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-600 mb-1.5">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-lock text-gray-400"></i>
                            </div>
                            <input type="password" name="password" id="password"
                                   class="w-full pl-10 pr-4 py-3 text-sm border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   placeholder="Masukkan password" required>
                        </div>
                    </div>

                    {{-- Remember --}}
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember"
                                   class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 transition-colors">
                            <span class="text-sm text-gray-600">Ingat saya</span>
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="w-full py-3 text-sm font-semibold text-white bg-slate-900 rounded-lg shadow-sm hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition-colors">
                        Masuk
                    </button>
                </form>
            </div>

            {{-- Footer --}}
            <p class="text-center text-xs text-gray-400 mt-6">
                &copy; {{ date('Y') }} FaizFashion Management System
            </p>
        </div>
    </div>

    @include('sweetalert::alert')
</body>

</html>
