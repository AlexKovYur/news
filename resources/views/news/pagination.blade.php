<!--
$paginator->hasPages() – возвращает true если есть страницы
$paginator->onFirstPage() – true, если мы на первой странице
$paginator->previousPageUrl() – получает ссылку на предыдущую страницу, если нет, то возвращает null
$paginator->currentPage() – получает текущую страницу
$paginator->hasMorePages() – возвращает true, если есть следующие страницы
$paginator->nextPageUrl() – получает ссылку на следующую страницу, если нет то возвращает null
-->

@if ($paginator->hasPages())
    <nav class="blog-pagination">
        @if ($paginator->onFirstPage())
            <a class="btn btn-outline-primary disabled">Older</a>
        @else
            <a class="btn btn-outline-primary" href="{{ $paginator->previousPageUrl() }}" rel="prev">Older</a>
        @endif

        @if ($paginator->hasMorePages())
            <a class="btn btn-outline-secondary" href="{{ $paginator->nextPageUrl() }}" rel="next">Newer</a>
        @else
            <a class="btn btn-outline-secondary disabled">Newer</a>
        @endif
    </nav>
@endif
