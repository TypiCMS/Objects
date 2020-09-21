@extends('core::admin.master')

@section('title', __('Objects'))

@section('content')

<item-list
    url-base="/api/objects"
    locale="{{ config('typicms.content_locale') }}"
    fields="id,image_id,status,title"
    table="objects"
    title="objects"
    include="image"
    appends="thumb"
    :exportable="true"
    :searchable="['title']"
    :sorting="['title_translated']">

    <template slot="add-button" v-if="$can('create objects')">
        @include('core::admin._button-create', ['module' => 'objects'])
    </template>

    <template slot="columns" slot-scope="{ sortArray }">
        <item-list-column-header name="checkbox" v-if="$can('update objects')||$can('delete objects')"></item-list-column-header>
        <item-list-column-header name="edit" v-if="$can('update objects')"></item-list-column-header>
        <item-list-column-header name="status_translated" sortable :sort-array="sortArray" :label="$t('Status')"></item-list-column-header>
        <item-list-column-header name="image" :label="$t('Image')"></item-list-column-header>
        <item-list-column-header name="title_translated" sortable :sort-array="sortArray" :label="$t('Title')"></item-list-column-header>
    </template>

    <template slot="table-row" slot-scope="{ model, checkedModels, loading }">
        <td class="checkbox" v-if="$can('update objects')||$can('delete objects')"><item-list-checkbox :model="model" :checked-models-prop="checkedModels" :loading="loading"></item-list-checkbox></td>
        <td v-if="$can('update objects')">@include('core::admin._button-edit', ['module' => 'objects'])</td>
        <td><item-list-status-button :model="model"></item-list-status-button></td>
        <td><img :src="model.thumb" alt="" height="27"></td>
        <td>@{{ model.title_translated }}</td>
    </template>

</item-list>

@endsection
