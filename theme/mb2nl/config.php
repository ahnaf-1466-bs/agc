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

$THEME->doctype = 'html5';
$THEME->name = 'mb2nl';

$THEME->extrascsscallback = 'theme_mb2nl_get_pre_scss_raw';
$THEME->prescsscallback = 'theme_mb2nl_get_pre_scss';
$THEME->scss = function( $theme ){
    return theme_mb2nl_get_scss_content( $theme ) ;
};
$THEME->sheets = array();
$THEME->parents = array( 'boost' );
$THEME->supportscssoptimisation = false;
$THEME->yuicssmodules = array();
$THEME->rendererfactory = 'theme_overridden_renderer_factory';
$THEME->blockrtlmanipulations = array();
$THEME->enable_dock = false;
$THEME->editor_sheets = array();
$THEME->usefallback = true;
$THEME->haseditswitch = false;

// Define region arrays
$fpRegions = array('side-pre','side-post','content-top','content-bottom','adminblock','bottom','bottom-a','bottom-b','bottom-c','bottom-d');
//$fpRegions = array('side-pre','content-top','content-bottom','adminblock','bottom','bottom-a','bottom-b','bottom-c','bottom-d');
$incourseRegions = array('side-pre','content-top','content-bottom','adminblock','bottom','bottom-a','bottom-b','bottom-c','bottom-d');
$defRegions = array('side-pre','side-post','content-top','content-bottom','adminblock','bottom','bottom-a','bottom-b','bottom-c','bottom-d');
//$defRegions = array('side-pre','content-top','content-bottom','adminblock','bottom','bottom-a','bottom-b','bottom-c','bottom-d');
$def2ColsRegions = array('side-pre','content-top','content-bottom','adminblock','bottom','bottom-a','bottom-b','bottom-c','bottom-d');
$oneColRegion = array('content-top','content-bottom','adminblock','bottom','bottom-a','bottom-b','bottom-c','bottom-d');

// Moodle documentation
// https://docs.moodle.org/dev/Page_API
$THEME->layouts = array(
    'base' => array(
		'file' => 'columns2.php',
        'regions' => $def2ColsRegions,
        'defaultregion' => 'side-pre'
    ),
    'standard' => array(
        'file' => 'columns2.php',
        'regions' => $def2ColsRegions,
        'defaultregion' => 'side-pre',
    ),
    'course' => array(
        'file' => isset($THEME->settings->c2cols) && $THEME->settings->c2cols ? 'columns2.php' : 'columns3.php',
        'regions' => $defRegions,
        'defaultregion' => 'side-pre'
    ),
    'coursecategory' => array(
        'file' => 'columns2.php',
        'regions' => $def2ColsRegions,
        'defaultregion' => 'side-pre',
    ),
    'incourse' => array(
        'file' => 'incourse.php',
        'regions' => $incourseRegions,
        'defaultregion' => 'side-pre'
    ),
    'frontpage' => array(
        'file' => 'frontpage.php',
        'regions' => $fpRegions,
        'defaultregion' => 'side-pre',
        'options' => array('nonavbar' => true),
    ),
    'mydashboard' => array(
        'file' => 'columns3.php',
        'regions' => $defRegions,
        'defaultregion' => 'side-pre',
        'options' => array(),
    ),
    'mycourses' => array(
        'file' => 'columns2.php',
        'regions' => $def2ColsRegions,
        'defaultregion' => 'side-pre',
    ),
    'admin' => array(
        'file' => 'columns2.php',
        'regions' => $def2ColsRegions,
        'defaultregion' => 'side-pre',
    ),
    'mypublic' => array(
        'file' => 'columns2.php',
        'regions' => $def2ColsRegions,
        'defaultregion' => 'side-pre',
    ),
    'login' => array(
        'file' => 'columns1.php',
        'regions' => $oneColRegion,
		'defaultregion' => 'content-bottom',
        'options' => array(),
    ),
    'popup' => array(
        'file' => 'popup.php',
        'regions' => array(),
        'options' => array(),
    ),
    'frametop' => array(
        'file' => 'columns1.php',
        'regions' => array(),
        'options' => array('nofooter' => true, 'nocoursefooter' => true),
    ),
    'embedded' => array(
        'file' => 'embedded.php',
        'regions' => array()
    ),
    'maintenance' => array(
        'file' => 'maintenance.php',
        'regions' => array(),
    ),
    'print' => array(
        'file' => 'columns1.php',
        'regions' => array(),
        'options' => array('nofooter' => true, 'nonavbar' => false),
    ),
    'redirect' => array(
        'file' => 'embedded.php',
        'regions' => array(),
    ),
    'report' => array(
        'file' => 'columns2.php',
        'regions' => $def2ColsRegions,
        'defaultregion' => 'side-pre',
    ),
    'secure' => array(
        'file' => 'columns3.php',
        'regions' => $defRegions,
        'defaultregion' => 'side-pre'
    ),
    'mb2builder' => array(
        'theme' => 'mb2nl',
        'file' => 'mb2builder.php',
        'regions' => array()
    ),
    'mb2builder_form' => array(
        'theme' => 'mb2nl',
        'file' => 'mb2builder_form.php',
        'regions' => array()
    )
);
