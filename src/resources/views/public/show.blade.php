@extends('core::public.master')

@section('title', $model->title.' – '.__('Objects').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->image(1200, 630))
@section('bodyClass', 'body-objects body-object-'.$model->id.' body-page body-page-'.$page->id)

@section('content')

<article class="object">
    <header class="object-header">
        <div class="object-header-container">
            <div class="object-header-navigator">
                @include('core::public._items-navigator', ['module' => 'Objects', 'model' => $model])
            </div>
            <h1 class="object-title">{{ $model->title }}</h1>
        </div>
    </header>
    <div class="object-body">
        @include('objects::public._json-ld', ['object' => $model])
        @empty(!$model->summary)
        <p class="object-summary">{!! nl2br($model->summary) !!}</p>
        @endempty
        @empty(!$model->image)
        <picture class="object-picture">
            <img class="object-picture-image" src="{!! $model->present()->image(2000, 1000) !!}" alt="">
            @empty(!$model->image->description)
            <legend class="object-picture-legend">{{ $model->image->description }}</legend>
            @endempty
        </picture>
        @endempty
        @empty(!$model->body)
        <div class="rich-content">{!! $model->present()->body !!}</div>
        @endempty
        @include('files::public._documents')
        @include('files::public._images')
    </div>
</article>

@endsection
