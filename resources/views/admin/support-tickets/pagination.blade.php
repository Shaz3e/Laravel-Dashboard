@php
    $previousPageUrl = $paginator->previousPageUrl();
    $prevpageNumber = null;
    $urlParts = parse_url($previousPageUrl);
    if (isset($urlParts['query'])) {
        parse_str($urlParts['query'], $queryParams);
        if (isset($queryParams['page'])) {
            $prevpageNumber = $queryParams['page'];
        }
    }
    
    $nextPageUrl = $paginator->nextPageUrl();
    $nextpageNumber = null;
    $urlParts = parse_url($nextPageUrl);
    if (isset($urlParts['query'])) {
        parse_str($urlParts['query'], $queryParams);
        if (isset($queryParams['page'])) {
            $nextpageNumber = $queryParams['page'];
        }
    }
@endphp



<div class="mr-2">
    {{ $paginator->currentPage() }}-{{ $paginator->lastPage() }} / {{ $paginator->lastPage() }}
</div>


<div class="btn-group">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <a rel="prev" aria-label="@lang('pagination.previous')" class="btn btn-default btn-sm">
            <i class="fas fa-chevron-left"></i>
        </a>
    @else
        <a href="{{ route('admin.support-tickets.index', array_merge(request()->query(), ['page' => $prevpageNumber, 'search' => request('search'), 'priority' => request('priority'), 'status' => request('status')])) }}"
            rel="prev" aria-label="@lang('pagination.previous')" class="btn btn-default btn-sm">
            <i class="fas fa-chevron-left"></i>
        </a>
    @endif

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ route('admin.support-tickets.index', array_merge(request()->query(), ['page' => $nextpageNumber, 'search' => request('search'), 'priority' => request('priority'), 'status' => request('status')])) }}"
            rel="prev" aria-label="@lang('pagination.next')" class="btn btn-default btn-sm">
            <i class="fas fa-chevron-right"></i>
        </a>
    @else
        <a rel="prev" aria-label="@lang('pagination.next')"
            class="btn btn-default btn-sm disabled">
            <i class="fas fa-chevron-right"></i>
        </a>
    @endif
</div>
