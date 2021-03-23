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
                        <strong class="d-inline-block mb-2 text-primary">World</strong>
                        <h3 class="mb-0">
                            <a class="text-dark" href="#">Featured post</a>
                        </h3>
                        <div class="mb-1 text-muted">Nov 12</div>
                        <p class="card-text mb-auto">This is a wider card with supporting text below as a natural lead-in to
                            additional content.</p>
                        <a href="#">Continue reading</a>
                    </div>
                    <img class="card-img-right flex-auto d-none d-md-block" data-src="holder.js/200x250?theme=thumb"
                         alt="Card image cap">
                </div>
            </div>
            <div class="col-md-6">
                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <div class="card-body d-flex flex-column align-items-start">
                        <strong class="d-inline-block mb-2 text-success">Design</strong>
                        <h3 class="mb-0">
                            <a class="text-dark" href="#">Post title</a>
                        </h3>
                        <div class="mb-1 text-muted">Nov 11</div>
                        <p class="card-text mb-auto">This is a wider card with supporting text below as a natural lead-in to
                            additional content.</p>
                        <a href="#">Continue reading</a>
                    </div>
                    <img class="card-img-right flex-auto d-none d-md-block" data-src="holder.js/200x250?theme=thumb"
                         alt="Card image cap">
                </div>
            </div>
        </div>
        <main role="main" class="container">
            <div class="row">
                <div class="col-md-8 blog-main">
                    @if(count($categoriesAll) && count($arrayTwoNewsByCategory))
                        @foreach($categoriesAll as $keyCategories => $valCategories)
                            <h3 class="pb-3 mb-4 font-italic border-bottom">
                                {{ $valCategories->name }}
                            </h3>

                            @if(count($arrayTwoNewsByCategory[$keyCategories]))
                                @foreach($arrayTwoNewsByCategory[$keyCategories] as $keyNews => $valNews)
                                    <div class="blog-post bg-light p-3">
                                        <a href="{{ route('one_news', ['id' => $valNews->id]) }}">
                                            <h2 class="blog-post-title">{{ $valNews->title }}</h2>
                                        </a>
                                        <p class="blog-post-meta">{{ $valNews->news_date->format('d F Y h:m') }}
                                            <a href="{{ $valNews->source }}" class="source-link" target="_blank">Источник: {{ $arrayHostByNews[$keyCategories][$keyNews] }}</a>
                                        </p>
                                        <br>
                                        <p>{{ $valNews->body }}</p>
                                        <div class="blog-four-news">
                                            @if(count($arrayFourNewsByCategory[$keyCategories]))
                                                @foreach($arrayFourNewsByCategory[$keyCategories] as $keyNews => $valNews)
                                                    <p class="mb-0">{{ $valNews->title }}</p>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div><!-- /.blog-post -->
                                @endforeach
                            @endif
                        @endforeach
                    @endif

                    <!-- Пагинация -->


                </div><!-- /.blog-main -->

                <aside class="col-md-4 blog-sidebar">
                    <div class="p-3 mb-3 bg-light rounded">
                        <h4 class="font-italic">About</h4>
                        <p class="mb-0">Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit
                            amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
                    </div>

                    <div class="p-3">
                        <h4 class="font-italic">Archives</h4>
                        <ol class="list-unstyled mb-0">
                            @if(!$monthYearNews->isEmpty())
                                @foreach($monthYearNews as $keyMonthYear => $monthYear)
                                    <li><a href="{{ route('news_group_by', ['id' => $monthYear->id]) }}">{{ $monthYear->month }} {{ $monthYear->year }}</a></li>
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

        <footer class="blog-footer">
            <p>Blog template built for <a href="https://getbootstrap.com/">Bootstrap</a>.</p>
            <p>
                <a href="#">Back to top</a>
            </p>
        </footer>
    </div>
@endsection
