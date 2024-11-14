<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('button', 'mb2_shortcode_button');

function mb2_shortcode_button($atts, $content= null){

	extract(mb2_shortcode_atts( array(
		'type' => 'default',
		'size' => '',
		'link' => '#',
		'target' => 0,
		'isicon' => 0,
		'icon'=> 'fa fa-play-circle-o',
		'upper' => 0,
		'fw' => 0,
		'fwcls' => 'medium',
		'lspacing' => 0,
		'wspacing' => 0,
		'rounded'=>0,
		'custom_class'=>'',
		'ml' => 0,
		'mr' => 0,
		'mt' => 0,
		'mb' => 15,
		'border'=>0,
		'margin' => '',
		'attribute'=>'',
		'center' => 0,
		//
		'color' => '',
		'bgcolor' => '',
		'borcolor' => '',
		'bghcolor' => '',
		'hcolor' => '',
		'borhcolor' => ''
	), $atts));

	$output = '';
	$style = '';
	$btncls = '';

	$iconpref = theme_mb2nl_font_icon_prefix($icon);
	$istarget = $target ? ' target="_blank"' : '';
	$dirmarginright = theme_mb2nl_isrtl() ? 'left' : 'right';
	$dirmarginleft = theme_mb2nl_isrtl() ? 'right' : 'left';

	// Define some button parameters
	$iconname = $icon;

	// Button icon and text
	$btnicon = $isicon ? '<span class="btn-incon" aria-hidden="true"><i class="' . $iconpref . $iconname . '"></i></span>' : '';
	$btntext = '<span class="btn-intext">' . $content . '</span>';

	// Define button css class
	$btncls .= ' type' . $type;
	$btncls .= ' size' . $size;
	$btncls .= ' rounded' . $rounded;
	$btncls .= ' btnborder' . $border;
	$btncls .= ' isicon' . $isicon;
	$btncls .= ' upper' . $upper;
	$btncls .= ' fw' . $fwcls;
	$btncls .= $custom_class ? ' ' . $custom_class : '';

	// Button style
	if (
		$ml ||
		$mr ||
		$mt ||
		$mb ||
		$lspacing != 0 ||
		$wspacing != 0 ||
		$margin ||
		$color ||
		$bgcolor ||
		$bghcolor ||
		$hcolor ||
		$borcolor ||
		$borhcolor
	)
	{
		$style .= ' style="';
		$style .= $margin ? 'margin:' . $margin . ';' : '';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= $ml ? 'margin-' . $dirmarginleft . ':' . $ml . 'px;' : '';
		$style .= $mr ? 'margin-' . $dirmarginright . ':' . $mr . 'px;' : '';
		$style .= $lspacing != 0 ? 'letter-spacing:' . $lspacing . 'px;' : '';
		$style .= $wspacing != 0 ? 'word-spacing:' . $wspacing . 'px;' : '';
		//
		$style .= $color ? '--mb2-pb-btn-color:' . $color . ';' : '';
		$style .= $bgcolor ? '--mb2-pb-btn-bgcolor:' . $bgcolor . ';' : '';
		$style .= $bghcolor ? '--mb2-pb-btn-bghcolor:' . $bghcolor . ';' : '';
		$style .= $hcolor ? '--mb2-pb-btn-hcolor:' . $hcolor . ';' : '';
		$style .= $borcolor ? '--mb2-pb-btn-borcolor:' . $borcolor . ';' : '';
		$style .= $borhcolor ? '--mb2-pb-btn-borhcolor:' . $borhcolor . ';' : '';
		//
		$style .= '"';
	}

	$output .= ( $center && ! $fw ) ? '<div style="text-align:center;" class="clearfix">' : '';
	$output .= '<a href="' . $link . '"' . $istarget . ' class="mb2-pb-btn' . $btncls . '"' . $style . '>';
	$output .= $btnicon . $btntext;
	$output .= '</a>';
	$output .= ( $center && ! $fw ) ? '</div>' : '';

	return $output;

}
