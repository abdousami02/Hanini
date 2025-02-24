
jQuery(function($){

    $(".product-status-change").on('click', function (e) {
        // e.preventDefault();
        // var token = $('meta[name="csrf-token"]').attr('content');
        var url = $('meta[name="main-url"]').attr('content');
        var value = $(this).val().split('/');

        // var user_type = $('meta[name="get-me"]').attr('content');
        // if (user_type !== 'seller') {
        //     user_type = 'admin';
        // }
        // var url = url + '/' + user_type + '/' + value[0];

        var url = url + '/' + value[0];
        var status = $(this).is(':checked') ? 1 : 0;
    
        var formData = {
            id: value[1],
            status,
            change_for: value[2],
        }

        $.post(url, formData).done(function(response){
            // if(response.statsuccess){
            //     let table = document.querySelector('#media-files-table')
            //     table.innerHTML = response.content_html;
            // }
            toastr[response.status](response.message)
        }).fail(function(e){
            toastr.error(e);
            // toastr['error'](response.message)
        })
    
        // $.ajax({
        //     type: 'POST',
        //     dataType: 'json',
        //     data: {
        //         data: formData,
        //         _token: token,
        //         _method: 'put'
        //     },
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     url: url,
        //     success: function (response) {
        //         toastr[response.status](response.message)
        //         // location.reload();
        //     },
        //     error: function (response) {
        //         toastr['error'](response.message)
        //     }
        // })
    
    });

    $(".product-set-day").on('click', function (e) {
        // console.log(this);
        let currenct = this
        $(".product-set-day").each(function(elem){
            if(currenct != this){
                console.log(this);
                this.checked = false;
            }
        })
        var url = $('meta[name="main-url"]').attr('content');
        var value = $(this).val().split('/');

        var url = url + '/' + value[0];
        var status = $(this).is(':checked') ? 1 : 0;
    
        var formData = {
            id: value[1],
            status,
            change_for: value[2],
        }

        $.post(url, formData).done(function(response){
            if(response.success){
                toastr.success(response.success)
            }else{
                toastr.error(response.error)
            }
        }).fail(function(e){
            toastr.error(e);
        })
    });
})

$(".onChangeFormSubmit").on("change", function () {
    console.log($(this).parents('form'));
    $(this).parents('form').submit();
    // $("#onChangeFormSubmit").submit();
});
