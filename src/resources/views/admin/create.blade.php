@extends('core::admin.master')

@section('title', __('New object'))

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'objects'])
        <h1 class="header-title">@lang('New object')</h1>
    </div>

    {!! BootForm::open()->action(route('admin::index-objects'))->multipart()->role('form') !!}
        @include('objects::admin._form')
    {!! BootForm::close() !!}

@endsection
