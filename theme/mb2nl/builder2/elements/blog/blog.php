<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('mb2pb_blog', 'mb2_shortcode_mb2pb_blog');

function mb2_shortcode_mb2pb_blog($atts, $content= null) {

	global $PAGE;

	$atts2 = array(
		'id' => 'blog',
		'limit' => 8,
		'sortcreated' => 0,
		'postexternal' => 1,
		'postids' => '',
		'exposts' => 0,
		'tagids' => '',
		'extags' => 0,
		'author' => 0,
		'date' => 1,
		'desc' => 1,
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
		'layout' => 2, //1 - modern, 2 - columns, 3 - carousel
		'superpost' => 0,
		'gutter' => 'normal',
		'linkbtn' => 0,
		'btntext' => '',
		'prestyle' => 'none',
		'custom_class' => '',
		'mt' => 0,
		'mb' => 30,
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$cls = '';
	$list_cls = '';
	// $col_cls = '';
	$style = '';
	$sliderid = $template ? '' : uniqid('swiper_');
	//
	// // Set column style
	// $col = 0;
	// $col_style = '';
	// $list_style = '';
	//
	$cls .= $custom_class ? ' ' . $custom_class : '';

	$blogopts = theme_mb2nl_page_builder_2arrays( $atts, $atts2 );
	$blogopts['lazy'] = 0;
	$posts = theme_mb2nl_get_blog_posts( $blogopts );
	$itemCount = count( $posts );
	$posts2 = theme_mb2nl_get_blog_posts( $blogopts );
	$firstpost = array_shift( $posts2 );

	// Carousel layout
	$list_cls .= $layout == 3 ? ' swiper-wrapper' : '';
	$list_cls .= $layout == 2 ? ' theme-boxes theme-col-' . $columns : '';
	$list_cls .= ' gutter-' . $gutter;
	$list_cls .= ' layout' . $layout;

	$super_cls = ' gutter-' . $gutter;

	$container_cls = $layout == 3 ? ' swiper' : '';

	//
	// $cls .= ' prestyle' . $prestyle;
	$cls .= $template ? ' mb2-pb-template-blog' : '';
	//
	if ( $mt || $mb )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	}
	//
	$output .= '<div class="mb2-pb-content mb2-pb-element mb2-pb-blog clearfix' . $cls . '"' . $style . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'blog' );
	$output .= '<div class="superpost' . $super_cls . '">';
	$output .= theme_mb2nl_blog_template_item( $firstpost, $blogopts );
	$output .= '</div>'; // superpost
	$output .= '<div id="' . $sliderid . '" class="mb2-pb-content-inner mb2-pb-element-inner clearfix' . $container_cls . '">';
	$output .= theme_mb2nl_shortcodes_swiper_nav();
	$output .= '<div class="mb2-pb-content-list' . $list_cls . '">';

	if ( ! $itemCount )
	{
		$output .= '<div class="theme-box">';
		$output .= get_string( 'nothingtodisplay' );
		$output .= '</div>';
	}
	else
	{
		$output .= theme_mb2nl_blog_template( $posts, $blogopts );
	}

	$output .= '</div>';
	$output .= theme_mb2nl_shortcodes_swiper_pagenavnav();
	$output .= '</div>';
	$output .= '</div>';

	if ( $layout == 3 )
	{
		// Init carousel
		//$PAGE->requires->js_call_amd( 'local_mb2builder/carousel','carouselInit', array($sliderid) );
	}

	return $output;

}
