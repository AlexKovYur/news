@extends('layouts.app')
@section('content')
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
@endsection
