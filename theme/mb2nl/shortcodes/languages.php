<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'languages', 'mb2_shortcode_languages' );

function mb2_shortcode_languages( $atts, $content = null ){
	global $OUTPUT;

	$atts2 = array(
		'horizontal' => 1,
		'image' => 0,
		'mt' => 0,
		'mb' => 30,
		'sizerem' => 1,
		'color' => '',
		'custom_class' => '',
		'template' => ''
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

	$cls .= ' horizontal' . $horizontal;
	$cls .= ' image' . $image;
	$cls .= $custom_class ? ' ' . $custom_class : '';

	$output .= '<div class="mb2-pb-languages' . $cls . '"' . $elstyle . '>';
	$output .= theme_mb2nl_language_list(true) ? theme_mb2nl_language_list(true) : 'No languages.';
	$output .= '</div>';

	return $output;

}
