<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode( 'subscribeform', 'mb2_shortcode_subscribeform' );

function mb2_shortcode_subscribeform( $atts, $content = null ){

	extract(mb2_shortcode_atts( array(
		'listid' => 1,3,
		'custom_class' => ''
	), $atts));

	global $PAGE;
	$output = '';
	$inline_js = '';
	$uniqid = uniqid('mb2newsletter_form_');
	$list = explode( ',', $listid );
	if ( ! $listid )
	{

	}

	$output .= '<div class="mb2-newsletter-wrap">';

	$output .= '<form class="mb2-newsletter-from" id="' . $uniqid . '" action="">';
	$output .= '<input type="hidden" name="status" value="3" />';
	$output .= '<input type="hidden" name="lists" value="" />';

	foreach( $list as $li )
	{
		$output .= '<input type="hidden" name="lists[]" value="' . $li . '" />';
	}

	$output .= '<input type="text" name="firstname" value="" />';
	$output .= '<input type="text" name="lastname" value="" />';
	$output .= '<input type="text" name="email" value="" />';
	$output .= '<input type="submit" value="Subscribe" />';
	$output .= '</form>';
	$output .= '</div>';


	$inline_js .= 'require([\'theme_mb2nl/subscribe\'], function(GradingPanel) {';
	$inline_js .= '';
	$inline_js .= 'new GradingPanel(\'.mb2-newsletter-wrap\');';
	$inline_js .= '';
	$inline_js .= '';
	$inline_js .= '});';


	$PAGE->requires->js_amd_inline( $inline_js );

	return $output;

}
