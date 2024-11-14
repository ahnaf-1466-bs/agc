<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('line', 'mb2_shortcode_line');

function mb2_shortcode_line ( $atts, $content = null ){

	extract(mb2_shortcode_atts( array(
		'color' => 'dark',
		'custom_color' => '',
		'size' => 1,
		'double' => 0,
		'style'=> 'solid',
		'mt' => 30,
		'mb' => 30,
		'custom_class' => ''
	), $atts));

	$output = '';
	$elstyle = '';
	$cls = '';

	$elstyle .= ' style="';
	$elstyle .= $custom_color !== '' ? 'border-color:' . $custom_color  . ';' : '';
	$elstyle .= 'border-width:' . $size  . 'px;';
	$elstyle .= 'margin-top:' .  $mt . 'px;';
	$elstyle .= 'margin-bottom:' .  $mb . 'px;';
	$elstyle .= '"';

	$cls .= ' ' . $color;
	$cls .= $custom_class ? ' ' . $custom_class : '';
	$cls .= ' double' . $double;
	$cls .= ' border-' . $style;

	$output .= '<div class="border-hor' . $cls . '"' . $elstyle . '></div>';

	return $output;

}
