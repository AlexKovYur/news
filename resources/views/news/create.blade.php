@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Добавить новую новость</h2>
                </div>
                <div class="panel-body">
                    <form action="{{ route('create_new_news') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <input required="required" value="{{ old('title') }}" placeholder="Введите заголовок новости" type="text" name = "title" class="form-control" />
                        </div>

                        <div class="form-group">
                            <textarea name='body'class="form-control form-news-body">{{ old('body') }}</textarea>
                        </div>

                        <input type="submit" name='publish' class="btn btn-success" value = "Опубликовать"/>
                        <input type="submit" name='save' class="btn btn-default" value = "Сохранить черновик" />
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--<script src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>-->
    <!--<script src="{{ asset('/js/main.js') }}"></script>-->
@endsection
