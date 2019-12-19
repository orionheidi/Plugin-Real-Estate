jQuery(document).ready(function ($) {

    $('.js-form-edit-real-estate').on('submit', function (e) {
        e.preventDefault(e);

        var post_title = $('#post_title').val();
        var subtitle = $('#subtitle').val();
        var post_id = $(this).data('id');
        var $images = $('.acf-field-gallery input');

        var images = [];

        $.each($images, function (index, value) {
            var imageID = parseInt($(value).val());

            if (imageID > 0) {
                images.push(imageID);
            }
        });

        var location = $('.js-location-select').val();

        var $slidesX = $('.acf-field-repeater input');

        var slidesX = [];


        $.each($slidesX, function (index, value) {
            var slidesXID = $(value).val();

            if (slidesXID) {
                slidesX.push({'text': slidesXID});
            }

        });

        console.log(slidesX);

        $.ajax({
            url: ajax_params.ajaxurl, // this is the object instantiated in wp_localize_script function
            // nonce: ajax_params.nonce,
            type: 'POST',
            data: {
                action: 'edit_ajax_request', // this is the function in your functions.php that will be triggered
                'x_nonce': ajax_params.x_nonce,
                'post_title': post_title,
                'subtitle': subtitle,
                'post_id': post_id,
                'gallery': images,
                'location': location,
                'slides': slidesX
            },
            success: function (data) {
                //Do something with the result from server
                console.log(data);
                document.location.reload(true);
                console.log('ulazi u ok');
            },
            error: function (errorThrown) {
                console.log(errorThrown);
                console.log('error je tu');
            }
        });
    });
});

