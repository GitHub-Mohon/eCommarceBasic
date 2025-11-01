@extends('frontend.layouts.app')

@section('custom_css')
    <link rel="stylesheet" href="{{url('assets/css/plugins/owl-carousel/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/plugins/magnific-popup/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/plugins/nouislider/nouislider.css')}}">
@endsection

@section('content')
      <main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
                    @if (!empty($getSubCategory))
                        <h1 class="page-title">{{$getSubCategory->name}}<span>Shop</span></h1>
                    @else
                        <h1 class="page-title">{{$getCategory->name}}<span>Shop</span></h1>
                    @endif

        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:;">Shop</a></li>
                        @if (!empty($getSubCategory))
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{url($getCategory->slug)}}">{{$getCategory->name}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$getSubCategory->name}}</li>
                        @else
                            <li class="breadcrumb-item active" aria-current="page">{{$getCategory->name}}</li>
                        @endif

                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container">
                	<div class="row">
                		<div class="col-lg-9">
                			<div class="toolbox">
                				<div class="toolbox-left">
                					<div class="toolbox-info">
                						Showing <span>9 of 56</span> Products
                					</div><!-- End .toolbox-info -->
                				</div><!-- End .toolbox-left -->

                				<div class="toolbox-right">
                					<div class="toolbox-sort">
                						<label for="sortby">Sort by:</label>
                						<div class="select-custom">
											<select name="sortby" id="sortby" class="form-control changShortBy">
												<option value="popularity" selected="selected" disabled>Select</option>
												<option value="popularity" >Most Popular</option>
												<option value="rating">Most Rated</option>
												<option value="date">Date</option>
											</select>
										</div>
                					</div><!-- End .toolbox-sort -->
                				</div><!-- End .toolbox-right -->
                			</div><!-- End .toolbox -->

                    <div id="getProductAjax">
                        @include("Frontend.product._list")
                    </div>

                    <div id="product-list">
    @include('frontend.product.partials.product_list', ['getProduct' => $getProduct])
</div>

@if($page > 0)
    <button id="load-more"
        data-url="{{ route('category.ajax', [$getCategory->slug, $getSubCategory->slug ?? null]) }}?page={{ $page }}">
        Load More
    </button>
@endif


                		</div><!-- End .col-lg-9 -->
                		<aside class="col-lg-3 order-lg-first">

                            <form id="filterForm" action="" method="post">

                                @csrf
                                <input type="hidden" name="old_cate_id" value="{{ !empty($getCategory) ? $getCategory->id : ''}}">
                                <input type="hidden" name="old_sub_cate_id" value="{{ !empty($getSubCategory) ? $getSubCategory->id : ''}}">
                                <input type="hidden" name="get_sub_cate_ids" id="get_sub_cate_ids">
                                <input type="hidden" name="get_size_ids" id="get_size_ids">
                                <input type="hidden" name="brand_ids" id="brand_ids" value="">
                                <input type="hidden" name="get_color_ids" id="get_color_ids">
                                <input type="hidden" name="get_short_by_id" id="get_short_by_id">
                                <input type="hidden" name="get_start_price" id="get_start_price">
                                <input type="hidden" name="get_end_price" id="get_end_price">
                            </form>

                			<div class="sidebar sidebar-shop">
                				<div class="widget widget-clean">
                					<label>Filters:</label>
                					<a href="#" class="sidebar-filter-clear">Clean All</a>
                				</div><!-- End .widget widget-clean -->

                				<div class="widget widget-collapsible">
    								<h3 class="widget-title">
									    <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
									        Category
									    </a>
									</h3><!-- End .widget-title -->

									<div class="collapse show" id="widget-1">
										<div class="widget-body">
											<div class="filter-items filter-items-count">
                                                @if ($subCateFilter->count() > 0)
                                                    @foreach ($subCateFilter as $f_category)
												    <div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input changeCategory" value="{{$f_category->id}}" id="cate_{{$f_category->id}}">
														<label class="custom-control-label" for="cate_{{$f_category->id}}">{{$f_category->name}}</label>
													</div><!-- End .custom-checkbox -->
													<span class="item-count">{{$f_category->totalProduct()}}</span>
												</div><!-- End .filter-item -->
                                                @endforeach
                                                @else
                                                    <div class="filter-item">
													  <span class="item-center">No have Filter Data</span>
												      </div><!-- End .filter-item -->
                                                @endif
                                </div>
        						</div><!-- End .widget -->

        						<div class="widget widget-collapsible">
    								<h3 class="widget-title">
									    <a data-toggle="collapse" href="#widget-2" role="button" aria-expanded="true" aria-controls="widget-2">
									        Size
									    </a>
									</h3><!-- End .widget-title -->

									<div class="collapse show" id="widget-2">
										<div class="widget-body">
											<div class="filter-items">
                                                @if ($productSizeFilter->count() > 0)
                                                    @foreach ($productSizeFilter as $f_size)
                                                    <div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input changeSize" value="{{$f_size->id}}" id="size_{{$f_size->id}}">
														<label class="custom-control-label" for="size_{{$f_size->id}}">{{$f_size->name}}</label>
													</div><!-- End .custom-checkbox -->
												</div><!-- End .filter-item -->
                                                    @endforeach
                                                @else
                                                <span class="item-center">No Product Size Filter</span>
                                                @endif

											</div><!-- End .filter-items -->
										</div><!-- End .widget-body -->
									</div><!-- End .collapse -->
        						</div><!-- End .widget -->

        						<div class="widget widget-collapsible">
    								<h3 class="widget-title">
									    <a data-toggle="collapse" href="#widget-3" role="button" aria-expanded="true" aria-controls="widget-3">
									        Colour
									    </a>
									</h3><!-- End .widget-title -->

									<div class="collapse show" id="widget-3">
										<div class="widget-body">
											<div class="filter-colors">
                                                @if ($filterColor->count() > 0)
                                                    @foreach ($filterColor as $f_color)
                                                    <a href="javascript:;" class="changeColor" data-val="0" id="{{$f_color->id}}" style="background: {{$f_color->code}};" ><span class="sr-only">{{$f_color->name}}</span></a>
                                                    @endforeach
                                                @else
                                                <span class="item-center">No have Color Filter</span>
                                                @endif

												<a href="#" class="selected" style="background: #cc3333;"><span class="sr-only">Color Name</span></a>
											</div><!-- End .filter-colors -->
										</div><!-- End .widget-body -->
									</div><!-- End .collapse -->
        						</div><!-- End .widget -->
        						<div class="widget widget-collapsible">
    								<h3 class="widget-title">
									    <a data-toggle="collapse" href="#widget-4" role="button" aria-expanded="true" aria-controls="widget-3">
									        Brand
									    </a>
									</h3><!-- End .widget-title -->

									<div class="collapse show" id="widget-4">
										<div class="widget-body">
											<div class="filter-items">


                                            @if ($brandFilter->count() > 0)
                                                    @foreach ($brandFilter as $f_brand)
                                                    <div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input changeBrand"  data-type="brand" value="{{$f_brand->id}}" id="brand_{{ $f_brand->id }}">
														<label class="custom-control-label" for="brand_{{ $f_brand->id }}">{{$f_brand->name}}</label>
													</div><!-- End .custom-checkbox -->
												</div><!-- End .filter-item -->
                                                    @endforeach
                                            @else
                                                <span class="item-center">No Product Brand Filter</span>
                                            @endif

											</div><!-- End .filter-items -->
										</div><!-- End .widget-body -->
									</div><!-- End .collapse -->
        						</div><!-- End .widget -->


        						<div class="widget widget-collapsible">
    								<h3 class="widget-title">
									    <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true" aria-controls="widget-5">
									        Price
									    </a>
									</h3><!-- End .widget-title -->

									<div class="collapse show" id="widget-5">
										<div class="widget-body">
                                            <div class="filter-price">
                                                <div class="filter-price-text">
                                                    Price Range:
                                                    <span id="filter-price-range"></span>
                                                </div><!-- End .filter-price-text -->

                                                <div id="price-slider"></div><!-- End #price-slider -->
                                            </div><!-- End .filter-price -->
										</div><!-- End .widget-body -->
									</div><!-- End .collapse -->
        						</div><!-- End .widget -->
                			</div><!-- End .sidebar sidebar-shop -->
                		</aside><!-- End .col-lg-3 -->
                	</div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

@endsection

@section('custom_js')
    <script src="{{url('assets/js/wNumb.js')}}"></script>
    <script src="{{url('assets/js/bootstrap-input-spinner.js')}}"></script>
    <script src="{{url('assets/js/nouislider.min.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            //sortBy
            $('.changShortBy').change(function(){
                var id = $(this).val();
                console.log(id);
                $('#get_short_by_id').val(id);
                filterForm();
            });

            //get Category
            $('.changeCategory').change(function(){
                var ids = '';
                $('.changeCategory').each(function(){
                    if(this.checked){
                        var id = $(this).val();
                        ids += id+',';
                    }
                    $('#get_sub_cate_ids').val(ids);
                    filterForm();
                });
            });
            //get Size filter
            $('.changeSize').change(function(){
                var ids = '';
                $('.changeSize').each(function(){
                    if(this.checked){
                        var id = $(this).val();
                        ids += id+',';
                    }
                    $('#get_size_ids').val(ids);
                    filterForm();
                });
            });

            //Brand
            $('.changeBrand').change(function(){
                var ids = '';
                $('.changeBrand').each(function(){
                    if(this.checked){
                        var id = $(this).val();
                        ids += id+',';
                    }
                    $('#brand_ids').val(ids);
                    filterForm();
                    console.log("Selected brand IDs:", ids);
                });
            });

        });

            // get Color filter
        $(document).on('click', '.changeColor', function(e) {
            e.preventDefault();

                let id = $(this).attr('id');
                let status = $(this).attr('data-val');
                if (status == "0") {
                    $(this).attr('data-val', "1");
                    $(this).addClass('selected');
                } else {
                    $(this).attr('data-val', "0");
                    $(this).removeClass('selected');
                }

                var ids = '';
            $('.changeColor').each(function() {
                var status = $(this).attr('data-val');
                if (status == "1") {
                    var id = $(this).attr('id');
                    ids += id + ',';
                }
            });
            $('#get_color_ids').val(ids);
            filterForm();
            });



        // Slider For category pages / filter price
    if ( typeof noUiSlider === 'object' ) {
		var priceSlider  = document.getElementById('price-slider');




		noUiSlider.create(priceSlider, {
			start: [ 0, 1000 ],
			connect: true,
			step: 10,
			margin: 200,
			range: {
				'min': 0,
				'max': 1000
			},
			tooltips: true,
			format: wNumb({
		        decimals: 0,
		        prefix: '$'
		    })
		});


		// Update Price Range
		priceSlider.noUiSlider.on('update', function( values, handle ){
            var start_price = values[0];
            var end_price = values[1];
            $('#get_start_price').val(start_price);
            $('#get_end_price').val(end_price);
            console.log(start_price,end_price);
			$('#filter-price-range').text(values.join(' - '));

            filterForm();
		});
	}



    function filterForm(){

    $.ajax({
        type : "POST",
        url : "{{ route('getFilterProductAjax') }}",
        data : $('#filterForm').serialize(),
        dataType : "json",
        success: function(data){
            $("#getProductAjax").html(data.success);
        },
        error: function(xhr){

        }
    });
}

$(document).on('click', '#load-more', function() {
    let button = $(this);
    let url = button.data('url');

    $.get(url, function(response) {
        if (response.status) {
            $('#product-list').append(response.products);

            if (response.next_page > 0) {
                button.data('url', url.replace(/page=\d+/, 'page=' + response.next_page));
            } else {
                button.remove(); // no more pages
            }
        }
    });
});






    </script>



@endsection
