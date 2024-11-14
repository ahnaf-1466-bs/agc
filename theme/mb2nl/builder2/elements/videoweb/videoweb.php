<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'mb2pb_videoweb', 'mb2_shortcode_mb2pb_videoweb' );

function mb2_shortcode_mb2pb_videoweb( $atts, $content = null )
{
	global $PAGE;

	$atts2 = array(
		'id' => 'videoweb',
		'width' => 800,
		'videourl' => 'https://youtu.be/3ORsUGVNxGs',
		'video_text' => '',
		'ratio'=> '16:9',
		'mt' => 0,
		'mb' => 30,
		'custom_class' => '',
		'bgimage' => 0,
		'bgimageurl' => theme_mb2nl_page_builder_demo_image( '1600x1066' ),
		'iconcolor' => '',
		'bgcolor' => '',
		'template' => ''
	);

	$atts['id'] = $atts2['id'];

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$style = '';
	$bgstyle = '';
	$bgstyle2 = '';
	$cls = '';

	$cls .= $template ? ' mb2-pb-template-videoweb' : '';
	$cls .= $bgimage ? ' isimage1' : ' isimage0';
	$cls .= $custom_class ? ' ' . $custom_class : '';

	$videourl = theme_mb2nl_get_video_url( $videourl );

	$isratio = str_replace(':', 'by', $ratio);

	if ( $mt || $mb || $width )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= $width ? 'max-width:' . $width .'px;' : '';
		$style .= '"';
	}

	$bgstyle .= ' style="';
	$bgstyle .= 'background-image:url(\'' . $bgimageurl . '\');';
	$bgstyle .= '"';

	$bgstyle2 .= ' style="';
	$bgstyle2 .= 'background-color:' . $bgcolor . ';';
	$bgstyle2 .= '"';

	$output .= '<div class="embed-responsive-wrap mb2-pb-element mb2pb-videoweb' . $cls . '"' . $style . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'videoweb' );
	$output .= '<div class="embed-responsive-wrap-inner">';
	$output .= '<div class="embed-responsive embed-responsive-'. $isratio . '">';
	$output .= '<div class="embed-video-bg"' . $bgstyle . '><i class="fa fa-play" style="color:' . $iconcolor . ';border-color:' . $iconcolor . ';"></i><div class="bgcolor"' . $bgstyle2 . '></div></div>';
	$output .= '<iframe class="videowebiframe" src="' . $videourl . '?showinfo=0&rel=0" allowfullscreen></iframe>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	//$output .= '<div>';
	//$output .= '<span class="mb2pb-modal-video" data-toggle="modal" data-target="#header-modal-video" data-src="' . $videourl . '?showinfo=0&rel=0">sdsdsds</span>';
	//$output .= '</div>';///

	////$PAGE->requires->js_call_amd('theme_mb2nl/modalvideo','openVideo');
	//$output .= mb2_shortcode_mb2pb_video_modal();

	return $output;

}


function mb2_shortcode_mb2pb_video_modal()
{
	$output = '';


	$output .= '<div id="header-modal-video" class="modal theme-modal-scale" role="dialog">';
	$output .= '<div class="modal-dialog" role="document">';
	$output .= '<div class="modal-content">';
	$output .= '<div class="theme-modal-container">';
	$output .= '<span class="close-container" data-dismiss="modal">&times;</span>';

	$output .= '<div class="embed-responsive-wrap-inner">';
	$output .= '<div class="embed-responsive embed-responsive-16by9">';
	$output .= '<iframe class="videowebiframe" src="" allowfullscreen></iframe>';
	$output .= '</div>'; // embed-responsive-wrap-inner
	$output .= '</div>'; // embed-responsive

	$output .= '</div>'; // theme-modal-container
	$output .= '</div>'; // modal-content
	$output .= '</div>'; // modal-dialog
	$output .= '</div>'; // theme-modal-scale

	return $output;

}
