<?php
/**
 * Retrieve calendar events from the Stellar Events plugin.
 */

$current_time = current_time( 'timestamp' );

$start_date = gmmktime( 0, 0, 0, date( 'n', $current_time ), date( 'j', $current_time ), date( 'Y', $current_time ) ); // The start date to retrieve from
$end_date = gmmktime( 0, 0, 0, date( 'n', $current_time ) + 2, date( 'j', $current_time ), date( 'Y', $current_time ) ); // The date to retrieve to

// Retrieve our events using the same method Stellar Events uses
$events = apply_filters( 'stellar_calendar-register_events', array(), getdate( $start_date ), getdate( $end_date ), array( 'id' => false ) );
$events = stellar_events_init::register_events( $events, $start_date, $end_date );

if ( ! empty( $events ) ) {
    // We have events!
} else {
    // We do NOT have events
}
