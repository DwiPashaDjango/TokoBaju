@extends('layouts.user.app')

@section('content')
<!-- Shopping Cart -->
<div class="shopping-cart section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<!-- Shopping Summery -->
				<table class="table shopping-summery">
					<thead>
						<tr class="main-hading">
							<th>PRODUCT</th>
							<th class="text-center">Harga Satuan</th>
							<th class="text-center">Qty</th>
							<th class="text-center">Total</th>
							<th class="text-center"><i class="ti-trash remove-icon"></i></th>
						</tr>
					</thead>
					<tbody id="cekOut">

					</tbody>
				</table>
				<!--/ End Shopping Summery -->
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<!-- Total Amount -->
				<div class="total-amount">
					<div class="row">
						<div class="col-lg-8 col-md-5 col-12">
							{{-- <div class="left">
									<div class="coupon">
										<form action="#" target="_blank">
											<input name="Coupon" placeholder="Enter Your Coupon">
											<button class="btn">Apply</button>
										</form>
									</div>
									<div class="checkbox">
										<label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox"> Shipping (+10$)</label>
									</div>
								</div> --}}
						</div>
						<div class="col-lg-4 col-md-7 col-12">
							<div class="right">
								<ul>
									<div id="jumlah">

									</div>
								</ul>
								<div class="button5">
									<button id="checkPay" data-id="{{Auth::guard('costumer')->user()->id}}" class="btn">Checkout</button>
									<a href="/" class="btn">Continue shopping</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--/ End Total Amount -->
			</div>
		</div>
	</div>
</div>
<!--/ End Shopping Cart -->

@endsection

@push('js')
<script src="{{asset('js/shop.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/bootstrap-notify.min.js')}}"></script>
<script>
	$(document).ready(function() {
		getChekout();

		function getChekout() {
			$.ajax({
				url: '/user/checkout/json',
				method: 'GET',
				success: function(response) {
					let cekOut = '';
					if (response.length != 0) {
						$.each(response.data, function(key, val) {
							if (val.qty_carts > 1) {
								cekOut += `<tr>
											<td class="product-des" data-title="Description">
												<p class="product-name"><a href="#">${val.produk.nm_produk}</a></p>
											</td>
											<td class="price" data-title="Price"><span>Rp.${val.produk.harga_produk}</span></td>
											<td class="qty" data-title="Qty"><!-- Input Order -->
												<div class="input-group">
													<div class="button minus">
														<button type="button" id="minus" data-id="${val.id}" class="btn btn-primary btn-number" data-type="minus" data-field="qty_carts">
															<i class="ti-minus"></i>
														</button>
													</div>
													<input type="text" id="qty_carts" class="input-number" value="${val.qty_carts}">
													<div class="button plus">
														<button type="button" id="plus" data-id="${val.id}" class="btn btn-primary btn-number" data-type="plus" data-field="qty_carts">
															<i class="ti-plus"></i>
														</button>
													</div>
												</div>
												<!--/ End Input Order -->
											</td>
											<td class="total-amount" data-title="Total"><span>Rp.${val.grand_total_carts}</span></td>
											<td class="action" data-title="Remove"><a href="#"><i class="ti-trash remove-icon"></i></a></td>
										</tr>`;
							} else {
								cekOut += `<tr>
											<td class="product-des" data-title="Description">
												<p class="product-name"><a href="#">${val.produk.nm_produk}</a></p>
											</td>
											<td class="price" data-title="Price"><span>Rp.${val.produk.harga_produk}</span></td>
											<td class="qty" data-title="Qty"><!-- Input Order -->
												<div class="input-group">
													<div class="button minus">
														<button type="button" id="minus" data-id="${val.id}" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="qty_carts">
															<i class="ti-minus"></i>
														</button>
													</div>
													<input type="text" id="qty_carts" class="input-number" value="${val.qty_carts}">
													<div class="button plus">
														<button type="button" id="plus" data-id="${val.id}" class="btn btn-primary btn-number" data-type="plus" data-field="qty_carts">
															<i class="ti-plus"></i>
														</button>
													</div>
												</div>
												<!--/ End Input Order -->
											</td>
											<td class="total-amount" data-title="Total"><span>Rp.${val.grand_total_carts}</span></td>
											<td class="action" data-title="Remove"><a href="javascript:void(0)" id="deleteCart" data-id="${val.id}"><i class="ti-trash remove-icon"></i></a></td>
										</tr>`;
							}
						});
						$('#cekOut').html(cekOut);
					} else {
						cekOut += '<tr><td colspan="5" class="text-center">Tidak Ada Produk Di Keranjang</td</tr>';
						$('#cekOut').html(cekOut);
					}
				},
				error: function(err) {
					console.log(err);
				}
			})
		}

		get_sum_carts();

		function get_sum_carts() {
			$.ajax({
				url: '/user/checkout/sum/json',
				method: 'GET',
				success: function(response) {
					let jumlah = '';
					if (response.length != 0) {
						jumlah += ` <li>Total<span>Rp.${response.data.jumlah_awal}</span></li>
										<li>Ongkir<span>${response.data.ongkir}</span></li>
										<li>Diskon<span>Rp.${response.data.diskon}</span></li>
										<li class="last">Total Pembayaran<span>Rp.${response.data.jumlah_akhir}</span></li>`;
						$('#jumlah').html(jumlah);
					} else {
						jumlah += `<li class="last text-center">Tidak Ada Pembayaran</span></li>`;
						$('#jumlah').html(jumlah);
					}
				},
				error: function(err) {
					console.log(err);
				}
			});
		}

		$(document).on('click', '#plus', function(e) {
			e.preventDefault();
			let id = $(this).data('id');
			let qty_carts = $('#qty_carts').val();
			$.ajax({
				url: '/user/checkout/json/plus/' + id,
				method: 'PUT',
				data: {
					qty_carts: qty_carts
				},
				success: function(response) {
					getChekout();
					get_sum_carts();
				},
				error: function(err) {
					console.log(err);
				}
			});
		});

		$(document).on('click', '#minus', function(e) {
			e.preventDefault();
			let id = $(this).data('id');
			let qty_carts = $('#qty_carts').val();
			$.ajax({
				url: '/user/checkout/json/minus/' + id,
				method: 'PUT',
				data: {
					qty_carts: qty_carts
				},
				success: function(response) {
					getChekout();
					get_sum_carts();
				},
				error: function(err) {
					console.log(err);
				}
			});
		});

		$(document).on('click', '#deleteCart', function(e) {
			e.preventDefault();
			let id = $(this).data('id');
			alert(id)
		});

		$('#checkPay').click(function(e) {
			e.preventDefault();
			let id = $(this).data('id');
			$.ajax({
				url: '/user/checkout/pay/' + id,
				type: 'GET',
				success: function(response) {
					console.log(response.data[0].customer.id);
					window.location.href = '/user/checkout/check/pay/' + response.data[0].customer.id;
				},
				error: function(err) {
					console.log(err);
				}
			})
		});
	});
</script>
@endpush