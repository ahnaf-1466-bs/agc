<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'mb2pb_html', 'mb2pb_shortcode_html' );

function mb2pb_shortcode_html( $atts, $content = null ) {

	global $PAGE;

	$atts2 = array(
		'id' => 'html',
		'el_onmobile' => 1,
		'text' => '',
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$cls = '';
	$output = '';
	$cls .= $template ? ' mb2-pb-template-html' : '';

	$cls .= ' el_onmobile' . $el_onmobile;

	$text = $text ? $text : '<h4 style="font-size:38px;border:dashed 1px #ccff66;padding: 20px;text-align:center;"><span style="color:#40ff00;">This</span> <span style="color:#0040ff;">is</span> <span style="color:#ffbf00;">a</span> <span style="color:#ffff00;">custom</span> <span style="color:#ff00ff;">HTML</span></h4>';

	$output .= '<div class="mb2-pb-element mb2pb-html' . $cls . '"' . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'html' );
	$output .= '<div class="html-content">' . urldecode( $text ) . '</div>';
	$output .= '</div>'; // mb2-pb-element

	return $output;

}
