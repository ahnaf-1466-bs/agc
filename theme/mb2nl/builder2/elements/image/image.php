<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('mb2pb_image', 'mb2_shortcode_mb2pb_image');

function mb2_shortcode_mb2pb_image( $atts, $content = null ) {

    $atts2 = array(
        'id' => 'image',
        'align' => 'none',
        'center' => 1,
		'width' => 450,
        'alt' => '',
        'mt' => 0,
		'mb' => 30,
        'caption' => 0,
        'captiontext' => 'Caption text here',
		'link' => '',
		'link_target' => 0,
        'custom_class' => '',
        'template' => ''
    );

    extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
    $style = '';
    $cls = '';

	$cls .= ' align-' . $align;
    $cls .= ' center' . $center;
    $cls .= ' caption' . $caption;
    $cls .= $custom_class ? ' ' . $custom_class : '';
    $cls .= $template ? ' mb2-pb-template-image' : '';

    if ( $mt || $mb || $width )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
        $style .= $width ? 'width:' . $width . 'px;max-width:100%;' : '';
		$style .= '"';
	}

    $content = $content ? $content : theme_mb2nl_page_builder_demo_image( '1600x1066' );
    $atts2['text'] = $content;

    $output .= '<div class="mb2-pb-element mb2pb-image mb2-image' . $cls . '"' . $style . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
    $output .= '<div class="element-helper"></div>';
    $output .= theme_mb2nl_page_builder_el_actions( 'element', 'image' );
	$output .= '<img class="mb2-image-src" src="' . urldecode( $content ) . '" alt="' . $alt . '" />';
    $output .= '<div class="caption">' . $captiontext . '</div>';
    $output .= '</div>';

	return $output;

}
