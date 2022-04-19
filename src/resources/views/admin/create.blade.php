@extends('core::admin.master')

@section('title', __('New object'))

@section('content')

    {!! BootForm::open()->action(route('admin::index-objects'))->multipart()->role('form') !!}
        @include('objects::admin._form')
    {!! BootForm::close() !!}

@endsection
