<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'text', 'mb2_shortcode_text' );

function mb2_shortcode_text ( $atts, $content = null ){

	extract(mb2_shortcode_atts( array(
		'align' => 'none',
		'size' => 'n',
		'sizerem' => 1,
		//'fweight' => 400,
		'fwcls' => 'global',
		'lhcls' => 'global',
		'lspacing' => 0,
		'wspacing' => 0,
		//
		'tupper' => 0,
		//'tfw' => 600,
		//'tlh' => 1.2,
		'tfwcls' => 'global',
		'tlhcls' => 'global',
		'tlspacing' => 0,
		'twspacing' => 0,
		'tsizerem' => 1.4,
		'tcolor' => '',
		//
		'color' => '',
		'showtitle' => 0,
		'upper' => 0,
		//'lh' => 1.7,
		'title' => '',
		'width' => 2000,
		'rounded' => 0,
		'mt' => 0,
		'mb' => 30,
		'pv' => 0,
		'ph' => 0,
		'tmb'=> 30,
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
		'bgcolor' => '',
		'scheme' => 'light',
		'custom_class'=> ''
	), $atts));

	$output = '';
	$style = '';
	$typostyle = '';
	$fontcls = '';
	$cls = '';
	$typosttyle = '';
	$titlecls = '';
	$btncls = '';
	$style_inner = '';

	$link_target = $target ? ' target="_blank"' : '';

	//$filteropt = new stdClass;
	//$filteropt->overflowdiv = true;
	//$filteropt->noclean = true;

	$cls .= $custom_class ? ' ' . $custom_class : '';
	$cls .= ' align-' . $align;
	$cls .= ' text-' . $color;
	$cls .= ' rounded' . $rounded;
	$cls .= ' gradient' . $gradient;
	$cls .= ' ' . $scheme;

	$fontcls .= ' ' . theme_mb2nl_heading_cls( $sizerem, 'textsize-' );
	$fontcls .= ' upper' . $upper;
	$fontcls .= ' fw' . $fwcls;
	$fontcls .= ' lh' . $lhcls;

	$titlecls .= ' upper' . $tupper;
	$titlecls .= ' fw' . $tfwcls;
	$titlecls .= ' lh' . $tlhcls;

	// Text container style
	$style .= ' style="';
	$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
	$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
	$style .= 'max-width:' . $width . 'px;margin-left:auto;margin-right:auto;';
	$style .= '"';


	$style_inner .= ' style="';
	$style_inner .= $pv ? 'padding-top:' . $pv . 'px;' : '';
	$style_inner .= $pv ? 'padding-bottom:' . $pv . 'px;' : '';
	$style_inner .= $ph ? 'padding-left:' . $ph . 'px;' : '';
	$style_inner .= $ph ? 'padding-right:' . $ph . 'px;' : '';
	$style_inner .= $bgcolor ? 'background-color:' . $bgcolor . ';' : '';
	$style_inner .= '"';

	$btncls .= ' type' . $btype;
	$btncls .= ' size' . $bsize;
	$btncls .= ' rounded' . $brounded;
	$btncls .= ' btnborder' . $bborder;
	$btncls .= ' fw' . $bfwcls;

	$typostyle .= ' style="';
	$typostyle .= $color ? 'color:' . $color . ';' : '';
	//$typostyle .= $fweight ? 'font-weight:' . $fweight . ';' : '';
	$typostyle .= $lspacing != 0 ? 'letter-spacing:' . $lspacing . 'px;' : '';
	$typostyle .= $wspacing != 0 ? 'word-spacing:' . $wspacing . 'px;' : '';
	//$typostyle .= 'line-height:' . $lh . ';';
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

	$output .= '<div class="theme-text"' . $style . '>';
	$output .= '<div class="theme-text-inner' . $cls . '"' . $style_inner . '>';
	$output .= ( $showtitle && $title ) ? '<h4 class="theme-text-title' . $titlecls . '"' . $typosttyle . '>' . format_text( $title, FORMAT_HTML ) . '</h4>' : '';
	$output .= '<div class="theme-text-text' . $fontcls . '"' . $typostyle . '>';
	$output .= format_text( $content, FORMAT_HTML );
	$output .= '</div>';

	if ( $button )
	{
		$output .= '<div class="theme-text-button" style="padding-top:' . $bmt . 'px;">';
		$output .= '<a href="' . $link . '" class="mb2-pb-btn' . $btncls . '"' . $link_target . '>' . $btext . '</a>';
		$output .= '</div>';
	}

	$output .= '</div>';
	$output .= '</div>';

	return $output;

}
