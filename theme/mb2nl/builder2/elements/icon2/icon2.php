<?php

defined( 'MOODLE_INTERNAL' ) || die();

mb2_add_shortcode( 'mb2pb_icon2', 'mb2_shortcode_mb2pb_icon2' );

function mb2_shortcode_mb2pb_icon2( $atts, $content = null ){

	$atts2 = array(
		'id' => 'icon2',
		'name' => 'fa fa-star',
		'color' => '',
		'size' => 'n',
		'circle' => 1,
		'desc' => 0,
		'spin' => 0,
		'rotate' => 0,
		'mt' => 0,
		'mb' => 30,
		'sizebg' => '',
		'rounded' => '',
		'bgcolor' => '',
		'custom_class' => '',
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$cls = '';
	$style = '';
	$estyle = '';

	$cls .= ' size' . $size;
	$cls .= ' desc' . $desc;
	$cls .= ' circle' . $circle;
	$cls .= $template ? ' mb2-pb-template-icon2' : '';

	if ( $mt || $mb )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	}

	// Define icon text
	$content = $content ? $content : 'Icon text here.';
	$atts2['text'] = $content;

	if ( $color || $bgcolor )
	{
		$estyle .= ' style="';
		$estyle .= $color ? 'color:' . $color . ';' : '';
		$estyle .= $bgcolor ? 'background-color:' . $bgcolor . ';' : '';
		$estyle .= '"';
	}

	$output .= '<div class="theme-icon2 mb2-pb-element mb2pb-icon2' . $cls . '"' . $style . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'icon2' );
	$output .= '<span class="icon-bg"' . $estyle . '>';
	$output .= '<i class="' . $name . '"></i>';
	$output .= '</span>';
	$output .= '<span class="icon-desc">';
	$output .=  urldecode( $content );
	$output .= '</span>';
	$output .= '</div>';

	return $output;

}
