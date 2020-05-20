@extends('core::public.master')

@section('title', $model->title.' – '.__('Objects').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->image(1200, 630))
@section('bodyClass', 'body-objects body-object-'.$model->id.' body-page body-page-'.$page->id)

@section('content')

    @include('core::public._btn-prev-next', ['module' => 'Objects', 'model' => $model])

    @include('objects::public._json-ld', ['object' => $model])

    <article class="object">
        <h1 class="object-title">{{ $model->title }}</h1>
        @empty(!$model->image)
        <img class="object-image" src="{!! $model->present()->image(null, 1000) !!}" alt="">
        @endempty
        @empty(!$model->summary)
        <p class="object-summary">{!! nl2br($model->summary) !!}</p>
        @endempty
        @empty(!$model->body)
        <div class="object-body">{!! $model->present()->body !!}</div>
        @endempty
        @include('files::public._documents')
        @include('files::public._images')
    </article>

@endsection
