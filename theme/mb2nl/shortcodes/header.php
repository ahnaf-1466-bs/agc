<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('header', 'mb2_shortcode_header');


function mb2_shortcode_header ($atts, $content= null){

	extract(mb2_shortcode_atts( array(
		'title'=> '',
		'subtitle' => '',
		'issubtitle' => 1,
		'mt' => 0,
		'mb' => 30,
		'bgcolor' => '',
		'linkbtn' => 0,
		'link' => '#',
		'btntype' => 'primary',
		'btnsize' => 'lg',
		'btnrounded' => 0,
		'btnborder' => 0,
		'link_target' => 0,
		'linktext' => get_string( 'readmore', 'theme_mb2nl' ),
		'color' => '',
		'image' => '',
		'type' => 1,
		'custom_class'=> ''
	), $atts));


	$output = '';
	$style = '';
	$btncls = '';
	$cls ='';


	$cls .= $custom_class ? ' ' . $custom_class: '';
	$cls .= ' type-' . $type;
	$cls .= ' linkbtn' . $linkbtn;
	$cls .= ' issubtitle' . $issubtitle;
	$cls .= $image !== '' ? ' lazy' : '';

	$target = $link_target ? ' target="_blank"' : '';

	$btncls .= ' type' . $btntype;
	$btncls .= ' size' . $btnsize;
	$btncls .= ' rounded' . $btnrounded;
	$btncls .= ' btnborder' . $btnborder;


	if ( $mt || $mb )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	}

	$bgData = $image !== '' ? ' data-bg="' . $image . '"' : '';
	$bgcolor_style = $bgcolor ? ' style="background-color:' . $bgcolor . ';"' : '';
	$color_style = $color ? ' style="color:' . $color . ';"' : '';

	$output .= '<div class="theme-header-wrap"' . $style . '>';
	$output .= '<div class="theme-header' . $cls . '"' . $bgData . '>';
	$output .= '<div class="theme-header-content">';
	$output .= '<div class="content-a">';
	$output .= $title ? '<h3 class="theme-header-title"' . $color_style . '>' . $title . '</h3>' : '';
	$output .= $subtitle ? '<div><div class="theme-header-subtitle"' . $color_style . '>' . $subtitle . '</div></div>' : '';
	$output .= '</div>';

	if ( $linkbtn )
	{
		$output .= '<div class="content-b">';
		$output .= '<a href="' . $link. '" class="mb2-pb-btn' . $btncls . '"' . $target . '><span class="btn-intext">' . $linktext . '</span></a>';
		$output .= '</div>';
	}

	$output .= '</div>';
	$output .= '<div class="theme-header-bg"' . $bgcolor_style . '></div>';
	$output .= '</div>';
	$output .= '</div>';


	return $output;


}
