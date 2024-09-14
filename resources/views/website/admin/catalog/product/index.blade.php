@extends('website.admin.layouts.master')

@push('css')
    <link rel="stylesheet"
        href="{{asset('css\admin\product\index.css')}}?v ={{filemtime(public_path('css/admin/product/index.css'))}}">
    <!-- <link rel="stylesheet" href="http://amall.ps/route/"> -->
@endpush

@section('title')
Products
@endsection


@push('js')
    <script src={{asset("js\admin\product\index.js")}}></script>
@endpush

@section('content')
<div class="page" id="product-page">
    <a href="{{route('website.admin.catalog.index', ['website' => $website])}}">back</a>
    <a href="{{route('website.admin.catalog.product.create', ['website' => $website])}}">create</a>

</div>
@endsection