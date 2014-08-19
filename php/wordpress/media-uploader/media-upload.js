/**
 * This file should be enqueued on ANY admin page where you want the media uploader to appear!
 * NOTE: Also make sure wp_enqueue_media() is called on that admin page! (not needed for add/edit post/page/custom-post-type pages)
 */

/*
 * WordPress 3.5+ media custom uploader for use in meta boxes and the WP admin area in general.
 * Written by Sideways8 Interactive, LLC and David Wood
 * http://sideways8.com/
 * http://davidwood.ninja/
 */
jQuery(document).ready( function($) {
    var s8_media_file_frame,
        s8_current_item,
        s8_identifier;
    // Attach the upload/add button to our functionality
    $( '.s8_media_uploader' ).bind( 'click', function(e) {
        e.preventDefault();
        s8_current_item = $(this);
        s8_identifier = $(this).attr('id');
        // Create media frame using data elements from the clicked element
        s8_media_file_frame = wp.media.frames.file_frame = wp.media( {
            title: $(this).data('title'),
            button: { text: $(this).data('button') },
            class: s8_identifier
        } );
        // What to do when the image/file is selected
        s8_media_file_frame.on( 'select', function() {
            var attachment = s8_media_file_frame.state().get('selection').first().toJSON(),
                file_type = s8_current_item.data('upload-type');
            if ( 'image' == file_type ) {
                // Have the image be visible immediately
                $( '.s8_media_uploader_output.' + s8_identifier ).attr( 'src', attachment.url ).css( 'display', 'block' );
            } else {
                // Show the file name
                $( '.s8_media_uploader_output.' + s8_identifier ).html( attachment.filename).css( 'display', 'block' );
            }
            // Put the attachment ID where we can save it
            $( '.s8_media_uploader_output_id.' + s8_identifier ).attr( 'value', attachment.id );
            $( '.s8_media_uploader_remove.' + s8_identifier ).css( 'display', 'inline-block' );
        } );
        // Open the modal
        s8_media_file_frame.open();
    } );
    // Attach the remove button to our functionality
    $( '.s8_media_uploader_remove' ).bind( 'click', function(e) {
        e.preventDefault();
        s8_identifier = $(this).data( 'id' );
        $(this).css( 'display', 'none' );
        $( '.s8_media_uploader_output.' + s8_identifier ).css( 'display', 'none' );
        $( '.s8_media_uploader_output_id.' + s8_identifier ).attr( 'value', '' );
    } );
} );
