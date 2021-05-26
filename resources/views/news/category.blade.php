@extends('layouts.app')
@section('content')
    <main role="main" class="container">
        <div class="row">
            <!-- Вывод всех новостей категории -->
            <div class="col-md-8 blog-main">
                @if(!empty($categoriesNews))
                    @foreach($categoriesNews as $keyCategoriesNews => $valCategoriesNews)
                            <div class="blog-post">
                                <h2 class="blog-post-title">{{ $valCategoriesNews->title }}</h2>
                                <p class="blog-post-meta">{{ $valCategoriesNews->news_date->format('d F Y h:m') }} <a href="#">{{ $valCategoriesNews->author->name }}</a></p>
                                <img src="{{ asset('storage/images/' . $valCategoriesNews->photo) }}" alt="photo news">
                                <br>
                                <br>
                                <p>{{ $valCategoriesNews->body }}</p>
                            </div><!-- /.blog-post -->
                    @endforeach
                @endif

                <!-- Пагинация -->
                {{ $categoriesNews->links('news.pagination') }}
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
                        @if(!$monthYearNews->isEmpty())
                            @foreach($monthYearNews as $keyMonthYear => $monthYear)
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
