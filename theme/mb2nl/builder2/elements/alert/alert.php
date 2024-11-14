<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'mb2pb_alert', 'mb2pb_shortcode_alert' );

function mb2pb_shortcode_alert( $atts, $content = null ) {

	$atts2 = array(
		'id' => 'alert',
		'type' => 'info',
		'close' => 0,
		'mt' => 0,
		'mb' => 30,
		'class' => '',
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$style = '';
	$cls = $close ? ' alert-dismissible' : '';
	$cls .= $class !='' ? ' ' . $class : '';
	$cls .= $template ? ' mb2-pb-template-alert' : '';
	$cls .= ' closebtn' . $close;

	if ( $mt || $mb )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	}

	$content = $content ? $content : 'Alert text here.';
	$atts2['text'] = $content;

	$output .= '<div class="alert mb2-pb-element mb2pb-alert alert-' . $type . $cls . '"' . $style . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'alert' );
	$output .= '<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	$output .= '<div class="alert-text">' . urldecode( $content ) . '</div>';
	$output .= '</div>';

	return $output;

}
