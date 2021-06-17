@extends('layouts.admin')

@section('page_title', "Add Categories")

@section('extend_style')
  <!-- page style -->
  <link href="{{ asset('vendors/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb_item')
  <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
  <a class="breadcrumb-item" href="{{ route('category.manage') }}">Kategori</a>
  <span class="breadcrumb-item active">
    {{ $mode == "edit" ? "Edit kategori" : "Tambah kategori" }}
  </span>
@endsection

@section('content')
  <div class="card">
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
      <form id="form-validation" action="{{$mode == 'edit' ? route('category.update') : route('category.store')}}" method="post">
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
  </div>

@endsection

@section('extend_script')
  <!-- page js -->
  <script src="{{ asset('vendors/jquery-validation/jquery.validate.min.js') }}"></script>

  <script type="text/javascript">
    $( "#form-validation" ).validate({
      ignore: ':hidden:not(:checkbox)',
      errorElement: 'label',
      errorClass: 'is-invalid',
      validClass: 'is-valid',
      rules: {
          name: {
              required: true,
              minlength: 2,
              maxlength : 50
          },
          description: {
              required: false
          }
      }
    });
  </script>
@endsection
