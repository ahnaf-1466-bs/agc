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
 * @copyright  2018 - 2020 Mariusz Boloz (mb2moodle.com/)
 * @license   Commercial https://themeforest.net/licenses
 */

defined('MOODLE_INTERNAL') || die();



$mb2_settings = array(
	'id' => 'html',
	'subid' => '',
	'title' => get_string('html', 'local_mb2builder'),
	'icon' => 'fa fa-html5',
	'tabs' => array(
		'general' => get_string('generaltab', 'local_mb2builder'),
		'style' => get_string('styletab', 'local_mb2builder')
	),
	'attr' => array(
		'text'=>array(
			'type'=>'textarea',
			'section' => 'general',
			'title'=> get_string('html', 'local_mb2builder'),
			'action' => 'text',
			'selector' => '.html-content',
			'default' => ''
		),
		'el_onmobile' => array(
			'type' => 'yesno',
			'section' => 'style',
			'title'=> get_string('onmobile', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 1,
			'action' => 'class',
			'class_remove' => 'el_onmobile0 el_onmobile1',
			'class_prefix' => 'el_onmobile'
		)
	)
);


define('LOCAL_MB2BUILDER_SETTINGS_HTML', base64_encode( serialize( $mb2_settings ) ));
