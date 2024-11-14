<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'mb2pb_iframe', 'mb2_shortcode_mb2pb_iframe' );

function mb2_shortcode_mb2pb_iframe( $atts, $content = null ){

	$atts2 = array(
		'id' => 'iframe',
		'width' => 800,
		'height' => 350,
		'mt' => 0,
		'mb' => 30,
		'url' => 'https://example.com',
		'title' => '',
		'custom_class' => '',
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

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

	$tmplcls = $template ? ' mb2-pb-template-iframe' : '';

	$output .= '<div class="mb2-pb-element mb2pb-iframe' . $tmplcls . '"' . $style . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'iframe' );
	$output .= '<div class="embed-responsive-wrap"><div class="embed-responsive-wrap-inner">';
	$output .= '<iframe src="' . $url . '" title="' . $title . '" height="' . $height  . '"></iframe>';
	$output .= '</div></div>';
	$output .= '</div>';

	return $output;

}
