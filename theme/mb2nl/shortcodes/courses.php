<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('courses', 'mb2_shortcode_courses');

function mb2_shortcode_courses($atts, $content= null){

	global $PAGE;

	$atts2 = array(
		'limit' => 8,
		'catids' => '',
		'courseids' => '',
		'excourses' => 0,
		//
		'tagids' => '',
		'extags' => 0,
		//
		'lazy' => 1,
		'mobcolumns' => 0,
		'excats' => 0,
		'carousel' => 0,
		'columns' => 3,
		'sdots' => 0,
		'sloop' => 0,
		'snav' => 1,
		'sautoplay' => 1,
		'autoplay' => 0,
		'spausetime' => 5000,
		'pausetime' => 5000,
		'sanimate' => 600,
		'animtime' => 600,
		'desclimit' => 25,
		'titlelimit' => 6,
		'gridwidth' => 'normal',
		'gutter' => 'normal',
		'linkbtn' => 0,
		'btntext' => '',
		'prestyle' => 'none',
		'custom_class' => '',
		'colors' => '',
		'mt' => 0,
		'mb' => 30,
		'coursestudentscount' => 1,
		'coursinstructor' => 1,
		//'coursestartdate' => 0,
		'courseprice' => 1
	);
	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$cls = '';
	$list_cls = '';
	$col_cls = '';
	$style = '';
	$sliderid = uniqid('swiper_');

	// Set column style
	$col = 0;
	$col_style = '';
	$list_style = '';

	$courseopts = theme_mb2nl_page_builder_2arrays( $atts, $atts2 );

	// Disable touch move for quick view courses
	if ( theme_mb2nl_theme_setting( $PAGE, 'quickview' ) )
	{
		$courseopts['touchmove'] = 0;
	}

	$sliderdata = theme_mb2nl_shortcodes_slider_data( $courseopts );
	$courses = theme_mb2nl_get_courses( $courseopts );
	$itemCount = count( $courses );

	// Carousel layout
	$list_cls .= $carousel ? ' swiper-wrapper' : '';
	$list_cls .= ! $carousel ? ' theme-boxes theme-col-' . $columns : '';
	$list_cls .= ! $carousel ? ' gutter-' . $gutter : '';

	$container_cls = $carousel ? ' swiper' : '';

	$cls .= ' prestyle' . $prestyle;

	if ( $mt || $mb )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	}

	$output .= '<div class="mb2-pb-content mb2-pb-courses clearfix' . $cls . '"' . $style . $sliderdata . '>';
	$output .= '<div id="' . $sliderid . '" class="mb2-pb-content-inner clearfix' . $container_cls . '">';
	$output .= $carousel ? theme_mb2nl_shortcodes_swiper_nav() : '';
	$output .= '<div class="mb2-pb-content-list' . $list_cls . '">';

	if ( ! $itemCount )
	{
		$output .= '<div class="theme-box">';
		$output .= get_string( 'nothingtodisplay' );
		$output .= '</div>';
	}

	$output .= theme_mb2nl_shortcodes_course_template( $courses, $courseopts );

	$output .= '</div>'; // mb2-pb-content-list
	$output .= $carousel ? theme_mb2nl_shortcodes_swiper_pagenavnav() : '';
	$output .= '</div>'; // mb2-pb-content-inner
	$output .= '</div>'; // mb2-pb-content

	if ( $carousel  )
	{
		//$PAGE->requires->js_call_amd( 'theme_mb2nl/carousel','carouselInit', array($sliderid) );
	}

	return $output;

}
