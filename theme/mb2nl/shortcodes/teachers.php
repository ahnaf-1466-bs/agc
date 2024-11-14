<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('teachers', 'mb2_shortcode_teachers');

function mb2_shortcode_teachers( $atts, $content= null ) {

	global $PAGE;

	$atts2 = array(
		'limit' => 8,
		'teacherids' => '',
		'exteachers' => 0,
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
		'custom_class' => '',
		'mt' => 0,
		'mb' => 30,
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

	$teacheropts = theme_mb2nl_page_builder_2arrays( $atts, $atts2 );
	$sliderdata = theme_mb2nl_shortcodes_slider_data( $teacheropts );
	$teachers = theme_mb2nl_get_all_teachers( $teacheropts, 'u.id,u.firstname,u.firstnamephonetic,u.lastnamephonetic,u.middlename,u.alternatename,u.email,u.lastname,u.picture,u.imagealt,u.description' );
	$itemCount = count( $teachers );

	// Carousel layout
	$list_cls .= $carousel ? ' swiper-wrapper' : '';
	$list_cls .= ! $carousel ? ' theme-boxes theme-col-' . $columns : '';
	$list_cls .= ! $carousel ? ' gutter-' . $gutter : '';

	$container_cls = $carousel ? ' swiper' : '';

	if ( $mt || $mb )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	}

	$output .= '<div class="mb2-pb-content mb2-pb-teachers clearfix' . $cls . '"' . $style . $sliderdata . '>';
	$output .= '<div id="' . $sliderid . '" class="mb2-pb-content-inner clearfix' . $container_cls . '">';
	$output .= $carousel ? theme_mb2nl_shortcodes_swiper_nav() : '';
	$output .= '<div class="mb2-pb-content-list' . $list_cls . '">';

	if ( ! $itemCount )
	{
		$output .= get_string('nothingtodisplay');
	}

	$output .= theme_mb2nl_shortcodes_teachers_template( $teachers, $teacheropts );

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
