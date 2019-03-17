$(document).ready(function() {
    $('body').on('click','a.chngst',function(e){
        e.preventDefault();
        var status = 0;
        var reg_number = 0;
        if($(this).hasClass('need_status_10')){
            status = 10;
            reg_number = $(this).attr('reg_number');
            var promt = prompt('Регистрационный номер на сайте: www.faberlic.com', reg_number);

            if(!promt){
                return null;
            }
        }

        if($(this).hasClass('need_status_1')){
            status = 1;
            var conf = confirm("Вы уверены что хотите отклонить заявку данного пользователя?");
            if(!conf){
                return null;
            }
        }
        if($(this).hasClass('delete')){
            status = -1;
            var conf = confirm("Вы уверены что хотите удалить данного пользователя?");
            if(!conf){
                return null;
            }

        }

        var id = $(this).attr('href');
        var obj = $(this);

        $.ajax({
            url: '/user/change-status',
            type: 'post',
            data: {
                'status': status,
                'id': id,
                'reg_number': promt
            },
            success: function (result) {
                if (result === 'success') {
                    $.pjax.reload({container:"#applications"});
                } else {
                    alert('error change status');
                }
            }
        });

    });

});