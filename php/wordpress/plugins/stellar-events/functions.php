<?php
/**
 * A collection of useful functions for use with the Stellar Events plugin
 */


/**
 * Outputs or returns the event time in a readable format.
 * @param int $post_id The post ID of the event
 * @param array $time_format A collection of arguments to format the time with, see source for valid args
 * @param bool $return Will return the date string when true, otherwise will auto echo (default)
 *
 * @return string Will return string of date when $return = true, otherwise an empty string.
 */
function s8_stlr_event_time_output( $post_id, $time_format = array(), $return = false ) {
	$format = array_merge( array(
		'month' => 'M',
		'day' => 'j',
		'year' => 'Y',
		'hour' => 'g',
		'minute' => 'i',
		'meridiem' => ' a',
		'show_time' => true,
	), $time_format );
	$show_time = (bool) $format['show_time'];
	$date_time = '';

	$start_date = get_post_meta( $post_id, '_stellar_event_startDate', true );
	$end_date = get_post_meta( $post_id, '_stellar_event_endDate', true );

	if ( empty( $end_date ) && ! empty( $start_date ) ) {
		$end_date = $start_date;
	} elseif ( empty( $start_date ) && ! empty( $end_date ) ) {
		$start_date = $end_date;
	}

	if ( ! empty( $start_date ) && ! empty( $end_date ) ) {
		$start_time = strtotime( $start_date );
		$end_time = strtotime( $end_date );

		$same_year = ( date( 'Y', $start_time ) == date( 'Y', $end_time ) );
		$same_month = ( $same_year && date( 'm', $start_time ) == date( 'm', $end_time ) );
		$same_day = ( $same_month && date( 'd', $start_time ) == date( 'd', $end_time ) );

		$same_hour = ( date( 'H', $start_time ) == date( 'H', $end_time ) );
		$same_minute = ( date( 'i', $start_time ) == date( 'i', $end_time ) );
		$same_am = ( date( 'a', $start_time ) == date( 'a', $end_time ) );
		$same_time = ( $same_hour && $same_minute && $same_am );

		$date_time .= date( $format['month'] . ' ' . $format['day'], $start_time );
		if ( ! $same_year || $same_day ) {
			$date_time .= ', ' . date( $format['year'], $start_time );
		}
		if ( ! $same_time && $show_time ) {
			$date_time .= ', ' . date( $format['hour'] . ':' . $format['minute'] . $format['meridiem'], $start_time );
			if ( $same_day ) {
				$date_time .= ' - ' . date( $format['hour'] . ':' . $format['minute'] . $format['meridiem'], $end_time );
			}
		}

		if ( ! $same_month || ! $same_day ) {
			$date_time .= ' - ' . date( $format['month'] . ' ' . $format['day'], $end_time );
			if ( ! $same_year ) {
				$date_time .= ', ' . date( $format['year'], $end_time );
			}
		}
		if ( ! $same_day && ! $same_time && $show_time ) {
			$date_time .= ', ' . date( $format['hour'] . ':' . $format['minute'] . $format['meridiem'], $end_time );
		}

		if ( $same_year ) {
			$date_time .= ', ' . date( $format['year'], $start_time );
		}

		if ( $same_time && $show_time ) {
			$date_time .= ', ' . date( $format['hour'] . ':' . $format['minute'] . $format['meridiem'], $start_time );
		}

	}
	if ( ! $return ) {
		echo $date_time;
		return '';
	} else {
		return $date_time;
	}
}
