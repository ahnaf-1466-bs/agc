<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('popupimage', 'mb2_shortcode_popupimage');


function mb2_shortcode_popupimage( $atts, $content= null )
{
	global $PAGE;

	extract(mb2_shortcode_atts( array(
		'image' => '',
		'width' => 300,
		'border' => 1,
		'zoom' => 1,
		'custom_class'=> ''
	), $atts));

	$output = '';
	$style = '';
	$cls = $custom_class ? ' ' . $custom_class : '';
	$isimage = $image ? $image : 'https://dummyimage.com/600x400/cccccc/000000.jpg';
	$el_cls = '';

	// Image style
	$style .= ' style="';
	$style .= 'width:' . $width . 'px;max-width:100%;';
	$style .= '"';

	$el_cls .= ' border' . $border;
	$el_cls .= ' zoom' . $zoom;

	$output .= '<span class="theme-popup-element' . $el_cls . '">';
	$output .= '<a class="theme-popup-link popup-image" href="' . $isimage . '"' . $style . '><img src="' . $isimage . '" alt="' . $isimage . '"></a>';
	$output .= '</span>';

	//$PAGE->requires->js_call_amd( 'theme_mb2nl/popup','popupImage' );

	return $output;


}
