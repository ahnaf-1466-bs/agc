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

// Moodle classess
require_once( __DIR__ . '/../../config.php' );
require_once( $CFG->libdir . '/adminlib.php' );
require_once( __DIR__ . '/lib.php' );
require_once( __DIR__ . '/form-page.php');

// Builder classess
require_once( __DIR__ . '/classes/pages_helper.php' );
require_once( __DIR__ . '/classes/pages_api.php' );
require_once( __DIR__ . '/classes/footers_api.php' );
require_once( __DIR__ . '/classes/builder.php' );

require_login();

// Optional parameters
$itemid = optional_param('itemid', 0, PARAM_INT);
$footer = optional_param('footer', 0, PARAM_INT);
$pageid = optional_param( 'pageid', '', PARAM_TEXT );
$footerid = optional_param( 'footerid', '', PARAM_TEXT );

// Link generation
$urlparameters = array( 'itemid' => $itemid, 'pageid' => $pageid, 'footer' => $footer, 'footerid' => $footerid );
$baseurl = new moodle_url( '/local/mb2builder/customize.php', $urlparameters );

// Configure the context of the page
//admin_externalpage_setup( 'local_mb2builder_managepages', '', null, $baseurl );
require_capability( 'local/mb2builder:managepages', context_system::instance() );
$PAGE->set_context( context_system::instance() );
$PAGE->set_url( '/local/mb2builder/customize.php' );

$data = '';
// Get page data by itemid
if ( $itemid && ! $footer )
{
    $data = Mb2builderPagesApi::get_record( $itemid );
}
// Get page data by pageid
// It's require if user don't save page and refresh iframe after ajax saving
// remember that in this case itemid param in URL is still empty
elseif ( $pageid && ! $footer )
{
    $data = Mb2builderPagesApi::get_record( $pageid, true );
}
// Now get footer data by ID
elseif ( $footer && $itemid )
{
    $data = Mb2builderFootersApi::get_record( $itemid );
}
// Get footer data by footerid
// It's require if user don't save page and refresh iframe after ajax saving
// remember that in this case itemid param in URL is still empty
elseif ( ! $itemid && $footer && $footerid )
{
    $data = Mb2builderFootersApi::get_record( $footerid, true );
}

// The page title
$titlepage = get_string( 'customize', 'local_mb2builder' );
$PAGE->set_pagelayout( 'mb2builder' );
$PAGE->navbar->add($titlepage);
$PAGE->set_heading($titlepage);
$PAGE->set_title($titlepage);
echo $OUTPUT->header();

if ( ! mb2builderBuilder::check_shortcodes_filter() )
{
    echo get_string( 'nofilter', 'local_mb2builder' );
}
elseif ( ! mb2builderBuilder::check_urltolink_filter() )
{
    echo get_string( 'urltolink', 'local_mb2builder' );
}
else
{
    // TO DO: check it for imported content
    // $filteropt = new stdClass;
	// $filteropt->overflowdiv = true;
	// $filteropt->noclean = true;

    //Show page builder
    echo format_text( mb2builderBuilder::get_builder_layout( $data, $footer ), FORMAT_HTML );

    // Show page builder settings
    echo mb2builderApi::get_builder_settings( array('footer'=> $footer) );

    if ( $footer )
    {
        echo Mb2builderFootersApi::get_form_democontent( array( 'itemid' => $itemid, 'footerid' => $footerid ) );
    }
    else
    {
        echo Mb2builderPagesApi::get_form_democontent( array( 'itemid' => $itemid, 'pageid' => $pageid ) );
    }

    //if ( ! $footer )
    //{
        echo mb2builderBuilder::manage_layouts();
    //}
}

if ( preg_match( '@mb2builder@', $PAGE->pagetype ) )
{
    //$PAGE->requires->js_call_amd( 'local_mb2builder/builder','init' );
    //$PAGE->requires->js_call_amd( 'local_mb2builder/actions','initActions' );
}

echo $OUTPUT->footer();
?>
