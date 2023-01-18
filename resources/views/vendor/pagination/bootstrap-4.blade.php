@if ($paginator->hasPages())
    <nav class="py-3">
        <ul class="pagination justify-content-center align-items-center flex-wrap">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span style="width: 42px; height: 42px;" class="d-center text-dark page-link arrow rounded bg-secondary" aria-hidden="true">@fa(['icon' => 'chevron-left', 'mr' => 0])</span>
                </li>
            @else
                <li class="page-item">
                    <a style="width: 42px; height: 42px;" class="d-center text-dark page-link arrow rounded bg-secondary" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">@fa(['icon' => 'chevron-left', 'mr' => 0])</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="text-white opacity-4 fw-bold page-link" style="font-size: 1.2rem">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link text-secondary fw-bold link-none" style="font-size: 1.2rem" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a style="width: 42px; height: 42px;" class="d-center text-dark page-link rounded bg-secondary" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">@fa(['icon' => 'chevron-right', 'mr' => 0])</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span style="width: 42px; height: 42px;" class="d-center text-dark page-link rounded bg-secondary" aria-hidden="true">@fa(['icon' => 'chevron-right', 'mr' => 0])</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
