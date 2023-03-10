<!-- Modal -->
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
						</div>
						<div class="modal-body">
							<div class="row no-gutters mt-3">
								<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
									<!-- Product Slider -->
										<div class="product-gallery">
											<div class="quickview-slider-active">
												<div class="single-slider" id="single-slider">
													<div id="image">

													</div>
												</div>
											</div>
										</div>
									<!-- End Product slider -->
								</div>
								<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
									<div class="quickview-content mt-3">
										<h2 id="judul"></h2>
										<div class="quickview-ratting-review">
											<div class="quickview-ratting-wrap">
												<div class="quickview-ratting">
													<i class="yellow fa fa-star"></i>
													<i class="yellow fa fa-star"></i>
													<i class="yellow fa fa-star"></i>
													<i class="yellow fa fa-star"></i>
													<i class="fa fa-star"></i>
												</div>
												<a href="#"></a>
											</div>
											<div class="quickview-stock">
												<span id="inStock"></span>
											</div>
										</div>
										<h3 id="harga"></h3>
										{{-- <div class="quickview-peragraph">
											<p id="isiProduk"></p>
										</div> --}}
										<div class="size mt-5">
											<div class="row">
												<div class="col-lg-12 col-12">
													<h5 class="title">Size</h5>
													<select id="ukuran">
														<option selected="selected">s</option>
														<option value="m">m</option>
														<option value="l">l</option>
														<option value="xl">xl</option>
													</select>
												</div>
											</div>
										</div>
										<div class="quantity">
											<!-- Input Order -->
											<div class="input-group">
												<div class="button minus">
													<button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="qty_carts">
														<i class="ti-minus"></i>
													</button>
												</div>
												<input type="hidden" id="products_id">
												<input type="text" name="qty_carts" id="qty_carts" class="input-number"  data-min="0" data-max="1000" value="0">
												<div class="button plus">
													<button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="qty_carts">
														<i class="ti-plus"></i>
													</button>
												</div>
											</div>
											<!--/ End Input Order -->
										</div>
										<div class="add-to-cart mt-5">
											<a href="javascript:void(0)" class="btn" id="cart_btn">Keranjang</a>
											<a href="#" class="btn min"><i class="fa fa-compress"></i></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Modal end -->
		
		<!-- Start Footer Area -->
		<footer class="footer">
			<div class="copyright">
				<div class="container">
					<div class="inner">
						<div class="row">
							<div class="col-lg-6 col-12">
								<div class="left">
									<p>Copyright © 2020 <a href="http://www.wpthemesgrid.com" target="_blank">Wpthemesgrid</a>  -  All Rights Reserved.</p>
								</div>
							</div>
							<div class="col-lg-6 col-12">
								<div class="right">
									<img src="{{asset('user/')}}/images/payments.png" alt="#">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!-- /End Footer Area -->
	
	
    <!-- Jquery -->
  <script src="{{asset('user/')}}/js/jquery.min.js"></script>
  <script src="{{asset('user/')}}/js/jquery-migrate-3.0.0.js"></script>
	<script src="{{asset('user/')}}/js/jquery-ui.min.js"></script>
	<!-- Popper JS -->
	<script src="{{asset('user/')}}/js/popper.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="{{asset('user/')}}/js/bootstrap.min.js"></script>
	<!-- Color JS -->
	<script src="{{asset('user/')}}/js/colors.js"></script>
	<!-- Slicknav JS -->
	<script src="{{asset('user/')}}/js/slicknav.min.js"></script>
	<!-- Owl Carousel JS -->
	<script src="{{asset('user/')}}/js/owl-carousel.js"></script>
	<!-- Magnific Popup JS -->
	<script src="{{asset('user/')}}/js/magnific-popup.js"></script>
	<!-- Fancybox JS -->
	<script src="{{asset('user/')}}/js/facnybox.min.js"></script>
	<!-- Waypoints JS -->
	<script src="{{asset('user/')}}/js/waypoints.min.js"></script>
	<!-- Countdown JS -->
	<script src="{{asset('user/')}}/js/finalcountdown.min.js"></script>
	<!-- Nice Select JS -->
	<script src="{{asset('user/')}}/js/nicesellect.js"></script>
	<!-- Ytplayer JS -->
	<script src="{{asset('user/')}}/js/ytplayer.min.js"></script>
	<!-- Flex Slider JS -->
	<script src="{{asset('user/')}}/js/flex-slider.js"></script>
	<!-- ScrollUp JS -->
	<script src="{{asset('user/')}}/js/scrollup.js"></script>
	<!-- Onepage Nav JS -->
	<script src="{{asset('user/')}}/js/onepage-nav.min.js"></script>
	<!-- Easing JS -->
	<script src="{{asset('user/')}}/js/easing.js"></script>
	<!-- Active JS -->
	<script src="{{asset('user/')}}/js/active.js"></script>
	<script src="{{asset('js/shop.js')}}"></script>
	@stack('js')
</body>
</html>