<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('icon', 'mb2_shortcode_icon');
mb2_add_shortcode('icon2', 'mb2_shortcode_icon2');

function mb2_shortcode_icon($atts, $content= null){
	extract(mb2_shortcode_atts( array(
		'name' => 'fa-star',
		'color' => '',
		'size' => 'default',
		'spin'=> 0,
		'rotate'=> 0,
		'margin' => '',
		'sizebg'=>'',
		'rounded'=>'',
		'bgcolor'=>'',
		'icon_text_pos'=>'after',
		'custom_class' => '',
		'nline' => 0
	), $atts));


	$cls = '';
	$output = '';
	$pref = theme_mb2nl_font_icon_prefix( $name );
	$is7stroke = preg_match('@pe-7s@', $name);

	$cls .= $spin ? $is7stroke ? ' pe-spin' : ' fa-spin' : '';
	$cls .= $rotate ? $is7stroke ? ' pe-' . $rotate : ' fa-' . $rotate : '';
	$cls .= ' ' . $pref . $name;
	$cls .= ' icon-size-' . $size;
	$cls .= $custom_class ? ' ' . $custom_class : '';


	// Wrap class
	$wcls = $bgcolor !='' ? ' iconbg' : '';
	$wcls .= ' icon-size-' . $size;
	$wcls .= $rounded == 1 ? ' iconrounded' : '';


	// Wrap style
	$sstyle = ' style="';
	$sstyle .= $nline == 1 ? 'display:block;' : '';
	$sstyle .= $margin !='' ? 'margin:' . $margin . ';' : '';
	$sstyle .= '"';


	// Set icon style
	$style = ' style="';
	$style .= $color !='' ? 'color:' . $color . ';' : '';
	$style .= '"';


	// Wrap style
	$wstyle = ' style="';
	$wstyle .= $sizebg > 0 ? 'width:' . $sizebg . 'px;text-align:center;height:' .  $sizebg . 'px;line-height:' . $sizebg . 'px;' : '';
	$wstyle .= $bgcolor !='' ? 'background-color:' . $bgcolor . ';' : '';
	$wstyle .= '"';



	$iscontent = $content ? ' <span class="tmpl-icon-content">' . mb2_do_shortcode($content) . '</span>' : '';


	$output .= '<span class="tmpl-icon-wrap' . $wcls . '"' . $sstyle . '>';
	$output .= $icon_text_pos === 'before' ? $iscontent : '';
	$output .= $bgcolor ? '<span class="tmpl-icon-bg"' . $wstyle . '>' : '';
	$output .= '<i class="tmpl-icon' . $cls . '"' . $style . '></i>';
	$output .= $bgcolor ? '</span>' : '';
	$output .= $icon_text_pos === 'after' ? $iscontent : '';
	$output .= '</span>';


	return $output;



}




function mb2_shortcode_icon2($atts, $content= null){
	extract(mb2_shortcode_atts( array(
		'name' => 'fa fa-star',
		'color' => '',
		'size' => 'n',
		'circle' => 1,
		'desc' => 0,
		'spin' => 0,
		'rotate' => 0,
		'mt' => 0,
		'mb' => 30,
		'sizebg' => '',
		'rounded' => '',
		'bgcolor' => '',
		'custom_class' => '',
	), $atts));


	$output = '';
	$cls = '';
	$style = '';
	$estyle = '';

	$cls .= ' size' . $size;
	$cls .= ' desc' . $desc;
	$cls .= ' circle' . $circle;

	if ( $mt || $mb )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	}

	// Define icon text
	$content = $content ? $content : 'Icon text here.';
	$atts2['text'] = $content;

	if ( $color || $bgcolor )
	{
		$estyle .= ' style="';
		$estyle .= $color ? 'color:' . $color . ';' : '';
		$estyle .= $bgcolor ? 'background-color:' . $bgcolor . ';' : '';
		$estyle .= '"';
	}

	$output .= '<div class="theme-icon2' . $cls . '"' . $style . '>';
	$output .= '<span class="icon-bg"' . $estyle . '>';
	$output .= '<i class="' . $name . '"></i>';
	$output .= '</span>';
	$output .= '<span class="icon-desc">';
	$output .=  mb2_do_shortcode( $content );
	$output .= '</span>';
	$output .= '</div>';

	return $output;

}
