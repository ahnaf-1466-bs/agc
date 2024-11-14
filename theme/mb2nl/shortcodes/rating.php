<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode( 'ratingblock', 'mb2_shortcode_ratingblock' );

function mb2_shortcode_ratingblock( $atts, $content = null ){

	global $CFG;

	extract( mb2_shortcode_atts( array(), $atts ) );

	if ( theme_mb2nl_is_review_plugin() )
	{
		if ( ! class_exists( 'Mb2reviewsHelper' ) )
		{
			require_once( $CFG->dirroot . '/local/mb2reviews/classes/helper.php' );
		}

		return Mb2reviewsHelper::rating_block('none');
	}

	return get_string('nothingtodisplay');

}
