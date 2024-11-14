<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'mb2pb_line', 'mb2_shortcode_mb2pb_line' );

function mb2_shortcode_mb2pb_line( $atts, $content = null ){

	$atts2 = array(
		'id' => 'line',
		'color' => 'dark',
		'custom_color'=> '',
		'size' => 1,
		'double' => 0,
		'style'=> 'solid',
		'mt' => 30,
		'mb' => 30,
		'custom_class' => '',
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$elstyle = '';
	$cls = '';
	//$height = $double == 1 ? round(5*$size) : 1;

	$elstyle .= ' style="';
	$elstyle .= $custom_color !== '' ? 'border-color:' . $custom_color  . ';' : '';
	$elstyle .= 'border-width:' . $size  . 'px;';
	$elstyle .= 'margin-top:' .  $mt . 'px;';
	$elstyle .= 'margin-bottom:' .  $mb . 'px;';
	//$elstyle .= 'height:' .  $height . 'px;';
	$elstyle .= '"';

	$cls .= ' ' . $color;
	$cls .= $custom_class ? ' ' . $custom_class : '';
	$cls .= ' double' . $double;
	$cls .= ' border-' . $style;

	$tmplcls = $template ? ' mb2-pb-template-line' : '';

	$output .= '<div class="mb2-pb-element mb2pb-line' . $tmplcls . '"' . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'line' );
	$output .= '<div class="border-hor' . $cls . '"' . $elstyle . '></div>';
	$output .= '</div>';

	return $output;

}
