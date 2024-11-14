<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('mb2pb_videolocal', 'mb2_shortcode_mb2pb_videolocal');

function mb2_shortcode_mb2pb_videolocal( $atts, $content = null )
{
	$atts2 = array(
		'id' => 'videolocal',
		'width' => 800,
		'videofile' => '',
		'video_text' => '',
		'mt' => 0,
		'mb' => 30,
		'custom_class' => '',
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$style = '';
	$cls = '';

	$cls .= $template ? ' mb2-pb-template-videolocal' : '';
	$cls .= $custom_class ? ' ' . $custom_class : '';

	$imgplc_cls = $videofile ? ' hidden' : '';

	if ( $mt || $mb || $width )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= $width ? 'max-width:' . $width .'px;' : '';
		$style .= '"';
	}

	$output .= '<div class="theme-videolocal mb2-pb-element mb2pb-videolocal' . $cls . '"' . $style . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'videolocal' );
	$output .= '<div class="theme-videolocal-inner">';
	if ( $videofile )
	{
		$output .= '<video controls="true">';
		$output .= '<source src="' . $videofile . '">';
		$output .= '</video>';
	}
	$output .= '</div>';
	$output .= '<img class="videolocal-placeholder' . $imgplc_cls . '" src="' . theme_mb2nl_page_builder_demo_image( '1600x1066' ) . '" alt" />';
	$output .= '</div>';

	return $output;

}
