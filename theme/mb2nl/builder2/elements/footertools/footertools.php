<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'mb2pb_footertools', 'mb2_shortcode_mb2pb_footertools' );

function mb2_shortcode_mb2pb_footertools( $atts, $content = null ){
	global $OUTPUT;

	$atts2 = array(
		'id' => 'footertools',
		'mt' => 0,
		'mb' => 30,
		'sizerem' => 1,
		'color' => '',
		'custom_class' => '',
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$elstyle = '';
	$cls = '';

	$elstyle .= ' style="';
	$elstyle .= 'margin-top:' .  $mt . 'px;';
	$elstyle .= 'margin-bottom:' .  $mb . 'px;';
	$elstyle .= $color ? 'color:' .  $color . ';' : '';
	$elstyle .= 'font-size:' .  $sizerem . 'rem;';
	$elstyle .= '"';

	$cls .= $custom_class ? ' ' . $custom_class : '';

	$tmplcls = $template ? ' mb2-pb-template-' . $id : '';

	$output .= '<div class="mb2-pb-element mb2-pb-footertools' . $tmplcls . $cls . '"' . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . $elstyle . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'footertools', array('copy' => 0 ) );

	// TO DO: check what is the reason on PERFORMANCEINFO... on customize page
	// The code below is only workaround
	$footercontent = theme_mb2nl_get_footertools();
	$preformance_str = '%%PERFORMANCEINFO-' . sesskey() . '%%';

	$output .= str_replace($preformance_str, '', $footercontent);
	$output .= '</div>';

	return $output;

}
