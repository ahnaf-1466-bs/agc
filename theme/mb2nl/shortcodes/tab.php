<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('tabs', 'mb2_shortcode_tabs');
mb2_add_shortcode('tab_item', 'mb2_shortcode_tabs_item');
mb2_add_shortcode('tabs_item', 'mb2_shortcode_tabs_item');

function mb2_shortcode_tabs($atts, $content = null ) {

	extract( mb2_shortcode_atts( array(
		  'tabpos' => 'top',
		  'height'=> 100,
		  'isicon' => 0,
		  'icon' => 'fa fa-trophy',
		  'custom_class' => '',
		  'margin' => '',
		  'mt' => 0,
		  'mb' => 30
	), $atts ));

	$GLOBALS['mb2pbtabicon'] = $icon;
	$unique = uniqid('tab-');
	$output = '';
	$icontag = '';
	$style = '';
	$cls = '';
	$i = -1;

	//$content = str_replace('/', 'sl', $content );

	// We have to check if user use old or new tabs shortcode
	$tabsname = preg_match( '@tab_item@', $content ) ? 'tab_item' : 'tabs_item';

	// Get tab content for sortable elements
	$regex = '\\[(\\[?)(' . $tabsname . ')\\b([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
	preg_match_all( "/$regex/is", $content, $match );
	$content = $match[0];

	if ( $mt || $mb || $margin )
	{
		$style .= ' style="';
		$style .= $margin ? 'margin:' . $margin . ';' : '';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	}

	$height = $height ? ' style="min-height:' . $height . 'px"' : '';

	$cls .= $tabpos;
	$cls .= ' isicon' . $isicon;
	$cls .= $custom_class ? ' ' . $custom_class : '';

	$output .= '<div class="theme-tabs tabs ' . $cls . '"' . $style . '>';
	$output .= '<ul class="nav nav-tabs">';


	foreach( $content as $c )
	{
		$i++;
		$unique_id = $unique . $i;
		$tab_selected = $i == 0 ? 'true' : 'false'; // We need word 'true' or 'false' for data attribute
		$activecls = $i == 0 ? ' active' : '';
		$tabattr = $i == 0 ? ' custom_class="active"' : '';

		// This is required for old shortcodes
		// to use shortcode_parse_atts
		$c = str_replace('"]', '" ]', $c);
		$c = str_replace('accordion_item title', 'accordion_item titlex', $c);

		$attributes = shortcode_parse_atts( $c );

		$attr['pbid'] = ( isset( $attributes['pbid'] ) && $attributes['pbid'] ) ? $attributes['pbid'] : '';
		$attr['title'] = ( isset( $attributes['title'] ) && $attributes['title'] ) ? $attributes['title'] : 'Tab';
		$attr['icon'] = ( isset( $attributes['icon'] ) && $attributes['icon'] ) ? $attributes['icon'] : '';

		// Defaine global icon
		$icon = $attr['icon'] ? $attr['icon'] : $icon;

		if( $icon )
		{
			$pref = theme_mb2nl_font_icon_prefix( $icon );
			$icontag = '<i class="'. $pref . $icon . '"></i> ';
		}

		$output .= '<li class="nav-item">';
		$output .= '<a class="nav-link'. $activecls .'" href="#' . $unique_id . '" data-toggle="tab" role="tab" aria-controls="' . $unique_id . '" aria-selected="' . $tab_selected . '">';
		$output .= '<span class="tab-text">' . $icontag . format_text( $attr['title'], FORMAT_HTML ) . '</span>';
		$output .= '</a>';
		$output .= '</li>';

		$content[$i] = str_replace( '[' . $tabsname . ' ','[' . $tabsname . $tabattr . ' tabid="' . $unique_id . '" ', $content[$i] );
	}

	$output .= '</ul>';
	$output .= '<div class="tab-content"' . $height . '>';

	foreach( $content as $c )
	{
		$output .= mb2_do_shortcode( $c );
	}

	$output .= '</div>';
	$output .= '</div>';

	unset( $GLOBALS['mb2pbtabicon'] );
	return $output;

}



function mb2_shortcode_tabs_item( $atts, $content = null ) {
	extract( mb2_shortcode_atts( array(
		'title' => '',
		'id' => '',
		'tabid' => '',
		'icon' => '',
		'custom_class' => ''
	), $atts ) );

	$cls = $custom_class ? ' ' . $custom_class : '';
	$id = $tabid ? $tabid : $id;

	$output = '<div class="tab-pane' . $cls . '" id="' . $id . '" role="tabpanel" aria-labelledby="' . $id . '">';
	$output .= mb2_do_shortcode( $content );
	$output .= '</div>';

	return $output;
}
