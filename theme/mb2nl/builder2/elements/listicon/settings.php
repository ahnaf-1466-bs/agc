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
	'id' => 'listicon',
	'subid' => 'listicon_item',
	'title' => get_string('listicon', 'local_mb2builder'),
	'icon' => 'fa fa-list',
	'type'=> 'general',
	'tabs' => array(
		'general' => get_string('generaltab', 'local_mb2builder'),
		'typo' => get_string('typotab', 'local_mb2builder'),
		'colors' => get_string('colorstab', 'local_mb2builder'),
		'style' => get_string('styletab', 'local_mb2builder')
	),
	'attr' => array(
		'horizontal' => array(
			'type' => 'buttons',
			'section' => 'general',
			'title'=> get_string('display', 'local_mb2builder'),
			'options' => array(
				0 => get_string('normal', 'local_mb2builder'),
				1 => get_string('horizontal', 'local_mb2builder'),
				2 => get_string('twocols', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'selector' => '.theme-listicon',
			'class_remove' => 'horizontal0 horizontal1 horizontal2',
			'class_prefix' => 'horizontal',
		),
		'align'=>array(
			'type' => 'buttons',
			'section' => 'general',
			'title'=> get_string('alignlabel', 'local_mb2builder'),
			'options' => array(
				'none' => get_string('none', 'local_mb2builder'),
				'left' => get_string('left', 'local_mb2builder'),
				'right' => get_string('right', 'local_mb2builder'),
				'center' => get_string('center', 'local_mb2builder')
			),
			'default' => 'none',
			'action' => 'class',
			'selector' => '.theme-listicon',
			'class_remove' => 'alignnone alignleft alignright aligncenter',
			'class_prefix' => 'align'
		),
		'space'=>array(
			'type' => 'range',
			'section' => 'general',
			'title'=> get_string('elpacing', 'local_mb2builder'),
			'min'=> 0,
			'max' => 10,
			'step' => 0.01,
			'default'=> .45,
			'action' => 'style',
			'style_suffix' => 'none',
			'changemode' => 'input',
			'selector' => '.theme-listicon',
			'style_properity' => '--mb2-pb-listicon-space',
			'style_suffix' => 'rem',
		),
		'icon'=>array(
			'type'=>'icon',
			'section' => 'general',
			'title'=> get_string('icon', 'local_mb2builder'),
			'action' => 'icon',
			'default' => 'fa fa-check-square-o',
			'selector' => '.iconel i',
			'globalparent' => 1
		),
		'isize'=>array(
			'type' => 'range',
			'section' => 'general',
			'title'=> get_string('iconsize', 'local_mb2builder'),
			'min'=> 1,
			'max' => 10,
			'step' => 0.01,
			'default'=> 2.65,
			'action' => 'style',
			'style_suffix' => 'none',
			'changemode' => 'input',
			'selector' => '.theme-listicon',
			'style_properity' => '--mb2-pb-listicon-isize',
			'style_suffix' => 'rem',
		),
		'fs'=>array(
			'type' => 'range',
			'section' => 'typo',
			'title'=> get_string('sizelabel', 'local_mb2builder'),
			'min'=> 1,
			'max' => 10,
			'step' => 0.01,
			'default'=> 1,
			'action' => 'style',
			'style_suffix' => 'none',
			'changemode' => 'input',
			'style_properity' => '--mb2-pb-listicon-fs',
			'selector' => '.theme-listicon',
			'style_suffix' => 'rem',
		),
		'fwcls'=>array(
			'type' => 'buttons',
			'section' => 'typo',
			'title'=> get_string('fweight', 'local_mb2builder'),
			'options' => array(
				'global' => get_string('global', 'local_mb2builder'),
				'light' => get_string('fwlight', 'local_mb2builder'),
				'normal' => get_string('normal', 'local_mb2builder'),
				'medium' => get_string('wmedium', 'local_mb2builder'),
				'bold' => get_string('fwbold', 'local_mb2builder')
			),
			'default' => 'global',
			'action' => 'class',
			'selector' => '.theme-listicon',
			'class_remove' => 'fwglobal fwlight fwnormal fwmedium fwbold',
			'class_prefix' => 'fw'
		),
		'iconcolor'=>array(
			'type'=>'color',
			'section' => 'colors',
			'title'=> get_string('color', 'local_mb2builder'),
			'action' => 'color',
			'selector' => '.iconel',
			'style_properity' => 'color',
			'globalparent' => 1
		),
		'textcolor'=>array(
			'type'=>'color',
			'section' => 'colors',
			'title'=> get_string('textcolor', 'local_mb2builder'),
			'action' => 'color',
			'selector' => '.list-text',
			'style_properity' => 'color',
			'globalparent' => 1
		),
		'iconbg' => array(
			'type' => 'yesno',
			'section' => 'colors',
			'title'=> get_string('background', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'selector' => '.theme-listicon',
			'class_remove' => 'iconbg0 iconbg1',
			'class_prefix' => 'iconbg',
		),
		'bgcolor'=>array(
			'type'=>'color',
			'showon' => 'iconbg:1',
			'section' => 'colors',
			'title'=> get_string('bgcolor', 'local_mb2builder'),
			'action' => 'color',
			'selector' => '.iconel',
			'style_properity' => 'background-color',
			'globalparent' => 1
		),
		'border' => array(
			'type' => 'yesno',
			'section' => 'colors',
			'title'=> get_string('border', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'selector' => '.theme-listicon',
			'class_remove' => 'border0 border1',
			'class_prefix' => 'border',
		),
		'borderw'=>array(
			'type'=>'range',
			'section' => 'colors',
			'showon' => 'border:1',
			'title'=> get_string('borderw', 'local_mb2builder'),
			'min'=> 1,
			'max' => 5,
			'default'=> 1,
			'action' => 'style',
			'changemode' => 'input',
			'selector' => '.list-text',
			'style_properity' => 'border-bottom-width'
		),
		'bordercolor'=>array(
			'type'=>'color',
			'showon' => 'border:1',
			'section' => 'colors',
			'title'=> get_string('bordercolor', 'local_mb2builder'),
			'action' => 'color',
			'selector' => '.list-text',
			'style_properity' => 'border-bottom-color',
			'globalparent' => 1
		),
		'mt'=>array(
			'type'=>'range',
			'section' => 'style',
			'title'=> get_string('mt', 'local_mb2builder'),
			'min'=> 0,
			'max' => 300,
			'default'=> 0,
			'action' => 'style',
			'changemode' => 'input',
			'style_properity' => 'margin-top'
		),
		'mb'=>array(
			'type'=>'range',
			'section' => 'style',
			'title'=> get_string('mb', 'local_mb2builder'),
			'min'=> 0,
			'max' => 300,
			'default'=> 30,
			'action' => 'style',
			'changemode' => 'input',
			'style_properity' => 'margin-bottom'
		),
		'custom_class'=>array(
			'type'=>'text',
			'section' => 'style',
			'title'=> get_string('customclasslabel', 'local_mb2builder'),
			'desc'=> get_string('customclassdesc', 'local_mb2builder'),
			'default'=> ''
		)
	),
	'subelement' => array(
		'tabs' => array(
			'general' => get_string('generaltab', 'local_mb2builder')
		),
		'attr' => array(
			'text'=>array(
				'type'=>'textarea',
				'section' => 'general',
				'title'=> get_string('text', 'local_mb2builder'),
				'action' => 'text',
				'default' => 'List content here.',
				'selector' => '.list-text'
			),
			'icon'=>array(
				'type'=>'icon',
				'section' => 'general',
				'title'=> get_string('icon', 'local_mb2builder'),
				'action' => 'icon',
				'default' => '',
				'selector' => '.iconel i',
				'globalchild' => 1
			),
			'iconcolor'=>array(
				'type'=>'color',
				'section' => 'general',
				'title'=> get_string('color', 'local_mb2builder'),
				'action' => 'color',
				'selector' => '.iconel',
				'style_properity' => 'color',
				'globalchild' => 1
			),
			'textcolor'=>array(
				'type'=>'color',
				'section' => 'general',
				'title'=> get_string('textcolor', 'local_mb2builder'),
				'action' => 'color',
				'selector' => '.list-text',
				'style_properity' => 'color',
				'globalchild' => 1
			),
			'bgcolor'=>array(
				'type'=>'color',
				'showon2' => 'iconbg:1',
				'section' => 'general',
				'title'=> get_string('bgcolor', 'local_mb2builder'),
				'action' => 'color',
				'selector' => '.iconel',
				'style_properity' => 'background-color',
				'globalchild' => 1
			),
			'bordercolor'=>array(
				'type'=>'color',
				'showon2' => 'border:1',
				'section' => 'general',
				'title'=> get_string('bordercolor', 'local_mb2builder'),
				'action' => 'color',
				'selector' => '.list-text',
				'style_properity' => 'border-bottom-color',
				'globalchild' => 1
			),
			'link'=>array(
				'type'=>'text',
				'section' => 'general',
				'title'=> get_string('link', 'local_mb2builder')
			),
			'link_target'=>array(
				'type'=>'yesno',
				'section' => 'general',
				'title'=> get_string('linknewwindow', 'local_mb2builder'),
				'options' => array(
					1 => get_string('yes', 'local_mb2builder'),
					0 => get_string('no', 'local_mb2builder')
				),
				'action' => 'none',
				'default' => 0
			)
		)
	)
);


define( 'LOCAL_MB2BUILDER_SETTINGS_LISTICON', base64_encode( serialize( $mb2_settings ) ) );
