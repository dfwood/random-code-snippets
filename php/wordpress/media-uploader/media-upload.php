<?php
$field_id = '_s8_meta_field_name'; // Unique ID, used as the name of the value to save
$image_id = get_post_meta( get_the_ID(), $field_id, true );
$image = false;
if ( 0 < $image_id ) {
    $image = wp_get_attachment_image_src( $image_id, 'thumbnail' );
}
?>
<p>
	<label><?php _e( 'Field Label' ); ?></label><br>
	<button type="button" class="button button-secondary s8_media_uploader"
	        data-s8id="<?php echo esc_attr( $field_id ); ?>"
	        data-s8type="image" <?php // File type to filter by, can also be left out for all, audio, or video ?>
	        data-s8button="Button Text (optional)"
	        data-s8title="Library Title (optional)"
	        value="<?php esc_attr_e( 'Button Text' ); ?>"><?php _e( 'Button Text' ); ?></button>

	<button type="button" class="button button-secondary s8_media_upload_remove"
	        data-s8id="<?php echo esc_attr( $field_id ); ?>"
	        value="<?php esc_attr_e( 'Remove Image' ); ?>"><?php _e( 'Remove Image' ); ?></button>

	<input type="hidden" name="<?php echo esc_attr( $field_id ); ?>"
	       value="<?php echo esc_attr( $image_id ? $image_id : 0 ); ?>"
	       data-s8id="<?php echo esc_attr( $field_id ); ?>"
	       class="s8_media_upload_output"/>

	<img class="s8_media_upload_preview"
	     data-s8id="<?php echo esc_attr( $field_id ); ?>"
	     style="display: <?php echo $image ? 'block' : 'none'; ?>; margin: 15px 0 0; max-height: 150px; max-width: 100%; width: 150px; height: auto;"
	     src="<?php if ( $image && $image[0] ) {
		     echo $image[0];
	     } ?>"/>
</p>
