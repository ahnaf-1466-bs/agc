<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'mb2pb_date', 'mb2_shortcode_mb2pb_date' );

function mb2_shortcode_mb2pb_date( $atts, $content = null ){
	global $OUTPUT;

	$atts2 = array(
		'id' => 'date',
		'textbefore' => '&copy; 2017 - ',
		'textafter' => ' New Learning Theme. All rights reserved.',
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

	$cls .= $custom_class ? ' ' . $custom_class : '';

	$tmplcls = $template ? ' mb2-pb-template-' . $id : '';

	$output .= '<div class="mb2-pb-element mb2-pb-date' . $tmplcls . $cls . '"' . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . $elstyle . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'date', array('copy' => 0 ) );
	$output .= '<span class="before">' . $textbefore . '</span>';
	$output .=  date('Y');
	$output .= '<span class="after">' . $textafter . '</span>';
	$output .= '</div>';

	return $output;

}
