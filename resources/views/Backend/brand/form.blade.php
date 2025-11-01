

@extends('Backend.admin.layouts')

@section('form-content')
<div class="content-wrapper">

  <section class="content-header">
  <div class="container-fluid">
  <div class="row mb-2">
  <div class="col-sm-6">
  <h1>Add New Brand</h1>
  </div>
  <div class="col-sm-6">
  <ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{route('brand.read')}}">All Brands</a></li>
  </ol>
  </div>
  </div>
  </div>
  </section>

  <section class="content">
  <div class="container-fluid">
  <div class="row">

  <div class="col-md-12">
  <div class="card card-primary">
    @if (session('success'))
    <div class="alert alert-success">
      {{session('success')}}
    </div>

    @endif
    @if (session('errors'))
    <div class="alert alert-danger">
      {{session('errors')}}
    </div>

    @endif
  <div class="card-header">
  <h3 class="card-title">Add New Brand</h3>
  </div>


  <form action="{{route('brand.store')}}" method="POST" enctype="multipart/form-data">
    {{csrf_field()}}
  <div class="card-body">
  <div class="form-group">
  <label for="exampleInputAcademic1">Brand Name<span style="color: red">*</span></label>
  <input type="text" name="name" class="form-control" id="exampleInputAcademic1" placeholder="Enter Name">
  @error('name')
  <p class="text-danger">{{$message}}</p>
  @enderror
  </div>
  <div class="form-group">
  <label for="exampleInputAcademic1">Brand Picture<span style="color: red">*</span></label>
  <input type="file" name="image" class="form-control" id="exampleInputAcademic1" placeholder="Enter Picture">
  @error('image')
  <p class="text-danger">{{$message}}</p>
  @enderror
  </div>
  <div class="form-group">
  <label for="exampleInputAcademic1">Status<span style="color: red">*</span></label>
  <select name="status" class="form-control" id="">
    <option value="0"> Active </option>
    <option value="1"> Inactive </option>
  </select>
  @error('status')
  <p class="text-danger">{{$message}}</p>
  @enderror
  </div>
  <div class="form-group">
  <label for="exampleInputAcademic1">Meta Title<span style="color: red">*</span></label>
  <input type="text" name="meta_title" class="form-control" id="exampleInputAcademic1" placeholder="Enter Name">
  @error('meta_title')
  <p class="text-danger">{{$message}}</p>
  @enderror
  </div>
  <div class="form-group">
  <label for="exampleInputAcademic1">Meta Description<span style="color: red">*</span></label>
  <textarea name="meta_description" class="form-control" id="exampleInputAcademic1" placeholder="Enter Meta Description"></textarea>
  @error('meta_description')
  <p class="text-danger">{{$message}}</p>
  @enderror
  </div>
  <div class="form-group">
  <label for="exampleInputAcademic1">Meta Keywords<span style="color: red">*</span></label>
  <input type="text" name="meta_keyword" class="form-control" id="exampleInputAcademic1" placeholder="Enter Keywords">
  @error('meta_keyword')
  <p class="text-danger">{{$message}}</p>
  @enderror
  </div>
  </div>

  <div class="card-footer">
  <button type="submit" class="btn btn-primary">Submit</button>
  </div>
  </form>
  </div>

  </div>

  </div>

  </div>
  </section>

  </div>
@endsection

@section('customJs')


<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<script>
$(function () {
  bsCustomFileInput.init();
});
</script>

@endsection
