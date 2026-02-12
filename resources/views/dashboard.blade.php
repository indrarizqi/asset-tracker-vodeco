<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-4 rounded-xl shadow-sm mb-6 flex flex-col sm:flex-row justify-between items-center gap-4 border border-gray-100">
    
                <form method="GET" action="{{ route('dashboard') }}" class="w-full sm:w-1/2 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-lg leading-5 bg-gray-50 text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm transition" 
                        placeholder="Cari Aset Berdasarkan ID, Nama, atau Kategori...">
                </form>

                <div class="flex gap-3 w-full sm:w-auto justify-end">
                    <a href="{{ route('assets.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md">
                        + Add New
                    </a>
                    <a href="{{ route('report.assets') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-900 focus:outline-none focus:border-purple-900 focus:ring ring-purple-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        PDF Report
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto bg-white rounded-xl shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
                    <table class="min-w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/80 text-gray-500 text-[11px] font-extrabold uppercase tracking-wider">
                                <th class="px-4 py-4 w-10 text-center">No</th>
                                <th class="px-4 py-4 whitespace-nowrap">Asset ID</th>
                                <th class="px-4 py-4">Asset Name</th>
                                <th class="px-4 py-4">Person In Charge & Info</th>
                                <th class="px-4 py-4 text-center">Asset Category</th>
                                <th class="px-4 py-4 text-center">Status</th>
                                <th class="px-4 py-4">Descriptions</th>
                                <th class="px-4 py-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @foreach($assets as $asset)
                            <tr class="hover:bg-blue-50/40 transition-colors duration-200 group">
                                <td class="px-4 py-4 text-sm text-gray-400 font-medium text-center">
                                    {{ ($assets->currentPage() - 1) * $assets->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="font-mono font-bold text-gray-800 bg-gray-100 px-2 py-1 rounded-md text-sm group-hover:bg-white transition">
                                        {{ $asset->asset_tag }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="font-bold text-gray-900 text-sm">{{ $asset->name }}</div>
                                    <div class="text-[11px] text-gray-500 mt-1">
                                        Kondisi: 
                                        @php
                                            $kondisi = $asset->condition ?? 'Baik';
                                            $warnaKondisi = 'text-green-600';
                                            if (stripos($kondisi, 'rusak') !== false) $warnaKondisi = 'text-yellow-600';
                                            if (stripos($kondisi, 'total') !== false || stripos($kondisi, 'berat') !== false) $warnaKondisi = 'text-red-500 font-bold';
                                        @endphp
                                        <span class="font-medium {{ $warnaKondisi }}">{{ $kondisi }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center text-sm font-semibold text-gray-700">
                                        <svg class="w-4 h-4 text-blue-500 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        {{ $asset->person_in_charge ?? '-' }}
                                    </div>
                                    <div class="flex items-center text-[11px] text-gray-400 mt-1 font-medium">
                                        <svg class="w-3.5 h-3.5 text-red-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Date : {{ $asset->purchase_date ? \Carbon\Carbon::parse($asset->purchase_date)->format('d M Y') : '-' }}
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center whitespace-nowrap">
                                    <span class="inline-block px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-gradient-to-r from-blue-500 to-purple-500 text-white shadow-sm">
                                        {{ $asset->category }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center whitespace-nowrap">
                                    @php
                                        $statusKey = strtolower(str_replace(' ', '_', $asset->status));
                                        $colorClass = 'bg-gray-100 text-gray-700'; 
                                        if (str_contains($statusKey, 'available')) { $colorClass = 'bg-green-100 text-green-700 border border-green-200'; } 
                                        elseif (str_contains($statusKey, 'use')) { $colorClass = 'bg-blue-100 text-blue-700 border border-blue-200'; } 
                                        elseif (str_contains($statusKey, 'maintenance')) { $colorClass = 'bg-yellow-100 text-yellow-700 border border-yellow-200'; } 
                                        elseif (str_contains($statusKey, 'unrepairable') || str_contains($statusKey, 'rusak')) { $colorClass = 'bg-red-100 text-red-700 border border-red-200'; }
                                    @endphp
                                    <span class="inline-block px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider rounded-full {{ $colorClass }}">
                                        {{ str_replace('_', ' ', $asset->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-600 truncate max-w-[150px]" title="{{ $asset->description }}">
                                    {{ $asset->description }}
                                </td>
                                
                                <td class="px-4 py-4 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('assets.edit', $asset->id) }}" title="Edit Aset"
                                            class="p-2 text-blue-500 bg-blue-50 hover:bg-blue-600 hover:text-white rounded-lg transition-all duration-200 shadow-sm border border-blue-100">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>

                                        <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" class="inline m-0 p-0 form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus Aset"
                                                class="p-2 text-red-500 bg-red-50 hover:bg-red-600 hover:text-white rounded-lg transition-all duration-200 shadow-sm cursor-pointer border border-red-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                </table>
            </div> 
        </div> 
        
        <div class="mt-8 flex justify-center">
            {{ $assets->links('pagination.custom') }}
        </div>

    </div>

    <input type="hidden" id="flash-success" value="{{ session('success') }}">
    <input type="hidden" id="flash-error" value="{{ session('error') }}">

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // Ambil data dari elemen rahasia di atas
            const successInput = document.getElementById('flash-success');
            const errorInput = document.getElementById('flash-error');
            
            const successMessage = successInput ? successInput.value : '';
            const errorMessage = errorInput ? errorInput.value : '';

            // LOGIC POPUP SUKSES
            if (successMessage) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: successMessage,
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top',
                    background: '#fff',
                    iconColor: '#10b981', 
                    customClass: {
                        popup: 'rounded-xl shadow-xl border border-gray-100'
                    }
                });
            }

            // LOGIC POPUP ERROR
            if (errorMessage) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Memuat!',
                    text: errorMessage,
                });
            }

            // LOGIC KONFIRMASI DELETE
            const deleteForms = document.querySelectorAll('.form-delete');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault(); // Cegah submit langsung
                    
                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        text: "Data aset ini akan dihapus secara permanen!",
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
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>