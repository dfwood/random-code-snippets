<?php

/**
 * Enqueues our script and adds our localized JS object for access in JS
 * to the ajaxUrl, our nonce, and any other value we need to pass.
 */
function _enqueue_scripts() {
    wp_enqueue_script( 'YOUR_HANDLE', 'path/to/ajax.js', array( 'jquery' ) );
    wp_localize_script( 'YOUR_HANDLE', 'myObject', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'myCustomAction' . dirname( __FILE__ ) ),
        'myCustomVariable' => 'My custom value I need on the frontend!',
    ) );
}
add_action( 'wp_enqueue_scripts', '_enqueue_scripts' );


$ajax_action = 'my_action';


function _frontend_ajax_action() {
    $response = array(
        'status' => 'failure',
        'message' => __( 'Invalid request!' ),
    );
    if ( ! empty( $_POST['nonce'] ) ) {
        $request = $_POST['nonce'];
        $response['message'] = __( 'Invalid nonce!' );
        if ( ! empty( $request['nonce'] ) && wp_verify_nonce( $request['nonce'], 'myCustomAction' . dirname( __FILE__ ) ) ) {
            $response['status'] = 'success';
            // Do data stuff here as needed!
            $response['message'] = 'Our response!';
        }
    }
    // Return (output) our response
    echo json_encode( $response );
    die(); // This closes out our ajax request
}
// This line allows logged in uses to use ajax
add_action( "wp_ajax_{$ajax_action}", '_frontend_ajax_action' );
// This line allows non-logged in users to use ajax
add_action( "wp_ajax_nopriv_{$ajax_action}", '_frontend_ajax_action' );
