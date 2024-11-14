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
 * @package    local_mb2builder
 * @copyright  2018 - 2022 Mariusz Boloz (mb2moodle.com)
 * @license    Commercial https://themeforest.net/licenses
 */

defined( 'MOODLE_INTERNAL' ) || die();

function xmldb_local_mb2builder_upgrade( $oldversion )
{
    global $DB;
    $dbman = $DB->get_manager();
    $pagedata = new stdClass();

    require_once( __DIR__ . '/../lib.php' );
    require_once( __DIR__ . '/../classes/pages_api.php' );

    if ( $oldversion < 2020090916 )
    {
        $table_pages = new xmldb_table( 'local_mb2builder_pages' );
        $table_pages->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table_pages->add_field('pageid', XMLDB_TYPE_TEXT, null, null, null, null);
        $table_pages->add_field('sortorder', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table_pages->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table_pages->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table_pages->add_field('title', XMLDB_TYPE_TEXT, null, null, null, null);
        $table_pages->add_field('content', XMLDB_TYPE_TEXT, null, null, null, null);
        $table_pages->add_field('democontent', XMLDB_TYPE_TEXT, null, null, null, null);
        $table_pages->add_field('createdby', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table_pages->add_field('modifiedby', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table_pages->add_key('primary', XMLDB_KEY_PRIMARY, array('id') );

        if ( ! $dbman->table_exists( $table_pages ) )
        {
            $dbman->create_table( $table_pages );
        }

        $table_layouts = new xmldb_table( 'local_mb2builder_layouts' );
        $table_layouts->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table_layouts->add_field('sortorder', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table_layouts->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table_layouts->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table_layouts->add_field('name', XMLDB_TYPE_TEXT, null, null, null, null);
        $table_layouts->add_field('content', XMLDB_TYPE_TEXT, null, null, null, null);
        $table_layouts->add_field('createdby', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table_layouts->add_field('modifiedby', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table_layouts->add_key('primary', XMLDB_KEY_PRIMARY, array('id') );

        if ( ! $dbman->table_exists( $table_layouts ) )
        {
            $dbman->create_table( $table_layouts );
        }

        // Now we have to check if user has page built with the old page builder
        // If yes we have to:
        // 1. Add new page
        // 2. Add shortcode to the front page summary content
        // 3. Purge cache of the front page
        $oldpage = isset( get_config('local_mb2builder')->builderfptext ) ? get_config('local_mb2builder')->builderfptext : '';

        if ( $oldpage )
        {
            // Set content and demo content for the new page
            $pagedata->content = $oldpage;
            $pagedata->democontent = $oldpage;
            $pagedata->title = get_string( 'sitehome' );

            // Add new page
            Mb2builderPagesApi::add_record( $pagedata );

            // Add shortcode to the front page summary
            // -1 means that it's front page
            // 1 - page id will be 1 because this is the first page which user create
            Mb2builderPagesApi::update_moodle_page( -1, 1 );

            // Clear cache for the front page
            rebuild_course_cache( 1, true );
        }

    }


    if ( $oldversion < 2021033025 )
    {
        $table_pages = new xmldb_table( 'local_mb2builder_pages' );
        $headingfield = new xmldb_field( 'heading', XMLDB_TYPE_INTEGER, '10', null, null, null, '0' );

        if ( ! $dbman->field_exists( $table_pages, $headingfield ) )
        {
            $dbman->add_field( $table_pages, $headingfield );
        }

        upgrade_plugin_savepoint( true, 2021033025, 'local' , 'mb2builder' );
    }

    if ( $oldversion < 2022060616 )
    {
        $table_pages = new xmldb_table( 'local_mb2builder_pages' );
        $footerfield = new xmldb_field( 'footer', XMLDB_TYPE_INTEGER, '10', null, null, null, '0' );

        if ( ! $dbman->field_exists( $table_pages, $footerfield ) )
        {
            $dbman->add_field( $table_pages, $footerfield );
        }

        upgrade_plugin_savepoint( true, 2022060616, 'local' , 'mb2builder' );
    }

    // Add footer table
    if ( $oldversion < 2022060616 )
    {
        $table_footers = new xmldb_table( 'local_mb2builder_footers' );
        $table_footers->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table_footers->add_field('footerid', XMLDB_TYPE_TEXT, null, null, null, null);
        $table_footers->add_field('sortorder', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table_footers->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table_footers->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table_footers->add_field('name', XMLDB_TYPE_TEXT, null, null, null, null);
        $table_footers->add_field('content', XMLDB_TYPE_TEXT, null, null, null, null);
        $table_footers->add_field('democontent', XMLDB_TYPE_TEXT, null, null, null, null);
        $table_footers->add_field('createdby', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table_footers->add_field('modifiedby', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table_footers->add_key('primary', XMLDB_KEY_PRIMARY, array('id') );

        if ( ! $dbman->table_exists( $table_footers ) )
        {
            $dbman->create_table( $table_footers );
        }
    }


    // Add header style field
    if ( $oldversion < 2022111412 )
    {
        $table_pages = new xmldb_table( 'local_mb2builder_pages' );
        $headerstylefield = new xmldb_field( 'headerstyle', XMLDB_TYPE_TEXT, null, null, null, null );

        if ( ! $dbman->field_exists( $table_pages, $headerstylefield ) )
        {
            $dbman->add_field( $table_pages, $headerstylefield );
        }

        upgrade_plugin_savepoint( true, 2022111412, 'local' , 'mb2builder' );
    }

    // Add page style
    if ( $oldversion < 2022121521 )
    {
        $table_pages = new xmldb_table( 'local_mb2builder_pages' );
        $pagecssfield = new xmldb_field( 'pagecss', XMLDB_TYPE_TEXT, null, null, null, null );

        if ( ! $dbman->field_exists( $table_pages, $pagecssfield ) )
        {
            $dbman->add_field( $table_pages, $pagecssfield );
        }

        upgrade_plugin_savepoint( true, 2022121521, 'local' , 'mb2builder' );
    }

    // Add menu
    if ( $oldversion < 2023032919 )
    {
        $table_pages = new xmldb_table( 'local_mb2builder_pages' );
        $menufield = new xmldb_field( 'menu', XMLDB_TYPE_INTEGER, '10', null, null, null, '0' );

        if ( ! $dbman->field_exists( $table_pages, $menufield ) )
        {
            $dbman->add_field( $table_pages, $menufield );
        }

        upgrade_plugin_savepoint( true, 2023032919, 'local' , 'mb2builder' );
    }    

    return true;
}
