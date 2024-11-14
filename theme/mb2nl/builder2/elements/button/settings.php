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
	'id' => 'button',
	'subid' => '',
	'title' => get_string('button', 'local_mb2builder'),
	'icon' => 'fa fa-hand-pointer-o',
	'tabs' => array(
		'general' => get_string('generaltab', 'local_mb2builder'),
		'type' => get_string('type', 'local_mb2builder'),
		'typo' => get_string('typotab', 'local_mb2builder'),
		'colors' => get_string('colorstab', 'local_mb2builder'),
		'style' => get_string('styletab', 'local_mb2builder')
	),
	'attr' => array(
		'text'=>array(
			'type' => 'text',
			'section' => 'general',
			'title' => get_string('text', 'local_mb2builder'),
			'action' => 'text',
			'selector' => '.btn-intext',
			'default' => get_string( 'btntext', 'local_mb2builder' )
		),
		'isicon'=>array(
			'type'=>'yesno',
			'section' => 'general',
			'title'=> get_string('icon', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'selector' => '.mb2-pb-btn',
			'class_remove' => 'isicon0 isicon1',
			'class_prefix' => 'isicon',
		),
		'icon' => array(
			'type'=>'icon',
			'showon' => 'isicon:1',
			'section' => 'general',
			'title'=> get_string('icon', 'local_mb2builder'),
			'default' => 'fa fa-play-circle-o',
			'action' => 'icon',
			'selector' => '.btn-incon i'
		),
		'link'=>array(
			'type'=>'text',
			'section' => 'general',
			'title'=> get_string('link', 'local_mb2builder'),
			'default' => '#'
		),
		'target'=>array(
			'type'=>'yesno',
			'section' => 'general',
			'title'=> get_string('linknewwindow', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'action' => 'none',
			'default' => 0
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
			'selector' => '.mb2-pb-btn',
			'class_remove' => 'fwglobal fwlight fwnormal fwmedium fwbold',
			'class_prefix' => 'fw'
		),
		'lspacing'=>array(
			'type'=>'range',
			'section' => 'typo',
			'title'=> get_string('lspacing', 'local_mb2builder'),
			'min'=> -10,
			'max' => 30,
			'step' => 1,
			'default'=> 0,
			'action' => 'style',
			'changemode' => 'input',
			'selector' => '.mb2-pb-btn',
			'style_properity' => 'letter-spacing'
		),
		'wspacing'=>array(
			'type'=>'range',
			'section' => 'typo',
			'title'=> get_string('wspacing', 'local_mb2builder'),
			'min'=> -10,
			'max' => 30,
			'step' => 1,
			'default'=> 0,
			'action' => 'style',
			'changemode' => 'input',
			'selector' => '.mb2-pb-btn',
			'style_properity' => 'word-spacing'
		),
		'upper' => array(
			'type' => 'yesno',
			'section' => 'typo',
			'title'=> get_string('uppercase', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'selector' => '.mb2-pb-btn',
			'class_remove' => 'upper0 upper1',
			'class_prefix' => 'upper',
		),

		'type'=>array(
			'type'=>'list',
			'section' => 'type',
			'title'=> get_string('type', 'local_mb2builder'),
			'options' => array(
				'default' => get_string('default', 'local_mb2builder'),
				'primary' => get_string('primary', 'local_mb2builder'),
				'secondary' => get_string('secondary', 'local_mb2builder'),
				'success' => get_string('success', 'local_mb2builder'),
				'warning' => get_string('warning', 'local_mb2builder'),
				'info' => get_string('info', 'local_mb2builder'),
				'danger' => get_string('danger', 'local_mb2builder'),
				'inverse' => get_string('inverse', 'local_mb2builder'),
				'link' => get_string('link', 'local_mb2builder')
			),
			'default' => 'primary',
			'action' => 'class',
			'selector' => '.mb2-pb-btn',
			'class_remove' => 'typeprimary typesecondary typesuccess typewarning typeinfo typedanger typeinverse typelink',
			'class_prefix' => 'type',
		),
		'size'=>array(
			'type' => 'buttons',
			'section' => 'type',
			'title'=> get_string('sizelabel', 'local_mb2builder'),
			'options' => array(
				//'xs' => get_string('xsmall', 'local_mb2builder'),
				'sm' => get_string('small', 'local_mb2builder'),
				'normal' => get_string('medium', 'local_mb2builder'),
				'lg' => get_string('large', 'local_mb2builder'),
				'xlg' => get_string('xlarge', 'local_mb2builder')
			),
			'default' => 'normal',
			'action' => 'class',
			'selector' => '.mb2-pb-btn',
			'class_remove' => 'sizesm sizelg sizexlg sizenormal',
			'class_prefix' => 'size',
		),
		'rounded' => array(
			'type' => 'yesno',
			'section' => 'type',
			'title'=> get_string('rounded', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'selector' => '.mb2-pb-btn',
			'class_remove' => 'rounded0 rounded1',
			'class_prefix' => 'rounded',
		),
		'border' => array(
			'type' => 'yesno',
			'section' => 'type',
			'title'=> get_string('border', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'selector' => '.mb2-pb-btn',
			'class_remove' => 'btnborder0 btnborder1',
			'class_prefix' => 'btnborder',
		),
		'fw' => array(
			'type' => 'yesno',
			'section' => 'type',
			'title'=> get_string('fullwidth', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'selector2' => '.mb2-pb-btn',
			'action' => 'class',
			'class_remove' => 'fw0 fw1',
			'class_prefix' => 'fw',
		),

		'group_btn_start_1' => array(
		'type'=>'group_start', 'section' => 'colors', 'title'=> get_string('normal', 'local_mb2builder')), // ============ GROUP START ============ //
		'color'=>array(
			'type'=>'color',
			'section' => 'colors',
			'title'=> get_string('color', 'local_mb2builder'),
			'action' => 'color',
			'selector' => '.mb2-pb-btn',
			'cssvariable' => '--mb2-pb-btn-color'
		),

		'bgcolor'=>array(
			'type'=>'color',
			'section' => 'colors',
			'title'=> get_string('bgcolor', 'local_mb2builder'),
			'action' => 'color',
			'selector' => '.mb2-pb-btn',
			'cssvariable' => '--mb2-pb-btn-bgcolor'
		),

		'borcolor'=>array(
			'type'=>'color',
			'section' => 'colors',
			'title'=> get_string('bordercolor', 'local_mb2builder'),
			'action' => 'color',
			'selector' => '.mb2-pb-btn',
			'cssvariable' => '--mb2-pb-btn-borcolor'
		),
		'group_btn_end_1' => array('type'=>'group_end', 'section' => 'colors'), // ============ GROUP END ============ //

		'group_btn_start_2' => array(
		'type'=>'group_start', 'section' => 'colors', 'title'=> get_string('hover_active', 'local_mb2builder')), // ============ GROUP START ============ //
		'hcolor'=>array(
			'type'=>'color',
			'section' => 'colors',
			'title'=> get_string('color', 'local_mb2builder'),
			'action' => 'color',
			'selector' => '.mb2-pb-btn',
			'cssvariable' => '--mb2-pb-btn-hcolor'
		),

		'bghcolor'=>array(
			'type'=>'color',
			'section' => 'colors',
			'title'=> get_string('bgcolor', 'local_mb2builder'),
			'action' => 'color',
			'selector' => '.mb2-pb-btn',
			'cssvariable' => '--mb2-pb-btn-bghcolor'
		),

		'borhcolor'=>array(
			'type'=>'color',
			'section' => 'colors',
			'title'=> get_string('bordercolor', 'local_mb2builder'),
			'action' => 'color',
			'selector' => '.mb2-pb-btn',
			'cssvariable' => '--mb2-pb-btn-borhcolor'
		),
		'group_btn_end_2' => array('type'=>'group_end', 'section' => 'colors'), // ============ GROUP END ============ //



		'center' => array(
			'type' => 'yesno',
			'section' => 'style',
			'title'=> get_string('center', 'local_mb2builder'),
			'options' => array(
				1 => get_string('yes', 'local_mb2builder'),
				0 => get_string('no', 'local_mb2builder')
			),
			'default' => 0,
			'action' => 'class',
			'class_remove' => 'center0 center1 btn-full',
			'class_prefix' => 'center',
		),
		'ml'=>array(
			'type'=>'range',
			'section' => 'style',
			'title'=> get_string('ml', 'local_mb2builder'),
			'min'=> 0,
			'max' => 300,
			'default'=> 0,
			'action' => 'style',
			'changemode' => 'input',
			'style_properity' => 'margin-left'
		),
		'mr'=>array(
			'type'=>'range',
			'section' => 'style',
			'title'=> get_string('mr', 'local_mb2builder'),
			'min'=> 0,
			'max' => 300,
			'default'=> 0,
			'action' => 'style',
			'changemode' => 'input',
			'style_properity' => 'margin-right'
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
			'default'=> 15,
			'action' => 'style',
			'changemode' => 'input',
			'style_properity' => 'margin-bottom'
		),
		'custom_class'=>array(
			'type'=>'text',
			'section' => 'style',
			'title'=> get_string('customclasslabel', 'local_mb2builder'),
			'desc'=> get_string('customclassdesc', 'local_mb2builder')
		)
	)
);


define('LOCAL_MB2BUILDER_SETTINGS_BUTTON', base64_encode( serialize( $mb2_settings ) ));
