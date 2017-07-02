(function (){
    var module = this;
    module.refreashBasketView=function(element){
        $.ajax({
            type : "GET",
            url:'?r=basket/delete&productId='+$(element).attr('productId'),
            data: "",
            success  : function(response) {
                console.log(response);
                $.pjax.reload({url: '?r=basket',container: '#basket_list'});
                var thisMethod=this;
            },
            error : function(response){
                console.log(response);

            }
        });
    };
    module.changeCount=function(element){
        $.ajax({
            type : "GET",
            url:'?r=basket/update&productId='+$(element).attr('productId')+'&act='+$(element).attr('act'),
            data: "",
            success  : function(response) {
                $.pjax.reload({url: '?r=basket',container: '#basket_list',cache: false});


                console.log(response);
            },
            error : function(response){
                console.log(response);

            }
        });
    };
    $(document).on('pjax:success', function() {
        module.init();
    });
    module.init=function(){
        $('.productDel').click(function(){
            module.refreashBasketView(this);
            return false;
        });
        $('.countPlus').click(function(){
            module.changeCount(this);
            return false;
        });
        $('.countMinus').click(function(){
            module.changeCount(this);
            return false;
        });
    };

    module.init();
})();

