@extends('pages::public.master')

@section('bodyClass', 'body-objects body-objects-index body-page body-page-'.$page->id)

@section('content')

    {!! $page->present()->body !!}

    @include('files::public._documents', ['model' => $page])
    @include('files::public._images', ['model' => $page])

    @include('objects::public._itemlist-json-ld', ['items' => $models])

    @includeWhen($models->count() > 0, 'objects::public._list', ['items' => $models])

@endsection
