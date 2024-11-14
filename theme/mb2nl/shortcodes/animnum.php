<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'animnum', 'mb2_shortcode_animnum' );
mb2_add_shortcode( 'animnum_item', 'mb2_shortcode_animnum_item' );

function mb2_shortcode_animnum ( $atts, $content = null ){

	global $PAGE;

	extract( mb2_shortcode_atts( array(
		'columns' => 4, // max 5
		'mt' => 0,
		'mb' => 0, // 0 because box item has margin bottom 30 pixels
		'pv' => 30,
		'icon' => 0,
		'subtitle' => 0,
		'gutter' => 'normal',
		'aspeed' => 10000,
		'size_number' => 3,
		'size_title' => 1.44,
		//'fw_number' => 600,
		//'fweight_title' => 600,
		//'lh_title' => 1.2,
		'nfwcls' => 'global',
		'tfwcls' => 'global',
		'tlhcls' => 'global',
		'nopadding' => 0,
		'center' => 1,
		'size_icon' => 3,
		'color_icon' => '',
		'color_number' => '',
		'color_title' => '',
		'color_subtitle' => '',
		'color_bg' => '',
		'custom_class' => ''
	), $atts));

	$output = '';
	$cls = '';
	$style = '';

	$GLOBALS['size_number'] = $size_number;
	$GLOBALS['size_icon'] = $size_icon;
	$GLOBALS['color_icon'] = $color_icon;
	$GLOBALS['color_number'] = $color_number;
	$GLOBALS['color_title'] = $color_title;
	$GLOBALS['color_subtitle'] = $color_subtitle;
	$GLOBALS['color_bg'] = $color_bg;
	$GLOBALS['animnumicon'] = $icon;
	$GLOBALS['animnumsubtitle'] = $subtitle;
	$GLOBALS['animnumpv'] = $pv;
	//$GLOBALS['animnufw_number'] = $fw_number;
	//$GLOBALS['fweight_title'] = $fweight_title;
	//$GLOBALS['lh_title'] = $lh_title;
	//$GLOBALS['lh_title'] = $lh_title;
	$GLOBALS['size_title'] = $size_title;
	$GLOBALS['nfwcls'] = $nfwcls;
	$GLOBALS['tlhcls'] = $tlhcls;
	$GLOBALS['tfwcls'] = $tfwcls;

	$cls .= ' gutter-' . $gutter;
	$cls .= ' theme-col-' . $columns;
	$cls .= ' center' . $center;
	$cls .= ' nopadding' . $nopadding;
	$cls .= $custom_class ? ' ' . $custom_class : '';

	if ( $mt || $mb )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	}

	$output .= '<div class="mb2-pb-animnum theme-boxes' . $cls . ' clearfix" data-aspeed="' . $aspeed . '"' . $style . '>';
	$output .= mb2_do_shortcode( $content );
	$output .= '</div>';

	//$PAGE->requires->js_call_amd( 'theme_mb2nl/animnum','animnumInit' );

	unset( $GLOBALS['size_number'] );
	unset( $GLOBALS['size_icon'] );
	unset( $GLOBALS['color_icon'] );
	unset( $GLOBALS['color_number'] );
	unset( $GLOBALS['color_title'] );
	unset( $GLOBALS['color_subtitle'] );
	unset( $GLOBALS['color_bg'] );
	unset( $GLOBALS['animnumicon'] );
	unset( $GLOBALS['animnumsubtitle'] );
	unset( $GLOBALS['animnumpv'] );
	unset( $GLOBALS['animnufw_number'] );
	unset( $GLOBALS['fweight_title'] );
	unset( $GLOBALS['lh_title'] );
	unset( $GLOBALS['size_title'] );

	return $output;

}





function mb2_shortcode_animnum_item ($atts, $content = null){
	extract(mb2_shortcode_atts( array(
		'number' => 0,
		'icon' => 'fa fa-graduation-cap',
		'title' => '',
		'color_icon' => '',
		'color_number' => '',
		'color_title' => '',
		'color_subtitle' => '',
		'color_bg' => '',
		'subtitle' => '',
	), $atts));

	$output = '';
	$con_pref = theme_mb2nl_font_icon_prefix( $icon );
	$size_number = isset( $GLOBALS['size_number'] ) ? $GLOBALS['size_number'] : 3;
	$size_icon = isset( $GLOBALS['size_icon'] ) ? $GLOBALS['size_icon'] : 3;
	$color_icon_style = '';
	$color_number_style = '';
	$color_title_style = '';
	$color_subtitle_style = '';
	$color_bg_style = '';
	$tcls = '';
	$ncls = '';

	$ncls .= ' fw' . $GLOBALS['nfwcls'];
	$tcls .= ' fw' . $GLOBALS['tfwcls'];
	$tcls .= ' lh' . $GLOBALS['tlhcls'];

	if ($color_icon || $GLOBALS['color_icon'])
	{
		$color = $color_icon ? $color_icon : $GLOBALS['color_icon'];
		$color_icon_style = 'color:' . $color . ';';
	}

	if ( $color_number || $GLOBALS['color_number'] )
	{
		$color = $color_number ? $color_number : $GLOBALS['color_number'];
		$color_number_style = 'color:' . $color . ';';
	}

	if ($color_title || $GLOBALS['color_title'] || $GLOBALS['size_title'] )
	{
		$color = $color_title ? $color_title : $GLOBALS['color_title'];
		$color_title_style .= ' style="';
		$color_title_style .= 'color:' . $color . ';';
		$color_title_style .= 'font-size:' . $GLOBALS['size_title'] . 'rem;';
		//$color_title_style .= 'font-weight:' . $GLOBALS['fweight_title'] . ';';
		//$color_title_style .= 'line-height:' . $GLOBALS['lh_title'] . ';';
		$color_title_style .= '"';
	}

	if ($color_subtitle || $GLOBALS['color_subtitle'])
	{
		$color = $color_subtitle ? $color_subtitle : $GLOBALS['color_subtitle'];
		$color_subtitle_style = ' style="color:' . $color . ';"';
	}

	if ( $color_bg || $GLOBALS['color_bg'] || $GLOBALS['animnumpv'] )
	{
		$color = $color_bg ? $color_bg : $GLOBALS['color_bg'];

		$color_bg_style .= ' style="';
		$color_bg_style .= $color ? 'background-color:' . $color . ';' : '';

		if ( $GLOBALS['animnumpv'] )
		{
			$color_bg_style .= 'padding-top:' . $GLOBALS['animnumpv'] . 'px;';
			$color_bg_style .= 'padding-bottom:' . $GLOBALS['animnumpv'] . 'px;';
		}

		$color_bg_style .= '"';
	}

	$output .= '<div class="theme-box">';
	$output .= '<div class="pbanimnum-item"' . $color_bg_style . ' data-number="' . $number . '">';

	if ( $GLOBALS['animnumicon'] )
	{
		$output .= '<div class="pbanimnum-icon" style="font-size:' . $size_icon. 'rem;' . $color_icon_style . '"><i class="' . $con_pref . $icon . '"></i></div>';
	}

	$output .= '<span class="pbanimnum-number' . $ncls . '" style="font-size:' . $size_number . 'rem;' . $color_number_style . '" aria-label="' . $number . '">0</span>';

	$output .= '<div class="pbanimnum-text">';
	$output .= $title ? '<h4 class="pbanimnum-title' . $tcls . '"' . $color_title_style . '>' . $title . '</h4>' : '';
	$output .= $GLOBALS['animnumsubtitle'] ? '<span class="pbanimnum-subtitle"' . $color_subtitle_style . '>' . $subtitle . '</span>' : '';
	$output .= '</div>';

	$output .= '</div>';
	$output .= '</div>';

	return $output;

}
