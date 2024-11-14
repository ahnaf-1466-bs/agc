<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'search', 'mb2pb_shortcode_search' );

function mb2pb_shortcode_search( $atts, $content = null ) {

	extract( mb2_shortcode_atts( array(
		'id' => 'search',
		'placeholder' => get_string( 'searchcourses' ),
		'global' => 0,
		'rounded' => 0,
		'width' => 750,
		'size' => 'n',
		'border' => 1,
		'mt' => 0,
		'mb' => 30,
		'custom_class' => ''
	), $atts ) );

	global $CFG;

	$output = '';
	$style = '';
	$inputstyle = '';
	$cls = '';
	$cls .= ' border' . $border;

	$formid = uniqid( 'searchform_' );
	$inputname = $global ? 'q' : 'search';

    $action = new moodle_url( $CFG->wwwroot . '/course/search.php', array() );

    if ( $global && isset( $CFG->enableglobalsearch ) && $CFG->enableglobalsearch && theme_mb2nl_moodle_from( 2016052300 ) )
    {
        $action = new moodle_url( $CFG->wwwroot . '/search/index.php', array() );
    }

	$cls .= $custom_class ? ' ' . $custom_class : '';
	$cls .= ' size' . $size;
	$cls .= ' rounded' . $rounded;

	if ( $mt || $mb || $width )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= $width ? 'max-width:' . $width . 'px;' : '';
		$style .= '"';
	}

	$content = $content ? $content : 'Alert text here.';
	$atts2['text'] = $content;

	$output .= '<div class="mb2-pb-search' . $cls . '"' . $style . '>';
	$output .= '<form id="' . $formid . '" action="' . $action . '">';
	$output .= '<input id="' . $formid . '_search" type="text" value="" placeholder="' . $placeholder . '" name="' . $inputname . '">';
	$output .= '<button type="submit"><i class="fa fa-search"></i></button>';
	$output .= '</form>';
	$output .= '</div>';

	return $output;

}
