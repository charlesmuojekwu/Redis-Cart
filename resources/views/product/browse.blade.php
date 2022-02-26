@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            @if ($products)
                <div class="row">
                    <div class="col-9">
                        <div class="col-12 mb-1">
                            <a href="{{ route('product.new') }}">Add New Product</a>
                        </div>
                        @foreach ($products as $product )
                            @if($product)
                                <div class="col-4 mb-1" style="float:left">
                                    <div class="card">
                                        <img class="card-img-top" height="260" src="{{ $product['image'] }}" alt="Card image cap">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">{{ $product['name']}}</h5>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="col-3 border">
                        @foreach ($tags as $tag )
                            <a class="btn btn-sm btn-primary px-2 py-1 m-1" href="?tag={{ $tag }}" role="button">{{ $tag}}</a>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-header">Browse Products</div>
                        <div class="col-8">
                            <div class="alert alert-success mt-2" role="alert">
                                Empty Products! <a href="{{ route('product.new') }}">Add Product</a>
                            </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>



@endsection