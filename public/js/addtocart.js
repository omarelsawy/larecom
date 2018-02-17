//ajax add to cart
    /*$(".addtocart").click(function () {
        var id = $(this).val();
        $.get('/addcartajax', {id: id}
        , function(match){
            $('.ajax_cart_quantity').html(match);
        }
        );
    });*/

$(".qtyajaxplus").click(function () {
    var qty = $(this).prev(".qtyajaxres").val();
    var plus = ++qty;
    $(this).prev(".qtyajaxres").val(plus);
    var id = $(this).val();
    $.get('/increaseqty', {id: id});
    location.reload(true);
});

$(".qtyajaxminus").click(function () {
    var qty = $(this).next(".qtyajaxres").val();
    if (qty > 1){
      var minus = --qty;
      $(this).next(".qtyajaxres").val(minus);
        var id = $(this).val();
        $.get('/decreaseqty', {id: id});
        location.reload(true);
    }
});


