@extends('layouts.admin-detail-product')


@section('extend_style')
<!-- page style -->
  <style media="screen">
    .product-image-detail{
      content : '';
      background: red;
    }
  </style>
@endsection

@section('breadcrumb_item')
{{-- <a href="{{ route('admin.dashboard')}}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
<a class="breadcrumb-item" href="{{ route('product.manage') }}">Product</a>
<span class="breadcrumb-item active">
  {{ $mode == "edit" ? "Edit product" : "Add product" }}
</span> --}}
@endsection

@section('content')
  @php
    $product = $data->product;

    // Product thumbnail
    $imageUrl;
    if ($product->product_images != null && count($product->product_images) > 0) {
      $imageUrl = $product->product_images[0]->url;
    } else {
      $imageUrl = "placeholder_medium.jpg";
    }

    // Color split
    $colors = explode(";", $product->color);
  @endphp
  <div class="page-header no-gutters has-tab">
      <div class="d-md-flex m-b-15 align-items-center justify-content-between">
          <div class="media align-items-center m-b-15">
              <div class="avatar avatar-image rounded" style="height: 70px; width: 70px">
                <img src="{{ url('images/products/' . $imageUrl)  }}" alt="">
              </div>
              <div class="m-l-15">
                  <h4 class="m-b-0">
                    {{$product->name}}
                  </h4>
                  <p class="text-muted m-b-0">{{ "Code: #" . $product->id }}</p>
              </div>
          </div>
          <div class="m-b-15">
              <a href="{{route('product.edit', $product->id)}}" class="btn btn-primary">
                  <i class="anticon anticon-edit"></i>
                  <span>Edit</span>
              </a>
          </div>
      </div>
      <ul class="nav nav-tabs" >
          <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#product-overview">Overview</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#product-images">Product Images</a>
          </li>
      </ul>
  </div>
  <div class="container-fluid">
      <div class="tab-content m-t-15">
          <div class="tab-pane fade show active" id="product-overview" >
              <div class="row">
                  <div class="col-md-3">
                      <div class="card">
                          <div class="card-body">
                              <div class="media align-items-center">
                                  <i class="font-size-40 text-success anticon anticon-smile"></i>
                                  <div class="m-l-15">
                                      <p class="m-b-0 text-muted">10 ratings</p>
                                      <div class="star-rating m-t-5">
                                          <input type="radio" id="star3-5" name="rating-3" value="5" checked disabled/><label for="star3-5" title="5 star"></label>
                                          <input type="radio" id="star3-4" name="rating-3" value="4" disabled/><label for="star3-4" title="4 star"></label>
                                          <input type="radio" id="star3-3" name="rating-3" value="3" disabled/><label for="star3-3" title="3 star"></label>
                                          <input type="radio" id="star3-2" name="rating-3" value="2" disabled/><label for="star3-2" title="2 star"></label>
                                          <input type="radio" id="star3-1" name="rating-3" value="1" disabled/><label for="star3-1" title="1 star"></label>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="card">
                          <div class="card-body">
                              <div class="media align-items-center">
                                  <i class="font-size-40 text-primary anticon anticon-shopping-cart"></i>
                                  <div class="m-l-15">
                                      <p class="m-b-0 text-muted">Sales</p>
                                      <h3 class="m-b-0 ls-1">{{ number_format($data->sales, 0, ',', '.') }}</h3>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="card">
                          <div class="card-body">
                              <div class="media align-items-center">
                                  <i class="font-size-40 text-primary anticon anticon-message"></i>
                                  <div class="m-l-15">
                                      <p class="m-b-0 text-muted">Reviews</p>
                                      <h3 class="m-b-0 ls-1">{{ number_format($data->feedbacks, 0, ',', '.') }}</h3>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="card">
                          <div class="card-body">
                              <div class="media align-items-center">
                                  <i class="font-size-40 text-primary anticon anticon-stock"></i>
                                  <div class="m-l-15">
                                      <p class="m-b-0 text-muted">Available Stock</p>
                                      <h3 class="m-b-0 ls-1">{{ number_format($product->stock, 0, ',', '.') }}</h3>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="card">
                  <div class="card-body">
                      <h4 class="card-title">Basic Info</h4>
                      <div class="table-responsive">
                          <table class="product-info-table m-t-20">
                              <tbody>
                                  <tr>
                                      <td>Price:</td>
                                      <td class="text-dark font-weight-semibold">
                                        @if ($product->discount != null && $product->discount != 0)
                                          @php
                                            $newPrice = (int)$product->price - ((int)$product->price * ($product->discount / 100))
                                          @endphp
                                          {{ "Rp. " . number_format($newPrice, 0, ',', '.') }}
                                          <small class="ml-2" style="text-decoration:line-through">
                                            {{ "Rp. " . number_format($product->price, 0, ',', '.') }}
                                          </small>
                                        @else
                                          {{ "Rp. " . number_format($product->price, 0, ',', '.') }}
                                        @endif
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>Discount:</td>
                                      <td class="text-dark">{{ $product->discount . "%" }}</td>
                                  </tr>
                                  <tr>
                                      <td>Category:</td>
                                      <td>{{ ucwords($product->category) }}</td>
                                  </tr>
                                  <tr>
                                      <td>Brand:</td>
                                      <td>{{ ucwords($product->brand) }}</td>
                                  </tr>
                                  <tr>
                                      <td>Tax Rate:</td>
                                      <td>{{ "5%" }}</td>
                                  </tr>
                                  <tr>
                                      <td>Status:</td>
                                      <td>
                                        @if ($product->status == "inStock")
                                          <span class="badge badge-pill badge-cyan">In Stock</span>
                                        @else
                                          <span class="badge badge-pill badge-danger">Out of Stock</span>
                                        @endif
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
              <div class="card">
                  <div class="card-body">
                      <h4 class="card-title">Option Info</h4>
                      <div class="table-responsive">
                          <table class="product-info-table m-t-20">
                              <tbody>
                                  <tr>
                                      <td>Units:</td>
                                      <td>{{ ucwords($product->unit) }}</td>
                                  </tr>
                                  <tr>
                                      <td>Colors:</td>
                                      <td class="d-flex">
                                        @foreach ($colors as $color)
                                          <span class="d-flex align-items-center m-r-20">
                                            <span class="badge badge-dot product-color m-r-5" style="background-color: {{ucwords(str_replace(' ', '', $color))}}"></span>
                                            <span>{{ ucwords($color) }}</span>
                                          </span>
                                        @endforeach
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
              <div class="card">
                  <div class="card-header">
                      <h4 class="card-title">Product Description</h4>
                  </div>
                  <div class="card-body">
                    {!! $product->description !!}
                  </div>
              </div>
          </div>
          <div class="tab-pane fade" id="product-images">
              <div class="card">
                  <div class="card-body">
                      <div class="row">
                          @if ($product->product_images != null && count($product->product_images) > 0)
                            @foreach ($product->product_images as $image)
                              <div class="col-md-3 product-image-detail-box">
                                {{-- <div class="col-12 product-image-detail" style=""></div> --}}
                                <img class="img-fluid col-12" src="{{ url('images/products/' . $image->url) }}" alt="">
                              </div>
                            @endforeach
                          @else
                            <div class="col-12 text-center">
                              This product does not have a picture.
                            </div>
                          @endif
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
@endsection

@section('extend_script')

@endsection
