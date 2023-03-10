$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    get_carts();
    countCart();

    $(document).on("click", "#btnShop", function (e) {
        e.preventDefault();
        let id = $(this).data("id");
        $.ajax({
            url: "/user/get/produk/" + id,
            method: "GET",
            success: function (response) {
                console.log(response);
                $("#exampleModal").modal("show");
                $("#judul").text(response.data.nm_produk);
                $("#inStock").text("Stock : " + response.data.stock_produk);
                $("#products_id").val(response.data.id);
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    $(document).on("click", "#cart_btn", function (e) {
        e.preventDefault();
        let products_id = $("#products_id").val();
        let qty_carts = $("#qty_carts").val();
        let ukuran = $("#ukuran").val();

        $.ajax({
            url: "/user/create/cart",
            method: "POST",
            data: {
                products_id: products_id,
                qty_carts: qty_carts,
                ukuran: ukuran,
            },
            success: function (response) {
                if (response.errors) {
                    $.notify(
                        {
                            message: response.errors,
                            icon: "fa fa-xmark",
                        },
                        {
                            type: "danger",
                        }
                    );
                    $("#exampleModal").modal("hide");
                } else {
                    $("#exampleModal").modal("hide");
                    countCart();
                    get_carts();
                }
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    function get_carts() {
        $.ajax({
            url: "/user/cart/json",
            method: "GET",
            success: function (response) {
                let navCart = "";
                $.each(response.data.data, function (key, val) {
                    navCart += `<li>
                                    <a href="javascript:void(0)" data-id="${val.id}" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
                                    <a class="cart-img" href="#"><img src="storage/produk/${val.produk.image_produk}" alt="#"></a>
                                    <h4><a href="#">${val.produk.nm_produk}</a></h4>
                                    <p class="quantity">${val.qty_carts} x - <span class="amount">Rp.${val.produk.harga_produk}</span></p>
                                </li>`;
                });
                $(".shopping-list").html(navCart);
            },
            error: function (err) {
                console.log(err);
            },
        });
    }

    function countCart() {
        $.ajax({
            url: "/user/cart/count/json",
            method: "GET",
            success: function (response) {
                console.log(response);
                $("#viewCart").text(response.data + " Produk");
                $(".total-count").text(response.data);
            },
            error: function (err) {
                console.log(err);
            },
        });
    }
});
