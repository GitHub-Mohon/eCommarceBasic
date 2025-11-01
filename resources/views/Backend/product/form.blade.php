

@extends('Backend.admin.layouts')

@section('form-content')
<div class="content-wrapper">

  <section class="content-header">
  <div class="container-fluid">
  <div class="row mb-2">
  <div class="col-sm-6">
  <h1>New Product</h1>
  </div>
  <div class="col-sm-6">
  <ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{route('product.read')}}">All Product</a></li>
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
  <h3 class="card-title">New Product</h3>
  </div>


  <form action="{{route('product.store')}}" method="POST" enctype="multipart/form-data">
    {{csrf_field()}}
  <div class="card-body">
  <div class="row">
    <div class="col-md-8">
        <div class="form-group">
        <label for="exampleInputAcademic1">Title<span style="color: red">*</span></label>
        <input type="text" name="name" class="form-control" id="exampleInputAcademic1" placeholder="product Title">

        </div>
    </div>

  </div>
  <div class="row">
    <div class="col-md-8">
        <div class="form-group">
        <label for="heroImage">Product Hero Image</label>
        <input type="file" name="hero_image" class="form-control" id="heroImage" placeholder="Enter Picture">
        {{-- @error('hero_image')
        <p class="text-danger">{{$message}}</p>
        @enderror --}}
        </div>
    </div>
    <div class="col-md-4">
        <div  class="form-group"  style="height: 120px; width: 150px;">
            <div id="imagePreview" class="d-flex flex-wrap gap-2"></div>
        </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
        <div class="form-group">
        <label for="exampleInputAcademic1">SKU</span></label>
        <input type="text" name="sku" class="form-control" id="exampleInputAcademic1" placeholder="sku=2224">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
        <label for="category_id">Category <span style="color: red">*</span></label>
        <select name="category_id"class="form-control" id="category_id">
            <option selected disabled>Selected</option>
            @foreach ($category as $item )
            <option value="{{$item->id}}">{{$item->name}}</option>
            @endforeach
        </select>

        </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
        <div class="form-group">
        <label for="sub_category">Sub Category</span></label>
        <select name="sub_category_id"class="form-control" id="sub_category_id">
            <option selected disabled>Selected</option>

        </select>

        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
        <label for="exampleInputAcademic1">Brand <span style="color: red">*</span></label>
        <select name="brand_id"class="form-control" id="">
            <option selected disabled>Selected</option>
            @foreach ($brand as $item)
            <option value="{{$item->id}}">{{$item->name}}</option>
            @endforeach
        </select>
        {{-- @error('brand_id')
        <p class="text-danger">{{$message}}</p>
        @enderror --}}
        </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
        <div class="form-group">
        <label for="color">Color Type <span style="color: red">*</span></label>
        <div>
            @foreach ($Color as $item)
            <label for="color_{{ $item->id }}">
                <input
                    type="checkbox"
                    name="color_id[]"
                    id="color_{{ $item->id }}"
                    value="{{ $item->id }}">
                {{ $item->name }}
            </label>
    @endforeach
        </div>
        {{-- @error('color_id')
        <p class="text-danger">{{$message}}</p>
        @enderror --}}
        </div>
  </div>
  </div>
  <div class="row">
    <div class="col-md-6">
        <div class="form-group">
        <label for="exampleInputAcademic1">Price <span style="color: red">*</span></label>
        <input type="text" name="price" class="form-control" placeholder="per pis Price 20$">
        {{-- @error('price')
        <p class="text-danger">{{$message}}</p>
        @enderror --}}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
        <label for="exampleInputAcademic1">Old Price</label>
        <input type="text" name="old_price" class="form-control" placeholder="20$">
        {{-- @error('old_price')
        <p class="text-danger">{{$message}}</p>
        @enderror --}}
        </div>
    </div>
  </div>
  {{-- Size --}}
  <div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="">Size <span style="color: red">*</label>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Price</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody id="appendSection">

                {{-- @php
                $i_s = 1;
                @endphp

                <tr id="deletePrice">
                    <td>
                        <input type="text" name="size[{{$i_s}}][name]" class="form-control">
                    </td>
                    <td>
                        <input type="text" name="size[{{$i_s}}][price]" class="form-control">
                    </td>
                    <td>
                        <button type="button" id="{{$i_s}}" class="btn btn-danger btn-sm deletePrice">Delete</button>
                    </td>
                </tr>

                @php
                $i_s++;
                @endphp --}}
                <tr>
                    <td>
                        <input type="text" name="size[100][name]" class="form-control"  placeholder="type your Product Size">
                    </td>
                    <td>
                        <input type="text" name="size[100][price]" class="form-control" placeholder="Product Price 200.00$">
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" id="addPice">Add</button>
                        {{-- <button type="button" class="btn btn-danger btn-sm">Delete</button> --}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
  </div>
<div class="row">
<div class="col-md-12">
        <div class="form-group">
        <label for="imageInput">Product Images Gallery</label>
        <input type="file" name="image_name[]" class="form-control" id="imageInput" multiple accept="image/*" placeholder="Enter Product Image Gallery" style="padding: 3px">
        {{-- @error('image_name')
        <p class="text-danger">{{$message}}</p>
        @enderror --}}
        </div>
</div>
</div>
<div class="row">
    <div class="col-md-12">
         <div id="imagePreviewContainer" class="d-flex flex-wrap gap-2"></div>
    </div>
</div>
{{-- @if (!empty($product_gallery->count()))
    <div class="row" id="sortable">
        @foreach ($product_gallery as $image)
        @if (!empty($image))
             <div class="col-md-3 mb-4">
                <div class="card shadow-sm sortable_image" id="{{$image->id}}">
                    <span style="text-align: right">
                        <a href="{{route('deleteImage',$image->id)}}"> <i class="fas fa-times text-danger"></i> </a>
                    </span>
                    <img src="{{ asset('productGallery/' . $image->image_name) }}"
                         alt="Image not found"
                         class="card-img-top"
                         style=" width:100%; height: 150px; object-fit: cover;">
                </div>
            </div>
        @endif
        @endforeach
    </div>
@endif --}}
  <div class="row">
    <div class="col-md-12">
        <div class="form-group">
        <label for="shortDes">Short Description</label>
        <textarea class="form-control" name="short_description" placeholder="Short Description about Product" id="shortDes"></textarea>
    </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
        <div class="form-group">
        <label for="des">Description</label>
        <textarea class="form-control editor" name="description"  id="des"></textarea>
    </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
        <div class="form-group">
        <label for="adInfo">Additional Information</label>
        <textarea class="form-control editor" name="additional_information" id="adInfo"></textarea>
    </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
        <div class="form-group">
        <label for="shortDes">Shipping Returns  <span style="color: red">*</span></label>
        <textarea class="form-control editor" name="shipping_returns" placeholder="Short Description about Product" id="shortDes"></textarea>
    </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="status">Status  <span style="color: red">*</span></label>
            <select name="status" id="status" class="form-control">
                <option value="0">Active</option>
                <option value="1">Inactive</option>
            </select>
            {{-- @error('status')
        <p class="text-danger">{{$message}}</p>
        @enderror --}}
        </div>
    </div>
  </div>

  <div class="card-footer">
  <button type="submit" class="btn btn-primary">Add New Product</button>
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
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

<script>
$(function () {
  bsCustomFileInput.init();
});
</script>

{{-- sub category --}}
<script>
    $(document).ready(function () {
        $('#category_id').on('change', function () {
            var categoryId = $(this).val();

            $.ajax({
                url: "{{ route('findSubCategory') }}",
                type: "GET",
                data: { category_id: categoryId },
                success: function (response) {
                    if (response.status) {
                        $('#sub_category_id').empty();
                        $('#sub_category_id').append('<option selected disabled>Selected</option>');

                        $.each(response.sub_category, function (key, item) {
                            $('#sub_category_id').append(`<option value="${item.id}">${item.name}</option>`);
                        });
                    }
                },
                error: function (xhr) {
                    console.log("AJAX Error:", xhr.responseText);
                }
            });
        });
    });
</script>

<script>
    var i = 101;
    $('#addPice').on('click',function(){
        const addSection = `<tr>
                    <td>
                        <input type="text" name="size[${i}][name]" class="form-control" placeholder="type your Product Size">
                    </td>
                    <td>
                        <input type="text" name="size[${i}][price]" class="form-control" placeholder="Product Price 200.00$">
                    </td>
                    <td>
                        <button type="button" id="${i}" class="btn btn-danger btn-sm deletePrice">Delete</button>
                    </td>
                </tr>`;

                i++;
                $('#appendSection').append(addSection);
    });


    $(document).on('click', '.deletePrice', function () {
    $(this).closest('tr').remove();
});

</script>




{{-- single image previews --}}

<script>
document.getElementById('heroImage').addEventListener('change', function(event) {
    const files = event.target.files;
    const container = document.getElementById('imagePreview');
    container.innerHTML = ''; // Clear previous previews

    if (files.length === 0) return;

    Array.from(files).forEach(file => {
        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-thumbnail';
            img.style.maxHeight = '100px';
            img.style.maxWidth = '120px';
            img.style.margin = '5px';
            container.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
});
</script>

{{-- Multiple images --}}


<script>
document.getElementById('imageInput').addEventListener('change', function(event) {
    const files = event.target.files;
    const container = document.getElementById('imagePreviewContainer');
    container.innerHTML = ''; // Clear previous previews

    if (files.length === 0) return;

    Array.from(files).forEach(file => {
        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-thumbnail';
            img.style.maxHeight = '80px';
            img.style.maxWidth = '100px';
            img.style.margin = '5px';
            container.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
});
</script>


{{-- Image Gallery Short able  --}}

{{-- <script>
  $( function() {
    $( "#sortable" ).sortable({
        update : function(event, ui){
            var photo_id = new Array();
            $('.sortable_image').each(function(){
                var id = $(this).attr('id');
                photo_id.push(id);
                // console.log(id);

                $.ajax({
                type : "POST",
                url : "route('imageSortable')",
                data : {
                    "photo_id" : photo_id,
                    "_token" : "{{csrf_field()}}"
                },
                dataType : "json",
                success : function(data){

                },
                error : function(data){

                }
            });

            });


        }


    });
  } );
</script> --}}

<script>
$(function () {
    $('#sortable').sortable({
        update() {
            const photo_id = $('.sortable_image').map(function () {
                return $(this).attr('id');
            }).get();                         // -> ["12","7","5"]

            $.post({
                url: "{{ route('imageSortable') }}",
                data: {
                    photo_id,
                    _token: "{{ csrf_token() }}"
                },
                success: () => console.log('Order saved'),
                error:  xhr => console.error(xhr.responseText)
            });
        }
    });
});
</script>



@endsection


