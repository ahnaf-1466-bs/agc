<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('mb2pb_coursetabs', 'mb2_shortcode_mb2pb_coursetabs');

function mb2_shortcode_mb2pb_coursetabs($atts, $content= null) {

	$atts2 = array(
		'id' => 'coursetabs',
		'limit' => 12,
		'filtertype' => 'category',
		'catids' => '',
		'excats' => 0,
		'tagids' => '',
		'extags' => 0,
		'columns' => 4,
		'gutter' => 'normal',
		'custom_class' => '',
		'mt' => 0,
		'mb' => 30,
		'catdesc' => 0,
		'coursecount' => 0,
		// carousel options
		'carousel' => 0,
		'sloop' => 0,
		'snav' => 1,
		'sdots' => 0,
		'autoplay' => 0,
		'pausetime' => 5000,
		'animtime' => 450,
		//
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	global $PAGE, $CFG;

	$output = '';
	$cls = '';
	$style = '';

	$elopts = theme_mb2nl_page_builder_2arrays( $atts, $atts2 );
	$elopts['lazy'] = 0;
	$categories = theme_mb2nl_get_categories(true);

	// Define builder option
	// It's required to init carousel by builder or theme script
	$elopts['builder'] = 1;

	$cls .= ' coursecount' . $coursecount;
	$cls .= $template ? ' mb2-pb-template-coursetabs' : '';

	if ( $mt || $mb )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	}

	// Define uniq id
	$elopts['uniqid'] = uniqid( 'carousetabs_' );

	$output .= '<div class="mb2-pb-content mb2-pb-element mb2-pb-coursetabs clearfix' . $cls . '"' . $style . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'coursetabs' );
	$output .= '<div class="mb2-pb-content-inner mb2-pb-element-inner clearfix">';


	// Check if user update page builder
	// TODO: remove this condition after a few months
	if ( ! file_exists( $CFG->dirroot . '/local/mb2builder/ajax/coursetabs.php' )  )
	{
		$output .= '<strong style="color:blue;">Update page builder plugin to use "Course tabs" element.</strong>';
	}
	else
	{
		$output .= theme_mb2nl_coursetabs_tabs( $elopts );
		$output .= theme_mb2nl_coursetabs_courses( $elopts );
	}

	$output .= '</div>'; // mb2-pb-content-inner
	$output .= '</div>'; // mb2-pb-element

	//$inline_js = 'require([\'theme_mb2nl/coursetabs\'], function(CourseTabs) {';
	//$inline_js .= 'new CourseTabs();';
	//$inline_js .= '});';

	//$PAGE->requires->js_amd_inline( $inline_js );

	return $output;

}
