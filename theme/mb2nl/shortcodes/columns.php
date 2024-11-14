<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode( 'columns', 'mb2_shortcode_columns' );

function mb2_shortcode_columns ( $atts, $content = null ){

	extract( mb2_shortcode_atts( array(), $atts ) );
	$output = '';
	$output .= '<div class="row theme-cols">';
	$output .= mb2_do_shortcode( $content );
	$output .= '</div>';
	return $output;

}
