@if ($paginator->hasPages())
  <div class="pagination-container margin-top-20">
    <nav class="pagination">
      <ul>
        @foreach ($elements as $element)
          {{-- "Three Dots" Separator --}}
          @if (is_string($element))
              <li class="blank">{{ $element }}</li>
          @endif

          {{-- Array Of Links --}}
          @if (is_array($element))
            @foreach ($element as $page => $url)
              @if ($page == $paginator->currentPage())
                <li><a href="#" class="current-page">{{ $page }}</a></li>
              @else
                <li><a href="{{ $url }}">{{ $page }}</a></li>
              @endif
            @endforeach
          @endif
        @endforeach
      </ul>
    </nav>

    <nav class="pagination-next-prev">
      <ul>
        @if ($paginator->onFirstPage())
          <li>
              <a href="#" class="prev disabled" role="button">&lsaquo;</a>
          </li>
        @else
          <li><a href="{{ $paginator->previousPageUrl() }}" class="prev" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a></li>
        @endif
        @if ($paginator->hasMorePages())
          <li><a href="{{ $paginator->nextPageUrl() }}" class="next" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</li>
        @else
          <li>
            <a href="#" class="next disabled" role="button">&rsaquo;</a>
          </li>
        @endif  
      </ul>
    </nav>
  </div>
@endif