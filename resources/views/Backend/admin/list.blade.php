@extends('Backend.admin.layouts')


@section('customCss')

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

@endsection

@section('table-content')

<div class="content-wrapper">

  <section class="content-header">
  <div class="container-fluid">
  <div class="row mb-2">
  <div class="col-sm-6">
  <h1>All User</h1>
  </div>
  <div class="col-sm-6">
  <ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{route('admin.create')}}">Add New User</a></li>



  </ol>
  </div>
  </div>
  </div>
  </section>

  <section class="content">
  <div class="container-fluid">
  <div class="row">
  <div class="col-12">

  <div class="card">
  <div class="card-header">
  <h3 class="card-title">User List</h3>
    @if (session('status'))
    <div class="alert alert-success">
      {{session('status')}}
    </div>

    @endif
  </div>

  <div class="card-body">
  <table id="example1" class="table table-bordered table-striped">
  <thead>
  <tr>
  <th>ID</th>
  <th>Name</th>
  <th>Email</th>
  <th>Status</th>
  <th>Edit</th>
  <th>Delete</th>
  </tr>
  </thead>
  <tbody>
    @foreach ($admin_list as $item)


  <td>{{$item->id}}</td>
  <td>{{$item->name}}</td>
  <td>{{$item->email}}</td>
  <td>{{($item->status == 0) ? 'Active' : 'Inactive'}}</td>
  <td><a class="btn btn-warning" href="{{ route('admin.edit',$item->id)}}" >Edit</a></td>
  <td><a class="btn btn-danger" href="{{ route('admin.delete',$item->id)}}" onclick="return confirm('Are You sure Delete it?')">Delete</a></td>
  </tr>

  @endforeach

  </tbody>
  </table>
  </div>

  </div>

  </div>

  </div>

  </div>

  </section>

  </div>

@endsection

@section('customJs')

<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script src="dist/js/adminlte.min2167.js?v=3.2.0"></script>

<script src="dist/js/demo.js"></script>



@endsection


