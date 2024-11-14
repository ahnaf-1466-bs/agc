<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 *
 * @package   theme_mb2nl
 * @copyright 2017 - 2022 Mariusz Boloz (mb2moodle.com)
 * @license   Commercial https://themeforest.net/licenses
 *
 */

defined('MOODLE_INTERNAL') || die();



/*
 *
 * Method to get page builder elements actions
 *
 */
function theme_mb2nl_page_builder_el_actions( $element = 'element', $elstr = '', $opts = array() )
{

	$output = '';

	$output .= '<div class="mb2-pb-actions">';
	$elstr0 = $elstr;

	if ( $elstr && $element === 'element' )
	{
		$elstr = get_string( $elstr, 'local_mb2builder' );
	}
	else
	{
		$elstr = get_string( $element, 'local_mb2builder' );
	}

	$output .= $element !== 'subelement' ? '<span>' . $elstr . ':</span>' : '';

	$output .= '<span class="drag-handle ' . $element . '-drag-handle" title="' . get_string('move','local_mb2builder') . '">';
	$output .= '<i class="fa fa-arrows"></i>';
	//$output .= get_string('move','local_mb2builder');
	$output .= '</span>';

	$output .= '<a href="#" class="settings-' . $element . '" title="' .	get_string('settings','local_mb2builder')
	. '" data-modal="#mb2-pb-modal-settings-' . $element . '">';
	$output .= '<i class="fa fa-pencil"></i>';
	//$output .= get_string('settings','local_mb2builder');
	$output .= '</a>';

	if ( $elstr0 === 'carousel' || $elstr0 === 'pbmainslider' || $elstr0 === 'testimonials' )
	{
		$output .= '<a href="#" class="element-items" title="' . get_string('carouselitems','local_mb2builder') . '">';
		$output .= '<i class="fa fa-bars"></i>';
		//$output .= get_string('carouselitems','local_mb2builder');
		$output .= '</a>';
	}

	if ( $element === 'row' )
	{
		$output .= '<a href="#" class="layout-row" title="' . get_string('columns','local_mb2builder') . '" data-modal="#mb2-pb-modal-row-layout">';
		$output .= '<i class="fa fa-columns"></i>';
		//$output .= get_string('columns','local_mb2builder');
		$output .= '</a>';
	}

	if ( ! isset( $opts['copy'] ) || $opts['copy'] == 1 )
	{
		$output .= '<a href="#" class="duplicate-' . $element . '" title="' . get_string('duplicate','local_mb2builder') . '">';
		$output .= '<i class="fa fa-clone"></i>';
		//$output .= get_string('duplicate','local_mb2builder');
		$output .= '</a>';
	}

	if ( $element !== 'column' )
	{
		$output .= '<a href="#" class="remove-' . $element . '" title="' . get_string('remove','local_mb2builder') . '">';
		$output .= '<i class="fa fa-trash"></i>';
		//$output .= get_string('remove','local_mb2builder');
		$output .= '</a>';
	}

	if ( $element === 'column' )
	{
		$output .= '<a href="#" class="mb2-pb-add-element" data-modal="#mb2-pb-modal-elements" title="' . get_string('addelement','local_mb2builder') . '">';
		$output .= '<i class="fa fa-plus"></i>';
		//$output .= get_string('addelement','local_mb2builder');
		$output .= '</a>';
	}

	if ( $element === 'section' || $element === 'row' )
	{
		$output .= '<span class="visible-off" title="' . get_string( 'hidden','local_mb2builder' ) . '">';
		$output .= '<i class="fa fa-eye-slash"></i>';
		$output .= '</span>';

		$output .= '<span class="access-lock" title="' . get_string( 'elaccessusers','local_mb2builder' ) . '">';
		$output .= '<i class="fa fa-lock"></i>';
		$output .= '</span>';

		$output .= '<span class="access-unlock" title="' . get_string( 'elaccesguests','local_mb2builder' ) . '">';
		$output .= '<i class="fa fa-unlock"></i>';
		$output .= '</span>';

		$output .= '<span class="languages">';
		if ( $opts['lang'][0] )
		{
			$output .= implode( ', ', $opts['lang'] );
		}
		$output .= '</span>';
	}

	$output .= '</div>';

	if ( $elstr0 === 'courses' || $elstr0 === 'categories' || $elstr0 === 'coursetabs' || $elstr0 === 'blog' )
	{
		$output .= '<div class="mb2-pb-actions-loading"></div>';
	}

	return $output;

}







/*
 *
 * Method to get data attributes of page builder elements
 *
 */
function theme_mb2nl_page_builder_el_datatts( $atts, $atts2 = array() )
{
	global $CFG;
	$output = '';

	if ( theme_mb2nl_check_builder() != 2 )
	{
		reurn;
	}

	// Get page api file
	require_once( $CFG->dirroot . '/local/mb2builder/classes/builder.php' );

	if ( isset( $atts2['id'] ) )
	{
		$atts2['elname'] = get_string( $atts2['id'], 'local_mb2builder' );
	}

	foreach ( $atts2 as $k => $v )
	{
		if ( isset( $atts[$k] ) )
		{
			$v = $atts[$k];
		}

		// We have to replace shortcodes
		if ( strpos( $v, ']' ) )
		{
			$v = mb2builderBuilder::replace_shortcode( $v );
		}

		if ( $k === 'content' || $k === 'text' )
		{
			// Params comes encoded from page builder
			// So we need to decode it
			$v = urldecode($v);

			// In data attribute we need html entities
			// But we need to prevent to etities twice
			// So, first we need to remove entities with 'html_entity_decode'
			// And then convert to entities width 'htmlentities'
			$v = html_entity_decode($v);
			$v = htmlentities($v);
		}

		$output .= ' data-' . $k . '="' . $v . '"';
	}



	return $output;

}






/*
 *
 * Method to get variables from two arrays
 *
 */
function theme_mb2nl_page_builder_2arrays( $atts, $atts2 = array() )
{
	$attributes = array();

	foreach ( $atts2 as $k => $v )
	{
		$v = $v;

		if ( isset( $atts[$k] ) )
		{
			$v = $atts[$k];
		}

		$attributes[$k] = $v;
	}

	return $attributes;

}





/*
 *
 * Method to get demo image from page builder
 *
 */
function theme_mb2nl_page_builder_demo_image( $size = '1600x1066' )
{
	//global $CFG, $OUTPUT;

	// Special condition for Moodle 3.3 and erlier
	// if ( $CFG->version < 2017051500 )
	// {
	// 	return $OUTPUT->pix_url( 'demo/' . $name, 'local_mb2builder' );
	// }
	// else
	// {
	// 	return $OUTPUT->image_url( 'demo/' . $name, 'local_mb2builder' );
	// }

	return get_string('demoimage', 'theme_mb2nl', array('size'=>$size));

}




/*
 *
 * Method to get shortcode content for attribute [... content="..."
 *
 */
function theme_mb2nl_page_builder_shortcode_content_attr( $content, $pattern )
{
	$output = '';

	$matches = array();
	preg_match( "/$pattern/s", $content, $matches );

	if ( isset( $matches[5] ) )
	{
		if ( strip_tags( $matches[5] ) !== $matches[5] )
		{
			return htmlentities( $matches[5] );
		}
		else
		{
			return $matches[5];
		}


	}

}






/*
 *
 * Method to get link to edit page
 *
 */
function theme_mb2nl_page_builder_pagelink($isitemid = false)
{
	global $CFG, $PAGE, $COURSE, $USER;

	$output = '';
	$link = '';
	$pageid = -1;
	$checkbuilder = theme_mb2nl_check_builder();

	if ( $checkbuilder != 2 )
	{
		return array();
	}

	$canmanage = has_capability('local/mb2builder:managepages', context_system::instance());

	if (! $canmanage || ! theme_mb2nl_check_shortcodes_filter() || ( $PAGE->pagetype !== 'site-index' && $PAGE->pagetype !== 'mod-page-view' ) || $PAGE->user_is_editing() )
	{
		return array();
	}

	// Get page api file
	require_once( $CFG->dirroot . '/local/mb2builder/classes/pages_api.php' );

	// Display front page button
	if ( $PAGE->pagetype === 'site-index' )
	{
		$pagecontent = Mb2builderPagesApi::get_fp_summary();
	}
	elseif ( $PAGE->pagetype === 'mod-page-view' )
	{
		$pageid = Mb2builderPagesApi::get_page_id();
		$pagecontent = Mb2builderPagesApi::get_page_content();
	}

	$itemid = Mb2builderPagesApi::get_shortcode_id( $pagecontent );

	if ( $isitemid )
	{
		return $itemid;
	}

	$linkparams = array(
		'itemid' => $itemid,
		'courseid' => $COURSE->id,
		'savetomoodle' => $pageid,
		'returnurl' => $PAGE->url->out_as_local_url(),
		'pagename' => urlencode( $PAGE->title ),
		'pageid' => uniqid('page_')
	);

	return $linkparams;

}




/*
 *
 * Method to check if moodle page has builder page
 *
 */
function theme_mb2nl_has_builderpage()
{
	global $CFG, $PAGE;

	if ( theme_mb2nl_check_builder() != 2 )
	{
		return false;
	}

	if ( $PAGE->user_is_editing() )
	{
		return false;
	}

	// Get page api file
	require_once( $CFG->dirroot . '/local/mb2builder/classes/pages_api.php' );

	if ( Mb2builderPagesApi::has_page() )
	{
		return true;
	}

	return false;

}


/*
 *
 * Method to check if moodle page has builder page
 *
 */
function theme_mb2nl_builderpage_heading()
{
	global $PAGE, $DB, $CFG;

	$content = '';

	$pageid = theme_mb2nl_builderpage_pageid();

	if ( ! $pageid )
	{
		return 0;
	}

	// Get heading databse
	// Check for old vearion of page builder if 'hesding' filed exist
	$dbman = $DB->get_manager();
	$table_pages = new xmldb_table( 'local_mb2builder_pages' );
	$headingfield = new xmldb_field( 'heading', XMLDB_TYPE_INTEGER, '10', null, null, null, '0' );

	if ( ! $dbman->field_exists( $table_pages, $headingfield ) )
	{
		return 0;
	}

	$recordsql = 'SELECT heading FROM {local_mb2builder_pages} WHERE id=' . $pageid;

	if ( $DB->record_exists_sql( $recordsql ) )
	{
		return $DB->get_record_sql( $recordsql, array() )->heading;
	}

	return 0;

}



/*
 *
 * Method to get page ID
 *
 */
function theme_mb2nl_builderpage_pageid()
{
	global $PAGE, $CFG;

	if ( ! theme_mb2nl_has_builderpage() )
	{
		return 0;
	}

	// Get page api file
	require_once( $CFG->dirroot . '/local/mb2builder/classes/pages_api.php' );

	if ( $PAGE->pagetype === 'mod-page-view' )
	{
		$content = Mb2builderPagesApi::get_page_content();
	}
	elseif ( $PAGE->pagetype === 'site-index' )
	{
		$content = Mb2builderPagesApi::get_fp_summary();
	}

	$pageid = Mb2builderPagesApi::get_shortcode_id($content);

	if ( $pageid )
	{
		return $pageid;
	}

	return 0;

}



/*
 *
 * Method to get header builder style
 *
 */
function theme_mb2nl_builder_header()
{
	global $DB;

	$pageid = theme_mb2nl_builderpage_pageid();

	if ( ! $pageid )
	{
		return 0;
	}

	// Get footer databse
	// Check for old vearion of page builder if 'footer' filed exist
	$dbman = $DB->get_manager();
	$table_pages = new xmldb_table( 'local_mb2builder_pages' );
	$headerstylefield = new xmldb_field( 'headerstyle', XMLDB_TYPE_TEXT, null, null, null, null );

	if ( ! $dbman->field_exists( $table_pages, $headerstylefield ) )
	{
		return 0;
	}

	$recordsql = 'SELECT headerstyle FROM {local_mb2builder_pages} WHERE id=' . $pageid;

	if ( $DB->record_exists_sql( $recordsql ) )
	{
		return $DB->get_record_sql( $recordsql, array() )->headerstyle;
	}

	return 0;

}





/*
 *
 * Method to get header builder style
 *
 */
function theme_mb2nl_builder_menu()
{
	global $DB;

	$pageid = theme_mb2nl_builderpage_pageid();

	if ( ! $pageid )
	{
		return 0;
	}

	// Get builder databse
	// Check for old vearion of page builder if 'menu' filed exist
	$dbman = $DB->get_manager();
	$table_pages = new xmldb_table( 'local_mb2builder_pages' );
	$menufield = new xmldb_field( 'menu', XMLDB_TYPE_INTEGER, '10', null, null, null, '0' );

	if ( ! $dbman->field_exists( $table_pages, $menufield ) )
	{
		return 0;
	}

	$recordsql = 'SELECT menu FROM {local_mb2builder_pages} WHERE id=' . $pageid;

	if ( $DB->record_exists_sql( $recordsql ) )
	{
		return $DB->get_record_sql( $recordsql, array() )->menu;
	}

	return 0;

}





/*
 *
 * Method to get header builder style
 *
 */
function theme_mb2nl_builder_css()
{

	global $DB, $PAGE;

	$pageid = theme_mb2nl_builderpage_pageid();

	// Page ID from page builder editor
	if ( $PAGE->pagetype === 'admin-local-mb2builder-customize' )
	{
		$urlparams = theme_mb2nl_get_url_params();
		$pageid = $urlparams['itemid'];
	}

	if ( ! $pageid )
	{
		return 0;
	}

	// Get footer databse
	// Check for old vearion of page builder if 'footer' filed exist
	$dbman = $DB->get_manager();
	$table_pages = new xmldb_table( 'local_mb2builder_pages' );
	$pagecssfield = new xmldb_field( 'pagecss', XMLDB_TYPE_TEXT, null, null, null, null );

	if ( ! $dbman->field_exists( $table_pages, $pagecssfield ) )
	{
		return 0;
	}

	$recordsql = 'SELECT pagecss FROM {local_mb2builder_pages} WHERE id=' . $pageid;

	if ( $DB->record_exists_sql( $recordsql ) )
	{
		return $DB->get_record_sql( $recordsql, array() )->pagecss;
	}

	return 0;

}




/*
 *
 * Method to get header builder style
 *
 */
function theme_mb2nl_builder_style()
{
	$output = '';
	$enrolpage = theme_mb2nl_is_custom_enrolment_page();
	$css = theme_mb2nl_builder_css();

	if ( $enrolpage )
	{
		$css = theme_mb2nl_mb2fields_filed('mb2css');
	}

	if ( ! $css )
	{
		return;
	}

	$output .= '<style type="text/css" id="css-mb2-page-builder">';
	$output .= $css;
	$output .= '</style>';

	return $output;

}
