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
jQuery(document).ready( function($) {
    var namespace = 's8_',// This is the namespace used for classes (e.g. class="s8_media_uploader")
        dataNamespace = 's8media-',// This is the namespace used for data attributes (e.g. data-s8media-group="some-value")
        classes = { // NOTE: The classes are automatically prefixed with the namespace!
            uploadButton: 'media_uploader', // Class of the upload/select button
            removeButton: 'media_remove', // Class of the remove button
            outputAttachmentId: 'media_id_output', // This is where the attachment ID will be placed, should be an input field class
            outputAttachmentName: 'media_filename', // This should be the class used on a tag whose contents should be the filename
            outputImageSrc: 'media_img' // This should be the class name used on the image tag
        },
        i18nStrings = { // For release, these should really be localized using the localize_scripts function
            // These are the defaults if the button doesn't define an override
            title: 'Media Selector', // The title at the top of the media uploader screen
            buttonText: 'Use Selected' // The text on the select/use button in the media uploader
        },
        currentGroup, // Internal use only
        media_frames = {}, // Internal use only
        mediaTypes = [ 'audio', 'video', 'image', 'text' ]; // Internal use only
    var s8_identifier;
    // Attach the upload/add button to our functionality
    $( '.' + namespace + classes.uploadButton ).bind( 'click', function(e) {
        e.preventDefault();
        var currentElem = $(this),
            currentFrame,
            currentType,
            currentId;
        if ( currentElem.attr('id') ) {
            currentId = $(this).attr('id');
        } else {
            currentId = namespace + 'frame_' + Object.keys(media_frames).length;
            $(this).attr('id', currentId);
        }
        if ( ! media_frames[ currentId ] ) {
            // Setup our options
            var options = {
                title: ( currentElem.data('title') || i18nStrings.title ),
                button: { text: ( currentElem.data('button') ? currentElem.data('button') : i18nStrings.buttonText ) },
                class: currentId
            };
            if ( currentElem.data('file-type') ) {
                if ( 0 <= $.inArray( currentElem.data('file-type'), mediaTypes ) ) {
                    currentType = currentElem.data('file-type');
                    options['library'] = { type: currentType };
                }
            }
            // Create media frame
            media_frames[ currentId ] = currentFrame = wp.media.frames.file_frame = wp.media( options );
            // Setup our frame listeners
            currentFrame.on( 'select', function() {
                var attachment = currentFrame.state().get('selection').first().toJSON();
                if ( 'image' == currentType ) {
                    // Have the image be visible immediately
                    $( '.' + namespace + classes.outputImageSrc + '.' + currentId ).attr( 'src', attachment.url ).css( 'display', 'block' );
                } else {
                    // Show the file name
                    $( '.' + namespace + classes.outputAttachmentName + '.' + currentId ).html( attachment.filename).css( 'display', 'block' );
                }
                // Put the attachment ID where we can save it
                $( '.' + namespace + classes.outputAttachmentId + '.' + currentId ).attr( 'value', attachment.id );
                $( '.' + namespace + classes.removeButton + '.' + currentId ).css( 'display', 'inline-block' );
            } );
        }
        // Open the modal
        media_frames[ currentId ].open();
    } );
    // Attach the remove button to our functionality
    /*$( '.s8_media_uploader_remove' ).bind( 'click', function(e) {
     e.preventDefault();
     s8_identifier = $(this).data( 'id' );
     $(this).css( 'display', 'none' );
     $( '.s8_media_uploader_output.' + s8_identifier ).css( 'display', 'none' );
     $( '.s8_media_uploader_output_id.' + s8_identifier ).attr( 'value', '' );
     } );*/
} );
