<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'iframe', 'mb2_shortcode_iframe' );

function mb2_shortcode_iframe( $atts, $content = null )
{
	extract( mb2_shortcode_atts( array(
		'width' => 800,
		'height' => 350,
		'mt' => 0,
		'mb' => 30,
		'url' => '',
		'title' => '',
		'custom_class' => ''
	), $atts ) );

	$output = '';
	$style = '';
	$cls = '';

	if ( $mt || $mb || $width )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= $width ? 'max-width:' . $width .'px;' : '';
		$style .= '"';
	}

	$output .= '<div class="mb2pb-iframe"' . $style . '>';
	$output .= '<div class="embed-responsive-wrap"><div class="embed-responsive-wrap-inner">';
	$output .= '<iframe class="lazy" data-src="' . $url . '" title="' . $title . '" height="' . $height  . '"></iframe>';
	$output .= '</div></div>';
	$output .= '</div>';

	return $output;

}
