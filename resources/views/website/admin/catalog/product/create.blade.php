@extends('website.admin.layouts.master')

@push('css')
    <link rel="stylesheet"
        href="{{asset('css\admin\product\create.css')}}?v ={{filemtime(public_path('css/admin/product/create.css'))}}">
@endpush

@section('title')
Products
@endsection


@push('js')
    <script src={{asset("js\admin\product\index.js")}}></script>
@endpush

@section('content')
<div>
    <form id="create-product" name="create-product"
        action="{{route('website.admin.catalog.product.store', ['website' => $website])}}" method="POST">
        @csrf
        <label for="name">name</label>
        <input type="text" name="name" id="name">
        <br>
        @error('name')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label for="slug">slug</label>
        <input type="text" name="slug" id="slug">
        <br>
        @error('slug')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label for="description">description</label>
        <input type="text" name="description" id="description">
        <br>
        @error('description')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label for="price">price</label>
        <input type="text" name="price" id="price">
        <br>
        @error('price')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label for="cover">cover</label>
        <input type="text" name="cover" id="cover">
        <br>
        @error('cover')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label for="category_id">category_id</label>
        <select name="category_id" id="category_id">
            <br>
            @error('category_id')
                <div class="alert alert-danger">{{$message}}</div>
            @enderror
            @foreach ($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
        <br>
        <label for="is_special">is_special</label>
        <input type="checkbox" name="is_special" id="is_special">
        <br>
        @error('is_special')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <label for="is_new">is_new</label>
        <input type="checkbox" name="is_new" id="is_new">
        <br>
        @error('is_new')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
        <button id="creatProductBtn">Create</button>
    </form>
</div>
@endsection