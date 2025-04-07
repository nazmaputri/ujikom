<nav role="navigation" aria-label="Pagination Navigation" class="flex justify-end mt-4">
    <ul class="inline-flex items-center space-x-1 text-sm">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="px-3 py-1 bg-gray-200 text-gray-700 rounded">‹</li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100">‹</a>
            </li>
        @endif

        {{-- Only show current page and its neighbors --}}
        @php
            $currentPage = $paginator->currentPage();
            $lastPage = $paginator->lastPage();
            $start = max($currentPage - 1, 1);
            $end = min($currentPage + 1, $lastPage);
        @endphp

        @for ($i = $start; $i <= $end; $i++)
            @if ($i == $currentPage)
                <li class="px-3 py-1 bg-sky-300 text-white rounded">{{ $i }}</li>
            @else
                <li>
                    <a href="{{ $paginator->url($i) }}" class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100 text-gray-700">{{ $i }}</a>
                </li>
            @endif
        @endfor

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100">›</a>
            </li>
        @else
            <li class="px-3 py-1 bg-gray-200 text-gray-500 rounded">›</li>
        @endif

    </ul>
</nav>
