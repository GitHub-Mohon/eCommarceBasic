

@extends('Backend.admin.layouts')

@section('form-content')
<div class="content-wrapper">

  <section class="content-header">
  <div class="container-fluid">
  <div class="row mb-2">
  <div class="col-sm-6">
  <h1>Edit Category</h1>
  </div>
  <div class="col-sm-6">
  <ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{route('category.read')}}">All Category</a></li>
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
  <div class="card-header">
  <h3 class="card-title">Edit {{$category->name}}</h3>
  </div>


  <form action="{{route('category.update',$category->id)}}" method="POST" enctype="multipart/form-data">
    {{csrf_field()}}
  <div class="card-body">
  <div class="form-group">
  <label for="exampleInputAcademic1">Edit Name <span style="color: red">*</span></label>
  <input type="text" name="name" class="form-control" id="exampleInputAcademic1" value="{{old('name',$category->name)}}">
  @error('name')
  <p class="text-danger">{{$message}}</p>
  @enderror
  </div>
  <div class="form-group"  style="height: 120px; width: 150px;">
    <img src="/categoryImages/{{$category->image}}" alt="Category Image Not Fund" style="max-width: 100%; max-height: 100%;">
  </div>
  <div class="form-group">
  <label for="exampleInputAcademic1">Category Picture<span style="color: red">*</span></label>
  <input type="file" name="image" class="form-control" id="exampleInputAcademic1" placeholder="Enter New Picture">
  @error('image')
  <p class="text-danger">{{$message}}</p>
  @enderror
  </div>
  <div class="form-group">
  <label for="exampleInputAcademic1">Status<span style="color: red">*</span></label>
  <select name="status" class="form-control" id="">
    <option {{($category->status == 0) ? 'selected' : ''}} value="0"> Active </option>
    <option {{($category->status == 1 ) ? 'selected' : ''}} value="1"> Inactive </option>
  </select>
  @error('status')
  <p class="text-danger">{{$message}}</p>
  @enderror
  </div>
  </div>
<div class="form-group">
  <label for="exampleInputAcademic1">Meta Title<span style="color: red">*</span></label>
  <input type="text" name="meta_title" class="form-control" id="exampleInputAcademic1" value="{{old('meta_title',$category->meta_title)}}">
  @error('meta_title')
  <p class="text-danger">{{$message}}</p>
  @enderror
  </div>
  <div class="form-group">
  <label for="exampleInputAcademic1">Meta Description<span style="color: red">*</span></label>
  <textarea name="meta_description" class="form-control" id="exampleInputAcademic1" placeholder="Enter Meta Description">{{$category->meta_description}}</textarea>
  @error('meta_description')
  <p class="text-danger">{{$message}}</p>
  @enderror
  </div>
  <div class="form-group">
  <label for="exampleInputAcademic1">Meta Keywords<span style="color: red">*</span></label>
  <input type="text" name="meta_keyword" class="form-control" id="exampleInputAcademic1" value="{{old('meta_keyword',$category->meta_keyword)}}">
  @error('meta_keyword')
  <p class="text-danger">{{$message}}</p>
  @enderror
  </div>
  <div class="card-footer">
  <button type="submit" class="btn btn-primary">Save Change</button>
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
