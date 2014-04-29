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
 */
function _manage_sortable_columns( $columns ) {
    $columns['my_column'] = 'sort_by_me!';

    return $columns;
}
add_filter( "manage_edit-{$post_type}_sortable_columns", '_manage_sortable_columns' );


/**
 * Allows customization of post updated messages for specific post types
 * @param $messages
 * @return mixed
 */
function _filter_post_type_updated_messages( $messages ) {
    global $post, $post_ID;

    $messages['book_cpt'] = array(
        0 => '', // Unused, messages start with index 1
        1 => sprintf( __( 'Book updated. <a href="%s">View book</a>' ), esc_url( get_permalink( $post_ID ) ) ),
        2 => __( 'Custom field updated.' ),
        3 => __( 'Custom field deleted.' ),
        4 => __( 'Book updated.' ),
        /* translators: %s: date and time of the revision */
        5 => isset( $_GET['revision'] ) ? sprintf( __( 'Book restored to revision from %s' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6 => sprintf( __( 'Book published. <a href="%s">View book</a>' ), esc_url( get_permalink( $post_ID ) ) ),
        7 => __( 'Book saved.' ),
        8 => sprintf( __( 'Book submitted. <a target="_blank" href="%s">Preview book</a>' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
        9 => sprintf( __( 'Book scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview book</a>' ),
            // translators: Publish box date format, see http://php.net/date
            date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
        10 => sprintf( __( 'Book draft updated. <a target="_blank" href="%s">Preview book</a>' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
    );

    return $messages;
}
add_filter( 'post_updated_messages', '_filter_post_type_updated_messages' );
