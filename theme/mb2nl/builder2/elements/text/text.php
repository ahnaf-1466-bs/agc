<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'mb2pb_text', 'mb2_shortcode_mb2pb_text' );

function mb2_shortcode_mb2pb_text( $atts, $content = null ){

	$atts2 = array(
		'id' => 'text',
		'align' => 'none',
		'size' => 'n',
		'sizerem' => 1,
		'color' => '',
		'showtitle' => 0,
		//'fweight' => 400,
		//'lh' => 1.7,
		'fwcls' => 'global',
		'lhcls' => 'global',
		'lspacing' => 0,
		'wspacing' => 0,
		'tupper' => 0,
		//'tfw' => 600,
		//'tlh' => 1.2,
		'tfwcls' => 'global',
		'tlhcls' => 'global',
		'tlspacing' => 0,
		'twspacing' => 0,
		'tsizerem' => 1.4,
		'tcolor' => '',
		'upper' => 0,
		'title' => 'Title text',
		'bgcolor' => '',
		'mt' => 0,
		'mb' => 30,
		'pv' => 0,
		'ph' => 0,
		'tmb'=> 30,
		'width' => 2000,
		'rounded' => 0,
		'gradient' => 0,
		//
		'button' => 0,
		'btype' => 'primary',
		'bsize' => 'normal',
		'link' => '#',
		'target' => 0,
		'brounded' => 0,
		'bmt' => 0,
		'bborder' => 0,
		'btext' => "Read more",
		'bfwcls' => 'global',
		//
		'scheme' => 'light',
		'custom_class'=> '',
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$style = '';
	$innerstyle = '';
	$typostyle = '';
	$typosttyle = '';
	$fontcls = '';
	$titlecls = '';
	$btncls = '';

	$cls = $custom_class ? ' ' . $custom_class : '';
	$cls .= ' align-' . $align;
	$cls .= ' text-' . $color;
	$cls .= ' title' . $showtitle;
	$cls .= ' button' . $button;
	$cls .= ' rounded' . $rounded;
	$cls .= ' gradient' . $gradient;
	$cls .= ' ' . $scheme;

	$templatecls = $template ? ' mb2-pb-template-text' : '';

	$fontcls .= ' ' . theme_mb2nl_heading_cls( $sizerem, 'textsize-' );
	$fontcls .= ' upper' . $upper;
	$fontcls .= ' fw' . $fwcls;
	$fontcls .= ' lh' . $lhcls;

	$titlecls .= ' upper' . $tupper;
	$titlecls .= ' fw' . $tfwcls;
	$titlecls .= ' lh' . $tlhcls;

	// Make content default text
	$content = ! $content ? '<p>Element content here.</p>' : $content;
	$atts2['content'] = $content;

	$btncls .= ' type' . $btype;
	$btncls .= ' size' . $bsize;
	$btncls .= ' rounded' . $brounded;
	$btncls .= ' btnborder' . $bborder;
	$btncls .= ' fw' . $bfwcls;

	// Text container style
	$style .= ' style="';
	$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
	$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
	$style .= 'max-width:' . $width . 'px;margin-left:auto;margin-right:auto;';
	$style .= '"';

	$innerstyle .= ' style="';
	$innerstyle .= $pv ? 'padding-top:' . $pv . 'px;' : '';
	$innerstyle .= $pv ? 'padding-bottom:' . $pv . 'px;' : '';
	$innerstyle .= $ph ? 'padding-left:' . $ph . 'px;' : '';
	$innerstyle .= $ph ? 'padding-right:' . $ph . 'px;' : '';
	$innerstyle .= $bgcolor ? 'background-color:' . $bgcolor . ';' : '';
	$innerstyle .= '"';

	$typostyle .= ' style="';
	$typostyle .= $color ? 'color:' . $color . ';' : '';
	//$typostyle .= $fweight ? 'font-weight:' . $fweight . ';' : '';
	//$typostyle .= 'line-height:' . $lh . ';';
	$typostyle .= $lspacing != 0 ? 'letter-spacing:' . $lspacing . 'px;' : '';
	$typostyle .= $wspacing != 0 ? 'word-spacing:' . $wspacing . 'px;' : '';
	$typostyle .= $sizerem ? 'font-size:' . $sizerem . 'rem;' : '';
	$typostyle .= '"';

	$typosttyle .= ' style="';
	$typosttyle .= $tcolor ? 'color:' . $tcolor . ';' : '';
	//$typosttyle .= 'font-weight:' . $tfw . ';';
	//$typosttyle .= 'line-height:' . $tlh . ';';
	$typosttyle .= 'letter-spacing:' . $tlspacing . 'px;';
	$typosttyle .= 'word-spacing:' . $twspacing . 'px;';
	$typosttyle .= 'font-size:' . $tsizerem . 'rem;';
	$typosttyle .= 'margin-bottom:' . $tmb . 'px;';
	$typosttyle .= '"';

	$output .= '<div class="theme-text mb2-pb-element mb2pb-text' . $templatecls . '"' . $style . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'text' );
	$output .= '<div class="theme-text-inner' . $cls . '"' . $innerstyle . '>';
	$output .= '<h4 class="theme-text-title' . $titlecls . '"'. $typosttyle .'>' . $title . '</h4>';
	$output .= '<div class="theme-text-text' . $fontcls . '"' . $typostyle . '>';
	$output .= urldecode( $content );
	$output .= '</div>';
	$output .= '<div class="theme-text-button" style="padding-top:' . $bmt . 'px;">';
	$output .= '<a href="#" class="mb2-pb-btn' . $btncls . '">' . $btext . '</a>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;


}
