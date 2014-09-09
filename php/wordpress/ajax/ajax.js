jQuery(document).ready(function ($) {
    var data = {
        action: 'my_action',
        nonce: myObject.nonce
    };

    $.post(myObject.ajaxUrl, data, function(response) {
        // Do something with our response!
    });
});
