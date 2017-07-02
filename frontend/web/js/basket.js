

(function () {
    var module = this; // сохраняем ссылку на родительский объект
    module.UBasket = function()
    {

        $.ajax({
            url: '?r=basket/content',
            dataType : "json",
            success: function (data, textStatus) { // вешаем свой обработчик на функцию success
                console.log(data);
                if(data['itog'].count==0)
                    $('#basket').html('Корзина');
                else
                    $('#basket').html('Корзина ('+data['itog'].count+')');

            }
        });
    };
    module.addToBasket=function(element){
        $.ajax({
            type : "GET",
            url:'?r=basket/add&productId='+$(element).attr('productId')+'&addCount='+$("#counter"+$(element).attr('productId')).val(),
            data: "",
            success  : function(response) {
                //---------------------------
                module.UBasket();
                console.log(response);
            },
            error : function(response){
                console.log(response);

            }
        });
    };

    module.rebindEvent=function(){
        $('.productBuy').click(function(){
            module.addToBasket(this);
            return false;
        });
    };
    $(document).on('pjax:success', function() {
        module.UBasket();
        module.rebindEvent();
    });
    module.UBasket();
    module.rebindEvent();
})();




