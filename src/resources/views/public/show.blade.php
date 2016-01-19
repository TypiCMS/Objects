@extends('core::public.master')

@section('title', $model->title . ' – ' . trans('objects::global.name') . ' – ' . $websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->thumbUrl())
@section('bodyClass', 'body-objects body-object-' . $model->id . ' body-page body-page-' . $page->id)

@section('main')

    @include('core::public._btn-prev-next', ['module' => 'Objects', 'model' => $model])
    <article>
        <h1>{{ $model->title }}</h1>
        {!! $model->present()->thumb(null, 200) !!}
        <p class="summary">{{ nl2br($model->summary) }}</p>
        <div class="body">{!! $model->present()->body !!}</div>
    </article>

@endsection
