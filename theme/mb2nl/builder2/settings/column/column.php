<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('mb2pb_column', 'mb2_shortcode_mb2pb_column');

function mb2_shortcode_mb2pb_column ($atts, $content = null)
{
	$atts2 = array(
		'id' => 'column',
		'col' => 12,
		'pt' => 0,
		'pb' => 30,
		//'ph' => 0,
		//'phcls' => 0,
		'mobcenter' => 0,
		//'aos' => 0,
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
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$style = '';
	$cstyle = '';
	$cls = '';
	$colid = uniqid('mb2-pb-col_');

	$cls .= $content === '' ? ' empty' : ' noempty';
	$cls .= ' ' . $scheme;
	$cls .= ' align-' . $align;
	$cls .= ' alignc' . $alignc;
	$cls .= ' mobcenter' . $mobcenter;
	//$cls .= $animation ? ' aniview' : '';
	//$cls .= ' ' . theme_mb2nl_heading_cls( $ph, 'phcls-', false );
	$cls .= ' moborder' . $moborder;
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

	if ( $bgimage || $height )
	{
		$cstyle .= ' style="';
		$cstyle .= $bgimage ? 'background-image:url(\'' . $bgimage . '\');' : '';
		$cstyle .= $height ? 'min-height:' . $height . 'px;' : '';
		$cstyle .= '"';
	}

	$colpref = $isfooter ? 'md' : 'lg';

	$output .= '<div class="mb2-pb-column col-' . $colpref . '-' . $col . $cls . '"' . $cstyle . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="column-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'column', '', array('copy' => 0 ) );
	$output .= '<div class="column-inner"' . $style . '>';
	$output .= '<div class="mb2-pb-sortable-elements clearfix">';
	$output .= mb2_do_shortcode( $content );
	$output .= '</div>';
	$output .= '</div>';

	$output .= '<div class="mb2-pb-column-footer">';
	$output .= '<a href="#" class="mb2-pb-add-element" title="' .
	get_string('addelement','local_mb2builder') . '" data-modal="#mb2-pb-modal-elements">&plus; ' . get_string('addelement','local_mb2builder') . '</a>';
	$output .= '</div>';
	$output .= '<div class="column-inner-bg"' . $bgcolorstyle . '></div>';
	$output .= '</div>';

	return $output;

}
