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
 * Method to get predefined less variables
 *
 */
function theme_mb2nl_get_pre_scss($theme)
{
	global $CFG;
	$scss = '';
    $vars = theme_mb2nl_get_style_vars();
	$cssvars = theme_mb2nl_get_style_vars(true);

    foreach ($vars as $k => $v)
	{
		switch ($k)
		{
			case ('ffgeneral') :

				$isv = theme_mb2nl_scss_fvalue('ffgeneral', $theme);
				break;

			case ('ffheadings') :

				$isv = theme_mb2nl_scss_fvalue('ffheadings', $theme);
				break;

			case ('ffmenu') :

				$isv = theme_mb2nl_scss_fvalue('ffmenu', $theme);
				break;

			case ('ffddmenu') :

				$isv = theme_mb2nl_scss_fvalue('ffddmenu', $theme);
				break;

			case ('fwgeneral3') :

				$isv = theme_mb2nl_scss_fvalue('fwgeneral3', $theme, false);
				break;

			case ('fwheadings3') :

				$isv = theme_mb2nl_scss_fvalue('fwheadings3', $theme, false);
				break;

			case ('fwmenu3') :

				$isv = theme_mb2nl_scss_fvalue('fwmenu3', $theme, false);
				break;

			case ('fwddmenu3') :

				$isv = theme_mb2nl_scss_fvalue('fwddmenu3', $theme, false);
				break;


			default :

			$isv = (isset($theme->settings->$k) && $theme->settings->$k !== '') ? $theme->settings->$k : NULL;

		}

		if ( empty( $isv ) )
		{
			continue;
		}


		//if ( ! empty( $isv ) )
		//{
			$issuffix = isset($v[1]) ? $v[1] : '';
			$scss .= '$' . $v[0] . ':' . $isv . $issuffix . ';';
		//}

		//$headingscolor

    }


	$scss .= ':root {';

	foreach ($cssvars as $k => $v)
	{
		$isv = ( isset($theme->settings->$k) && $theme->settings->$k !== '' ) ? $theme->settings->$k : NULL;

		if ( empty( $isv ) )
		{
			continue;
		}		

		$issuffix = isset($v[1]) ? $v[1] : '';
		$scss .= $v[0] . ':' . $isv . $issuffix . ';';
	}

	$scss .= '}';


	return $scss;

}






/*
 *
 * Method to get predefined less variables
 *
 */
function theme_mb2nl_scss_fvalue($name, $theme, $quote = true)
{

	$output = '';

	// Get settings
	$sname1 = $theme->settings->$name;

	if ( isset( $theme->settings->$sname1 ) && $theme->settings->$sname1 !== '' )
	{
		$output .=  $quote ? '\'' : '';
		$output .= $theme->settings->$sname1;
		$output .=  $quote ? '\'' : '';

		return $output;
	}
	else
	{
		return NULL;
	}

}







/*
 *
 * Method to set inline styles
 *
 */
function theme_mb2nl_get_pre_scss_raw($theme)
{

	global $PAGE;
	$output = '';

	$output .= theme_mb2nl_fonticons();
	$output .= theme_mb2nl_custom_fonts();
    $output .= theme_mb2nl_admin_regions_hide_options();
	$output .= theme_mb2nl_theme_setting($PAGE,'customcss','',false,$theme);

	return $output;

}







/*
 *
 * Method to get theme settings for scss and less file
 *
 */
function theme_mb2nl_get_style_vars($css = false)
{


    $vars = array(

		// Theme setting => scss/less variable
		// General settings
	    'navddwidth' => array('ddwidth','px'),
		'pagewidth' => array('pagewidth','px'),
		'logoh' => array('logoh','px'),
		'logohsm' => array('logohsm','px'),

		// Footer
		'partnerlogoh' => array('partnerlogoh','px'),

		// Colors
		'accent1' =>  array('accent1'),
		'accent2' =>  array('accent2'),
		'accent3' =>  array('accent3'),
		'textcolor' =>  array('textcolor'),
		'textcolor_lighten' => array('textcolor_lighten'),
		'textcolorondark' => array('textcolorondark'),
		'linkcolor' =>  array('linkcolor'),
		'linkhcolor' =>  array('linkhcolor'),
		'headingscolor' =>  array('headingscolor'),
		'btncolor' =>  array('btncolor'),
		'btnprimarycolor' =>  array('btnprimarycolor'),

		// Helper colors
		'color_success' =>  array('color_success'),
		'color_warning' =>  array('color_warning'),
		'color_danger' =>  array('color_danger'),
		'color_info' =>  array('color_info'),

		// Mian header color		
		'mhbgcolor' =>  array('mhbgcolor'),
		'tbbgcolor' =>  array('tbbgcolor'),

		// Transparent header
		'headerbgcolor' => array('headerbgcolor'),
		'headerbgcolor2' => array('headerbgcolor2'),
		'headerlbgcolor' => array('headerlbgcolor'),
		'headerlbgcolor2' => array('headerlbgcolor2'),

		// Page background
		'pbgcolor' => array('pbgcolor'),
		'pbgcolor' => array('pbgcolor'),

		// Login page background
		'loginbgcolor' => array('loginbgcolor'),
		'loginbgcolor' => array('loginbgcolor'),

		// Fonts family
		'ffgeneral' =>  array('ffgeneral'),
		'ffheadings' =>  array('ffheadings'),
		'ffmenu' =>  array('ffmenu'),
		'ffddmenu' =>  array('ffddmenu'),

		// Font weight
		'fwlight' =>  array('fwlight'),
		'fwnormal' =>  array('fwnormal'),
		'fwmedium' =>  array('fwmedium'),
		'fwbold' =>  array('fwbold'),

		// Font size
		'fsbase'=> array('fsbase','px'),
		'fsheading1'=> array('fsheading1','rem'),
		'fsheading2'=> array('fsheading2','rem'),
		'fsheading3'=> array('fsheading3','rem'),
		'fsheading4'=> array('fsheading4','rem'),
		'fsheading5'=> array('fsheading5','rem'),
		'fsheading6'=> array('fsheading6','rem'),
		'fsmenu'=> array('fsmenu','rem'),
		'fsddmenu2'=> array('fsddmenu2','rem'),

		// Font weight
		'fwgeneral3'=> array('fwgeneral3'),
		'fwheadings3'=> array('fwheadings3'),
		'fwmenu3'=> array('fwmenu3'),
		'fwddmenu3'=> array('fwddmenu3'),

		// Text transform
		'ttmenu'=> array('ttmenu'),
		'ttddmenu'=> array('ttddmenu')

   	);

	$cssvars = array(
		'fsbase' => array('--mb2-pb-fsbase', 'px'),
		// Typography colors
		'textcolor' => array('--mb2-pb-textcolor'),
		'textcolor_lighten' => array('--mb2-pb-textcolor_lighten'),
		'linkcolor' =>  array('--mb2-pb-linkcolor'),
		'headingscolor' => array('--mb2-pb-headingscolor'),
		// Accent colors
		'accent1' =>  array('--mb2-pb-accent1'),
		'accent2' =>  array('--mb2-pb-accent2'),
		'accent3' =>  array('--mb2-pb-accent3'),

		// Main header colors		
		'mhbgcolor' =>  array('--mb2-pb-mhbgcolor'),
		'tbbgcolor' =>  array('--mb2-pb-tbbgcolor'),	

		// Header colors
		'headerbgcolor' =>  array('--mb2-pb-headerbgcolor'),
		'headerbgcolor2' =>  array('--mb2-pb-headerbgcolor2'),
		'headerlbgcolor' =>  array('--mb2-pb-headerlbgcolor'),
		'headerlbgcolor2' =>  array('--mb2-pb-headerlbgcolor2'),
		// Helper colors
		'color_success' =>  array('--mb2-pb-color_success'),
		'color_warning' =>  array('--mb2-pb-color_warning'),
		'color_danger' =>  array('--mb2-pb-color_danger'),
		'color_info' =>  array('--mb2-pb-color_info'),
		// Accordions
		//'headingscolor' =>  array('--mb2-pb-acc-tcolor'),
		//'headingscolor' =>  array('--mb2-pb-acc-thcolor'),
		// Buttons
		'btncolor' =>  array('--mb2-pb-btn-bgcolor'),
		'btnprimarycolor' =>  array('--mb2-pb-btn-primarybgcolor'),		
        
        // Font weight
        'fwlight' =>  array('--mb2-pb-fwlight'),
        'fwnormal' =>  array('--mb2-pb-fwnormal'),
        'fwmedium' =>  array('--mb2-pb-fwmedium'),
        'fwbold' =>  array('--mb2-pb-fwbold')			
	);

	if ( $css )
	{
		return $cssvars;
	}
	else
	{
		return $vars;
	}


}




/*
 *
 * Method to get main scss content
 *
 */
function theme_mb2nl_get_scss_content($theme)
{
    global $CFG, $PAGE;

    $scss = '';

	$footerstyle = $theme->settings->footerstyle;

	// Get main scss file
	$scss .= file_get_contents( $CFG->dirroot . '/theme/mb2nl/scss/style.scss' );

	// Footer style
	$scss .= file_get_contents( $CFG->dirroot . '/theme/mb2nl/scss/theme/theme-footer-' . $footerstyle . '.scss' );

	// Plugin styles
	$plugins = theme_mb2nl_add_scss($theme);

	if ( count( $plugins ) )
	{
		foreach( $plugins as $plugin )
		{
			$fileurl = $CFG->dirroot . '/theme/mb2nl/scss/plugins/' . $plugin . '.scss';

			if ( ! file_exists( $fileurl ) )
			{
				continue;
			}

			$scss .= file_get_contents( $fileurl );
		}
	}

	// Course view style
	if (
		in_array('plugin-buttons', $plugins) ||
		in_array('plugin-grid', $plugins) ||
		in_array('plugin-topcoll', $plugins) ||
		in_array('plugin-tiles', $plugins) ||
		in_array('plugin-mb2sections', $plugins)
		)
	{
		$scss .= file_get_contents( $CFG->dirroot . '/theme/mb2nl/scss/moodle-custom/moodle-course-view-all.scss' );
	}
	else
	{
		$scss .= file_get_contents( $CFG->dirroot . '/theme/mb2nl/scss/moodle-custom/moodle-course-view.scss' );
	}

	// Acsb block
	if ( $theme->settings->acsboptions )
	{
		$scss .= file_get_contents( $CFG->dirroot . '/theme/mb2nl/scss/theme/theme-acsb_block.scss' );
	}

    return $scss;
}





/*
 *
 * Method to get additional scss
 *
 */
function theme_mb2nl_add_scss($theme)
{
	global $PAGE, $CFG;

	$files = array();
	$plugincss = $theme->settings->plugincss;
	$slider = $theme->settings->slider;

	if ( $plugincss !== '' )
	{
		$files = preg_split('/\r\n|\n|\r/', trim($plugincss));
	}

	if ( $slider && file_exists( $CFG->dirroot . '/local/mb2slides/index.php' ) )
	{
		$files[] = 'plugin-lightslider';
		$files[] = 'plugin-mb2slides-admin';
		$files[] = 'plugin-mb2slides-nav';
		$files[] = 'plugin-mb2slides-slider';
		$files[] = 'plugin-mb2slides-mobile';
	}

	return $files;

}