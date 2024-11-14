<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'mb2pb_select', 'mb2pb_shortcode_select' );
mb2_add_shortcode( 'mb2pb_select_item', 'mb2pb_shortcode_select_item' );

function mb2pb_shortcode_select( $atts, $content = null ){

	$atts2 = array(
		'id' => 'select',
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

	$cls .= $custom_class ? ' ' . $custom_class : '';
	$cls .= ' isimage'. $image;
	$cls .= ' layout' . $layout;
	$cls .= ' label' . $label;
	$cls .= ' size' . $size;
	$cls .= ' elcenter' . $elcenter;
	$templatecls = $template ? ' mb2-pb-template-select' : '';

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
			$content .= '[mb2pb_select_item image="' .
			theme_mb2nl_page_builder_demo_image( '100x100' ) . '" link="#" itemtext="Select text" ]Select text[/mb2pb_select_item]';
		}
	}

	// Get first element
	$regex = '\\[(\\[?)(mb2pb_select_item)\\b([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
	preg_match_all( "/$regex/is", $content, $match );
	$firstitem = shortcode_parse_atts($match[0][0]);

	$dtext = $firstitem['itemtext'] ? $firstitem['itemtext'] : 'Select text';
	$dlink = $firstitem['link'] ? $firstitem['link'] : '#';
	$dimage = $firstitem['image'] ? $firstitem['image'] : theme_mb2nl_page_builder_demo_image( '100x100' );

	$output .= '<div class="mb2-pb-element mb2-pb-select' . $templatecls . $cls . '"' . $styleattr . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'select' );

	$output .= '<div class="select-label"><span class="labeltext">' . $labeltext . '</span></div>';
	$output .= '<div class="select-container">';
	$output .= '<div class="select-dropdown">';
	$output .= '<button type="button" class="mb2-pb-select-btn">';
	$output .= '<span class="select-btn-image" aria-hidden="true"><img class="select-image" src="' . $dimage . '"></span>';
	$output .= '<span class="select-btn-text">' . $dtext . '</span>';
	$output .= '<span class="select-btn-arrow" aria-hidden="true"></span>';
	$output .= '</button>';
	$output .= '</div>'; // select-dropdown
	$output .= '<div class="select-button">';
	$output .= '<a href="#" class="mb2-pb-btn' . $btncls . '">' . $btntext . '</a>';
	$output .= '</div>'; // select-button
	$output .= '</div>'; // select-container
	$output .= '<div class="mb2-pb-sortable-subelements select-items-container">';
	$output .= mb2_do_shortcode( $content );
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}




function mb2pb_shortcode_select_item( $atts, $content = null ){

	$atts2 = array(
		'id' => 'select_item',
		'link'=> '#',
		'image' => theme_mb2nl_page_builder_demo_image( '100x100' ),
		'itemtext' => 'Select text',
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';

	$output .= '<div class="mb2-pb-subelement mb2-pb-select_item"' . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= theme_mb2nl_page_builder_el_actions( 'subelement' );
	$output .= '<div class="subelement-helper"></div>';
	$output .= '<div class="select-item-inner">';
	$output .= '<img class="select-image" src="' . $image . '">';
	$output .= '<span class="select-text">' . $itemtext . '</span>';
	$output .= '</div>'; // select-item
	$output .= '</div>';

	return $output;

}
