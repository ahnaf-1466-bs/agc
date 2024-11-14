<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'pbcolumn', 'mb2_shortcode_pbcolumn' );
mb2_add_shortcode( 'column', 'mb2_shortcode_pbcolumn' ); // This is old column shortcode

function mb2_shortcode_pbcolumn  ($atts, $content = null )
{
	extract(mb2_shortcode_atts( array(
		'col' => 12,
		'size' => 0, // This is for the old column shortcode
		'pt' => 0,
		'pb' => 30,
		//'ph' => 0,
		//'phcls' => 0,
		'mobcenter' => 0,
		'moborder' => 0,
		'align' => 'none',
		'alignc' => 'none',
		'height' => 0,
		'width' => 2000,
		'scheme' => 'light',
		'bgcolor' => '',
		'bgimage' => '',
		'isfooter' => 0,
		'custom_class' => ''
	), $atts));

	$output = '';
	$style = '';
	$cstyle = '';
	$cls = '';
	$col = $size ? $size : $col;

	$cls .= ! $content ? ' empty' : ' noempty';
	$cls .= ' ' . $scheme;
	$cls .= ' align-' . $align;
	$cls .= ' alignc' . $alignc;
	$cls .= ' mobcenter' . $mobcenter;
	//$cls .= ' ' . theme_mb2nl_heading_cls( $ph, 'phcls-', false );
	$cls .= ' moborder' . $moborder;
	$cls .= $bgimage ? ' lazy' : '';
	$cls .= $custom_class ? ' ' . $custom_class : '';

	if ( $pt || $pb || $width )
	{
		$style .= ' style="';
		$style .= $pt ? 'padding-top:' . $pt . 'px;' : '';
		$style .= $pb ? 'padding-bottom:' . $pb . 'px;' : '';
		$style .= $width ? 'max-width:' . $width . 'px;' : '';
		//$style .= $ph ? 'padding-left:' . $ph . 'px;padding-right:' . $ph . 'px;' : '';
		$style .= '"';
	}

	$bgcolorstyle = $bgcolor ? ' style="background-color:' . $bgcolor . ';"' : '';

	if ( $height )
	{
		$cstyle .= ' style="';
		//$cstyle .= $bgimage ? 'background-image:url(\'' . $bgimage . '\');' : '';
		$cstyle .= $height ? 'min-height:' . $height . 'px;' : '';
		$cstyle .= '"';
	}

	$databgimage = $bgimage ? ' data-bg="' . $bgimage . '"' : '';

	$bgcolor = $bgcolor ? ' style="background-color:' . $bgcolor . ';"' : '';

	$colpref = $isfooter ? 'md' : 'lg';

	$output .= '<div class="mb2-pb-column col-' . $colpref . '-' . $col . $cls . '"' . $cstyle . $databgimage . '>';
	$output .= '<div class="column-inner"' . $style . '>';
	$output .= '<div class="clearfix">';
	$output .= ! $content ? '&nbsp;' : mb2_do_shortcode( $content );
	$output .= '</div>';
	$output .= '</div>';
	$output .= $bgcolor ? '<div class="column-inner-bg"' . $bgcolorstyle . '></div>' : '';
	$output .= '</div>';

	return $output;

}
