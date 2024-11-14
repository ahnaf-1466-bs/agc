<?php

defined( 'MOODLE_INTERNAL' ) || die();

mb2_add_shortcode( 'mb2pb_carousel', 'mb2_shortcode_mb2pb_carousel' );
mb2_add_shortcode( 'mb2pb_carousel_item', 'mb2_shortcode_mb2pb_carousel_item' );

function mb2_shortcode_mb2pb_carousel( $atts, $content = null ){

	global $PAGE;

	$atts2 = array(
		'id' => 'carousel',
		'mt' => 0,
		'mb' => 30,
		'width' => '',
		'custom_class' => '',
		'prestyle' => 'nlearning',
		'columns' => 4,
		'gutter' => 'normal',
		'linkbtn' => 0,
		'title' => 1,
		'titlefs' => 1.4,
		'imgwidth' => 700,
		'mobcolumns' => 1,
		'desc' => 1,
		'btntext' => '',
		'sloop' => 0,
		'snav' => 1,
		'sdots' => 0,
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
	$GLOBALS['carouselbtntext'] = $btntext;
	$GLOBALS['carouseluniqid'] = $uniqid;
	$GLOBALS['carouselitem'] = 0;
	$GLOBALS['carimgwidth'] = $imgwidth;
	$GLOBALS['carouseltitlefs'] = $titlefs;

	$cls .= ' prestyle' . $prestyle;
	$cls .= ' linkbtn' . $linkbtn;
	$cls .= ' title' . $title;
	$cls .= ' desc' . $desc;
	$cls .= ' snav' . $snav;
	$cls .= ' sdots' . $sdots;
 	$cls .= $custom_class ? ' ' . $custom_class : '';
	$cls .= $template ? ' mb2-pb-template-carousel' : '';

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
		$demoimage = theme_mb2nl_page_builder_demo_image( '1600x1066' );

		for ( $i = 1; $i <= 5; $i++  )
		{
			$content .= '[mb2pb_carousel_item pbid="" image="' . $demoimage . '" ][/mb2pb_carousel_item]';
		}

	}

	// Get carousel content for sortable elements
	$regex = '\\[(\\[?)(mb2pb_carousel_item)\\b([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
	preg_match_all( "/$regex/is", $content, $match );
	$content = $match[0];

	$output .= '<div class="mb2-pb-element mb2-pb-carousel' . $cls . '"' . $style . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'carousel' );
	//$output .= '<div class="mb2-pb-element-inner owl-carousel">';
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

	//$PAGE->requires->js_call_amd( 'local_mb2builder/carousel','carouselInit', array($sliderid) );

	$output .= '<div class="mb2-pb-sortable-subelements">';
	$output .= '<a href="#" class="element-items">&#x2715;</a>';
	$z = 0;
	foreach( $content as $c )
	{

		// Get attributes of carousel items
		$attributes = shortcode_parse_atts( $c );
		$z++;
		$attr['id'] = 'carousel_item';
		$attr['pbid'] = ( isset( $attributes['pbid'] ) && $attributes['pbid'] ) ? $attributes['pbid'] : $uniqid . $z;
		$attr['image'] = $attributes['image'];
		$attr['title'] = ( isset( $attributes['title'] ) && $attributes['title'] ) ? $attributes['title'] : 'Title text';
		$attr['desc'] = ( isset( $attributes['desc'] ) && $attributes['desc'] ) ? $attributes['desc'] : 'Description text';
		$attr['color'] = isset( $attributes['color'] ) ? $attributes['color'] : '';
		$attr['link'] = isset( $attributes['link'] ) ? $attributes['link'] : '';
		$attr['link_target'] = isset( $attributes['link_target'] ) ? $attributes['link_target'] : '';

		$output .= '<div class="mb2-pb-subelement mb2-pb-carousel_item" style="background-image:url(\'' . $attr['image'] . '\');"' .
		theme_mb2nl_page_builder_el_datatts( $attr, $attr ) . '>';
		$output .= theme_mb2nl_page_builder_el_actions( 'subelement' );
		$output .= '<div class="mb2-pb-subelement-inner">';
		$output .= '<img src="' . $attr['image'] . '" class="theme-slider-img-src" alt="" />';
		$output .= '</div>';
		$output .= '</div>';
	}

	$output .= '</div>';
	$output .= '</div>';

	// unset( $GLOBALS['carouselbtntext'] );
	// unset( $GLOBALS['carouseluniqid'] );
	// unset( $GLOBALS['carouselitem'] );
	// unset( $GLOBALS['carimgwidth'] );

	return $output;

}



function mb2_shortcode_mb2pb_carousel_item( $atts, $content = null ){
	extract(mb2_shortcode_atts( array(
		'id' => 'carousel_item',
		'pbid' => '', // it's require for sorting elements below carousel items
		'title' => 'Title text',
		'image' => theme_mb2nl_page_builder_demo_image( '1600x1066' ),
		'desc' => 'Description text',
		'color' => '',
		'link' => '',
		'target' => '',
		'link_target' => 0,
		'template' => ''
		), $atts)
	);

	$output = '';
	$imgstyle = ' style="width:' . $GLOBALS['carimgwidth'] . 'px;"';

	if ( isset( $GLOBALS['carouselitem'] ) )
	{
		$GLOBALS['carouselitem']++;
	}
	else
	{
		$GLOBALS['carouselitem'] = 0;
	}

	$pbid = $pbid ? $pbid : $GLOBALS['carouseluniqid'] . $GLOBALS['carouselitem'];

	$colorcls = $color ? ' color1' : '';

	$color_style = $color ? ' style="background-color:' . $color . ';"' : '';

	$output .= '<div class="mb2-pb-carousel-item theme-slider-item swiper-slide" data-pbid="' . $pbid . '">';
	$output .= '<div class="theme-slider-item-inner">';

	$output .= '<div class="theme-slider-img">';
	$output .= '<img class="theme-slider-img-src" src="' . $image . '" alt="' . $title . '"' . $imgstyle . '>';
	$output .= '</div>';

	$output .= '<div class="theme-slide-content1' . $colorcls . '"' . $color_style . '>';
	$output .= '<div class="theme-slide-content2">';
	$output .= '<div class="theme-slide-content3">';
	$output .= '<div class="theme-slide-content4">';
	$output .= '<h4 class="theme-slide-title" style="font-size:' . $GLOBALS['carouseltitlefs'] . 'rem;">';
	$output .= $title;
	$output .= '</h4>';
	$output .= '<div class="theme-slider-desc">';
	$output .= $desc;
	$output .= '</div>';
	$btntext = $GLOBALS['carouselbtntext'] ? $GLOBALS['carouselbtntext'] : get_string('btntext','local_mb2builder');
	$output .= '<div class="theme-slider-readmore">';
	$output .= '<a class="mb2-pb-btn typeprimary" href="#">' . $btntext . '</a>';
	$output .= '</div>';

	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	$output .= '</div>';
	$output .= '</div>';

	return $output;


}
