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

$settings = null;

defined('MOODLE_INTERNAL') || die();

if ( is_siteadmin() )
{
    // Reguire heleper class
	require( __DIR__ . '/classess/fields.php' );

	$ADMIN->add('themes', new admin_category('theme_mb2nl', get_string('pluginname', 'theme_mb2nl')));

	require(__DIR__ . '/settings/general.php');
	require(__DIR__ . '/settings/courses.php');
	require(__DIR__ . '/settings/features.php');
	require(__DIR__ . '/settings/fonts.php');
	require(__DIR__ . '/settings/navigation.php');
	require(__DIR__ . '/settings/social.php');
	require(__DIR__ . '/settings/style.php');
	require(__DIR__ . '/settings/typography.php');

}
