@extends('layouts.admin')

@section('page_title', "Add Product")

@section('extend_style')
<!-- page style -->
<link href="{{ asset('vendors/select2/select2.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css') }}" rel="stylesheet">

<link href="{{ asset('vendors/dropzone/dropzone.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/dropzone/test.css') }}" rel="stylesheet">

<style media="screen">
  .select2-choices {
    border: 1px solid #edf2f9 !important;
    background: none !important;
  }
</style>
@endsection

@section('breadcrumb_item')
<a href="{{ route('admin.dashboard')}}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
<a class="breadcrumb-item" href="{{ route('product.manage') }}">Product</a>
<span class="breadcrumb-item active">
  {{ $mode == "edit" ? "Edit product" : "Add product" }}
</span>
@endsection

@section('content')

<form id="form_product" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="page-header no-gutters has-tab">
    <div class="d-md-flex m-b-15 align-items-center justify-content-between">
      <div class="media align-items-center m-b-15">
        @if($mode != "edit")
        <i class="anticon anticon-file-add display-4"></i>
        @else
        <div class="avatar avatar-image rounded" style="height: 70px; width: 70px">
          <img src="{{asset('admin/images/others/thumb-16.jpg')}}" alt="">
        </div>
        @endif
        <div class="m-l-15">
          @if($mode != "edit")
          <h4 class="m-b-0">New Product</h4>
          @else
          <h4 class="m-b-0">{{$data->product->name}}</h4>
          <p class="text-muted m-b-0">Code: #5325</p>
          @endif
        </div>
      </div>
      <div class="m-b-15">
        <button class="btn btn-primary" id="btn_save" type="submit">
          <i class="anticon anticon-save"></i>
          <span>Save</span>
        </button>
      </div>
    </div>
    <div class="alert alert-danger" id="error-area" style="display:none">
      <h5 class="text-danger"><i class="anticon anticon-warning"></i> Error</h5>
      <hr>
      <div class="col-12">
        <ul id="error">
          @foreach ($errors->all() as $error)
            <li>{{ $error->massage }}</li>
          @endforeach
        </ul>

      </div>
    </div>
    <ul class="nav nav-tabs">
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
    <div class="tab-pane fade show active" id="product-edit-basic">
      <div class="card">
        <div class="card-body">
          <div class="form-group">
            <label class="font-weight-semibold" for="productName">Product Name</label>
            <input type="text" name="name" class="form-control" id="productName" placeholder="Product Name" value="{{ isset($data->product) ? $data->product->name : old('name') }}" required>
          </div>
          <div class="form-group">
            <label class="font-weight-semibold" for="productPrice">Price</label>
            {{-- <input type="number" name="price" class="form-control" id="productPrice" placeholder="Min : Rp. 100" min="100" required> --}}
            <input type="number" name="price" class="form-control" id="productPrice" placeholder="Min : Rp. 100" min="100" value="{{ isset($data->product) ? $data->product->price : old('price') }}" required>
          </div>
          <div class="form-group">
            <label class="font-weight-semibold" for="productStock">Stock</label>
            {{-- <input type="number" name="stock" class="form-control" id="productStock" placeholder="Min : 0" min="0" required> --}}
            <input type="number" name="stock" class="form-control" id="productStock" placeholder="Min : 0" min="0" value="{{ isset($data->product) ? $data->product->stock : old('stock') }}" required>
          </div>
          <div class="form-group">
            <label class="font-weight-semibold" for="productCategory">Category </label>
            <select class="custom-select" name="category" id="productCategory" required>
              @foreach ($data->categories as $item)
                <option value="{{ isset($data->product) ? $data->product->category_id : $item->id }}" {{ $loop->index == 0 ? "selected" : "" }}>{{ ucfirst($item->name) }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="font-weight-semibold" for="productBrand">Brand</label>
            <input type="text" name="brand" class="form-control" id="productBrand" value="{{ isset($data->product) ? $data->product->brand : old('brand') }}" placeholder="Brand" required>
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
            <input type="number" name="discount" class="form-control" id="productDiscount" value="{{ isset($data->product) ? $data->product->discount : old('discount') }}" placeholder="Ex : 10%" min="0" max="100">
          </div>
          <div class="form-group">
            <label class="font-weight-semibold" for="productSize">Unit</label>
            <select class="custom-select w-100" name="unit" id="productSize" required>
              <option value="pcs" {{ old("unit") == "pcs" || old('unit') == "" ? "selected" : ""  }}>Pcs</option>
              <option value="box" {{ old("unit") == "box" ? "selected" : ""  }}>Box</option>
            </select>
          </div>
          <div class="form-group">
            <label class="font-weight-semibold" for="productColors">Colors</label>
            @if(isset($data->product))
            <input type="text" name="colors" class="form-control" id="productDiscount" value="{{isset($data->product) ? $data->product->color : ''}}">
            @else
            <select class="select2 w-100" name="colors" id="productColors" multiple="multiple" required>
              @foreach ($data->colors as $color)
              <option value="{{$color['id']}}">{{$color['name']}}</option>
              @endforeach
            </select>
            @endif
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
          <h5>Upload Images</h5>

          <input type="file" name="image_product[]" id="image_product" class="form-control" accept="image/*" multiple>

          <small>Accepted image type is .png, .jpg, .jpeg, and .gif. </small>
          <br>
          <small>Max image size is 15 Mb</small>

        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <div class="row" id="image_prev">

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
<script src="{{ asset('vendors/dropzone/dropzone.min.js') }}"></script>
{{-- <script src="{{ asset('admin/js/pages/e-commerce-product-edit.js') }}"></script> --}}

<script type="text/javascript">
  $('.select2').select2();
  $(document).ready(function () {
    new Quill('#productDescription', {
      theme: 'snow'
    });
  });

  var imagesPreview = function(input, placeToInsertImagePreview) {

    if (input.files) {
      var filesAmount = input.files.length;
      var elementImage = "";
      $('div#image_prev').empty();

      for (i = 0; i < filesAmount; i++) {
        var reader = new FileReader();


        reader.onload = function(event) {
          elementImage = '<div class="col-md-3"><img class="img-fluid" src="' + event.target.result + '"></div>';
          $('div#image_prev').append(elementImage);
        }

        reader.readAsDataURL(input.files[i]);
      }
    }

  };

  $('#image_product').on('change', function() {
    imagesPreview(this, 'div#image_prev');
  });


  $('#btn_save').click((e) => {
    e.preventDefault();
    $('#error').empty();

    // Color selection to text
    var _colors = $('#productColors').val();
    var _colorString = "";
    if (_colors) {
      for (var i = 0; i < _colors.length; i++) {
        if (i != _colors.length - 1) {
          _colorString += _colors[i] + ';';
        } else {
          _colorString += _colors[i];
        }
      }
    }

    var formData = new FormData(document.getElementById('form_product'));

    formData.append('description', $('#productDescription .ql-editor').html());
    formData.append('color', _colorString);

    $.ajax({
      url: "{{ (isset($data->product)) ? Route('product.update') : Route('product.store') }}",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      beforeSend: () => {
        $('#btn_save').html('<i class="anticon anticon-loading-3-quarters"></i> <span>Waiting...</span>');
        // $('#btn_save').prop('disabled', true);
        console.log("masuk");
      },
      success: (data) => {
        $('#btn_save').html('<i class="anticon anticon-save"></i> <span>Save</span>');
        $('#btn_save').prop('disabled', false);
        if (data.success) {
          swal("Sukses", "Product is successful {{ isset($data->product) ? 'updated' : 'inserted' }}!", "success")
            .then(() => {
              location.href = "/manage/product";
            });
        } else {
          swal("Error", data.msg, "error");
        }
      },
      error: function(err) {
        console.log("Meninggoy");
        console.warn(err.responseJSON.errors);

        $('#btn_save').html('<i class="anticon anticon-save"></i> <span>Save again</span>');

        $('#error-area').css('display', 'block');
        if (err.status == 422)
          $.each(err.responseJSON.errors, function(key, item) {
            $("#error").append("<li>" + item[0] + "</li>")
            // console.log(key);
          });
      }
    });
  });
</script>
@endsection
