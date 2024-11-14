<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'select', 'shortcode_select' );
mb2_add_shortcode( 'select_item', 'shortcode_select_item' );

function shortcode_select( $atts, $content = null ){

	global $PAGE;

	$atts2 = array(
		'custom_class' => '',
		'image' => 1,
		'layout' => 'h',
		'label' => 1,
		'labeltext' => 'Choose an option:',
		'btntext' => 'Submit',
		'btntype' => 'primary',
		'size' => 'l',
		'target' => 0,
		'btnrounded' => 0,
		'btnborder' => 0,
		'btnfwcls' => 'global',
		'width' => 2000,
		'elcenter' => 0,
		'mt' => 0,
		'mb' => 30,
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$styleattr = '';
	$output = '';
	$cls = '';
	$btncls = '';
	$btnid = uniqid('select_');
	$istarget = $target ? ' target="_blank"' : '';

	$cls .= $custom_class ? ' ' . $custom_class : '';
	$cls .= ' isimage'. $image;
	$cls .= ' layout' . $layout;
	$cls .= ' label' . $label;
	$cls .= ' size' . $size;
	$cls .= ' elcenter' . $elcenter;

	$btncls .= ' rounded' . $btnrounded;
	$btncls .= ' btnborder' . $btnborder;
	$btncls .= ' fw' . $btnfwcls;
	$btncls .= ' type' . $btntype;

	$styleattr .= ' style="';
	$styleattr .= 'margin-top:' . $mt . 'px;';
	$styleattr .= 'margin-bottom:' . $mb . 'px;';
	$styleattr .= 'max-width:' . $width . 'px;';
	$styleattr .= '"';

	$content = $content;

	if ( ! $content )
	{
		for (  $i = 1; $i <= 3; $i++ )
		{
			$content .= '[select_item link="#" itemtext="Select text" ]Select text[/select_item]';
		}
	}

	// Get first element
	$regex = '\\[(\\[?)(select_item)\\b([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
	preg_match_all( "/$regex/is", $content, $match );
	$ismatch = str_replace( '"]', '" ]', $match[0][0] );
	$firstitem = shortcode_parse_atts($ismatch);

	$dtext = $firstitem['itemtext'] ? $firstitem['itemtext'] : 'Select text';
	$dlink = $firstitem['link'] ? $firstitem['link'] : '#';
	$dimage = $firstitem['image'] ? $firstitem['image'] : theme_mb2nl_page_builder_demo_image( '100x100' );

	$output .= '<div id="' . $btnid . '" class="mb2-pb-select' . $cls . '"' . $styleattr . ' data-target="' . $target . '">';

	$output .= $label ? '<div class="select-label"><span class="labeltext">' . $labeltext . '</span></div>' : '';
	$output .= '<div class="select-container">';
	$output .= '<div class="select-dropdown">';
	$output .= '<button type="button" id="' . $btnid . '" class="mb2-pb-select-btn" tabindex="-1">';
	$output .= '<span class="select-btn-image" aria-hidden="true"><img class="select-image lazy" src="' . theme_mb2nl_lazy_plc() . '" data-src="' . $dimage . '"></span>';
	$output .= '<span class="select-btn-text">' . $dtext . '</span>';
	$output .= '<span class="select-btn-arrow" aria-hidden="true"></span>';
	$output .= '</button>';
	$output .= '<div id="' . $btnid . '_items" class="select-items-container size' . $size . '" data-id="' . $btnid . '" tabindex="-1">';
	$output .= '<ul>';
	$output .= mb2_do_shortcode( $content );
	$output .= '</ul>';
	$output .= '</div>';
	$output .= '</div>'; // select-dropdown

	$output .= '<div class="select-button">';
	$output .= '<a href="' . $dlink . '" class="mb2-pb-btn' . $btncls . '"' . $istarget . '>' . $btntext . '</a>';
	$output .= '</div>'; // select-button
	$output .= '</div>'; // select-container
	$output .= '</div>';

	$PAGE->requires->js_call_amd( 'theme_mb2nl/select', 'selectInit', array($btnid) );

	return $output;

}




function shortcode_select_item( $atts, $content = null ){

	$atts2 = array(
		'link'=> '#',
		'image' => theme_mb2nl_page_builder_demo_image( '100x100' ),
		'itemtext' => 'Select text'
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';

	$output .= '<li class="mb2-pb-select_item" data-link="' . $link . '" tabindex="-1">';
	$output .= '<div class="select-item-inner">';
	$output .= '<img class="select-image lazy" src="' . theme_mb2nl_lazy_plc() . '" data-src="' . $image . '">';
	$output .= '<span class="select-text">' . $itemtext . '</span>';
	$output .= '</div>'; // select-item-inner
	$output .= '</li>';

	return $output;

}
