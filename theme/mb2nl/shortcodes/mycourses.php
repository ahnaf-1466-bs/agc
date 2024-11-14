<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('mycourses', 'mb2_shortcode_mycourses');

function mb2_shortcode_mycourses($atts, $content= null){

	global $PAGE;

	$atts2 = array(
		'limit' => 8,
		'courseids' => '',
		'nocourseids' => '',
		'allaccessible' => 0,
		'carousel' => 0,
		'columns' => 3,
		'sloop' => 0,
		'snav' => 1,
		'sdots' => 0,
		'autoplay' => 0,
		'pausetime' => 5000,
		'animtime' => 450,
		'desclimit' => 25,
		'titlelimit' => 6,
		'gutter' => 'normal',
		'linkbtn' => 0,
		'btntext' => '',
		'prestyle' => 'none',
		'custom_class' => '',
		'mt' => 0,
		'mb' => 30,
		'coursestudentscount' => 1,
		'coursinstructor' => 1,
		'courseprice' => 1,
		'template' => ''
	);
	extract( mb2_shortcode_atts( $atts2, $atts ) );

	if ( ! isloggedin() || isguestuser() )
	{
		return;
	}

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
	$sliderdata = theme_mb2nl_shortcodes_slider_data( $courseopts );

	$cids = explode(',', $courseopts['courseids']);
	$cids = is_array($cids) && $cids[0] ? $cids : array();
	$nocids = explode(',', $courseopts['nocourseids']);
	$nocids = is_array($nocids) && $nocids[0] ? $nocids : array();
	$courses = enrol_get_my_courses(null, null, $limit, $cids, $allaccessible, 0, $nocids);

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
