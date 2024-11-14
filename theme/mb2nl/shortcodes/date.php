<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'date', 'mb2_shortcode_date' );
mb2_add_shortcode( 'year', 'mb2_shortcode_year' );

function mb2_shortcode_date( $atts, $content = null ){
	global $OUTPUT;

	$atts2 = array(
		'textbefore' => '&copy; 2017 - ',
		'textafter' => ' New Learning Theme. All rights reserved.',
		'mt' => 0,
		'mb' => 30,
		'sizerem' => 1,
		'color' => '',
		'custom_class' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$elstyle = '';
	$cls = '';

	$elstyle .= ' style="';
	$elstyle .= 'margin-top:' .  $mt . 'px;';
	$elstyle .= 'margin-bottom:' .  $mb . 'px;';
	$elstyle .= $color ? 'color:' .  $color . ';' : '';
	$elstyle .= 'font-size:' .  $sizerem . 'rem;';
	$elstyle .= '"';

	$cls .= $custom_class ? ' ' . $custom_class : '';

	$output .= '<div class="mb2-pb-date' . $cls . '"' . $elstyle . '>';
	$output .= '<span class="before">' . $textbefore . '</span>';
	$output .=  date('Y');
	$output .= '<span class="after">' . $textafter . '</span>';
	$output .= '</div>';

	return $output;

}



function mb2_shortcode_year( $atts, $content = null ){
	global $OUTPUT;

	$atts2 = array();

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	return '<span class="cyear">' . date('Y') . '</span>';

}
