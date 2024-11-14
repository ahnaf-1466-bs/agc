<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('heading', 'mb2_shortcode_heading');

function mb2_shortcode_heading ( $atts, $content = null ){

	global $PAGE;

	extract(mb2_shortcode_atts( array(
		'tag'=> 'h4',
		'size' => 2.4,
		'align' =>'none',
		//'fweight' => 600,
		'fwcls' => 'global',
		'lhcls' => 'global',
		'lspacing' => 0,
		'wspacing' => 0,
		'upper' => 0,
		'mt' => 0,
		'mb' => 30,
		'width' => 2000,
		//
		'btext' => '',
		'atext' => '',
		'color' => '',
		'acolor' => '',
		'bcolor' => '',
		'afwcls' => 'global',
		'bfwcls' => 'global',
		'nline' => 0,
		//
		'typed' => 0,
		'typespeed' => 50,
		'backspeed' => 50,
		'backdelay' => 1500,
		'typedtext' => 'first word|second word|third word',
		//
		'color' => '',
		'custom_class'=> ''
	), $atts));

	$output = '';
	$style = '';
	$typeddata = '';
	$astyle = '';
	$bstyle = '';
	$textstyle = '';
	$acls = '';
	$bcls = '';
	$textcls = '';
	$typedid = uniqid('typed_');

	$cls = $custom_class !='' ? ' ' . $custom_class : '';
	$cls .= ' heading-' . $align;
	$cls .= ' upper' . $upper;
	$cls .= ' fw' . $fwcls;
	$cls .= ' lh' . $lhcls;
	$cls .= ' ' . theme_mb2nl_heading_cls( $size );

	$acls .= ' fw' . $afwcls;
	$bcls .= ' fw' . $bfwcls;
	$textcls .= ' fw' . $fwcls;
	$textcls .= ' nline' . $nline;

	// Style for heading element
	$style .= ' style="';
	$style .= 'margin-top:' . $mt . 'px;';
	$style .= 'margin-bottom:' . $mb . 'px;';
	$style .= 'max-width:' . $width . 'px;margin-left:auto;margin-right:auto;';
	$style .= $lspacing != 0 ? 'letter-spacing:' . $lspacing . 'px;' : '';
	$style .= $wspacing != 0 ? 'word-spacing:' . $wspacing . 'px;' : '';
	$style .= $size ? 'font-size:' . $size . 'rem;' : '';
	$style .= '"';

	// Style for after heading element
	if ( $acolor )
	{
		$astyle .= ' style="';
		$astyle .= 'color:' . $acolor . ';';
		$astyle .= '"';
	}

	// Style for before heading element
	if ( $bcolor )
	{
		$bstyle .= ' style="';
		$bstyle .= 'color:' . $bcolor . ';';
		$bstyle .= '"';
	}

	// Style for text heading element
	if ( $color )
	{
		$textstyle .= ' style="';
		$textstyle .= 'color:' . $color . ';';
		$textstyle .= '"';
	}

	if ( $typed )
	{
		$typeddata .= ' data-typespeed="' . $typespeed . '"';
		$typeddata .= ' data-backspeed="' . $backspeed . '"';
		$typeddata .= ' data-backdelay="' . $backdelay . '"';
		$typeddata .= ' data-typedtext="' . $typedtext . '"';
	}

	$output .= '<' . $tag . $style . $typeddata . ' id="' . $typedid . '" class="heading' . $cls . '">';
	$output .= $btext ? '<span class="btext' . $bcls . '"' . $bstyle . '>' . format_text( $btext, FORMAT_HTML ) . '</span>' : '';
	$output .= '<span class="headingtext' . $textcls . '"' . $textstyle . '>';
	$output .= $typed ? theme_mb2nl_typed_content( format_text( $content, FORMAT_HTML ), $typedtext) : format_text( $content, FORMAT_HTML );
	$output .= '</span>';
	$output .= $atext ? '<span class="atext' . $acls . '"' . $astyle . '>' . format_text( $atext, FORMAT_HTML ) . '</span>' : '';
	$output .= '</' . $tag . '>';

	return $output;

}
