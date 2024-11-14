<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'boxesimg_item', 'mb2_shortcode_boxesimg_item' );
mb2_add_shortcode( 'boximg', 'mb2_shortcode_boxesimg_item' ); // This is old shortcode

function mb2_shortcode_boxesimg_item( $atts, $content = null ){
	extract( mb2_shortcode_atts( array(
		'image' =>'',
		'link' =>'',
		'type' => '',
		'link_target' => 0,
		'target' => 0,
		'description' => 'Box description here...',
		'link_target' => 0,
		'el_onmobile' => 1,
		'scheme' => 'dark',
		'color' =>'',
		'useimg' => 1
	), $atts ) );

	$output = '';
	$cls = '';
	$wrap_cls = '';
	$btncls = '';
	$title_color_span = '';

	//$cls .= preg_match( '@#@', $color ) || preg_match( '@rgb\(@', $color ) ? ' opcolor' : '';
	$cls .= preg_match( '@#@', $color ) ? ' opcolor' : '';
	$cls .= ' ' . $scheme;

	$wrap_cls .= ' el_onmobile' . $el_onmobile;

	$btncls .= ' type' . $GLOBALS['boxlinkbtntype'];
	$btncls .= ' size' . $GLOBALS['boxlinkbtnsize'];
	$btncls .= ' rounded' . $GLOBALS['boxlinkbtnrounded'];
	$btncls .= ' btnborder' . $GLOBALS['boxlinkbtnborder'];
	$btncls .= ' fw' . $GLOBALS['boxlinkbtnfwcls'];

	$link_target = $target ? $target : $link_target;
	$target =  $link_target ? ' target="_blank"' : '';

	$style = $color !== '' ? ' style="background-color:' . $color . ';"' : '';
	$title_color_span = '<span class="theme-boximg-color"' . $style . '></span>';

	$boxCls = $useimg == 1 ? ' useimg' : '';

	$output .= '<div class="theme-box' . $wrap_cls . '">';
	$output .= '<div class="theme-boximg' . $cls . '">';

	$output .= '<div class="box-allcontent">';
	$output .= '<div class="box-image">';
	$output .= $link !== '' ? '<a class="theme-boximg-img-link" href="' . $link . '"' . $target . ' tabindex="-1">' : '';
	$output .= '<img class="theme-boximg-img lazy" src="' . theme_mb2nl_lazy_plc() . '" data-src="' . $image . '" alt="" style="max-width:' . $GLOBALS['boximgwidth'] . 'px;">';
	$output .= $link !== '' ? '</a>' : '';
	$output .= '</div>'; // Box image

	$output .= '<div class="vtable-wrapp">';
	$output .= '<div class="vtable">';
	$output .= '<div class="vtable-cell">';
	$output .= '<div class="box-content">';
	$output .= '<h4 class="box-title" style="font-size:' . $GLOBALS['boxtfs'] . 'rem;">';
	$output .= $link !== '' ? '<a href="' . $link . '"' . $target . ' tabindex="-1">' : '';
	$output .= '<span class="box-title-text">' . format_text( $content, FORMAT_HTML ) . '</span>';
	$output .= $link !== '' ? '</a>' : '';
	$output .= '</h4>';

	$output .= $GLOBALS['boxdesc'] ? '<div class="box-desc">' . format_text( $description, FORMAT_HTML ) . '</div>' : '';
	$output .= $title_color_span;

	if ( $GLOBALS['boxlinkbtn'] )
	{
		$btntext = $GLOBALS['boxbtntext'] ? $GLOBALS['boxbtntext'] : get_string( 'readmorefp', 'local_mb2builder' );
		$output .= '<div class="box-readmore">';

		if ( $GLOBALS['boxlinkbtn'] == 2 )
		{
			$output .= '<a href="' . $link . '"' . $target . ' class="mb2-pb-btn' . $btncls . '" tabindex="-1">' . $btntext . '</a>';
		}
		else
		{
			$output .= '<a class="arrowlink" href="' . $link . '"' . $target . ' tabindex="-1">' . $btntext . '</a>';
		}

		$output .= '</div>'; // theme-boxicon-readmore
	}

	$output .= '</div>'; // box-content
	$output .= '</div>'; // vtable-cell
	$output .= '</div>'; // vtable
	$output .= '</div>'; // vtable-wrapp
	$output .= '</div>'; // Box all content
	$output .= '<div class="theme-boximg-color"' . $style . '></div>';
	$output .= '<div class="theme-boximg-imgel lazy" data-bg="' . $image . '"><div class="gradient-el gradient-left" style="background-image: linear-gradient(to right,' . $color . ',rgba(255,255,255,0));"></div><div class="gradient-el gradient-right" style="background-image: linear-gradient(to right,rgba(255,255,255,0),' . $color . ');"></div></div>';
	$output .= $link ? '<a class="linkabs" href="' . $link . '"' . $target . ' tabindex="0" aria-label="' . format_text( $content, FORMAT_HTML ) . '"></a>' : '';
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}
