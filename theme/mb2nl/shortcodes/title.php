<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('title', 'mb2_shortcode_title');


function mb2_shortcode_title ($atts, $content= null){

	extract(mb2_shortcode_atts( array(
		'tag'=> 'h4',
		'align' =>'none',
		'issubtext' => 0,
		'subtext' => '',
		'size' => 'n',
		'sizerem' => 2,
		'color' => '',
		//'fweight' => 600,
		'fwcls' => 'global',
		'lhcls' => 'global',
		'lspacing' => 0,
		'wspacing' => 0,
		'upper' => 0,
		'style' => 1,
		'mt' => 0,
		'mb' => 30,
		'custom_class'=> ''
	), $atts));

	$output = '';
	$cstyle = '';
	$tstyle = '';
	$cls = '';
	$tcls = '';

	$cls .= $custom_class ? ' ' . $custom_class : '';
	$cls .= ' title-' . $align;
	$cls .= ' title-' . $size;
	$cls .= ' style-' . $style;

	$tcls .= ' upper' . $upper;
	$tcls .= ' fw' . $fwcls;
	$tcls .= ' lh' . $lhcls;
	$tcls .= ' ' . theme_mb2nl_heading_cls( $sizerem );

	if ( $mt || $mb )
	{
		$cstyle .= ' style="';
		$cstyle .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$cstyle .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$cstyle .= '"';
	}

	if ( $sizerem || $color || $lspacing != 0 || $wspacing != 0 )
	{
		$tstyle .= ' style="';
		$tstyle .= 'font-size:' . $sizerem . 'rem;';
		//$tstyle .= 'font-weight:' . $fweight . ';';
		$tstyle .= $lspacing != 0 ? 'letter-spacing:' . $lspacing . 'px;' : '';
		$tstyle .= $wspacing != 0 ? 'word-spacing:' . $wspacing . 'px;' : '';
		$tstyle .= $color ? 'color:' . $color . ';' : '';
		$tstyle .= '"';
	}

	$output .= '<div class="theme-title' . $cls . '"' . $cstyle . '>';
	$output .= '<' . $tag . ' class="title' . $tcls . '"' . $tstyle . '><span>';
	$output .= format_text( $content, FORMAT_HTML );
	$output .= '</span></' . $tag . '>';
	$output .= ( $issubtext && $subtext ) ? '<span class="title-subtext">' . $subtext . '</span>' : '';
	$output .= '</div>';

	return $output;


}
