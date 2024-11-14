<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'social', 'mb2_shortcode_social' );

function mb2_shortcode_social( $atts, $content = null ){
	global $OUTPUT, $PAGE;

	$atts2 = array(
		'id' => 'social',
		'mt' => 0,
		'mb' => 30,
		'type' => 1,
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
	$elstyle .= '"';

	$socialtt = theme_mb2nl_theme_setting($PAGE, 'socialtt') == 1 ? 'top' : '';

	$cls .= ' type' . $type;
	$cls .= $custom_class ? ' ' . $custom_class : '';

	$output .= '<div class="mb2-pb-social' . $cls . '"' . $elstyle . '>';
	$output .= theme_mb2nl_social_icons(true, array( 'pos'=>'footer', 'tt'=>$socialtt ));
	$output .= '</div>';

	return $output;

}
