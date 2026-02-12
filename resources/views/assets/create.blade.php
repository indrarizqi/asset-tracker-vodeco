<x-app-layout>
    <x-slot name="title">Create Asset</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Aset Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('assets.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Aset</label>
                            <input type="text" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Laptop Dell Latitude 7490" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Kategori Aset</label>
                            <select name="category" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="" disabled selected></option>
                                <option value="mobile">Mobile Asset (Laptop, Tablet, Tools)</option>
                                <option value="semi-mobile">Semi-Mobile (PC, Printer, Router)</option>
                                <option value="fixed">Fixed Asset (AC, CCTV, Meja)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kondisi Fisik</label>
                            <select name="condition" class="w-full border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                                <option value="Baik" {{ (isset($asset) && $asset->condition == 'Baik') ? 'selected' : '' }}>
                                    Baik
                                </option>
                                
                                <option value="Rusak" {{ (isset($asset) && $asset->condition == 'Rusak') ? 'selected' : '' }}>
                                    Rusak
                                </option>
                                
                                <option value="Rusak Total" {{ (isset($asset) && $asset->condition == 'Rusak Total') ? 'selected' : '' }}>
                                    Rusak Total
                                </option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Penanggung Jawab</label>
                            <p class="text-gray-500 text-sm">Kosongkan saja bila tidak ada PJ</p>
                            <input type="text" name="person_in_charge" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="GA Staff / Bang Alam">
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Simpan
                            </button>
                            <a href="{{ route('dashboard') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>