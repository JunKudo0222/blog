@if ($paginator->hasPages())
    <ul class="pagination" role="navigation">
        
        
        {{-- Previous Page Link --}} 
        <li class="page-item {{ $paginator->onFirstPage() ? ' disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}">&lsaquo;</a>
        </li>


        

        
        {{-- Next Page Link --}}
        <li class="page-item {{ $paginator->currentPage() == $paginator->lastPage() ? ' disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}">&rsaquo;</a>
        </li>

        
    </ul>
@endif