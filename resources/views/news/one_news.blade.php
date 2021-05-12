@extends('layouts.app')
@section('content')
    <main role="main" class="container">
        <div class="row">
            <!-- Вывод новости -->
            <div class="col-md-8 blog-main">
                @if(!empty($foundNews))
                    <div class="blog-post">
                        <h2 class="blog-post-title">{{ $foundNews->title }}</h2>
                        <p class="blog-post-meta">{{ $foundNews->news_date->format('d F Y h:m') }}
                            <a href="{{ $foundNews->source }}" class="source-link" target="_blank">Источник: {{ $foundNews->getRelation('source')->host }}</a>
                        </p>
                        <img src="{{ asset('storage/images/' . $foundNews->photo) }}" alt="photo news">
                        <br>
                        <br>
                        <p>{{ $foundNews->body }}</p>
                    </div><!-- /.blog-post -->
                @endif
                @if (count($otherNewsSource))
                    <div class="wrapper-outher-news-source">
                        <span class="title-outher-news-source">Так же читайте:</span>
                        <ul class="outher-news-source">
                            @foreach($otherNewsSource as $keyNewsSource => $valNewsSource)
                                <li class="news-source">
                                    <a href="{{ route('one_news', ['id' => $valNewsSource->id]) }}">{{ $valNewsSource->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div> <!-- /.outher-news-source -->
                @endif
            </div><!-- /.blog-main -->

            <aside class="col-md-4 blog-sidebar">
                <div class="p-3 mb-3 bg-light rounded">
                    <h4 class="font-italic">About</h4>
                    <p class="mb-0">Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit
                        amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
                </div>

                <!-- Вывод архива нгвостей по месяцу и году -->
                <div class="p-3">
                    <h4 class="font-italic">Archives</h4>
                    <ol class="list-unstyled mb-0">
                        @if(!$monthYearNewsWhereSouceId->isEmpty())
                            @foreach($monthYearNewsWhereSouceId as $keyMonthYear => $monthYear)
                                <li><a href="{{ route('arhive', ['year' => $monthYear->year, 'month' => $monthYear->month]) }}">{{ $monthYear->month }} {{ $monthYear->year }}</a></li>
                            @endforeach
                        @endif
                    </ol>
                </div>

                <div class="p-3">
                    <h4 class="font-italic">Elsewhere</h4>
                    <ol class="list-unstyled">
                        <li><a href="#">GitHub</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Facebook</a></li>
                    </ol>
                </div>
            </aside><!-- /.blog-sidebar -->
        </div><!-- /.row -->

    </main><!-- /.container -->
@endsection
