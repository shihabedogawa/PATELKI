@extends('layouts.main')
@section('container')

    <body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-100 to-emerald-200">

        <!-- Card Login -->
        <div class="bg-white/90 backdrop-blur shadow-2xl rounded-3xl p-10 w-full max-w-xl mt-12">

            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <img src="img/Logo PATELKI.png" alt="Logo" class="w-24 h-24 object-contain">
            </div>

            <!-- Title -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Hai, Selamat Datang 👋</h1>
                <p class="text-gray-500 text-sm mt-1">
                    Silakan login untuk melanjutkan
                </p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif


            <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email -->
                <div class="relative">
                    <input type="email" name="email" placeholder="Email" required
                        class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 
           focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                <!-- Password -->
                <div class="relative">
                    <input type="password" name="password" placeholder="Password" required
                        class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 
           focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                <button type="submit" class="w-full py-3 rounded-xl bg-green-600 text-white font-semibold">
                    Login
                </button>
            </form>


            <!-- Register -->
            <p class="text-center text-gray-500 text-sm mt-6">
                Belum punya akun?
                <a href="/register" class="text-green-600 font-semibold hover:underline">
                    Register
                </a>
            </p>

        </div>

    </body>
@endsection
