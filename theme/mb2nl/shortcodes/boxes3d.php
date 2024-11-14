<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'boxes3d_item', 'mb2_shortcode_boxes3d_item' );

function mb2_shortcode_boxes3d_item( $atts, $content = null ){
	extract( mb2_shortcode_atts( array(
		'image' =>'',
		'link' =>'',
		'type' => '',
		'title' => 'Box title here',
		'link_target' => 0,
		'target' => 0,
		'frontcolor' => '',
		'backcolor' => ''
	), $atts ) );

	$output = '';
	$cls = '';
	$title_color_span = '';

	$link_target = $target ? $target : $link_target;
	$target =  $link_target ? ' target="_balnk"' : '';

	$stylefront = $frontcolor !== '' ? ' style="background-color:' . $frontcolor . ';"' : '';
	$styleback = $backcolor !== '' ? ' style="background-color:' . $backcolor . ';"' : '';

	$output .= '<div class="theme-box">';
	$output .= $link !== '' ? '<a href="' . $link . '"' . $target . '>' : '';
	$output .= '<div class="theme-box3d' . $cls . '">';
	$output .= '<div class="box-scene">';

	$output .= '<div class="box-face box-front">';
	$output .= '<div class="vtable-wrapp">';
	$output .= '<div class="vtable">';
	$output .= '<div class="vtable-cell">';
	$output .= '<h4 class="box-title"><span class="box-title-text">' . format_text( $title, FORMAT_HTML ) . '</span></h4>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '<img class="theme-box3d-img" src="' . $image . '" alt="">';
	$output .= '<div class="theme-box3d-color"' . $stylefront . '></div>';
	$output .= '</div>'; //box-front

	$output .= '<div class="box-face box-back">';
	$output .= '<div class="vtable-wrapp">';
	$output .= '<div class="vtable">';
	$output .= '<div class="vtable-cell">';
	$output .= '<div class="box-desc-text">' . format_text( $content, FORMAT_HTML ) . '</div>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '<div class="theme-box3d-color"' . $styleback . '></div>';
	$output .= '</div>'; //box-back

	$output .= '<img class="theme-box3d-img theme-box3d-imagenovisible lazy" src="' . theme_mb2nl_lazy_plc() . '" data-src="' . $image . '" alt="">';
	$output .= '</div>'; //box-scene
	$output .= '</div>';
	$output .= $link !== '' ? '</a>' : '';
	$output .= '</div>';

	return $output;

}
