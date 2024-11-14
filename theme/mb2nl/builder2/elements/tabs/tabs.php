<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'mb2pb_tabs', 'mb2_shortcode_mb2pb_tabs' );
mb2_add_shortcode( 'mb2pb_tabs_item', 'mb2_shortcode_mb2pb_tabs_item' );

function mb2_shortcode_mb2pb_tabs( $atts, $content = null ) {

	$atts2 = array(
		'id' => 'tabs',
		'tabpos' => 'top',
		'height'=> 100,
		'isicon' => 0,
		'icon' => 'fa fa-trophy',
		'custom_class' => '',
		'mt' => 0,
		'mb' => 30,
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$GLOBALS['mb2pbtabicon'] = $icon ? $icon : 'fa fa-trophy';
	$unique = uniqid('tab-' );
	$output = '';
	$style = '';
	$cls = '';

	if ( ! $content )
	{
		$content = '[mb2pb_tabs_item title="Tab" desc="Tab content here." ][/mb2pb_tabs_item]';
	}

	// Get tab content for sortable elements
	$regex = '\\[(\\[?)(mb2pb_tabs_item)\\b([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
	preg_match_all( "/$regex/is", $content, $match );
	$content = $match[0];

	if ( $mt || $mb )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	}

	$height = $height ? ' style="min-height:' . $height . 'px"' : '';

	$cls .= $tabpos;
	$cls .= $template ? ' mb2-pb-template-tabs' : '';
	$cls .= ' isicon' . $isicon;
	$cls .= $custom_class ? ' ' . $custom_class : '';

	$output .= '<div class="mb2-pb-element mb2-pb-tabs theme-tabs tabs ' . $cls . '"' . $style . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$i = -1;
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'tabs' );

	$output .= '<div class="mb2-pb-element-inner">';
	$output .= '<ul class="nav nav-tabs mb2-pb-sortable-subelements">';

	foreach( $content as $c )
	{
		$i++;
		$unique_id = $unique . $i;
		$tab_selected = $i == 0 ? 'true' : 'false'; // We need word 'true' or 'false' for data attribute
		$activecls = $i == 0 ? ' active' : '';
		$tabattr = $i == 0 ? ' custom_class="active"' : '';

		// Get attributes of tab items
		$attributes = shortcode_parse_atts( $c );
		$attr['id'] = 'tabs_item';
		$attr['pbid'] = ( isset( $attributes['pbid'] ) && $attributes['pbid'] ) ? $attributes['pbid'] : '';
		$attr['title'] = ( isset( $attributes['title'] ) && $attributes['title'] ) ? $attributes['title'] : 'Tab';
		$attr['icon'] = ( isset( $attributes['icon'] ) && $attributes['icon'] ) ? $attributes['icon'] : '';
		$attr['text'] = theme_mb2nl_page_builder_shortcode_content_attr( $c, mb2_get_shortcode_regex() );

		// Defaine global icon
		$icon = $attr['icon'] ? $attr['icon'] : $icon;

		$output .= '<li class="nav-item mb2-pb-subelement mb2-pb-tabs_item"' . theme_mb2nl_page_builder_el_datatts( $attr, $attr ) . '>';
		$output .= theme_mb2nl_page_builder_el_actions( 'subelement' );
		$output .= '<a class="nav-link'. $activecls .'" href="#' . $unique_id . '" data-toggle="tab" role="tab" aria-controls="' . $unique_id . '" aria-selected="' . $tab_selected . '">';
		$output .= '<i class="'. $icon . '"></i> <span class="tab-text">' . format_text( $attr['title'], FORMAT_HTML ) . '</span>';
		$output .= '</a>';
		$output .= '</li>';

		$content[$i] = str_replace( '[mb2pb_tabs_item ','[mb2pb_tabs_item'. $tabattr . ' tabid="' . $unique_id . '" ', $content[$i] );
	}

	$output .= '</ul>';

	$output .= '<div class="tab-content"' . $height . '>';

	foreach( $content as $c )
	{
		$output .= mb2_do_shortcode( $c );
	}

	$output .= '</div>';

	$output .= '</div>';
	$output .= '</div>';

	//unset( $GLOBALS['mb2pbtabicon'] );
	return $output;

}




function mb2_shortcode_mb2pb_tabs_item( $atts, $content = null ) {
	extract( mb2_shortcode_atts( array(
		'id' => 'tabs_item',
		'title' => 'Tab',
		'tabid' => '',
		'icon' => '',
		'text' => '',
		'custom_class' =>'',
		'template' => ''
	), $atts ) );

	$icon = $icon ? $icon : $GLOBALS['mb2pbtabicon'];

	$cls = '';
	$cls .= $template ? ' mb2-pb-template-tabs_item' : '';
	$cls .= $custom_class ? ' ' . $custom_class : '';
	//$content = $text ? $text : $content;

	if ( ! $content )
	{
		$content = 'Tab content here.';
	}

	$output = '<div class="tab-pane' . $cls . '" id="' . $tabid . '" role="tabpanel" aria-labelledby="' . $tabid . '">';
	$output .= urldecode( $content );
	$output .= '</div>';

	return $output;
}
