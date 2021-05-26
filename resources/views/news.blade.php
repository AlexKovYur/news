@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="jumbotron p-0 text-white rounded bg-dark slider">
                @if(!$sliderNews->isEmpty())
                    @foreach($sliderNews as $keyNews => $valNews)
                        <div class="col-md-6 p-3 p-md-5 slider-content" style=" background-image: url('{{ asset('storage/images/' . $valNews->photo) }}');">
                            <h1 class="display-4 font-italic">{{ $valNews->title }}</h1>
                            <p class="lead my-3 slider-text">{{ $valNews->body }}</p>
                        </div>
                    @endforeach
                @endif
        </div>

        <div class="row mb-2">
            <div class="col-md-6">
                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <div class="card-body d-flex flex-column align-items-start">
                        @if(@isset($arrayNewsByCategory[8]))
                            @php
                              $firstNewsByCategory = !empty($arrayNewsByCategory[8]->first()) ? $arrayNewsByCategory[8]->first() : null;
                            @endphp
                            @isset($firstNewsByCategory)
                            <strong class="d-inline-block mb-2 text-primary">{{ $firstNewsByCategory->pivot->pivotParent->name }}</strong>
                            <h3 class="mb-0">
                                <span class="text-dark">{{ $firstNewsByCategory->title }}</span>
                            </h3>
                            <div class="mb-1 text-muted">
                                {{ $firstNewsByCategory->news_date->format('d F Y h:m') }}
                                <a href="{{ $firstNewsByCategory->source }}" class="source-link" target="_blank">Источник: {{ $firstNewsByCategory->getRelations()['source']->host }}</a>
                            </div>
                            <p class="card-text mb-auto">{{ $firstNewsByCategory->body }}</p>
                            <a href="{{ route('one_news', ['id' => $firstNewsByCategory->id]) }}" class="card-link" target="_blank">Подробнее</a>
                            @endisset
                        @else
                            <strong class="d-inline-block mb-2 text-primary">Новости экономики</strong>
                            <p class="card-text mb-auto">Новости экономики в данный момент не доступны. Технический перерыв.</p>
                        @endif
                    </div>
                    <img class="card-img-right flex-auto d-none d-md-block" data-src="holder.js/200x250?theme=thumb" src="{{ asset('storage/images/' . $firstNewsByCategory->photo) }}"
                         alt="image news economy">
                </div>
            </div>
            <div class="col-md-6">
                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <div class="card-body card-body-currency d-flex flex-column align-items-start">
                        <div class="wrapper-table-currency">

                            <table class="table table-currency table-striped caption-top">
                                <caption>Курсы криптавалют на сегодня</caption>
                                <thead>
                                    <tr>
                                        <th>Валюта</th>
                                        <th>Стоимость</th>
                                        <th>Изменение (24.ч)</th>
                                    </tr>
                                </thead>
                                <tbody >
                                @if(!$dataCurrencyToday->isEmpty())
                                    @foreach($dataCurrencyToday as $keyCurrencyToday => $valCurrencyToday)
                                        <tr>
                                            <td>{{ $valCurrencyToday->currency_symbol }}</td>
                                            <td>{{ $valCurrencyToday->cost }}</td>
                                            <td>{{ $valCurrencyToday->change_24h}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <main role="main" class="container">
            <div class="row">
                <div class="col-md-8 blog-main">
                    @if(count($categoriesAll) && count($arrayNewsByCategory))
                        @foreach($categoriesAll as $keyCategories => $valCategories)
                            <!-- Если кактегория "Экономика", не выводим -->
                            @if($valCategories->id === 9)
                                @continue
                            @endif
                            @if(count($arrayNewsByCategory[$keyCategories]))
                            <h3 class="pb-3 mb-4 font-italic border-bottom">
                                {{ $valCategories->name }}
                            </h3>
                                <div class="blog-post bg-light p-3">
                                @foreach($arrayNewsByCategory[$keyCategories] as $keyNews => $valNews)
                                        @if(!$loop->index)
                                        <a href="{{ route('one_news', ['id' => $valNews->id]) }}" target="_blank">
                                            <h2 class="blog-post-title">{{ $valNews->title }}</h2>
                                        </a>
                                        <p class="blog-post-meta">{{ $valNews->news_date->format('d F Y h:m') }}
                                            <a href="{{ $valNews->source }}" class="source-link" target="_blank">Источник: {{ $valNews->getRelations()['source']->host }}</a>
                                        </p>
                                        <br>
                                        <p>{{ $valNews->body }}</p>
                                        <div class="blog-four-news">
                                            <ul>
                                        @else
                                            <li>
                                                <a href="{{ route('one_news', ['id' => $valNews->id]) }}" target="_blank">
                                                    <p class="mb-0">{{ $valNews->title }} {{ $valNews->getRelations()['source']->host }}</p>
                                                </a>
                                            </li>
                                        @endif
                                @endforeach
                                            </ul>
                                        </div>
                                </div><!-- /.blog-post -->
                            @endif
                        @endforeach
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
    </div>
@endsection
