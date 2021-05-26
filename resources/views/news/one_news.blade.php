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
                @if(!$dataWeatherLast->isEmpty())
                    <div class="p-3 mb-3 bg-light rounded">
                        @foreach($dataWeatherLast as $keyWeatherLast => $valWeatherLast)
                            <div class="weather-top">
                                <span class="font-italic">Погода</span>
                                <span class="font-italic weather-city">{{ $valWeatherLast->city }}</span>
                            </div>
                            <div class="bottom-weather">
                                <span class="weather-tempurature">{{  $valWeatherLast->tempurature }}°</span>
                                <div class="weather-info">
                                    <span class="weather-description" title="Малооблачно {{ $valWeatherLast->humidity . '+' . $valWeatherLast->tempurature }}">Малооблачно</span>
                                    <span class="weather-humidity">Влажность {{ $valWeatherLast->humidity }}%</span>
                                </div>
                            </div>
                            <a href="{{ $valWeatherLast->source }}" class="weather-link" target="_blank">Источник: <span class="weather-source">{{ parse_url($valWeatherLast->source, PHP_URL_HOST) }}</span></a>
                        @endforeach
                    </div>
            @endif

                <!-- Вывод архива нгвостей по месяцу и году -->
                <div class="p-3">
                    <h4 class="font-italic">Архивы</h4>
                    <ol class="list-unstyled mb-0">
                        @if(!$monthYearNewsWhereSouceId->isEmpty())
                            @foreach($monthYearNewsWhereSouceId as $keyMonthYear => $monthYear)
                                <li><a href="{{ route('arhive', ['year' => $monthYear->year, 'month' => $monthYear->month]) }}">{{ $monthYear->month }} {{ $monthYear->year }}</a></li>
                            @endforeach
                        @endif
                    </ol>
                </div>

                <div class="p-3">
                    <h4 class="font-italic">В другом месте</h4>
                    <ol class="list-unstyled">
                        <li><a href="https://github.com/AlexKovYur/news" target="_blank">GitHub</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Facebook</a></li>
                    </ol>
                </div>
            </aside><!-- /.blog-sidebar -->
        </div><!-- /.row -->

    </main><!-- /.container -->
@endsection
