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


$post_type = 'post'; // Replace with your custom post type

/**
 * Allows addition, removal and rearrangement of our post type columns on our post type edit screen
 * @param array $columns
 * @return array
 */
function _manage_columns( $columns ) {
    unset( $columns['date'] );
    $columns['my_column'] = __( 'My Column' );

    return $columns;
}
add_filter( "manage_{$post_type}_posts_columns", '_manage_columns' );

/**
 * Allows control of the output content for our custom columns on the post type edit screen
 * @param string $column
 * @param int $post_id
 */
function _manage_custom_column( $column, $post_id ) {
    switch ( $column ) {
        case 'my_column':
            echo 'This is my custom column content!';
            break;
    }
}
add_action( "manage_{$post_type}_posts_custom_column", '_manage_custom_column', 10, 2 );


/**
 * Allows our custom columns to become sortable
 * @param array $columns
 * @return array
 * @since 0.8.0
 */
function _manage_sortable_columns( $columns ) {
    $columns['my_column'] = 'sort_by_me!';

    return $columns;
}
add_filter( "manage_edit-{$post_type}_sortable_columns", '_manage_sortable_columns' );
