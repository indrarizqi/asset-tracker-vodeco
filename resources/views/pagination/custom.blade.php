@if ($paginator->hasPages())
    <div class="flex flex-col items-center my-2">
        
        <p class="text-xs text-gray-500 mb-4">
            Showing <span class="font-bold">{{ $paginator->firstItem() }}</span> 
            to <span class="font-bold">{{ $paginator->lastItem() }}</span> 
            of <span class="font-bold">{{ $paginator->total() }}</span> results
        </p>

        <div class="inline-flex rounded-md shadow-sm bg-white">
            
            {{-- Tombol Previous --}}
            @if ($paginator->onFirstPage())
                <span class="flex items-center justify-center px-4 py-2 text-gray-300 border border-gray-300 rounded-l-md bg-gray-50 cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="flex items-center justify-center px-4 py-2 text-gray-600 border border-gray-300 rounded-l-md hover:bg-gray-100 hover:text-purple-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
            @endif

            {{-- Angka Halaman --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="flex items-center justify-center px-4 py-2 text-gray-400 border-t border-b border-gray-300">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="flex items-center justify-center px-4 py-2 text-white bg-purple-600 border border-purple-600 font-bold">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="flex items-center justify-center px-4 py-2 text-gray-600 border-t border-b border-r border-gray-300 hover:bg-gray-100 transition">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="flex items-center justify-center px-4 py-2 text-gray-600 border border-gray-300 rounded-r-md hover:bg-gray-100 hover:text-purple-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            @else
                <span class="flex items-center justify-center px-4 py-2 text-gray-300 border border-gray-300 rounded-r-md bg-gray-50 cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </span>
            @endif
        </div>
    </div>
@endif