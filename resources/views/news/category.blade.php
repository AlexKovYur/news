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
                <div class="p-3 mb-3 bg-light rounded">
                    <h4 class="font-italic">About</h4>
                    <p class="mb-0">Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit
                        amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
                </div>

                <!-- Вывод архива нгвостей по месяцу и году -->
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
@endsection
