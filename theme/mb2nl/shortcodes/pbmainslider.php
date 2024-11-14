<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('pbmainslider', 'mb2_shortcode_pbmainslider');
mb2_add_shortcode('pbmainslider_item', 'mb2_shortcode_pbmainslider_item');


function mb2_shortcode_pbmainslider($atts, $content= null){

	$atts2 = array(
		'mt' => 0,
		'mb' => 30,
		'width' => '',
		'custom_class' => '',
		'columns' => 1,
		'sdots' => 0,
		'sloop' => 0,
		'snav' => 1,
		'sautoplay' => 1,
		'autoplay' => 0,
		'spausetime' => 5000,
		'pausetime' => 5000,
		'sanimate' => 450,
		'animtime' => 450,
		'gridwidth' => 'none',
		'mobcolumns' => 0,
		'gutter' => 'normal'
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$sData = '';
	$style = '';
	$cls = '';

	$cls .= $custom_class ? ' ' . $custom_class : '';

	if ( $mt || $mb )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	}

	$opts = theme_mb2nl_page_builder_2arrays( $atts, $atts2 );
	$sliderdata = theme_mb2nl_shortcodes_slider_data( $opts );

	$cls .= $sdots == 1 ? ' isdots' : '';

	$output .= '<div class="pbmainslider-wrap mb2-pb-carousel' . $cls . '"' . $style . '>';
	$output .= '<div class="theme-slider owl-carousel"' . $sliderdata  . '>';
	$output .= mb2_do_shortcode($content);
	$output .= '</div>';
	$output .= '</div>';


	return $output;

}



function mb2_shortcode_pbmainslider_item($atts, $content = null){
	extract(mb2_shortcode_atts( array(
		'title' => '',
		'desc' => '',
		'image' => '',
		'bgcolor' => '',
		'ocolor' => '',
		'isdesc' => 1,
		'istitle' => 1,
		'linkbtn' => 0,
		'link' => '',
		'cwidth' => 750,
		'halign' => 'center',
		'valign' => 'left',
		'target' => '',
		'btntext' => '',
		'link_target' => 0
		), $atts)
	);

	$output = '';
	$isTarget = '';
	$cls = '';
	$cstyle = '';

	$cls .= ' halign' . $halign;
	$cls .= ' valign' . $valign;
	$cls .= ' isdesc' . $isdesc;
	$cls .= ' istitle' . $istitle;
	$cls .= ' linkbtn' . $linkbtn;

	$cstyle .= ' style="';
	$cstyle .= 'width:' . $cwidth . 'px;max-width:100%;';
	$cstyle .= $bgcolor ? 'background-color:' . $bgcolor . ';' : '';
	$cstyle .= '"';

	$colorstyle = $bgcolor ? ' style="background-color:' . $bgcolor . ';"' : '';
	$innerstyle = $ocolor ? ' style="background-color:' . $ocolor . ';"' : '';

	$target = $target ? $target : $link_target;
	$isTarget = $target ? ' target="_blank"' : '';

	$output .= '<div class="pbmainslider-item' . $cls . '">';
	$output .= '<div class="pbmainslider-item-inner"' . $innerstyle . '>';

	if ( ( $istitle && $title ) || ( $isdesc && $desc ) || ( $linkbtn && $link ) )
	{

		$output .= '<div class="slide-content1">';
		$output .= '<div class="slide-content2">';
		$output .= '<div class="slide-content3"' . $cstyle . '>';
		$output .= '<div class="slide-content4">';

		if ( $istitle && $title )
		{
			$output .= '<h4 class="theme-slide-title">';
			$output .= $link ? '<a href="' . $link . '"' . $isTarget . '>' : '';
			$output .= format_text( $title, FORMAT_HTML );
			$output .= $link ? '</a>' : '';
			$output .= '</h4>';
		}

		if ( $isdesc && $desc )
		{
			$output .= '<div class="slide-details">';

			$desc = $content ? $content : $desc;

			if ( $desc )
			{
				$output .= '<div class="slide-desc">';
				$output .= format_text($desc, FORMAT_HTML);
				$output .= '</div>';
			}

			if ( $link && $linkbtn )
			{
				$readmoretext = $btntext ? $btntext : get_string('readmore','theme_mb2nl');

				$output .= '<div class="slide-readmore">';
				$output .= '<a class="mb2-pb-btn typeprimary" href="' . $link . '"' . $isTarget . '>' . $readmoretext . '</a>';
				$output .= '</div>';
			}

			$output .= '</div>';
		}

		$output .= '</div>'; // slide-content4
		$output .= '</div>'; // slide-content3
		$output .= '</div>'; // slide-content2
		$output .= '<div class="slide-descbg"' . $colorstyle . '></div>'; // theme-slide-content2
		$output .= '</div>'; // slide-content1

	}


	$output .= '</div>'; // pbmainslider-item-inner
	$output .= '<div class="theme-slider-img"><img src="' . $image . '" alt="' .
	$title . '"><div class="img-cover" style="background-image:url(\'' . $image . '\')"></div></div>';
	$output .= '</div>'; // pbmainslider-item

	return $output;


}
