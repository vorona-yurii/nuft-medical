$(document).ready(function() {
    $('body').on('click','a.success-order',function(e){
        e.preventDefault();

        var conf = confirm("Заказ готов?");
        if(conf) {
            var id = $(this).attr('href');
            $.ajax({
                url: 'orders/success-order',
                type: 'post',
                data: {
                    'id': id
                },
                success: function (result) {
                    alert('Вы уведомили пользователя о готовности заказа!');
                    location.reload();
                }
            });
        }

    });

});