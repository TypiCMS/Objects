@extends('core::admin.master')

@section('title', __('New object'))

@section('content')

    @include('core::admin._button-back', ['module' => 'objects'])
    <h1>
        @lang('New object')
    </h1>

    {!! BootForm::open()->action(route('admin::index-objects'))->multipart()->role('form') !!}
        @include('objects::admin._form')
    {!! BootForm::close() !!}

@endsection
