/**
 * This file should be enqueued on ANY admin page where you want the media uploader to appear!
 * NOTE: Also make sure wp_enqueue_media() is called on that admin page! (not needed for add/edit post/page/custom-post-type pages)
 */

/*!
 * WordPress 3.5+ media custom uploader for use in meta boxes and the WP admin area in general.
 * Written by Sideways8 Interactive, LLC and David Wood
 * http://sideways8.com/
 * http://davidwood.ninja/
 */

jQuery(document).ready(function($) {
    var s8MediaLib = {
        buttonText: 'Use File',
        outputClass: '.s8_media_upload_preview',
        outputIdClass: '.s8_media_upload_output',
        removeButtonClass: '.s8_media_upload_remove',
        uploadButtonClass: '.s8_media_uploader',
        uploadTitle: 'Select File'
    };
    var s8MediaUploadFrame = {};

    $(s8MediaLib.uploadButtonClass).bind('click', function(e) {
        e.preventDefault();
        var s8CurrentItem = $(this);
        var s8ID = s8CurrentItem.attr('data-s8id');

        if ( ! s8MediaUploadFrame[s8ID] ) {
            var mediaArgs = {
                class: s8ID,
                button: {
                    text: s8CurrentItem.attr('data-s8button') ? s8CurrentItem.attr('data-s8button') : s8MediaLib.buttonText
                },
                title: s8CurrentItem.attr('data-s8title') ? s8CurrentItem.attr('data-s8title') : s8MediaLib.uploadTitle
            };

            if ( s8CurrentItem.attr('data-s8type') ) {
                mediaArgs['type'] = s8CurrentItem.attr('data-s8type');
            }

            s8MediaUploadFrame[s8ID] = wp.media.frames.file_frame = wp.media(mediaArgs);
            s8MediaUploadFrame[s8ID].on('select', function() {
                var attachment = s8MediaUploadFrame[s8ID].state().get('selection').first().toJSON();
                var fileType = s8CurrentItem.data('s8type') ? s8CurrentItem.data('s8type') : 'image';
                if ( 'image' == fileType ) {
                    // Output image preview
                    $(s8MediaLib.outputClass + '[data-s8id="' + s8ID + '"]').attr('src', attachment.url).show();
                } else {
                    // Show the file name
                    $(s8MediaLib.outputClass + '[data-s8id="' + s8ID + '"]').html(attachment.filename).show();
                }
                // Output attachment ID and enable remove button
                $(s8MediaLib.outputIdClass + '[data-s8id="' + s8ID + '"]').attr('value', attachment.id);
                $(s8MediaLib.removeButtonClass + '[data-s8id="' + s8ID + '"]').removeAttr('disabled');
            });
        }
        s8MediaUploadFrame[s8ID].open();
    });

    // Handle removing of uploaded item from option
    $(s8MediaLib.removeButtonClass).bind('click', function(e) {
        e.preventDefault();
        var s8ID = $(this).attr('data-s8id');
        $(this).attr('disabled', 'disabled');
        $(s8MediaLib.outputClass + '[data-s8id="' + s8ID + '"]').hide();
        $(s8MediaLib.outputIdClass + '[data-s8id="' + s8ID + '"]').attr('value', '');
    });
});
