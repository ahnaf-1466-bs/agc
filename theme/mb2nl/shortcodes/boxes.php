<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'boxes', 'mb2_shortcode_boxes' );
mb2_add_shortcode( 'boxesimg', 'mb2_shortcode_boxes' );
mb2_add_shortcode( 'boxes3d', 'mb2_shortcode_boxes' );
mb2_add_shortcode( 'boxesicon', 'mb2_shortcode_boxes' );
mb2_add_shortcode( 'boxescontent', 'mb2_shortcode_boxes' );

function mb2_shortcode_boxes( $atts, $content = null, $tag = '' ){
	extract( mb2_shortcode_atts( array(
		'columns' => 1, // max 5
		'type' => 1,
		'mt' => 0,
		'mb' => 0, // 0 because box item has margin bottom 30 pixels
		'boxmb' => 0,
		'gutter' => 'normal',
		'imgwidth' => 800,
		//
		'tfs' => 1.4,
		'tfw' => 'global',
		//
		'cwidth' => 2000,
		'btnhor' => 0,
		'padding' => 'm',
		'shadow' => 0,
		//
		'linkbtn' => 0,
		'btntype' => 'primary',
		'btnsize' => 'normal',
		'btnfwcls' => 'global',
		'btnrounded' => 0,
		'btnborder' => 0,
		'btntext' => '',
		//
		'smtitle' => 1,
		'wave' => 0,
		'height' => 0,
		'desc' => 1,
		'rounded' => 0,
		'color' => 'primary',
		'ccolor' => '',
		'custom_class' => ''

	), $atts ) );

	$output = '';
	$style = '';
	$cls = '';

	// Global values
	$GLOBALS['height'] = $height;
	$GLOBALS['boxlinkbtn'] = $linkbtn;
	$GLOBALS['boxbtntext'] = $btntext;
	$GLOBALS['boxlinkbtntype'] = $btntype;
	$GLOBALS['boxlinkbtnsize'] = $btnsize;
	$GLOBALS['boxlinkbtnrounded'] = $btnrounded;
	$GLOBALS['boxlinkbtnborder'] = $btnborder;
	$GLOBALS['boxlinkbtnfwcls'] = $btnfwcls;
	$GLOBALS['boxtype'] = $type;
	$GLOBALS['boxcolor'] = $color;
	$GLOBALS['boxccolor'] = $ccolor;
	$GLOBALS['boxdesc'] = $desc;
	$GLOBALS['boxmb'] = $boxmb;
	$GLOBALS['boxheight'] = $height;
	$GLOBALS['boximgwidth'] = $imgwidth;
	$GLOBALS['boxtfs'] = $tfs;
	$GLOBALS['boxtfw'] = $tfw;
	$GLOBALS['boxcwidth'] = $cwidth;

	$cls .= ' type-' . $type;
	$cls .= ' gutter-' . $gutter;
	$cls .= ' theme-col-' . $columns;
	$cls .= ' smtitle' . $smtitle;
	$cls .= ' rounded' . $rounded;
	$cls .= ' wave' . $wave;
	$cls .= ' padding' . $padding;
	$cls .= ' linkbtn' . $linkbtn;
	$cls .= ' btnhor' . $btnhor;
	$cls .= ' theme-' . $tag;
	$cls .= ' shadow' . $shadow;
	$cls .= $custom_class ? ' ' . $custom_class : '';

	if ( $mt || $mb )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	}

	$output .= '<div class="theme-boxes' . $cls . ' clearfix"' . $style . '>';
	$output .= mb2_do_shortcode( $content );
	$output .= '</div>';

	// Unset global values
	unset( $GLOBALS['boxlinkbtn'] );
	unset( $GLOBALS['boxlinkbtn'] );
	unset( $GLOBALS['boxbtntext'] );
	unset( $GLOBALS['boxlinkbtntype'] );
	unset( $GLOBALS['boxlinkbtnsize'] );
	unset( $GLOBALS['boxlinkbtnrounded'] );
	unset( $GLOBALS['boxlinkbtnborder'] );
	unset( $GLOBALS['boxlinkbtnfwcls'] );
	unset( $GLOBALS['boxtype'] );
	unset( $GLOBALS['boxcolor'] );
	unset( $GLOBALS['boxccolor'] );
	unset( $GLOBALS['boxdesc'] );
	unset( $GLOBALS['boxmb'] );
	unset( $GLOBALS['boxheight'] );
	unset( $GLOBALS['boximgwidth'] );
	unset( $GLOBALS['boxtfs'] );
	unset( $GLOBALS['boxtfw'] );
	unset( $GLOBALS['boxcwidth'] );

	return $output;

}




mb2_add_shortcode('boxcontent', 'mb2_shortcode_boxcontent');

function mb2_shortcode_boxcontent ($atts, $content = null){
	extract(mb2_shortcode_atts( array(
		'icon' =>'',
		'type' => '',
		'title'=> '',
		'link' =>'',
		'linktext' =>'Read more',
		'color' => 'primary',
		'link_target' =>'',
		'target' =>''
	), $atts));

	$output = '';
	$istarget = $target ? $target : $link_target;

	if ($type === '' && isset( $GLOBALS['boxtype'] ) )
	{
		$type = $GLOBALS['boxtype'];
	}

	$pref = theme_mb2nl_font_icon_prefix($icon);
	$boxCls = $icon !='' ? ' isicon' : ' noicon';
	$boxCls .= $link !='' ? ' islink' : '';

	$output .= '<div class="theme-box">';

	$output .= '<div class="theme-boxcontent type-' . $type . ' cboxcolor-' . $color . $boxCls . '">';
	$output .= '<div class="theme-boxcontent-content">';
	$output .=  $icon !='' ?'<div class="theme-boxcontent-icon">' : '';
	$output .=  $icon !='' ? '<i class="' . $pref . $icon . '"></i>' : '';
	$output .=  $icon !='' ?'</div>' : '';
	$output .= $title !='' ? '<h4>' . format_text($title, FORMAT_HTML) . '</h4>' : '';
	$output .= mb2_do_shortcode(format_text($content, FORMAT_HTML));
	$output .= $link !='' ? '<div class="theme-boxcontent-readmore"><a class="mb2-pb-btn sizesm" href="' .
	$link . '" target="' . $istarget . '">' . $linktext . '</a></div>' : '';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}
