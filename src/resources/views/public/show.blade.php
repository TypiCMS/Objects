@extends('core::public.master')

@section('title', $model->title.' – '.__('Objects').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->image())
@section('bodyClass', 'body-objects body-object-'.$model->id.' body-page body-page-'.$page->id)

@section('content')

    @include('core::public._btn-prev-next', ['module' => 'Objects', 'model' => $model])

    @include('objects::public._json-ld', ['object' => $model])

    <article class="object">
        <h1 class="object-title">{{ $model->title }}</h1>
        <img class="object-image" src="{!! $model->present()->image(null, 200) !!}" alt="">
        <p class="object-summary">{{ nl2br($model->summary) }}</p>
        <div class="object-body">{!! $model->present()->body !!}</div>
        @include('files::public._documents')
        @include('files::public._images')
    </article>

@endsection
