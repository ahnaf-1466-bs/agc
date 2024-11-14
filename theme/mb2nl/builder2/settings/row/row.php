<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('mb2pb_row', 'mb2_shortcode_mb2pb_row');

function mb2_shortcode_mb2pb_row ( $atts, $content = null )
{
	global $PAGE;

	$atts2 = array(
		'id' => 'row',
		'bgcolor' => '',
		'bgfixed' => 0,
		'colgutter' => 's',
		'prbg' => 0,
		'scheme' => 'light',
		'bgimage' => '',
		//
		'bordert' => 0,
		'borderb' => 0,
		'bordertcolor' => '#dddddd',
		'borderbcolor' => '#dddddd',
		//
		'heroimg' => 0,
		'heroimgurl' => '',
		'herov' => 'center',
		//'heroh' => 'right',
		'herow' => 1200,
		'herohpos' => 'left',
		'heroml' => 0,
		'heromt' => 0,
		'heroonsmall' => 1,
		'herogradl' => 0,
		'herogradr' => 0,
		//
		'bgtext' => 0,
		'bgtextmob' => 0,
		'bgtexttext' => 'Sample text',
		'btsize' => 290,
		'btfweight' => 600,
		'btlh' => 1,
		'btlspacing' => 0,
		'btwspacing' => 0,
		'btupper' => 0,
		'bth' => 'left',
		'btv' => 'center',
		'btcolor' => 'rgba(0,0,0,.05)',
		//
		'bgvideo' => '',
		'rowhidden' => 0,
		'rowlang' => '',
		'pt' => 60,
		'pb' => 0,
		'fw' => 0,
		'va' => 0,
		'parallax' => 0,
		'rowaccess' => 0,
		'custom_class' => '',
		'template' => '',
		'wave' => 'none',
		'wavecolor' => '#ffffff',
		'wavepos' => 0,
		'wavefliph' => 0,
		'wavetop' => 0,
		'wavewidth' => 100,
		'waveheight' => 150,
		'waveover' => 1,
		'mt' => 0,
		//
		'gradient' => 0,
		'graddeg' => 45,
		'gradloc1' => 0,
		'gradloc2' => 100,
		'gradcolor1' => '#37E2D5',
		'gradcolor2' => '#590696'
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$headercls = '';
	$wrap_style = '';
	$btcls = '';
	$btcls2 = '';
	$btstyle = '';
	$wavestyle = '';
	$wavenum = 0;
	$innercls = '';

	$innercls .= ' ' . theme_mb2nl_heading_cls( $pt, 'rowpt-', false );
	$innercls .= ' ' . theme_mb2nl_heading_cls( $pb, 'rowpb-', false );

	$cls = $custom_class ? ' ' . $custom_class : '';
	$cls .= ' pre-bg' . $prbg;
	$cls .= ' ' . $scheme;
	$cls .= ' hidden' . $rowhidden;
	$cls .= ' access' . $rowaccess;
	$cls .= ' colgutter-' . $colgutter;
	$cls .= ' isfw' . $fw;
	$cls .= ' va' . $va;
	$cls .= ' wave-' . $wave;
	$cls .= ' bgfixed' . $bgfixed;
	$cls .= ' wavefliph' . $wavefliph;
	$cls .= ' wavepos' . $wavepos;
	$cls .= ' waveover' . $waveover;
	$cls .= ' parallax' . $parallax;
	$cls .= ' rowgrad' . $gradient;
	//
	$cls .= ' bordert' . $bordert;
	$cls .= ' borderb' . $borderb;
	//
	$cls .= ' heroimg' . $heroimg;
	$cls .= ' herov' . $herov;
	$cls .= ' herogradl' . $herogradl;
	$cls .= ' herogradr' . $herogradr;
	$cls .= ' heroonsmall' . $heroonsmall;
	$cls .= theme_mb2nl_is_image($heroimgurl) ? ' heroisimg' : ' heroisvideo';
	//
	$cls .= ' bgtext' . $bgtext;
	$cls .= ' bgtextmob' . $bgtextmob;
	//$cls .= ' heroh' . $heroh;
	$cls .= $template ? ' mb2-pb-template-row' : '';

	$btcls2 .= ' btupper' . $btupper;
	$btcls .= ' bth' . $bth;
	$btcls .= ' btv' . $btv;

	$btstyle .= ' style="';
	$btstyle .= 'font-size:' . $btsize . 'px;';
	$btstyle .= 'font-weight:' . $btfweight . ';';
	$btstyle .= 'line-height:' . $btlh . ';';
	$btstyle .= 'letter-spacing:' . $btlspacing . 'px;';
	$btstyle .= 'word-spacing:' . $btwspacing . 'px;';
	$btstyle .= 'color:' . $btcolor . ';';
	$btstyle .= '"';

	$lang_arr = explode( ',', $rowlang );
	$trimmed_lang_arr = array_map( 'trim', $lang_arr );

	$isid = theme_mb2nl_get_id_from_class( $custom_class );
	$id_attr = $isid ? 'id="' . $isid . '" ' : '';

	$wrap_style .= ' style="';
	$wrap_style .= $bgimage ? 'background-image:url(\'' . $bgimage . '\');' : '';
	$wrap_style .= $mt ? 'margin-top:' . $mt . 'px' : '';
	$wrap_style .= '"';

	$row_style = ' style="';
	$row_style .= 'padding-top:' . $pt . 'px;';
	$row_style .= 'padding-bottom:' . $pb . 'px;';
	$row_style .= $bgcolor ? 'background-color:' . $bgcolor . ';' : '';
	$row_style .= $bordert ? 'border-top-color:' . $bordertcolor . ';' : '';
	$row_style .= $borderb ? 'border-bottom-color:' . $borderbcolor . ';' : '';
	$row_style .= '"';

	$output .= '<div ' . $id_attr . 'class="mb2-pb-row mb2-pb-fprow' . $cls . '"' . $wrap_style . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= theme_mb2nl_page_builder_el_actions( 'row', 'row', array( 'lang' => $trimmed_lang_arr ) );
	$output .= '<div class="section-inner mb2-pb-row-inner' . $innercls . '"' . $row_style . '>';

	$output .= '<div class="container-fluid">';



	$output .= '<div class="row mb2-pb-sortable-columns">';
	$output .= mb2_do_shortcode($content);

	$output .= '</div>'; // row mb2-pb-sortable-columns
	$output .= '</div>'; // container-fluid

	$wavestyle .= ' style="';
	$wavestyle .= 'width:' . $wavewidth . '%;';
	$wavestyle .= 'height:' . $waveheight . 'px;';
	$wavestyle .= '"';

	$output .= '<div class="rowgrad" style="background-image:linear-gradient(' . $graddeg . 'deg,' . $gradcolor1 . ' ' . $gradloc1 . '%,' . $gradcolor2 . ' ' . $gradloc2 . '%);"></div>';

	$output .= '<div class="hero-img-wrap">';
	$output .= '<div class="hero-img-wrap2">';
	$output .= '<div class="hero-img-wrap3" style="width:' . $herow . 'px;' . $herohpos . ':' . $heroml . '%;margin-top:' . $heromt . 'px;">';

	$output .= '<video class="hero-video" autoplay muted loop >';
	$output .= '<source src="' . $heroimgurl . '">';
	$output .= '</video>';

	$output .= '<img class="hero-img" src="' . $heroimgurl . '" alt="">';

	$output .= '<div class="hero-img-grad grad-left" style="background-image:linear-gradient(to right,' . $bgcolor . ',rgba(255,255,255,0));"></div>';
	$output .= '<div class="hero-img-grad grad-right" style="background-image:linear-gradient(to right,rgba(255,255,255,0),' . $bgcolor . ');"></div>';
	$output .= '</div>'; // hero-img-wrap23
	$output .= '</div>'; // hero-img-wrap2
	$output .= '</div>'; // hero-img-wrap

	$output .= '<div class="bgtext' . $btcls . '">';
	$output .= '<div class="bgtext-text' . $btcls2 . '"' . $btstyle . '>';
	$output .= $bgtexttext;
	$output .= '</div>';
	$output .= '</div>';

	$waves = theme_mb2nl_get_waves();

	foreach ( $waves as $wave )
	{
		$wavenum++;

		$output .= '<div class="mb2-pb-row-wave wave-' . $wavenum . '">';
		$output .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="' . $wave['box'] . '" preserveAspectRatio="none"' . $wavestyle . '><path fill="' . $wavecolor . '" fill-opacity="1" d="' . $wave['d'] . '"></path></svg>';
		$output .= '</div>';
	}

	$output .= '</div>'; // mb2-pb-row-inner

	$output .= '<div class="section-video">';
	$output .= '<video autoplay muted loop >';
  	$output .= '<source src="' . $bgvideo . '">';
	$output .= '</video>';
	$output .= '</div>'; // section-video

	// Parallax
	$output .= '<img class="parallax-img" src="' . $bgimage . '" alt="">';

	if ( $parallax )
	{
		//$PAGE->requires->js_call_amd( 'local_mb2builder/parallax','parallaxInit' );
	}

	$output .= '</div>'; // mb2-pb-row

	return $output;

}
