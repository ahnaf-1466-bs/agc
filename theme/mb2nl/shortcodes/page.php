<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'mb2page', 'mb2_shortcode_mb2page' );

function mb2_shortcode_mb2page( $atts, $content = null ){

	global $PAGE, $CFG;

	extract( mb2_shortcode_atts( array(
		'pageid' => '',
		'democontent' => 0
	), $atts) );

	if ( theme_mb2nl_check_builder() != 2 )
	{
		return;
	}

	// Get page api file
	require_once( $CFG->dirroot . '/local/mb2builder/classes/pages_api.php' );

	if ( ! Mb2builderPagesApi::is_pageid( $pageid ) )
	{
		return get_string( 'pagenoexists', 'local_mb2builder', array( 'id' => $pageid ) );
	}

	// If user editing page we don't want to show builder code
	if ( $PAGE->user_is_editing() )
	{
		return '[mb2page pageid="' . $pageid . '"]';
	}

	$page = Mb2builderPagesApi::get_record( $pageid );
	$pagedata = $page->content;

	// Sometimes we want to show democontent instead of content
	if ( $democontent )
	{
		$pagedata = $page->democontent;
	}

	return theme_mb2nl_page_builder_content( json_decode( $pagedata ) );

}
