<?php

defined( 'MOODLE_INTERNAL' ) || die();

mb2_add_shortcode( 'login', 'mb2pb_shortcode_login' );

function mb2pb_shortcode_login( $atts, $content = null ) {

	extract( mb2_shortcode_atts( array(
		'istitle' => 1,
		'title' => 'Title text here',
		'titletag' => 'h4',
		'width' => 600,
		'mt' => 0,
		'mb' => 30,
		'custom_class' => ''
	), $atts ) );

	global $CFG, $USER, $OUTPUT;
	$output = '';
	$style = '';
	$inputstyle = '';
	$cls = '';
	$tcls = '';

	$formid = uniqid( 'loginform_' );
	$action = new moodle_url( $CFG->wwwroot . '/login/index.php', array() );
	$forgotlink = new moodle_url( $CFG->wwwroot . '/login/forgot_password.php', array() );
	$logintoken = '';

	if ( method_exists( '\core\session\manager', 'get_login_token' ) )
	{
		$action = get_login_url();
		$logintoken = '<input type="hidden" name="logintoken" value="' . s(\core\session\manager::get_login_token()) .'" />';
	}

	$cls .= $custom_class ? ' ' . $custom_class : '';
	$cls .= ' istitle' . $istitle;

	$tcls .= ' ' . $titletag;

	if ( $mt || $mb || $width )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= $width ? 'max-width:' . $width . 'px;' : '';
		$style .= '"';
	}

	$output .= '<div class="mb2-pb-login' . $cls . '"' . $style . '>';

	if ( isloggedin() && ! isguestuser() )
	{
		$output .= '<div class="form-content loggedin">';
		$output .= '<div class="user-picture">' . $OUTPUT->user_picture( $USER, array( 'size' => 80, 'class' => 'welcome_userpicture' ) ) . '</div>';
		$output .= '<div class="logincontent">';
		$output .= '<p class="logininfo">' . get_string( 'loggedinas', 'moodle', '<strong>' . $USER->firstname . ' ' . $USER->lastname . '</strong> ('  . $USER->username . ')' ) . '</p>';
		$output .= '<a class="mb2-pb-btn typeprimary" href="' . new moodle_url( $CFG->wwwroot . '/login/logout.php', array( 'sesskey' => sesskey() ) ) . '">' . get_string( 'logout' ) . '</a>';
		$output .= '</div>';
		$output .= '</div>';
	}
	else
	{
		$output .= '<form id="' . $formid . '" method="post" action="' . $action . '">';
		$output .= $istitle ? '<' . $titletag . ' class="form-title' . $tcls . '">' . $title . '</' . $titletag . '>' : '';
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
		$output .= $logintoken;
		$output .= '<div class="logininfo"><a href="' . $forgotlink . '">' . get_string('forgotten') . '</a></div>';
		$output .= '</div>';
		$output .= '</form>';
	}

	$output .= '</div>';

	return $output;

}
