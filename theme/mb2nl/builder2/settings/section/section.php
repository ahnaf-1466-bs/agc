<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('mb2pb_section', 'mb2_shortcode_mb2pb_section');

function mb2_shortcode_mb2pb_section ( $atts, $content = null )
{

	$atts2 = array(
		'id' => 'section',
		'size'=> '4',
		'margin' => '',
		'bgcolor' => '',
		'prbg' => 0,
		'scheme' => 'light',
		'bgimage' => '',
		//
		'bgel1' => '',
		'bgel2' => '',
		'bgel1s' => 500,
		'bgel2s' => 500,
		'bgel1top' => 200,
		'bgel2top' => 200,
		'bgel1left' => 0,
		'bgel2left' => 0,
		//
		'pt' =>0,
		'sectionhidden' => 0,
		'sectionlang' => '',
		'pb' => 0,
		'sectionaccess' => 0,
		'custom_class' => '',
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts));

	$output = '';
	$bg_image_style = $bgimage ? ' style="background-image:url(\'' . $bgimage . '\');"' : '';
	$cls = $custom_class ? ' ' . $custom_class : '';
	$cls .= ' pre-bg' . $prbg;
	$cls .= ' hidden' . $sectionhidden;
	$cls .= ' access' . $sectionaccess;
	$cls .= ' ' . $scheme;
	$cls .= $template ? ' mb2-pb-template-row' : '';

	$lang_arr = explode( ',', $sectionlang );
	$trimmed_lang_arr = array_map( 'trim', $lang_arr );

	$section_style = ' style="';
	$section_style .= 'padding-top:' . $pt . 'px;';
	$section_style .= 'padding-bottom:' . $pb . 'px;';
	$section_style .= $bgcolor ? 'background-color:' . $bgcolor . ';' : '';
	$section_style .= '"';

	$output .= '<div class="mb2-pb-section mb2-pb-fpsection' . $cls . '"' . $bg_image_style . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= theme_mb2nl_page_builder_el_actions( 'section', 'section', array( 'lang' => $trimmed_lang_arr ) );
	$output .= '<div class="section-inner mb2-pb-section-inner"' . $section_style . '>';
	$output .= '<div class="mb2-pb-sortable-rows">';
	$output .= mb2_do_shortcode( $content );
	$output .= '</div>'; // mb2-pb-sortable-rows

	$output .= '<div class="section-bgel-wrap">';
	$output .= '<div class="section-bgel-wrap2">';
	$output .= '<div class="section-bgel bgel1" style="width:' . $bgel1s . 'px;top:' . $bgel1top . 'px;left:' . $bgel1left . '%;"><img src="' . $bgel1 . '" alt=""></div>';
	$output .= '<div class="section-bgel bgel2" style="width:' . $bgel2s . 'px;top:' . $bgel2top . 'px;left:' . $bgel2left . '%;"><img src="' . $bgel2 . '" alt=""></div>';
	$output .= '</div>'; // section-bgel-wrap2
	$output .= '</div>'; // section-bgel-wrap

	$output .= '</div>'; // mb2-pb-section-inner
	$output .= '<div class="mb2-pb-addrow">';
	$output .= '<a href="#" class="mb2-pb-row-toggle" data-modal="#mb2-pb-modal-row-layout">&plus; ' . get_string('addrow','local_mb2builder') . '</a>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}
