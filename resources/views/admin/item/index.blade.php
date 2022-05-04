@extends('core::admin.master')

@section('title', __('Video Group'))

@section('content')

<item-list
url-base="/api/videos"
locale="{{ config('typicms.content_locale') }}"
fields="id,image_id,show_date,status,title,updated_at"
table="videos"
title="{{__('Videos')}}"
include="image"
appends="thumb"
:exportable="false"
:searchable="['title']"
:sorting="['show_date']">


<template slot="add-button" v-if="$can('create videos')">
    @include('core::admin._button-create', ['module' => 'videos'])
</template>

<template slot="columns" slot-scope="{ sortArray }">
    <item-list-column-header name="checkbox" v-if="$can('update videos')||$can('delete videos')"></item-list-column-header>
    <item-list-column-header name="edit" v-if="$can('update videos')"></item-list-column-header>
    <item-list-column-header name="status_translated" sortable :sort-array="sortArray" :label="$t('Status')"></item-list-column-header>
   <item-list-column-header name="image" :label="$t('Image')"></item-list-column-header>
    <item-list-column-header name="title_translated" sortable :sort-array="sortArray" :label="$t('Title')"></item-list-column-header>
    <item-list-column-header name="videopages_translated"  :label="$t('Category')"></item-list-column-header>
    <item-list-column-header :label="$t('Last Update Time')"></item-list-column-header>
</template>

<template slot="table-row" slot-scope="{ model, checkedModels, loading }">
    <td class="checkbox" v-if="$can('update videos')||$can('delete videos')"><item-list-checkbox :model="model" :checked-models-prop="checkedModels" :loading="loading"></item-list-checkbox></td>
    <td v-if="$can('update videos')">@include('core::admin._button-edit', ['module' => 'videos'])</td>
    <td><item-list-status-button :model="model"></item-list-status-button></td>
    <td><img :src="model.thumb" alt="" height="27"></td>
    <td>@{{ model.title_translated }}</td>
    {{-- <td>@{{ model.page.title[lang()] }}</td> --}}
    <td>@{{ getMoment(model.updated_at ) }}</td>
</template>

</item-list>


@endsection
