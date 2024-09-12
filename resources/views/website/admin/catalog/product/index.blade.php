@extends('website.admin.layouts.master')

@push('css')
    <link rel="stylesheet" href="\css\admin\product\index.css">
@endpush

@section('title')
Products
@endsection


@push('js')
    <script src="\js\admin\product\index.js"></script>
@endpush

@section('content')
<div class="page" id="product-page">
    <a href="{{route('website.admin.catalog.index', ['website' => $website])}}">back</a>
    <x-floating-window :title="$title" :btnName="$btnName" />
</div>
@endsection
<img src="" alt="" loading="">