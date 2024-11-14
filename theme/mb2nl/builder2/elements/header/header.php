<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('mb2pb_header', 'mb2_shortcode_mb2pb_header');

function mb2_shortcode_mb2pb_header ( $atts, $content= null ){

	$atts2 =  array(
		'id' => 'header',
		'title'=> 'Title text here',
		'issubtitle' => 1,
		'subtitle' => 'Subtitle text here',
		'bgcolor' => '',
		'linkbtn' => 0,
		'link' => '#',
		'btntype' => 'primary',
		'btnsize' => 'lg',
		'btnrounded' => 0,
		'btnborder' => 0,
		'link_target' => 0,
		'linktext' => get_string( 'readmorefp', 'local_mb2builder' ),
		'color' => '',
		'mt' => 0,
		'mb' => 30,
		'image' => theme_mb2nl_page_builder_demo_image( '2500x470' ),
		'type' => 'dark',
		'custom_class'=> '',
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$style = '';
	$cls = '';
	$btncls = '';

	$cls .= $custom_class ? ' ' . $custom_class: '';
	$cls .= ' type-' . $type;
	$cls .= ' linkbtn' . $linkbtn;
	$cls .= ' issubtitle' . $issubtitle;

	$btncls .= ' type' . $btntype;
	$btncls .= ' size' . $btnsize;
	$btncls .= ' rounded' . $btnrounded;
	$btncls .= ' btnborder' . $btnborder;

	$target = $link_target ? ' target="_blank"' : '';

	$tmplcls = $template ? ' mb2-pb-template-header' : '';

	if ( $mt || $mb )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	}

	$bgStyle = $image ? ' style="background-image:url(\'' . $image . '\');"' : '';
	$bgcolor_style = $bgcolor ? ' style="background-color:' . $bgcolor . ';"' : '';
	$color_style = $color ? ' style="color:' . $color . ';"' : '';

	$output .= '<div class="theme-header-wrap mb2-pb-element mb2pb-header' . $tmplcls . '"' . $style . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'header' );
	$output .= '<div class="theme-header' . $cls . '"' . $bgStyle . '>';
	$output .= '<div class="theme-header-content">';
	$output .= '<div class="content-a">';
	$output .= '<h3 class="theme-header-title"' . $color_style . '>' . $title . '</h3>';
	$output .= '<div><div class="theme-header-subtitle"' . $color_style . '>' . $subtitle . '</div></div>';
	$output .= '</div>';
	$output .= '<div class="content-b">';
	$output .= '<a href="#" class="mb2-pb-btn' . $btncls . '"><span class="btn-intext">' . $linktext . '</span></a>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '<div class="theme-header-bg"' . $bgcolor_style . '></div>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;


}
