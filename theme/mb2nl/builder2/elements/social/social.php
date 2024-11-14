<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'mb2pb_social', 'mb2_shortcode_mb2pb_social' );

function mb2_shortcode_mb2pb_social( $atts, $content = null ){
	global $OUTPUT, $PAGE;

	$atts2 = array(
		'id' => 'social',
		'type' => 1,
		'mt' => 0,
		'mb' => 30,
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

	$tmplcls = $template ? ' mb2-pb-template-' . $id : '';

	$output .= '<div class="mb2-pb-element mb2-pb-social' . $tmplcls . $cls . '"' . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . $elstyle . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'social', array('copy' => 0 ) );
	$output .= theme_mb2nl_social_icons(true, array( 'pos'=>'footer', 'tt'=>$socialtt ));
	$output .= '</div>';

	return $output;

}
