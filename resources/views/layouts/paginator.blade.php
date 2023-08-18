<nav aria-label="paginator">
    <ul class="pagination justify-content-center">
        @if ($data->onFirstPage())
            <li class="page-item disabled">
                <a class="page-link" href="{{$data->previousPageUrl()}}" tabindex="-1" aria-disabled="true">Предыдущая</a>
            </li>
            @else
            <li class="page-item">
                <a class="page-link" href="{{$data->previousPageUrl()}}" tabindex="-1" aria-disabled="true">Предыдущая</a>
            </li>
        @endif

        @for ($i = 1; $i <= $data->lastPage(); $i++)
            @if ($i == $data->currentPage())
                <li class="page-item disabled"><a class="page-link" href="{{$data->url($i)}}">{{$i}}</a></li>
                @else
                <li class="page-item"><a class="page-link" href="{{$data->url($i)}}">{{$i}}</a></li>
            @endif
        @endfor

      @if ($data->onLastPage())
        <li class="page-item disabled">
            <a class="page-link" href="{{$data->nextPageUrl()}}">Следующая</a>
        </li>
        @else
        <li class="page-item">
            <a class="page-link" href="{{$data->nextPageUrl()}}">Следующая</a>
        </li>
      @endif

    </ul>
  </nav>
