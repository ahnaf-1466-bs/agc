<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('categories', 'mb2_shortcode_categories');

function mb2_shortcode_categories($atts, $content= null){

	global $PAGE;

	$atts2 = array(
		'limit' => 8,
		'catids' => 0,
		'excats' => 0,
		'carousel' => 0,
		'mobcolumns' => 0,
		'columns' => 3,
		'sdots' => 0,
		'sloop' => 0,
		'snav' => 1,
		'sautoplay' => 1,
		'spausetime' => 7000,
		'sanimate' => 600,
		'desclimit' => 25,
		'titlelimit' => 6,
		'details' => 1,
		'gridwidth' => 'normal',
		'gutter' => 'normal',
		'link' => 1,
		'linkbtn' => 0,
		'btntext' => '',
		'prestyle' => 0,
		'custom_class' => '',
		'colors' => '',
		'lazy' => 1,
		'mt' => 0,
		'mb' => 30,
	);

	extract( mb2_shortcode_atts( $atts2 , $atts ) );

	$output = '';
	$cls = '';
	$list_cls = '';
	$col_cls = '';
	$style = '';
	$sliderid = uniqid('swiper_');

	if ( $mt || $mb )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	}

	$catopts = theme_mb2nl_page_builder_2arrays( $atts, $atts2 );
	$sliderdata = theme_mb2nl_shortcodes_slider_data( $catopts );
	$categories = theme_mb2nl_shortcodes_categories_get_items( $catopts );
	$itemCount = count( $categories );

	$cls .= ' prestyle' . $prestyle;

	$list_cls .= $carousel ? ' swiper-wrapper' : '';
	$list_cls .= ! $carousel ? ' theme-boxes theme-col-' . $columns : '';
	$list_cls .= ! $carousel ? ' gutter-' . $gutter : '';

	$container_cls = $carousel ? ' swiper' : '';

	$output .= '<div class="mb2-pb-content mb2-pb-categories clearfix' . $cls . '"' . $style . $sliderdata . '>';
	$output .= '<div id="' . $sliderid . '" class="mb2-pb-content-inner clearfix' . $container_cls . '">';
	$output .= $carousel ? theme_mb2nl_shortcodes_swiper_nav() : '';
	$output .= '<div class="mb2-pb-content-list' . $list_cls . '">';

	if ( ! $itemCount )
	{
		$output .= get_string('nothingtodisplay');
	}

	$output .= theme_mb2nl_shortcodes_content_template( $categories, $catopts );

	$output .= '</div>';
	$output .= $carousel ? theme_mb2nl_shortcodes_swiper_pagenavnav() : '';
	$output .= '</div>';
	$output .= '</div>';

	if ( $carousel  )
	{
		//$PAGE->requires->js_call_amd( 'theme_mb2nl/carousel','carouselInit', array($sliderid) );
	}

	return $output;

}
