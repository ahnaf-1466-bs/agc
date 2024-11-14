<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('events', 'mb2_shortcode_events');

function mb2_shortcode_events($atts, $content= null) {

	global $PAGE;

	$atts2 = array(
		'id' => 'blog',
		'type' => 0,// 0 = all, 1 = site events
		'upcoming' => 0,
		'limit' => 8,
		'sortcreated' => 0,
		'postexternal' => 1,
		'postids' => '',
		'exposts' => 0,
		'tagids' => '',
		'extags' => 0,
		'author' => 0,
		'date' => 1,
		'image' => 1,
		//
		//'carousel' => 0,
		'columns' => 3,
		'sloop' => 0,
		'snav' => 1,
		'sdots' => 0,
		'autoplay' => 0,
		'pausetime' => 5000,
		'animtime' => 450,
		//
		'superpost' => 0,
		'layout' => 2, // 1 - modern, 2 - columns, 3 - columns
		'desclimit' => 25,
		'titlelimit' => 6,
		'gutter' => 'normal',
		'linkbtn' => 0,
		'btntext' => '',
		'prestyle' => 'none',
		'custom_class' => '',
		'mt' => 0,
		'mb' => 30
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$cls = '';
	$list_cls = '';
	$style = '';
	$sliderid = uniqid('swiper_');
	$modalid = uniqid();

	$cls .= $custom_class ? ' ' . $custom_class : '';

	$options = theme_mb2nl_page_builder_2arrays( $atts, $atts2 );
	$events = theme_mb2nl_get_events( $options );
	$itemCount = count( $events );
	$sliderdata = theme_mb2nl_shortcodes_slider_data( $options );

	// Carousel layout
	$list_cls .= $layout == 3 ? ' swiper-wrapper' : '';
	$list_cls .= $layout == 2 ? ' theme-boxes theme-col-' . $columns : '';
	$list_cls .= ' gutter-' . $gutter;
	$list_cls .= ' layout' . $layout;

	$container_cls = $layout == 3 ? ' swiper' : '';
	$super_cls = ' gutter-' . $gutter;

	if ( $mt || $mb )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	}

	$output .= '<div class="mb2-pb-content mb2-pb-events clearfix' . $cls . '"' . $style . $sliderdata . '>';

	$output .= '<div id="' . $sliderid . '" class="mb2-pb-content-inner mb2-pb-element-inner clearfix' . $container_cls . '">';
	$output .= $layout == 3 ? theme_mb2nl_shortcodes_swiper_nav() : '';
	$output .= '<div class="mb2-pb-content-list' . $list_cls . '">';

	if ( ! $itemCount )
	{
		$output .= '<div class="theme-box">';
		$output .= get_string( 'nothingtodisplay' );
		$output .= '</div>';
	}
	else
	{
		$output .= theme_mb2nl_events_template( $events, $options );
	}

	$output .= '</div>'; // mb2-pb-content-list
	$output .= $layout == 3 ? theme_mb2nl_shortcodes_swiper_pagenavnav() : '';
	$output .= '</div>'; // mb2-pb-content-inner
	$output .= '<div class="mb2-pb-events-items"></div>';
	$output .= '</div>'; // mb2-pb-events

	if ( $layout == 3 )
	{
		// Init carousel
		//$PAGE->requires->js_call_amd( 'theme_mb2nl/carousel','carouselInit', array($sliderid) );
	}

	$PAGE->requires->js_call_amd( 'theme_mb2nl/events','eventDetails', array() );

	return $output;

}
