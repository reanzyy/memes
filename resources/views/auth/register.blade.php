<!DOCTYPE html>
<html data-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Register</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&amp;display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>

<body>
    <div class="hero min-h-screen bg-base-200">
        <div class="card flex-shrink-0 w-96 shadow-2xl bg-base-100">
            <div class="card-body">
                <x-alert />
                <form action="{{ route('register.process') }}" method="post">
                    @csrf
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Nama</span>
                        </label>
                        <input type="text" name="name" placeholder="Masukan nama anda"
                            class="input input-bordered @error('name') input-error @enderror" />
                        <label class="label">
                            @error('name')
                                <small class="label-text text-red-600">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Username</span>
                        </label>
                        <input type="text" name="username" placeholder="Masukan username anda"
                            value="{{ old('username') }}"
                            class="input input-bordered @error('username') input-error @enderror" />
                        <label class="label">
                            @error('username')
                                <small class="label-text text-red-600">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Password</span>
                        </label>
                        <input type="password" name="password" placeholder="Masukan password anda"
                            class="input input-bordered @error('password') input-error @enderror" />
                        <label class="label">
                            @error('password')
                                <small class="label-text text-red-600">{{ $message }}</small>
                            @enderror
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Konfirmasi Password</span>
                        </label>
                        <input type="password" name="password_confirmation" placeholder="Masukan password anda"
                            class="input input-bordered @error('password_confirmation') input-error @enderror" />
                        <label class="label">
                            @error('password_confirmation')
                                <small class="label-text text-red-600">{{ $message }}</small>
                            @enderror
                            <span></span>
                            <span class="label-text"><a href="{{ route('login') }}" class="link link-hover">Sudah punya
                                    akun?</a></span>
                        </label>
                    </div>
                    <div class="form-control mt-6">
                        <button class="btn btn-primary">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
