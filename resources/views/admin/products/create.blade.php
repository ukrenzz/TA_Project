@extends('layouts.admin')

@section('page_title', "Tambah produk")

@section('extend_style')
  <!-- page style -->
  <link href="{{ asset('vendors/select2/select2.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css') }}" rel="stylesheet">

  <style media="screen">
    .select2-choices{
      border: 1px solid #edf2f9 !important;
      background: none !important;
    }
  </style>
@endsection

@section('breadcrumb_item')
  <a href="{{ route('admin.dashboard')}}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
  <a class="breadcrumb-item" href="{{ route('product.manage') }}">Produk</a>
  <span class="breadcrumb-item active">
    {{ $mode == "edit" ? "Edit produk" : "Tambah produk" }}
  </span>
@endsection

@section('content')

  {{-- <div class="card">
    <div class="card-body">
      @if ($errors->any())
        <div class="row">
          <div class="alert alert-danger">
              <ul class="list-unstyled">
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
        </div>
      @endif
      <form id="form-validation" action="{{$mode == 'edit' ? route('product.update') : route('product.store')}}" method="post">
        @csrf
        @if(isset($data))
          @method('PUT')
        @endif
        <input type="hidden" name="id" value="{{isset($data) ? $data->id : ''}}">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label control-label">Nama kategori <span class="text-danger">*</span></label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" placeholder="Contoh : Kamera, Laptop, Lensa" value="{{ isset($data) ? $data->name : '' }}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label control-label">Deskripsi</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="description" rows="3" style="resize:none" placeholder="Contoh : Hanya untuk baran berukuran kecil">{{ isset($data) ? $data->description : '' }}</textarea>
            </div>
        </div>
        <div class="form-group text-right">
              <button class="btn btn-primary">{!! $mode == "edit" ? '<i class="anticon anticon-form"></i> Edit' : '<i class="anticon anticon-plus"></i> Tambah' !!}</button>
          </div>
      </form>
    </div>
  </div> --}}
  <form>
      <div class="page-header no-gutters has-tab">
          <div class="d-md-flex m-b-15 align-items-center justify-content-between">
              <div class="media align-items-center m-b-15">
                  <div class="avatar avatar-image rounded" style="height: 70px; width: 70px">
                      <img src="{{asset('admin/images/others/thumb-16.jpg')}}" alt="">
                  </div>
                  <div class="m-l-15">
                      <h4 class="m-b-0">Skinny Men Blazer</h4>
                      <p class="text-muted m-b-0">Code: #5325</p>
                  </div>
              </div>
              <div class="m-b-15">
                  <button class="btn btn-primary" type="submit">
                      <i class="anticon anticon-save"></i>
                      <span>Save</span>
                  </button>
              </div>
          </div>
          <ul class="nav nav-tabs" >
              <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#product-edit-basic">Basic Info</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#product-edit-option">Option Info</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#product-edit-description">Description</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#product-edit-image">Image</a>
              </li>
          </ul>
      </div>
      <div class="tab-content m-t-15">
          <div class="tab-pane fade show active" id="product-edit-basic" >
              <div class="card">
                  <div class="card-body">
                      <div class="form-group">
                          <label class="font-weight-semibold" for="productName">Product Name</label>
                          <input type="text" name="name" class="form-control" id="productName" placeholder="Product Name" value="Skinny Men Blazer" required>
                      </div>
                      <div class="form-group">
                          <label class="font-weight-semibold" for="productPrice">Price</label>
                          <input type="number" name="price" class="form-control" id="productPrice" placeholder="Min : Rp. 100" min="100" required>
                      </div>
                      <div class="form-group">
                          <label class="font-weight-semibold" for="productStock" >Stock</label>
                          <input type="number" name="stock" class="form-control" id="productStock" placeholder="Min : 0" min="0" required>
                      </div>
                      <div class="form-group">
                          <label class="font-weight-semibold" for="productCategory">Category</label>
                          <select class="custom-select" name="category" id="productCategory" required>
                              @foreach ($data->categories as $item)
                                  <option value="{{$item->id}}" {{ $loop->index == 0 ? "selected" : "" }} >{{ ucfirst($item->name) }}</option>
                              @endforeach
                          </select>
                      </div>
                      <div class="form-group">
                          <label class="font-weight-semibold" for="productBrand">Brand</label>
                          <input type="text" name="brand" class="form-control" id="productBrand" placeholder="Brand" value="H&M" required>
                      </div>
                  </div>
              </div>
          </div>
          <div class="tab-pane fade" id="product-edit-option">
              <div class="card">
                  <div class="card-body">
                      <div class="form-group">
                          <label class="font-weight-semibold" for="productStatus">Status</label>
                          <select class="custom-select" name="status" id="productStatus" required>
                              <option value="inStock" selected>In Stock</option>
                              <option value="outOfStock">Out of Stock</option>
                              <option value="pending">Pending</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label class="font-weight-semibold" for="productDiscount">Discount (%)</label>
                          <input type="number" name="discount" class="form-control" id="productDiscount" placeholder="Ex : 10%" min="0" max="100">
                      </div>
                      <div class="form-group">
                          <label class="font-weight-semibold" for="productSize">Unit</label>
                          <select class="custom-select w-100" name="unit" id="productSize" required>
                              <option value="pcs" selected>Pcs</option>
                              <option value="box">Box</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label class="font-weight-semibold" for="productColors">Colors</label>
                          <select class="select2 w-100" name="color" id="productColors" multiple="multiple" required>
                              <option value="db" selected>Dark Blue</option>
                              <option value="g" selected>Gray</option>
                              <option value="gb" selected>Gray Blue</option>
                          </select>
                      </div>
                  </div>
              </div>
          </div>
          <div class="tab-pane fade" id="product-edit-description">
              <div class="card">
                  <div class="card-body">
                      <div id="productDescription">
                          <p>Special cloth alert. The key to more success is to have a lot of pillows. Surround yourself with angels, positive energy, beautiful people, beautiful souls, clean heart, angel. They will try to close the door on you, just open it. A major key, never panic. Don’t panic, when it gets crazy and rough, don’t panic, stay calm. They key is to have every key, the key to open every door.The other day the grass was brown, now it’s green because I ain’t give up. Never surrender. Lion! I’m up to something. Always remember in the jungle there’s a lot of they in there, after you overcome they, you will make it to paradise.</p>
                      </div>
                  </div>
              </div>
          </div>
          <div class="tab-pane fade" id="product-edit-image">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <img class="img-fluid" src="{{asset('admin/images/others/product-1.jpg')}}" alt="">
                        </div>
                        <div class="col-md-3">
                            <img class="img-fluid" src="{{asset('admin/images/others/product-2.jpg')}}" alt="">
                        </div>
                        <div class="col-md-3">
                            <img class="img-fluid" src="{{asset('admin/images/others/product-3.jpg')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
          </div>
      </div>
  </form>
@endsection

@section('extend_script')
  <!-- page js -->
  <script src="{{ asset('vendors/select2/select2.min.js') }}"></script>
  <script src="{{ asset('vendors/quill/quill.min.js') }}"></script>
  <script src="{{ asset('vendors/ntc/ntc.js') }}"></script>
  <script src="{{ asset('vendors/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js') }}"></script>
  {{-- <script src="{{ asset('admin/js/pages/e-commerce-product-edit.js') }}"></script> --}}

  <script type="text/javascript">
      $('.select2').select2();
      $(document).ready(function () {
        new Quill('#productDescription', {
          theme: 'snow'
        });
      });
  </script>
@endsection
