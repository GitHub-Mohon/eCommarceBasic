

@extends('Backend.admin.layouts')

@section('form-content')
<div class="content-wrapper">

  <section class="content-header">
  <div class="container-fluid">
  <div class="row mb-2">
  <div class="col-sm-6">
  <h1>New User Form</h1>
  </div>
  <div class="col-sm-6">
  <ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{route('admin.read')}}">All User</a></li>
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
  <h3 class="card-title">Add New User</h3>
  </div>


  <form action="{{route('admin.store')}}" method="POST">
    {{csrf_field()}}
  <div class="card-body">
  <div class="form-group">
  <label for="exampleInputAcademic1">Name</label>
  <input type="text" name="name" class="form-control" id="exampleInputAcademic1" placeholder="Enter Name">
  @error('name')
  <p class="text-danger">{{$message}}</p>
  @enderror
  </div>
  <div class="form-group">
  <label for="exampleInputAcademic1">E-Mail</label>
  <input type="email" name="email" class="form-control" id="exampleInputAcademic1" placeholder="Enter Email">
  @error('email')
  <p class="text-danger">{{$message}}</p>
  @enderror
  </div>
  <div class="form-group">
  <label for="exampleInputAcademic1">Password</label>
  <input type="password" name="password" class="form-control" id="exampleInputAcademic1" placeholder="Enter password">
  @error('password')
  <p class="text-danger">{{$message}}</p>
  @enderror
  </div>
  <div class="form-group">
  <label for="exampleInputAcademic1">Status</label>
  <select name="status" class="form-control" id="">
    <option value="0"> Active </option>
    <option value="1"> Inactive </option>
  </select>
  @error('status')
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
