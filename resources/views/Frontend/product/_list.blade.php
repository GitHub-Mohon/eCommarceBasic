                        <div class="products mb-3">
                                <div class="row justify-content-center">
                                    @foreach ($getProduct as $productValue)

                                    @php
                                    // $getProductImage = App\Models\ProductImage::getImage($productValue->id);

                                    $getProductImage = $productValue->getImage($productValue->id);
                                    @endphp

                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="product product-7 text-center">
                                            <figure class="product-media">
                                                <span class="product-label label-new">New</span>
                                                @if (!empty($getProductImage))
                                                    <a href="{{url($productValue->slug ?? 'no-slug')}}">
                                                    <img src="{{ url('productGallery/' . ($getProductImage->image_name ?? 'no-image.png')) }}"  alt="{{$productValue->name}}" class="product-image">
                                                </a>
                                                @endif

                                                {{-- @if (!empty($productValue->hero_image))

                                                    <a href="product.html">
                                                    <img src="{{url('')}}/productHeroImages/{{$productValue->hero_image}}" alt="Product image" class="product-image">
                                                </a>
                                                @endif --}}

                                                <div class="product-action-vertical">
                                                    <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                                                    <a href="popup/quickView.html" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
                                                    <a href="#" class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a>
                                                </div><!-- End .product-action-vertical -->

                                                <div class="product-action">
                                                    <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                                </div><!-- End .product-action -->
                                            </figure><!-- End .product-media -->

                                            <div class="product-body">
                                                <div class="product-cat">
                                                    <a href="{{ url($productValue->category_slug.'/'.$productValue->sub_category_slug)}}">{{$productValue->sub_category_name}}</a>
                                                </div><!-- End .product-cat -->
                                                <h3 class="product-title"><a href="{{url($productValue->slug)}}">{{$productValue->name}}</a></h3><!-- End .product-title -->
                                                <div class="product-price">
                                                    {{'$'.number_format($productValue->price,2)}}
                                                </div><!-- End .product-price -->
                                                <div class="ratings-container">
                                                    <div class="ratings">
                                                        <div class="ratings-val" style="width: 20%;"></div><!-- End .ratings-val -->
                                                    </div><!-- End .ratings -->
                                                    <span class="ratings-text">( 2 Reviews )</span>
                                                </div><!-- End .rating-container -->

                                                <div class="product-nav product-nav-thumbs">
                                                    <a href="#" class="active">
                                                        <img src="{{url('')}}/assets/images/products/product-4-thumb.jpg" alt="product desc">
                                                    </a>
                                                    <a href="#">
                                                        <img src="{{url('')}}/assets/images/products/product-4-2-thumb.jpg" alt="product desc">
                                                    </a>

                                                    <a href="#">
                                                        <img src="{{url('')}}/assets/images/products/product-4-3-thumb.jpg" alt="product desc">
                                                    </a>
                                                </div><!-- End .product-nav -->
                                            </div><!-- End .product-body -->
                                        </div><!-- End .product -->
                                    </div><!-- End .col-sm-6 col-lg-4 -->

                                    @endforeach
                                </div><!-- End .row -->
                        </div><!-- End .products -->
                        <nav aria-level="Page navigation">
                            {{-- <div class="justify-content-center">
                                {!! $getProduct->appends(request()->except('page'))->links() !!}
                            </div> --}}
                        </nav>
