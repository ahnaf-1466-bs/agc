<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('html', 'mb2_shortcode_html');

function mb2_shortcode_html($atts, $content= null){

	extract(mb2_shortcode_atts( array(
		'el_onmobile' => 1,
		'text' => ''
	), $atts));

	$cls = '';
	$cls .= ' el_onmobile' . $el_onmobile;

	return '<div class="html-content' . $cls . '">' . $content . '</div>';

}
