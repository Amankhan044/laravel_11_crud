<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Simple Laravel 11 CRUD</title>
</head>
<body>
    <div class="bg-dark py-3">
        <h3 class="text-white text-center">Simple Laravel 11 CRUD</h3>
    </div>

    <div class="container">
        <div class="row justify-content-center my-4">
            <div class="col-md-10 d-flex justify-content-end">
                <a href="{{ route('products.create') }}" class="btn btn-dark">Create</a>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            @if(Session::has('success'))
                <div class="col-md-10 mt-4">
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                </div>
            @endif 

            <div class="col-md-10">
                <div class="card my-4">
                    <div class="card-header bg-dark">
                        <h3 class="text-white">Products</h3>
                    </div>
                    <div class="card-body">
                        <table class="table ">
                            <thead class=" text-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>SKU</th>
                                    <th>Price</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>
                                            @if($product->image)
                                                <img src="{{ asset('upload/products/' . $product->image) }}" width="50" height="50" alt="Product Image">
                                            @else
                                                No Image
                                            @endif
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->sku }}</td>
                                        <td>${{ $product->price }}</td>
                                        <td>{{Carbon\Carbon::parse($product->created_at)->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{route('products.edit',$product->id)}}" class="btn btn-dark btn-sm">Edit</a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">
        Delete
    </button>
</form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($products->isEmpty())
                            <p class="text-center">No products found.</p>
                        @endif
                        <div class="d-flex justify-content-end mt-3">
    {{ $products->links() }}
</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
