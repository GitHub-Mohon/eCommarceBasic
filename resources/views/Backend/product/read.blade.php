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
  <h1>Products</h1>
  </div>
  <div class="col-sm-6">
  <ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{route('product.create')}}">Add New Product</a></li>



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
  <h3 class="card-title">Product List</h3>
    @if (session('status'))
    <div class="alert alert-success">
      {{session('status')}}
    </div>

    @endif
  </div>

  <div class="card-body">
  <table id="example1" class="table table-striped">
  <thead>
  <tr>
  <th>ID</th>
  <th>Title</th>
  <th>Image</th>
  <th>Short Description</th>
  <th>Created By</th>
  <th>Status</th>
  <th>Created</th>
  <th>Action</th>
  </tr>
  </thead>
  <tbody>
    @foreach ($product as $item)


  <td>#</td>
  <td>{{$item->name}}</td>
  <td style="height: 80px; width: 100px;">
    <img src="/productHeroImages/{{$item->hero_image}}" alt="Product Image Not Fund" style="max-width: 100%; max-height: 100%;">
  </td>
  <td>{{$item->short_description}}</td>
  <td>{{$item->created_by}}</td>
  <td>{{($item->status == 0) ? 'Active' : 'Inactive'}}</td>
  <td>{{ date('d-m-y',strtotime($item->created_at))}}</td>
  <td><a class="btn btn-warning btn-sm" href="{{ route('product.edit',$item->id)}}" >Edit</a>
    <a class="btn btn-danger btn-sm" href="{{ route('product.delete',$item->id)}}" onclick="return confirm('Are You sure Delete it?')">Delete</a></td>
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


