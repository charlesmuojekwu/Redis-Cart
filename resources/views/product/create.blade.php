@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">New Product</div>
                    <div class="card-body">
                        <form action="{{ route('product.new')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="product_name">Product Name</label>
                                <input type="text" class="form-control" name="product_name" id="product_name" required placeholder="ex Name of Product">
                            </div>
                            <div class="form-group">
                                <label for="product_image">Product Image</label>
                                <input type="text" class="form-control" name="product_image" id="product_image" required placeholder="ex Name of Product">
                            </div>
                            <div class="form-group">
                                <label for="tags">Tags</label>
                                <input type="text" class="form-control" name="tags" id="tags" required placeholder="ex Name of Product">
                            </div>
                            <button type="submit" class="btn btn-primary">New Product</button>
                        </form>
                    </div>
            </div>
        </div>
    </div>

</div>

@endsection