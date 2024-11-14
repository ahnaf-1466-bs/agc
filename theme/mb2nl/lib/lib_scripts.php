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


function theme_mb2nl_scripts()
{
	global $PAGE;

	$PAGE->requires->jquery();

	// Do not load any scripts on page builder editing page
	if ( $PAGE->pagelayout === 'mb2builder_form' )
	{
		return;
	}

	$tb = preg_match('@local-mb2builder-customize@', $PAGE->pagetype ) ? 1 : 0;
	$themedir = theme_mb2nl_themedir();

	// We need these scripts on all pages
	$PAGE->requires->js( $themedir . '/mb2nl/script/mb2nl_helper.js', $tb );
	$PAGE->requires->js( $themedir . '/mb2nl/script/js.cookie.js', $tb );
	$PAGE->requires->js( $themedir . '/mb2nl/script/inview.js', $tb );
	$PAGE->requires->js( $themedir . '/mb2nl/script/swiper.js', $tb);
	$PAGE->requires->js( $themedir . '/mb2nl/script/jarallax.js', $tb );
	$PAGE->requires->js( $themedir . '/mb2nl/script/magnific-popup.js', $tb );
	$PAGE->requires->js( $themedir . '/mb2nl/script/typed.js', $tb );

	// Main slider script
	// Load it only if the front page slider is enabled
	if ( theme_mb2nl_theme_setting($PAGE, 'slider') )
	{
		$PAGE->requires->js( $themedir . '/mb2nl/script/lightslider/lightslider.js', $tb );
	}

	// Scripts only for admin users
	if ( is_siteadmin() )
	{
		$PAGE->requires->js( $themedir . '/mb2nl/script/spectrum/spectrum.js', $tb );
		$PAGE->requires->css( $themedir . '/mb2nl/script/spectrum/spectrum.css' );
	}

	// Scripts for all pages EXCLUDING page builder
	// We don't need layzyload and plugin init scipts on page builder editing page
	// For each plugin page builder loads own init script
	if ( $PAGE->pagelayout !== 'mb2builder' )
	{
		$PAGE->requires->js( $themedir . '/mb2nl/script/lazyload.js', $tb );
		$PAGE->requires->js( $themedir . '/mb2nl/script/mb2nl_plugins.js', $tb );
	}

	$PAGE->requires->js( $themedir . '/mb2nl/script/mb2nl.js', $tb );

}
