jQuery(function ($) {

    $('body').on('submit', '#itz-newsletter', function (e) {
        e.preventDefault();
        var name = jQuery('.itz-input.name').val();
        var email = jQuery('.itz-input.email').val();
        var isValid = valiadteItzForm(name, email);
        if (isValid) {
            submitItzForm(name, email); // submit form
        }
    });

    $('body').on('click', '.itz-close', function () {
        $('.itz-modal-backdrop').removeClass('show');
    });

    if ($('.itz-modal-wrap').length > 0) {
        setTimeout(function () {
            $('.itz-modal-backdrop').addClass('show');
        }, 1000);
    }

});

// Validate form fields
function valiadteItzForm(name, email) {

    jQuery('.itz-form-error').text('');

    // if name or email is empty form not be validated
    if (name == '' || email == '') {
        jQuery('.itz-form-error').text('Please fill the required info');
        return false;
    }

    // Validate is email
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if( ! regex.test(email) ){
        jQuery('.itz-form-error').text('Invalid email');
        return false
    }

    return true;

}

function submitItzForm(name, email) {

    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: itz_ajax_object.ajax_url,
        data: {
            action: "itz_newsletter",
            nonce: itz_ajax_object.nonce,
            name: name,
            email: email,
        },
        success: function (response) {
            if (response.success) {
                var now = new Date();
                var time = now.getTime();
                var expireTime = time + 1000*36000;
                now.setTime(expireTime);
                document.cookie = 'itz_subscribed=true;expires='+now.toUTCString()+';path=/';
                jQuery('.itz-modal-backdrop').remove();
            }
        }
    });

}