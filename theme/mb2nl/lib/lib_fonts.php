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
 * Method to get Google webfonts
 *
 */
function theme_mb2nl_google_fonts($page, $attribs = array())
{

	$output = '';

	$gfontsubset = theme_mb2nl_theme_setting($page, 'gfontsubset');

	//<link rel="preconnect" href="https://fonts.googleapis.com">
	//<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	//<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

	for ($i = 1; $i <=3; $i++)
	{

		$gfontname = theme_mb2nl_theme_setting($page, 'gfont' . $i);
		$gfontstyle = theme_mb2nl_theme_setting($page, 'gfontstyle' . $i);
		$isStyle = $gfontstyle !='' ? ':' . $gfontstyle : '';

		$isSubset = $gfontsubset !='' ? '&amp;subset=' . $gfontsubset : '';

		if ($gfontname !== '')
		{
			$output .= '<link href="//fonts.googleapis.com/css?family=' . str_replace(' ', '+', $gfontname) . $isStyle . $isSubset . '" rel="stylesheet">';
		}

	}

	return $output;

}






/*
 *
 * Method to get custom fonts
 *
 */
function theme_mb2nl_custom_fonts()
{

	global $PAGE;
    $output = '';

    for ($i = 1; $i <= 3; $i++)
	{
        $fonts = theme_mb2nl_filearea( 'cfontfiles' . $i, false );
        $fontname = theme_mb2nl_theme_setting( $PAGE, 'cfont' . $i );
        $x = 0;

        if ( count( $fonts ) && $fontname )
        {
            $output .= '@font-face {';
            $output .= 'font-family:\'' .$fontname . '\';';
            $output .= 'src: ';

            foreach ( $fonts as $f )
            {
                $x++;
                $finfo = pathinfo( $f );
                $sep = $x == count( $fonts ) ? ';' : ',';
                $format = $finfo['extension'];

                if ( $finfo['extension'] === 'ttf' )
                {
                    $format = 'truetype';
                }

                $output .= 'url(\'' . $finfo['dirname'] . '/' . $finfo['basename'] . '\') format(\'' . $format . '\')' . $sep;
            }

            $output .= '}';
        }
    }

    return $output;

}




/*
 *
 * Method to get font icons
 *
 */
function theme_mb2nl_fonticons()
{
    $output = '';

	$output .= theme_mb2nl_fontface( 'Pe-icon-7-stroke' );
	$output .= theme_mb2nl_fontface( 'LineIcons' );
	$output .= theme_mb2nl_fontface( 'Glyphicons-Halflings', true );
	$output .= theme_mb2nl_fontface( 'remixicon', true );

	return $output;

}





/*
 *
 * Method to get font icons
 *
 */
function theme_mb2nl_fontface( $fontname, $woff2 = false )
{
	global $CFG;

	$output = '';
	$assetsur = $CFG->wwwroot . theme_mb2nl_themedir() . '/mb2nl/assets/' . $fontname . '/fonts/';
	$fonfamily = $fontname;
	$svgfontname = $fontname;

	if ( $fontname === 'Glyphicons-Halflings' )
	{
		// font family: Glyphicons Halflings
		// svg: glyphicons_halflingsregular
		// filename: glyphicons-halflings
		$fonfamily = 'Glyphicons Halflings';
		$svgfontname = 'glyphicons_halflingsregular';
		$fontname = 'glyphicons-halflings-regular';
	}

	$output .= '@font-face {';
	$output .= 'font-family:\'' . $fonfamily . '\';';
	$output .= 'src: ';
	$output .= $woff2 ? 'url(\'' . $assetsur . $fontname . '.woff2\') format(\'woff2\'),' : ''; 	// Super Modern Browsers
	$output .= 'url(\'' . $assetsur . $fontname . '.woff\') format(\'woff\'),'; 					// Pretty Modern Browsers
	$output .= 'url(\'' . $assetsur . $fontname . '.ttf\') format(\'truetype\'),';					// Safari, Android, iOS
 	$output .= 'url(\'' . $assetsur . $fontname . '.svg#' . $svgfontname . '\') format(\'svg\');';	// Legacy iOS
	//$output .= 'font-display: swap;';
	$output .= 'font-weight: normal;';
	$output .= 'font-style: normal;';
	$output .= '}';

	return $output;

}




/*
 *
 * Method to get font family setting
 *
 */
function theme_mb2nl_get_fonf_family($page, $font)
{

	$output = '\'' . theme_mb2nl_theme_setting($page, $font) . '\'';

	return $output;

}
