<?php

defined('MOODLE_INTERNAL') || die();


function mb2_shortcode_alert($atts, $content= null){
	extract(mb2_shortcode_atts( array(
		'type' => 'info',
		'close' => 0,
		'mt' => 0,
		'mb' => 30,
		'class' => ''
	), $atts));

	$style = '';
	$cls = '';

	$cls .= $close ? ' alert-dismissible' : '';
	$cls .= $class !='' ? ' ' . $class : '';

	if ( $mt || $mb )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	}

	$cbutton = $close ? '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' : '';
	return '<div class="alert mb2pb-alert alert-' . $type . $cls . '"' . $style . '>' . $cbutton . mb2_do_shortcode( $content ) .'</div>';

}

mb2_add_shortcode('alert', 'mb2_shortcode_alert');
