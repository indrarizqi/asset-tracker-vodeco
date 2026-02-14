<x-app-layout>
    <x-slot name="title">Print Preview QR Code Labels</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Print Preview QR Code Labels') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
                    
                    <div class="w-full sm:w-1/2 relative">
                        <form method="GET" action="{{ route('assets.print') }}">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-lg leading-5 bg-gray-50 text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm transition duration-150 ease-in-out" 
                                placeholder="Cari Aset Berdasarkan ID, Nama, atau Kategori...">
                        </form>
                    </div>

                    <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                        
                        <span id="selected-count" class="text-xs font-bold text-purple-700 bg-purple-50 px-3 py-2 rounded-md hidden transition-all">
                            0 Selected
                        </span>

                        <button type="button" id="btn-select-all" class="inline-flex items-center px-4 py-2.5 border-2 border-blue-600 rounded-lg font-bold text-xs text-blue-600 uppercase tracking-widest bg-transparent hover:bg-blue-600 hover:text-white focus:outline-none transition ease-in-out duration-200">
                            Select All
                        </button>

                        <button type="button" id="btn-print" onclick="printSelected()" disabled 
                            class="inline-flex items-center px-6 py-2.5 rounded-lg font-bold text-xs uppercase tracking-widest focus:outline-none transition ease-in-out duration-200 bg-purple-600 text-white hover:bg-purple-700 focus:ring focus:ring-purple-300 disabled:bg-gray-200 disabled:text-gray-400 disabled:cursor-not-allowed">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Print
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/80 text-gray-500 text-[11px] font-extrabold uppercase tracking-wider">
                                <th class="px-6 py-4 text-center w-16">No</th>
                                
                                <th class="px-6 py-4">Asset ID</th>
                                
                                <th class="px-6 py-4">Asset Name</th>
                                
                                <th class="px-6 py-4 text-center">Asset Category</th>
                                
                                <th class="px-6 py-4 text-center">Status</th>

                                <th class="px-6 py-4">Descriptions</th>

                                <th class="px-6 py-4 text-center w-24">Options</th> 
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @foreach($assets as $asset)
                            <tr class="hover:bg-gray-50 transition-colors duration-200 group">
                                
                                <td class="px-6 py-4 text-center text-sm text-gray-400 font-medium">
                                    {{ ($assets->currentPage() - 1) * $assets->perPage() + $loop->iteration }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-bold text-gray-800 text-sm font-mono bg-gray-100 px-2 py-1 rounded">
                                        {{ $asset->asset_tag }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900 text-sm">{{ $asset->name }}</div>
                                    <div class="text-[11px] text-gray-400 mt-0.5">Kondisi: {{ $asset->condition ?? 'Baik' }}</div>
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if(strtolower($asset->category) == 'fixed')
                                        <span class="px-3 py-1 inline-flex text-[10px] leading-5 font-bold rounded-full bg-indigo-100 text-indigo-700 uppercase">
                                            FIXED
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-[10px] leading-5 font-bold rounded-full bg-purple-100 text-purple-700 uppercase">
                                            MOBILE
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @php
                                        $statusKey = strtolower(str_replace(' ', '_', $asset->status));
                                        $statusClass = 'bg-gray-100 text-gray-600'; // Default
                                        
                                        if (str_contains($statusKey, 'in_use')) {
                                            $statusClass = 'bg-green-50 text-green-600 border border-green-100';
                                        } elseif (str_contains($statusKey, 'maintenance')) {
                                            $statusClass = 'bg-blue-50 text-blue-600 border border-blue-100';
                                        } elseif (str_contains($statusKey, 'broken')) {
                                            $statusClass = 'bg-red-50 text-red-600 border border-red-100';
                                        } elseif (str_contains($statusKey, 'not_used')) {
                                            $statusClass = 'bg-yellow-50 text-yellow-600 border border-yellow-100';
                                        }
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-[10px] leading-5 font-bold rounded-full uppercase {{ $statusClass }}">
                                        {{ str_replace('_', ' ', $asset->status) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600 truncate max-w-xs">
                                    {{ $asset->description ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <input type="checkbox" value="{{ $asset->id }}" 
                                        class="asset-checkbox w-5 h-5 rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50 cursor-pointer transition-transform hover:scale-110">
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div> <div class="mt-8 flex justify-center">
                {{ $assets->links('pagination.custom') }}
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedAssets = JSON.parse(localStorage.getItem('selectedAssets')) || [];
            const checkboxes = document.querySelectorAll('.asset-checkbox');
            const btnPrint = document.getElementById('btn-print');
            const btnSelectAll = document.getElementById('btn-select-all');
            const countDisplay = document.getElementById('selected-count');

            updateUI();

            checkboxes.forEach(cb => {
                if (selectedAssets.includes(cb.value)) cb.checked = true;

                cb.addEventListener('change', function() {
                    if (this.checked) {
                        if (!selectedAssets.includes(this.value)) selectedAssets.push(this.value);
                    } else {
                        selectedAssets = selectedAssets.filter(id => id !== this.value);
                    }
                    saveAndRefresh();
                });
            });

            btnSelectAll.addEventListener('click', function() {
                const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                
                if (allChecked) {
                    checkboxes.forEach(cb => {
                        cb.checked = false;
                        selectedAssets = selectedAssets.filter(id => id !== cb.value);
                    });
                } else {
                    checkboxes.forEach(cb => {
                        if (!cb.checked) {
                            cb.checked = true;
                            if (!selectedAssets.includes(cb.value)) selectedAssets.push(cb.value);
                        }
                    });
                }
                saveAndRefresh();
            });

            function saveAndRefresh() {
                localStorage.setItem('selectedAssets', JSON.stringify(selectedAssets));
                updateUI();
            }

            function updateUI() {
                if (selectedAssets.length > 0) {
                    countDisplay.innerText = selectedAssets.length + ' Selected';
                    countDisplay.classList.remove('hidden');
                    btnPrint.disabled = false;
                    btnPrint.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    countDisplay.classList.add('hidden');
                    btnPrint.disabled = true;
                    btnPrint.classList.add('opacity-50', 'cursor-not-allowed');
                }

                // LOGIC GANTI WARNA TOMBOL SELECT/DESELECT
                const allCheckedNow = checkboxes.length > 0 && Array.from(checkboxes).every(cb => cb.checked);
                btnSelectAll.textContent = allCheckedNow ? "Deselect All" : "Select All";

                if (allCheckedNow) {
                    // JIKA DESELECT ALL
                    btnSelectAll.classList.remove('bg-transparent', 'text-blue-600', 'hover:bg-blue-600', 'hover:text-white');
                    btnSelectAll.classList.add('bg-blue-600', 'text-white', 'hover:bg-blue-700');
                } else {
                    // JIKA SELECT ALL
                    btnSelectAll.classList.add('bg-transparent', 'text-blue-600', 'hover:bg-blue-600', 'hover:text-white');
                    btnSelectAll.classList.remove('bg-blue-600', 'text-white', 'hover:bg-blue-700');
                }
            }

            window.printSelected = function() {
                if (selectedAssets.length === 0) return;
                let url = "{{ route('assets.pdf') }}"; 
                const params = new URLSearchParams();
                selectedAssets.forEach(id => params.append('selected_assets[]', id));
                window.open(url + '?' + params.toString(), '_blank');
            };
        });
    </script>
</x-app-layout>