<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'mb2pb_login', 'mb2pb_shortcode_mb2pb_login' );

function mb2pb_shortcode_mb2pb_login( $atts, $content = null ) {

	$atts2 = array(
		'id' => 'login',
		'istitle' => 1,
		'title' => 'Title text here',
		'titletag' => 'h4',
		'width' => 400,
		'mt' => 0,
		'mb' => 30,
		'custom_class' => '',
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$style = '';
	$inputstyle = '';
	$cls = '';
	$tcls = '';

	$formid = uniqid( 'loginform_' );

	$cls .= $custom_class ? ' ' . $custom_class : '';
	$cls .= ' istitle' . $istitle;
	$cls .= $template ? ' mb2-pb-template-login' : '';

	$tcls .= ' ' . $titletag;

	if ( $mt || $mb || $width )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= $width ? 'max-width:' . $width . 'px;' : '';
		$style .= '"';
	}

	$output .= '<div class="mb2-pb-element mb2-pb-login' . $cls . '"' . $style . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'login' );
	$output .= '<form id="' . $formid . '" method="post" action="">';
	$output .= '<h2 class="form-title' . $tcls . '">' . $title . '</h2>';
	$output .= '<div class="form-content">';
	$output .= '<div class="form-field">';
	$output .= '<label id="user"><i class="fa fa-user"></i></label>';
	$output .= '<input id="' . $formid . '_username" type="text" name="username" placeholder="' . get_string( 'username' ) . '" />';
	$output .= '</div>';
	$output .= '<div class="form-field">';
	$output .= '<label id="pass"><i class="fa fa-lock"></i></label>';
	$output .= '<input id="' . $formid . '_password" type="password" name="password" placeholder="' . get_string( 'password' ) . '" />';
	$output .= '</div>';
	$output .= '<div class="form-button"><input type="submit" id="' . $formid . '_submit" name="submit" value="' . get_string('login') . '" /></div>';
	$output .= '</form>';
	$output .= '<div class="logininfo"><a href="#">' . get_string('forgotten') . '</a></div>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}
