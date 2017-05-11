@extends('pages::public.master')

@section('bodyClass', 'body-objects body-objects-index body-page body-page-'.$page->id)

@section('content')

    {!! $page->present()->body !!}

    @include('files::public._files', ['model' => $page])

    @if ($models->count())
    @include('objects::public._list', ['items' => $models])
    @endif

@endsection
