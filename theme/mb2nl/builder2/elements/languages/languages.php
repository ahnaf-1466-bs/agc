<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'mb2pb_languages', 'mb2_shortcode_mb2pb_languages' );

function mb2_shortcode_mb2pb_languages( $atts, $content = null ){
	global $OUTPUT;

	$atts2 = array(
		'id' => 'languages',
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

	$tmplcls = $template ? ' mb2-pb-template-' . $id : '';

	$output .= '<div class="mb2-pb-element mb2-pb-languages' . $tmplcls . $cls . '"' . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . $elstyle . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'languages', array('copy' => 0 ) );
	$output .= theme_mb2nl_language_list(true) ? theme_mb2nl_language_list(true) : 'No languages.';
	$output .= '</div>';

	return $output;

}
