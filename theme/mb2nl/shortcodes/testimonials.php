<?php

defined( 'MOODLE_INTERNAL' ) || die();

mb2_add_shortcode( 'testimonials', 'mb2_shortcode_testimonials' );
mb2_add_shortcode( 'testimonials_item', 'mb2_shortcode_testimonials_item' );

function mb2_shortcode_testimonials( $atts, $content = null ){

	global $PAGE;

	$atts2 = array(
		'mt' => 0,
		'mb' => 30,
		'width' => '',
		'custom_class' => '',
		'clayout' => 2, // 1 - columns layout, 2 - creative layout
		'columns' => 4,
		'gutter' => 'normal',
		'isimage' => 1,
		'iscompany' => 1,
		'isjob' => 1,
		'mobcolumns' => 1,
		'sloop' => 0,
		'snav' => 0,
		'sdots' => 1,
		'autoplay' => 0,
		'pausetime' => 5000,
		'animtime' => 450
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$attr = array();
	$sliderid = uniqid('swiper_');
	$sData = '';
	$style = '';
	$cls = '';
	$GLOBALS['testimonials_isimage'] = $isimage;
	$GLOBALS['testimonials_iscompany'] = $iscompany;
	$GLOBALS['testimonials_isjob'] = $isjob;

	$cls .= ' snav' . $snav;
	$cls .= ' sdots' . $sdots;
	$cls .= ' isimage' . $isimage;
	$cls .= ' iscompany' . $iscompany;
	$cls .= ' isjob' . $isjob;
	$cls .= ' clayout' . $clayout;
 	$cls .= $custom_class ? ' ' . $custom_class : '';

	if ( $mt || $mb )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	}

	$opts = theme_mb2nl_page_builder_2arrays( $atts, $atts2 );
	$sliderdata = theme_mb2nl_shortcodes_slider_data( $opts );

	$output .= '<div class="mb2-pb-carousel mb2-pb-testimonials mb2-pb-content' . $cls . '"' . $style . $sliderdata . '>';
	$output .= '<div class="mb2-pb-testimonials-inner">';
	$output .= '<div id="' . $sliderid . '" class="mb2-pb-element-inner swiper">';
	$output .= theme_mb2nl_shortcodes_swiper_nav();
	$output .= '<div class="swiper-wrapper">';
	$output .= mb2_do_shortcode( $content );
	$output .= '</div>'; // swiper-wrapper
	$output .= theme_mb2nl_shortcodes_swiper_pagenavnav();
	$output .= '</div>'; // swiper
	$output .= '</div>'; //mb2-pb-testimonials-inner
	$output .= '</div>'; // mb2-pb-testimonials

	return $output;

}



function mb2_shortcode_testimonials_item( $atts, $content = null ){
	extract(mb2_shortcode_atts( array(
		'name' => 'Full Name',
		'job' => 'Moodel Dev',
		'companyname' => 'Company name',
		'image' => theme_mb2nl_page_builder_demo_image( '100x100' ),
		'rating' => 0,
		'template' => ''
		), $atts)
	);

	$output = '';

	$output .= '<div class="mb2-pb-carousel-item mb2-pb-testimonials-item theme-slider-item swiper-slide">';
	$output .= '<div class="testimonials-item-inner">';

	if ( $GLOBALS['testimonials_isimage'] )
	{
		$output .= '<div class="testimonial-image">';
		$output .= '<img class="testimonial-image-src lazy" src="' . theme_mb2nl_lazy_plc() . '" data-src="' . $image . '" alt="' . $name . '">';
		$output .= '</div>'; // testimonial-image
	}

	$output .= '<div class="testimonial-content">';

	$output .= '<div class="testimonial-header">';
	$output .= '<div class="testimonial-meta">';
	$output .= '<span class="testimonial-name">';
	$output .= $name;
	$output .= '</span>'; // testimonial-name

	if ( $GLOBALS['testimonials_isjob'] )
	{
		$output .= '<span class="testimonial-job">';
		$output .= $job;
		$output .= '</span>'; // testimonial-job
	}

	if ( $GLOBALS['testimonials_iscompany'] )
	{
		$output .= '<div class="testimonial-companyname">';
		$output .= $companyname;
		$output .= '</div>'; // testimonial-companyname
	}

	$output .= '</div>'; // testimonial-meta
	$output .= theme_mb2nl_stars($rating);
	$output .= '</div>'; // testimonial-header

	$output .= '<div class="testimonial-text">';
	$output .= urldecode( $content );
	$output .= '</div>'; // testimonial-text

	$output .= '</div>'; // testimonial-content

	$output .= '</div>'; // testimonials-item-inner
	$output .= '</div>'; // mb2-pb-testimonials-item

	return $output;


}
