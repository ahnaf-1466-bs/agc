<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('mb2pb_button', 'mb2_shortcode_mb2pb_button');

function mb2_shortcode_mb2pb_button( $atts, $content= null ){

	$atts2 = array(
		'id' => 'button',
		'type' => 'primary',
		'size' => 'normal',
		'link' => '#',
		'target' => 0,
		'isicon' => 0,
		'icon'=> 'fa fa-play-circle-o',
		'fw' => 0,
		'fwcls' => 'global',
		'lspacing' => 0,
		'wspacing' => 0,
		'rounded' => 0,
		'upper' => 0,
		'custom_class' => '',
		'ml' => 0,
		'mr' => 0,
		'mt' => 0,
		'mb' => 15,
		'border' => 0,
		'center' => 0,
		//
		'color' => '',
		'bgcolor' => '',
		'borcolor' => '',
		'bghcolor' => '',
		'hcolor' => '',
		'borhcolor' => '',
		//
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$cls = '';
	$style = '';
	$elcls = '';
	$btnstyle = '';

	// Button icon
	$btnicon = '<span class="btn-incon"><i class="' . $icon . '"></i></span>';

	// Define button css class
	$cls .= ' type' . $type;
	$cls .= ' size' . $size;
	$cls .= ' upper' . $upper;
	$cls .= ' rounded' . $rounded;
	$cls .= ' btnborder' . $border;
	$cls .= ' isicon' . $isicon;
	$cls .= ' fw' . $fw;
	$cls .= ' fw' . $fwcls;
	$cls .= $custom_class ? ' ' . $custom_class : '';

	$elcls .= ' fw' . $fw;
	$elcls .= ' center' . $center;
	$elcls .= $template ? ' mb2-pb-template-button' : '';

	$content = $content ? $content : get_string( 'readmorefp', 'local_mb2builder' );
	$atts2['text'] = $content;
	$btntext = '<span class="btn-intext">' . urldecode( $content ) . '</span>';

	// Button style
	if ( $ml || $mr || $mt || $mb )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= $ml ? 'margin-left:' . $ml . 'px;' : '';
		$style .= $mr ? 'margin-right:' . $mr . 'px;' : '';
		$style .= '"';
	}

	// Button style
	if (
		$lspacing != 0 ||
		$wspacing != 0 ||
		$color ||
		$bgcolor ||
		$borcolor ||
		$bghcolor ||
		$hcolor ||
		$borhcolor
	)
	{
		$btnstyle .= ' style="';
		$btnstyle .= $lspacing != 0 ? 'letter-spacing:' . $lspacing . 'px;' : '';
		$btnstyle .= $wspacing != 0 ? 'word-spacing:' . $wspacing . 'px;' : '';
		$btnstyle .= $color ? '--mb2-pb-btn-color:' . $color . ';' : '';
		$btnstyle .= $bgcolor ? '--mb2-pb-btn-bgcolor:' . $bgcolor . ';' : '';
		$btnstyle .= $bghcolor ? '--mb2-pb-btn-bghcolor:' . $bghcolor . ';' : '';
		$btnstyle .= $hcolor ? '--mb2-pb-btn-hcolor:' . $hcolor . ';' : '';
		$btnstyle .= $borcolor ? '--mb2-pb-btn-borcolor:' . $borcolor . ';' : '';
		$btnstyle .= $borhcolor ? '--mb2-pb-btn-borhcolor:' . $borhcolor . ';' : '';
		$btnstyle .= '"';
	}

	$output .= '<div class="mb2-pb-element mb2-pb-button' . $elcls . '"' . $style . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'button' );
	$output .= '<a href="#" class="mb2-pb-btn' . $cls . '"' . $btnstyle . '>';
	$output .= $btnicon . $btntext;
	$output .= '</a>';
	$output .= '</div>';

	return $output;

}
