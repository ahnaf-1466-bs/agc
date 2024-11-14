<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('mainslider', 'mb2_shortcode_mainslider');

function mb2_shortcode_mainslider($atts, $content= null){

	$atts2 = array(
		'items' => '',
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$items = explode( ',', $items );
	return theme_mb2nl_slider( $items );

}
