<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('image', 'mb2_image');

function mb2_image( $atts, $content) {

    extract(mb2_shortcode_atts( array(
        'align' => 'none',
        'center' => 1,
		'width' => 0,
        'alt' => '',
        'mt' => 0,
		'mb' => 30,
        'caption' => 0,
        'captiontext' => '',
		'link' => '',
		'link_target' => 0,
        'custom_class' => '',
   	), $atts));

	$output = '';
    $style = '';
    $cls = '';

	$cls .= ' align-' . $align;
    $cls .= ' center' . $center;
    $cls .= $custom_class ? ' ' . $custom_class : '';

    if ( $mt || $mb || $width )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
        $style .= $width ? 'width:' . $width . 'px;max-width:100%;' : '';
		$style .= '"';
	}

	$isLinkTarget = $link_target ? ' target="' . $link_target . '"' : '';

	$output .= '<div class="mb2-image' . $cls . '"' . $style . '>';
	$output .= $link ? '<a href="' . $link . '"' . $isLinkTarget . '>' : '';
	//$output .= '<img src="' . $content . '" alt="' . $alt . '" />';
    $output .= '<img class="lazy" src="' . theme_mb2nl_lazy_plc() . '" data-src="' . $content . '" alt="' . $alt . '" />';
	$output .= $link ? '</a>' : '';
    $output .= $caption ? '<div class="caption">' . $captiontext . '</div>' : '';
	$output .= '</div>';

	return $output;

}
