<?php

/**
 * Filters the placeholder text for post titles
 * @param string $text
 * @param WP_Post $post
 * @return string
 */
function filter_title_placeholder( $text, $post ) {
    if ( 'post' == $post->post_type ) { // replace 'post' with your custom post type!
        $text = __( 'I am placeholder text!' );
    }
    return $text;
}
add_filter( 'enter_title_here', 'filter_title_placeholder', 10, 2 );
