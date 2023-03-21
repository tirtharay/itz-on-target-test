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

});

// Validate form fields 
function valiadteItzForm(name, email) {

    // if name or email is empty form not be validated
    if (name == '' || email == '') {
        return false;
    }

    // Validate is email
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);

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
            alert("Your vote could not be added");
            alert(response);
        }
    });

}