<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'mb2pb_search', 'mb2pb_shortcode_mb2pb_search' );

function mb2pb_shortcode_mb2pb_search( $atts, $content = null ) {

	$atts2 = array(
		'id' => 'search',
		'placeholder' => get_string( 'searchcourses' ),
		'global' => 0,
		'rounded' => 0,
		'width' => 750,
		'border' => 1,
		'size' => 'n',
		'mt' => 0,
		'mb' => 30,
		'custom_class' => '',
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$style = '';
	$inputstyle = '';
	$cls = '';

	$formid = uniqid( 'searchform_' );
	$inputname = $global ? 'q' : 'search';

	$cls .= $custom_class ? ' ' . $custom_class : '';
	$cls .= ' size' . $size;
	$cls .= ' rounded' . $rounded;
	$cls .= ' border' . $border;
	$cls .= $template ? ' mb2-pb-template-search' : '';

	if ( $mt || $mb || $width )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= $width ? 'max-width:' . $width . 'px;' : '';
		$style .= '"';
	}

	$output .= '<div class="mb2-pb-element mb2-pb-search' . $cls . '"' . $style . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'search' );
	$output .= '<form id="' . $formid . '" action="">';
	$output .= '<input id="' . $formid . '_search" type="text" value="" placeholder="' . $placeholder . '" name="' . $inputname . '">';
	$output .= '<button type="submit"><i class="fa fa-search"></i></button>';
	$output .= '</form>';
	$output .= '</div>';

	return $output;

}
