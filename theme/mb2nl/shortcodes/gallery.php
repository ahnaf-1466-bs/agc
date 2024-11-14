<?php

defined('MOODLE_INTERNAL') || die();


function mb2_shortcode_gallery($atts, $content= null){
	extract(mb2_shortcode_atts( array(
		'folder' => ''
	), $atts));	
	
		
	$output = '';
	
	
	
	
	return $output;	
	
}

mb2_add_shortcode('gallery', 'mb2_shortcode_gallery');