<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Dashboard' }} - {{ config('app.name') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>

        <input type="hidden" id="global-flash-success" value="{{ session('success') }}">
        <input type="hidden" id="global-flash-error" value="{{ session('error') }}">

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // A. NOTIFIKASI TOAST (Login, Create, Update)
                const successMsg = document.getElementById('global-flash-success').value;
                const errorMsg = document.getElementById('global-flash-error').value;

                if (successMsg) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: successMsg,
                        timer: 3000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top',
                        background: '#fff',
                        iconColor: '#10b981',
                        customClass: { popup: 'rounded-xl shadow-xl border border-gray-100' }
                    });
                }

                if (errorMsg) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Memuat!',
                        text: errorMsg,
                    });
                }

                // B. KONFIRMASI LOGOUT
                const logoutForms = document.querySelectorAll('.form-logout');
                logoutForms.forEach(form => {
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Konfirmasi Logout',
                            text: "Pastikan Aktivitas Anda Sudah Disimpan",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#ef4444', 
                            cancelButtonColor: '#6b7280', 
                            confirmButtonText: 'Keluar',
                            cancelButtonText: 'Batal',
                            reverseButtons: true, 
                            background: '#fff',
                            customClass: {
                                popup: 'rounded-xl shadow-xl border border-gray-100',
                                confirmButton: 'px-6 py-2.5 rounded-lg font-bold shadow-lg',
                                cancelButton: 'px-6 py-2.5 rounded-lg font-bold'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });

                // 3. KONFIRMASI DELETE
                const deleteForms = document.querySelectorAll('.form-delete');
                deleteForms.forEach(form => {
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Konfirmasi Hapus',
                            text: "Data ini akan dihapus secara permanen!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ef4444', 
                            cancelButtonColor: '#6b7280', 
                            confirmButtonText: 'Hapus',
                            cancelButtonText: 'Batal',
                            reverseButtons: true, 
                            background: '#fff',
                            customClass: {
                                popup: 'rounded-xl shadow-xl border border-gray-100',
                                confirmButton: 'px-6 py-2.5 rounded-lg font-bold shadow-lg',
                                cancelButton: 'px-6 py-2.5 rounded-lg font-bold'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) form.submit();
                        });
                    });
                });
            });
        </script>
    </body>
</html>