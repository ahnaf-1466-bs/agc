<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('coursetabs', 'mb2_shortcode_coursetabs');

function mb2_shortcode_coursetabs($atts, $content= null){

	global $PAGE, $CFG;

	$atts2 = array(
		'limit' => 12,
		'catids' => '',
		'excats' => 0,
		'filtertype' => 'category',
		'tagids' => '',
		'extags' => 0,
		'columns' => 4,
		'gutter' => 'normal',
		'custom_class' => '',
		'mt' => 0,
		'mb' => 30,
		'catdesc' => 0,
		'coursecount' => 0,
		'lazy' => 1,
		// carousel options
		'carousel' => 0,
		'sloop' => 0,
		'snav' => 1,
		'sdots' => 0,
		'autoplay' => 0,
		'pausetime' => 5000,
		'animtime' => 450,
		//
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$cls = '';
	$style = '';
	//$inline_js = '';

	$cls .= ' coursecount' . $coursecount;

	$elopts = theme_mb2nl_page_builder_2arrays( $atts, $atts2 );

	// Disable touch move for quick view courses
	if ( theme_mb2nl_theme_setting( $PAGE, 'quickview' ) )
	{
		$elopts['touchmove'] = 0;
	}

	$carouseldata = theme_mb2nl_shortcodes_slider_data( $elopts );
	$categories = theme_mb2nl_get_categories( true );

	// Define uniq id
	$elopts['uniqid'] = uniqid( 'carousetabs_' );

	if ( $mt || $mb )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	}

	$output .= '<div class="mb2-pb-content mb2-pb-coursetabs clearfix' . $cls . '"' . $style . $carouseldata . ' data-carousel="' . $carousel . '" data-columns="' . $columns . '" data-gutter="' . $gutter . '" data-limit="' . $limit . '" data-catdesc="' . $catdesc . '" data-filtertype="' . $filtertype . '" data-rooturl="' . $CFG->wwwroot . theme_mb2nl_themedir() . '" data-sesskey="' . sesskey() . '">';
	$output .= '<div class="mb2-pb-content-inner clearfix">';
	$output .= theme_mb2nl_coursetabs_tabs( $elopts );
	$output .= theme_mb2nl_coursetabs_courses( $elopts );
	$output .= '</div>'; // mb2-pb-content-inner
	$output .= '</div>'; // mb2-pb-coursetabs

	//$inline_js .= 'require([\'theme_mb2nl/coursetabs\'], function(CourseTabs) {';
	//$inline_js .= 'new CourseTabs();';
	//$inline_js .= '});';

	//$PAGE->requires->js_amd_inline( $inline_js );

	return $output;

}
