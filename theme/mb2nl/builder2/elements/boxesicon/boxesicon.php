<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('mb2pb_boxesicon', 'mb2pb_shortcode_boxesicon');
mb2_add_shortcode('mb2pb_boxesicon_item', 'mb2pb_shortcode_boxesicon_item');

function mb2pb_shortcode_boxesicon( $atts, $content = null ){

	$atts2 = array(
		'id' => 'boxesicon',
		'columns' => 3, // max 5
		'gutter' => 'normal',
		'type' => 1,
		'color' => 'primary',
		'ccolor' => '',
		'rounded' => 0,
		//'smtitle' => 1,
		'tfs' => 1.4,
		'tfw' => 'global',
		'wave' => 0,
		'height' => 0,
		'mt' => 0,
		'mb' => 0, // 0 because box item has margin bottom 30 pixels
		'boxmb' => 0,
		'linkbtn' => 0,
		'btntext' => '',
		'desc' => 1,
		'custom_class' => '',
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$cls = '';
	$style = '';

	$GLOBALS['btntext'] = $btntext;
	$GLOBALS['boxicontype'] = $type;
	$GLOBALS['boxiconcolor'] = $color;
	$GLOBALS['boxiconccolor'] = $ccolor;
	$GLOBALS['boxmb'] = $boxmb;
	$GLOBALS['height'] = $height;
	$GLOBALS['boxicontitlefs'] = $tfs;
	$GLOBALS['boxicontitlefw'] = $tfw;

	//$cls .= ' type-' . $type;
	$cls .= ' gutter-' . $gutter;
	$cls .= ' linkbtn' . $linkbtn;
	$cls .= ' desc' . $desc;
	$cls .= ' theme-col-' . $columns;
	$cls .= ' rounded' . $rounded;
	//$cls .= ' smtitle' . $smtitle;
	$cls .= ' wave' . $wave;
	$cls .= $custom_class ? ' ' . $custom_class : '';
	$templatecls = $template ? ' mb2-pb-template-boxesicon' : '';

	if ( $mt || $mb )
	{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	}

	$content = $content;

	if ( ! $content )
	{
		$demoimage = theme_mb2nl_page_builder_demo_image( '1600x1066' );

		for (  $i = 1; $i <= 3; $i++ )
		{
			$content .= '[mb2pb_boxesicon_item title="Box title here" icon="fa fa-rocket" ]Box content here.[/mb2pb_boxesicon_item]';
		}
	}

	$output .= '<div class="mb2-pb-element mb2-pb-boxesicon' . $templatecls . '"' . $style . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'boxesicon' );
	$output .= '<div class="mb2-pb-element-inner theme-boxes' . $cls . '">';
	$output .= '<div class="mb2-pb-sortable-subelements">';
	$output .= mb2_do_shortcode($content);
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}


function mb2pb_shortcode_boxesicon_item( $atts, $content = null ){

	$atts2 = array(
		'id' => 'boxesicon_item',
		'icon' =>'fa fa-rocket',
		'type' => '',
		'title'=> 'Box title here',
		'link' => '',
		'color' => '',
		'ccolor' => '',
		'link_target' => 0,
		'target' =>'',
		'btntext' => '',
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$pref = '';
	$cls = '';
	$fcls = '';
	$ccolorstyle = '';
	$boxstyle = '';

	$content = ! $content ? 'Box content here.' : $content;
	$atts2['content'] = $content;

	$type = $type ? $type : $GLOBALS['boxicontype'];
	$color = $color ? $color : $GLOBALS['boxiconcolor'];

	if ( $GLOBALS['boxiconccolor'] )
	{
		$ccolorstyle .= ' style="';
		$ccolorstyle .= 'color:' . $GLOBALS['boxiconccolor']. ';';
		$ccolorstyle .= '"';
	}

	if ( $GLOBALS['boxmb'] || $GLOBALS['height'] )
	{
		$boxstyle .= ' style="';
		$boxstyle .= $GLOBALS['boxmb'] ? 'margin-bottom:' . $GLOBALS['boxmb'] . 'px;' : '';
		$boxstyle .= $GLOBALS['height'] ? 'min-height:' . $GLOBALS['height'] . 'px;' : '';
		$boxstyle .= '"';
	}

	$cls .= ' type-' . $type;
	$cls .= ' boxcolor-' . $color;

	$fcls .= ' fw' . $GLOBALS['boxicontitlefw'];

	$output .= '<div class="mb2-pb-subelement mb2-pb-boxesicon_item theme-box"' . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= theme_mb2nl_page_builder_el_actions( 'subelement' );
	$output .= '<div class="subelement-helper"></div>';
	$output .= '<div class="mb2-pb-subelement-inner">';

	$output .= '<div class="theme-boxicon' . $cls . '"' . $boxstyle . '>';
	$output .= '<div class="theme-boxicon-inner">';
	$output .= '<div class="theme-boxicon-icon"' . $ccolorstyle . '>';

	$output .= '<i class="' . $pref . $icon . '"></i>';
	$output .= '</div>';

	$output .= '<div class="theme-boxicon-content">';

	$output .= '<h4 class="box-title' . $fcls . '" style="font-size:' . $GLOBALS['boxicontitlefs'] . 'rem;">';
	$output .= $title;
	$output .= '</h4>';

	$output .= '<div class="box-desc">' . urldecode( $content ) . '</div>';

	$btntext = $GLOBALS['btntext'] ? $GLOBALS['btntext'] : get_string( 'readmorefp', 'local_mb2builder' );
	$output .= '<div class="theme-boxicon-readmore">';
	$output .= '<a class="mb2-pb-btn typeprimary" href="#">' . $btntext . '</a>';
	$output .= '</div>';

	$output .= '</div>';
	$output .= '</div>';
	$output .= '<div class="bigicon"><i class="' . $pref . $icon . '"></i></div>';
	$output .= '<div class="box-color" style="background-color:' . $ccolor . ';"></div>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}
