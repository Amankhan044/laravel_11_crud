<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
        crossorigin="anonymous">

    <title>Simple Laravel 11 CRUD</title>
</head>
<body>
    <div class="bg-dark py-3">
        <h3 class="text-white text-center">Simple Laravel 11 CRUD</h3>
    </div>

    <div class="container">
    <div class="row justify-content-center my-4">
        <div class="col-md-10 d-flex justify-content-end" >
            <a href="{{ route('products.index') }}" class="btn btn-dark">Back</a>
        </div>
    </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 border-0 shadow-lg">
                <div class="card my-4">
                    <div class="card-header bg-dark">
                        <h3 class="text-white">Edit Product</h3>
                    </div>
                </div>

                <form action="{{ route('products.update', $product->slug) }}" method="POST" enctype="multipart/form-data">
                    @method('put')
                    @csrf

                    <div class="card-body">
                        <div class="mb-3">  
                            <label class="form-label h5">Name</label>
                            <input type="text" 
                                class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                placeholder="Name" name="name" value="{{ old('name', $product->name) }}">
                            @error('name')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label h5">SKU</label>
                            <input type="text" 
                                class="form-control form-control-lg @error('sku') is-invalid @enderror" 
                                placeholder="SKU" name="sku" value="{{ old('sku',   $product->sku) }}">
                            @error('sku')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label h5">Price</label>
                            <input type="text" 
                                class="form-control form-control-lg @error('price') is-invalid @enderror" 
                                placeholder="Price" name="price" value="{{ old('price', $product->price) }}">
                            @error('price')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label h5">Description</label>
                            <textarea name="description" placeholder="Description" 
                                class="form-control @error('description') is-invalid @enderror" 
                                cols="30" rows="5">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label h5">Image</label>
                            <input type="file" 
                                class="form-control form-control-lg @error('image',) is-invalid @enderror" 
                                name="image">
                                @if($product->image)
                                                <img src="{{ asset('upload/products/' . $product->image) }}" class="w-50 h-50 my-2"  height="50" alt="Product Image">
                                            @else
                                                No Image
                                            @endif
                            @error('image')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="d-grid">
                            <button class="btn btn-lg btn-primary">Update</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
        crossorigin="anonymous"></script>

</body>
</html>
