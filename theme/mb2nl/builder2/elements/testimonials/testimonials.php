<?php

defined( 'MOODLE_INTERNAL' ) || die();

mb2_add_shortcode( 'mb2pb_testimonials', 'mb2_shortcode_mb2pb_testimonials' );
mb2_add_shortcode( 'mb2pb_testimonials_item', 'mb2_shortcode_mb2pb_testimonials_item' );

function mb2_shortcode_mb2pb_testimonials( $atts, $content = null ){

	global $PAGE;

	$atts2 = array(
		'id' => 'testimonials',
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
		'animtime' => 450,
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$attr = array();
	$uniqid = uniqid( 'carouselitem_' );
	$sliderid = $template ? '' : uniqid('swiper_');
	$sData = '';
	$style = '';
	$cls = '';
	$GLOBALS['carouseluniqid'] = $uniqid;
	$GLOBALS['carouselitem'] = 0;

	$cls .= ' snav' . $snav;
	$cls .= ' sdots' . $sdots;
	$cls .=  ' isimage' . $isimage;
	$cls .= ' iscompany' . $iscompany;
	$cls .= ' isjob' . $isjob;
 	$cls .= $custom_class ? ' ' . $custom_class : '';
	$cls .= $template ? ' mb2-pb-template-testimonials' : '';

	if ( $mt || $mb )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	}

	// Define default content
	if ( ! $content )
	{
		$demoimage = theme_mb2nl_page_builder_demo_image( '100x100' );

		for ( $i = 1; $i <= 5; $i++  )
		{
			$content .= '[mb2pb_testimonials_item pbid="" image="' . $demoimage . '" ][/mb2pb_testimonials_item]';
		}

	}

	// Get carousel content for sortable elements
	$regex = '\\[(\\[?)(mb2pb_testimonials_item)\\b([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
	preg_match_all( "/$regex/is", $content, $match );
	$content = $match[0];

	$output .= '<div class="mb2-pb-element mb2-pb-carousel mb2-pb-testimonials' . $cls . '"' . $style . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'testimonials' );
	$output .= '<div class="mb2-pb-testimonials-inner">';
	$output .= '<div id="' . $sliderid . '" class="mb2-pb-element-inner swiper">';
	$output .= theme_mb2nl_shortcodes_swiper_nav();
	$output .= '<div class="swiper-wrapper">';
	foreach( $content as $c )
	{
		$output .= mb2_do_shortcode( $c );
	}
	$output .= '</div>'; // swiper-wrapper
	$output .= theme_mb2nl_shortcodes_swiper_pagenavnav();
	$output .= '</div>'; // swiper

	$output .= '<div class="mb2-pb-sortable-subelements">';
	$output .= '<a href="#" class="element-items">&#x2715;</a>';
	$z = 0;
	foreach( $content as $c )
	{
		// Get attributes of carousel items
		$attributes = shortcode_parse_atts( $c );
		$z++;
		$attr['id'] = 'testimonials_item';
		$attr['pbid'] = ( isset( $attributes['pbid'] ) && $attributes['pbid'] ) ? $attributes['pbid'] : $uniqid . $z;
		$attr['image'] = $attributes['image'];
		$attr['name'] = ( isset( $attributes['name'] ) && $attributes['name'] ) ? $attributes['name'] : 'Full Name';
		$attr['job'] = ( isset( $attributes['job'] ) && $attributes['job'] ) ? $attributes['job'] : 'Moodle Dev';
		$attr['rating'] = ( isset( $attributes['rating'] ) && $attributes['rating'] ) ? $attributes['rating'] : 0;
		$attr['companyname'] = ( isset( $attributes['companyname'] ) && $attributes['companyname'] ) ? $attributes['companyname'] : 'Company name';
		$attr['text'] = theme_mb2nl_page_builder_shortcode_content_attr( $c, mb2_get_shortcode_regex() );

		$output .= '<div class="mb2-pb-subelement mb2-pb-carousel_item mb2-pb-testimonials_item" style="background-image:url(\'' . $attr['image'] . '\');"' .
		theme_mb2nl_page_builder_el_datatts( $attr, $attr ) . '>';
		$output .= theme_mb2nl_page_builder_el_actions( 'subelement' );
		$output .= '<div class="mb2-pb-subelement-inner">';
		$output .= '<img src="' . $attr['image'] . '" class="theme-slider-img-src" alt="" />';
		$output .= '</div>';
		$output .= '</div>';
	}

	$output .= '</div>';
	$output .= '</div>'; //mb2-pb-testimonials-inner
	$output .= '</div>';

	return $output;

}



function mb2_shortcode_mb2pb_testimonials_item( $atts, $content = null ){
	extract(mb2_shortcode_atts( array(
		'id' => 'testimonials_item',
		'pbid' => '', // it's require for sorting elements below carousel items
		'name' => 'Full Name',
		'job' => 'Moodel Dev',
		'companyname' => 'Company name',
		'image' => theme_mb2nl_page_builder_demo_image( '100x100' ),
		'rating' => 0,
		'template' => ''
		), $atts)
	);

	$output = '';

	if ( isset( $GLOBALS['carouselitem'] ) )
	{
		$GLOBALS['carouselitem']++;
	}
	else
	{
		$GLOBALS['carouselitem'] = 0;
	}

	$pbid = $pbid ? $pbid : $GLOBALS['carouseluniqid'] . $GLOBALS['carouselitem'];
	$content = $content ? $content : 'Testimonial content here.';

	$output .= '<div class="mb2-pb-carousel-item mb2-pb-testimonials-item theme-slider-item swiper-slide" data-pbid="' . $pbid . '">';
	$output .= '<div class="testimonials-item-inner">';

	$output .= '<div class="testimonial-image">';
	$output .= '<img class="testimonial-image-src" src="' . $image . '" alt="' . $name . '">';
	$output .= '</div>'; // testimonial-image

	$output .= '<div class="testimonial-content">';

	$output .= '<div class="testimonial-header">';
	$output .= '<div class="testimonial-meta">';
	$output .= '<span class="testimonial-name">';
	$output .= $name;
	$output .= '</span>';
	$output .= '<span class="testimonial-job">';
	$output .= $job;
	$output .= '</span>';
	$output .= '<div class="testimonial-companyname">';
	$output .= $companyname;
	$output .= '</div>';
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
