<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'footertools', 'mb2_shortcode_footertools' );

function mb2_shortcode_footertools( $atts, $content = null ){

	global $OUTPUT;

	$atts2 = array(
		'id' => 'footertools',
		'mt' => 0,
		'mb' => 0,
		'sizerem' => 1,
		'color' => '',
		'custom_class' => '',
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$style = '';
	$cls = '';

	$style .= ' style="';
	$style .= 'margin-top:' .  $mt . 'px;';
	$style .= 'margin-bottom:' .  $mb . 'px;';
	$style .= $color ? 'color:' .  $color . ';' : '';
	$style .= 'font-size:' .  $sizerem . 'rem;';
	$style .= '"';

	$cls .= $custom_class ? ' ' . $custom_class : '';

	$output .= '<div class="mb2-pb-footertools' . $cls . '"' . $style . '>';
	$output .= $OUTPUT->theme_part( 'footer_tools' );
	$output .= '</div>';

	return $output;

}
