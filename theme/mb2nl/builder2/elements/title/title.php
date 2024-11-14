<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('mb2pb_title', 'mb2_shortcode_mb2pb_title');


function mb2_shortcode_mb2pb_title( $atts, $content = null ){

	$atts2 = array(
		'id' => 'title',
		'tag'=> 'h4',
		'align' => 'none',
		'issubtext' => 1,
		'subtext' => 'Subtext here',
		'size' => 'n',
		'sizerem' => 2,
		//'fweight' => 600,
		'fwcls' => 'global',
		'lhcls' => 'global',
		'lspacing' => 0,
		'wspacing' => 0,
		'color' => '',
		'upper' => 0,
		'style' => 1,
		'mt' => 0,
		'mb' => 30,
		'custom_class'=> '',
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$cstyle = '';
	$tstyle = '';
	$cls = '';
	$tcls = '';

	$cls .= ' title-' . $align;
	$cls .= ' title-' . $size;
	$cls .= ' style-' . $style;
	$cls .= ' issubtext' . $issubtext;
	$cls .= $custom_class ? ' ' . $custom_class : '';

	$tcls .= ' upper' . $upper;
	$tcls .= ' fw' . $fwcls;
	$tcls .= ' lh' . $lhcls;
	$tcls .= ' ' . theme_mb2nl_heading_cls( $sizerem );

	$tmplcls = $template ? ' mb2-pb-template-title' : '';

	if ( $mt || $mb )
	{
		$cstyle .= ' style="';
		$cstyle .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$cstyle .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$cstyle .= '"';
	}

	if ( $sizerem || $color || $lspacing != 0 || $wspacing != 0 )
	{
		$tstyle .= ' style="';
		$tstyle .= 'font-size:' . $sizerem . 'rem;';
		//$tstyle .= 'font-weight:' . $fweight . ';';
		$tstyle .= $lspacing != 0 ? 'letter-spacing:' . $lspacing . 'px;' : '';
		$tstyle .= $wspacing != 0 ? 'word-spacing:' . $wspacing . 'px;' : '';
		$tstyle .= $color ? 'color:' . $color . ';' : '';
		$tstyle .= '"';
	}

	$content = $content ? $content : 'Heading text here';
	$atts2['content'] = $content;

	$output .= '<div class="mb2-pb-element mb2pb-title' . $tmplcls . '"' . $cstyle . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'title' );
	$output .= '<div class="theme-title' . $cls . '">';
	$output .= '<' . $tag . ' class="title' . $tcls . '"' . $tstyle . '><span>';
	$output .= '<span class="title-text">' . urldecode( $content ) . '</span>';
	$output .= '</span></' . $tag . '>';
	$output .= '<span class="title-subtext">' . $subtext . '</span>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;


}
