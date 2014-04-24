<?php
$field_id = '_id_name';
$image_id = 0; // Switch this out with the value (or source) of your stored image id
$image = false;
if ( 0 < $image_id ) {
    $image = wp_get_attachment_image_src( $image_id, 'thumbnail' );
}
?>
<p>
    <button type="button" class="button button-secondary s8_media_uploader"
            id="<?php echo $field_id; ?>" data-title="<?php _e( 'Select an image' ); ?>" data-button="<?php _e( 'Use image' ); ?>" data-upload-type="image"
            value="<?php _e( 'Select Image' ); ?>"><?php _e( 'Select Image' ); ?></button>
    <button type="button" class="button button-secondary s8_media_uploader_remove <?php echo $field_id; ?>"
            style="display: <?php echo $image ? 'inline-block' : 'none'; ?>;"
            data-id="<?php echo $field_id; ?>"
            value="<?php _e( 'Remove Image' ); ?>"><?php _e( 'Remove Image' ); ?></button><br />
    <input type="hidden" name="<?php echo $field_id; ?>_image_id" value="<?php echo $image ? $image_id : ''; ?>"
           class="s8_media_uploader_output_id <?php echo $field_id; ?>" />
    <img class="s8_media_uploader_output <?php echo $field_id; ?>" style="display: <?php echo $image ? 'block' : 'none'; ?>; margin: 15px 0 0;"
         src="<?php if ( $image && $image[0] ) echo $image[0]; ?>" />
</p>
