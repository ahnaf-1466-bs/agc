<?php

defined( 'MOODLE_INTERNAL' ) || die();

mb2_add_shortcode( 'modpage', 'mb2_shortcode_modpage' );

function mb2_shortcode_modpage( $atts, $content = null ){

	global $CFG, $DB;
	$output = '';

	require_once( $CFG->libdir . '/filelib.php' );

	extract( mb2_shortcode_atts( array(
		'id' => 0,
		'limit' => 25,
		'linktarget' => 0
	), $atts) );

	if ( ! $id )
	{
		return;
	}

	$target = $linktarget ? ' target="_blank"' : '';

	$instancesql = 'SELECT * FROM {course_modules} WHERE id = ?';

	if ( ! $DB->record_exists_sql( $instancesql, array( $id ) ) )
	{
		return 'Page with ID: ' . $id . ' doesn\'t exist';
	}

	// Pet page id
	$pageid = $DB->get_record( 'course_modules', array( 'id' => $id ), 'instance', MUST_EXIST );
	$pageid = $pageid->instance;

	// Get page
	$page = $DB->get_record( 'page', array( 'id' => $pageid ), '*', MUST_EXIST );
	$cm = get_fast_modinfo($page->course)->instances['page'][$page->id];
	$context = context_module::instance( $cm->id );
	$pagecontent = file_rewrite_pluginfile_urls( $page->content, 'pluginfile.php', $context->id, 'mod_page', 'content', $pageid );
	$pagecontent = format_text( $pagecontent, FORMAT_HTML );
	$pageurl = new moodle_url( '/mod/page/view.php', array( 'id' => $id ) );

	// Get image
	$images = array();
	$fs = get_file_storage();
	$files = $fs->get_area_files( $context->id, 'mod_page', 'content', 0 );

	foreach( $files as $f )
	{
		if ( $f->is_valid_image() )
		{
			$images[] = moodle_url::make_pluginfile_url( $f->get_contextid(), $f->get_component(), $f->get_filearea(), $pageid, $f->get_filepath(), $f->get_filename() );
		}
	}

	$output .= '<div class="modpage-wrap">';
	$output .= isset( $images[0] ) ? '<div class="modpage-image"><img src="' . $images[0] . '" alt=""></div>' : '';
	$output .= '<div class="modpage-content">';
	$output .= '<h4 class="modpage-name">' . $page->name . '</h4>';
	$output .= theme_mb2nl_wordlimit( $pagecontent, $limit );
	$output .= ' <a href="' . $pageurl . '"' . $target . '>' .get_string('readmore', 'theme_mb2nl') . ' &#187;</a>';
	$output .= '</div>';


	$output .= '</div>';

	return $output;

}
