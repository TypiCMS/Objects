@extends('core::public.master')

@section('title', $model->title.' – '.__('objects::global.name').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->thumbUrl())
@section('bodyClass', 'body-objects body-object-'.$model->id.' body-page body-page-'.$page->id)

@section('content')

    @include('core::public._btn-prev-next', ['module' => 'Objects', 'model' => $model])
    <article class="object">
        <h1 class="object-title">{{ $model->title }}</h1>
        {!! $model->present()->thumb(null, 200) !!}
        <p class="object-summary">{{ nl2br($model->summary) }}</p>
        <div class="object-body">{!! $model->present()->body !!}</div>
    </article>

@endsection
