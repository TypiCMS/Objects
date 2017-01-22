@extends('core::admin.master')

@section('title', __('objects::global.New'))

@section('content')

    @include('core::admin._button-back', ['module' => 'objects'])
    <h1>
        @lang('objects::global.New')
    </h1>

    {!! BootForm::open()->action(route('admin::index-objects'))->multipart()->role('form') !!}
        @include('objects::admin._form')
    {!! BootForm::close() !!}

@endsection
