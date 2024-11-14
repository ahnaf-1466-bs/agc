<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'mb2footer', 'mb2_shortcode_mb2footer' );

function mb2_shortcode_mb2footer( $atts, $content = null ){

	global $PAGE, $CFG, $DB;

	extract( mb2_shortcode_atts( array(
		'footerid' => ''
	), $atts) );

	$output = '';

	if ( theme_mb2nl_check_builder() != 2 )
	{
		return;
	}

	// Chckec footer database
	// Check for old vearion of page builder if 'hesding' filed exist
	$dbman = $DB->get_manager();
	$table_pages = new xmldb_table( 'local_mb2builder_pages' );
	$footerfield = new xmldb_field( 'footer', XMLDB_TYPE_INTEGER, '10', null, null, null, '0' );

	if ( ! $dbman->field_exists( $table_pages, $footerfield ) )
	{
		return;
	}

	// Get page api file
	require_once( $CFG->dirroot . '/local/mb2builder/classes/footers_api.php' );

	if ( ! Mb2builderFootersApi::is_footerid( $footerid ) )
	{
		return '<span class="d-block align-center pt-5 pb-5">' . get_string( 'footernoexists', 'local_mb2builder', array( 'id' => $footerid ) ) . '</span>';
	}

	if ( has_capability('local/mb2builder:managefooters', context_system::instance()) && ! $PAGE->user_is_editing() )
	{
		$linkparams = array(
			'itemid' => $footerid,
			'returnurl' => $PAGE->url->out_as_local_url()
		);
		$output .= '<div class="builder-links">';
		$output .= '<a class="mb2pb-editfooter" href="' . new moodle_url( '/local/mb2builder/edit-footer.php', $linkparams ) . '">';
		$output .= get_string( 'editfooter', 'local_mb2builder' );
		$output .= '</a>';
		$output .= '</div>';
	}

	// If user editing page we don't want to show builder code
	if ( $PAGE->user_is_editing() )
	{
		return '<span class="d-block align-center pt-5 pb-5">[mb2footer footerid="' . $footerid . '"]</span>';
	}

	$footer = Mb2builderFootersApi::get_record( $footerid );
	$footerdata = $footer->content;

	$output .= theme_mb2nl_page_builder_content( json_decode( $footerdata ), true );

	return $output;

}
