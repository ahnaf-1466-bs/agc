<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('mb2pb_boxesimg', 'mb2_shortcode_mb2pb_boxesimg');
mb2_add_shortcode('mb2pb_boxesimg_item', 'mb2_shortcode_mb2pb_boxesimg_item');

function mb2_shortcode_mb2pb_boxesimg ($atts, $content= null){

	$atts2 = array(
		'id' => 'boxesimg',
		'columns' => 2, // max 5
		'type' => 1,
		'mt' => 0,
		'mb' => 0, // 0 because box item has margin bottom 30 pixels
		'custom_class' => '',
		'desc' => 0,
		'rounded' => 0,
		//
		'tfs' => 1.4,
		//
		'linkbtn' => 0,
		'btntype' => 'primary',
		'btnsize' => 'normal',
		'btnfwcls' => 'global',
		'btnrounded' => 0,
		'btnborder' => 0,
		'btntext' => '',
		'imgwidth' => 800,
		//
		'gutter' => 'normal',
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$style = '';
	$cls = '';

	$cls .= ' type-' . $type;
	$cls .= ' gutter-' . $gutter;
	$cls .= ' desc' . $desc;
	$cls .= ' rounded' . $rounded;
	$cls .= ' linkbtn' . $linkbtn;
	$cls .= ' theme-col-' . $columns;
	$cls .= $custom_class ? ' ' . $custom_class : '';
	$templatecls = $template ? ' mb2-pb-template-boxesimg' : '';
	$GLOBALS['boximgbtntext'] = $btntext;
	$GLOBALS['boximgbtntype'] = $btntype;
	$GLOBALS['boximgbtnsize'] = $btnsize;
	$GLOBALS['boximgbtnfwcls'] = $btnfwcls;
	$GLOBALS['boximgbtnborder'] = $btnborder;
	$GLOBALS['boximgbtnrounded'] = $btnrounded;
	$GLOBALS['boximgimgwidth'] = $imgwidth;
	$GLOBALS['boximgimgtfs'] = $tfs;

	if ( $mt || $mb )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	}

	$content = $content;

	if ( ! $content )
	{
		$demoimage = theme_mb2nl_page_builder_demo_image( '1600x944' );

		for (  $i = 1; $i <= 2; $i++ )
		{
			$content .= '[mb2pb_boxesimg_item image="' . $demoimage . '" ]Box title here[/mb2pb_boxesimg_item]';
		}
	}

	$output .= '<div class="mb2-pb-element mb2-pb-boxesimg' . $templatecls . '"' . $style . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'boxesimg' );
	$output .= '<div class="mb2-pb-element-inner theme-boxes' . $cls . '">';
	$output .= '<div class="mb2-pb-sortable-subelements">';
	$output .= mb2_do_shortcode( $content );
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}


function mb2_shortcode_mb2pb_boxesimg_item($atts, $content = null){

	$atts2 = array(
		'id' => 'boxesimg_item',
		'image' => theme_mb2nl_page_builder_demo_image( '1600x944' ),
		'link' =>'',
		'description' => 'Box description here...',
		'link_target' => 0,
		'scheme' => 'dark',
		'el_onmobile' => 1,
		//'titlecolor' => '',
		//'desccolor' => '',
		'color' =>'',
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$cls = '';
	$wrap_cls = '';
	$title_color_span = '';

	$wrap_cls .= ' el_onmobile' . $el_onmobile;
	$cls .= ' ' . $scheme;

	$style = $color !== '' ? ' style="background-color:' . $color . ';"' : '';
	$title_color_span = '<span class="theme-boximg-color"' . $style . '></span>';

	$content = ! $content ? 'Box title here' : $content;
	$atts2['text'] = $content;

	$output .= '<div class="mb2-pb-subelement mb2-pb-boxesimg_item theme-box' . $wrap_cls . '"' . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= theme_mb2nl_page_builder_el_actions( 'subelement' );
	$output .= '<div class="subelement-helper"></div>';
	$output .= '<div class="mb2-pb-subelement-inner">';
	$output .= '<div class="theme-boximg' . $cls . '">';

	$output .= '<div class="box-allcontent">';
	$output .= '<div class="box-image">';
	$output .= '<img class="theme-boximg-img" src="' . $image . '" alt="" style="max-width:' . $GLOBALS['boximgimgwidth'] . 'px;">';
	$output .= '</div>'; // box-image
	$output .= '<div class="vtable-wrapp">';
	$output .= '<div class="vtable">';
	$output .= '<div class="vtable-cell">';
	$output .= '<div class="box-content">';
	$output .= '<h4 class="box-title" style="font-size:' . $GLOBALS['boximgimgtfs'] . 'rem;"><span class="box-title-text">' . urldecode( $content ) . '</span></h4>';
	$output .= '<div class="box-desc">' . $description . '</div>';
	$output .= $title_color_span;

	$btntext = $GLOBALS['boximgbtntext'] ? $GLOBALS['boximgbtntext'] : get_string( 'readmorefp', 'local_mb2builder' );
	$output .= '<div class="box-readmore">';
	$output .= '<a href="#" class="arrowlink">' . $btntext . '</a>';
	$output .= '<a href="#" class="mb2-pb-btn type' . $GLOBALS['boximgbtntype'] . ' size' . $GLOBALS['boximgbtnsize'] . ' rounded' . $GLOBALS['boximgbtnrounded'] . ' btnborder' . $GLOBALS['boximgbtnborder'] . ' fw' . $GLOBALS['boximgbtnfwcls'] . '">' . $btntext . '</a>';
	$output .= '</div>'; // theme-boxicon-readmore
	$output .= '</div>'; // box-content
	$output .= '</div>'; // vtable-cell
	$output .= '</div>'; // vtable
	$output .= '</div>'; // vtable-wrapp
	$output .= '</div>'; // box-allcontent
	$output .= '<div class="theme-boximg-color"' . $style . '></div>';
	$output .= '<div class="theme-boximg-imgel" style="background-image:url(\'' . $image . '\');"><div class="gradient-el gradient-left" style="background-image: linear-gradient(to right,' . $color . ',rgba(255,255,255,0));"></div><div class="gradient-el gradient-right" style="background-image: linear-gradient(to right,rgba(255,255,255,0),' . $color . ');"></div></div>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}
