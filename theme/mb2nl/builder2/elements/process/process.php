<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('mb2pb_process', 'mb2pb_shortcode_process');
mb2_add_shortcode('mb2pb_process_item', 'mb2pb_shortcode_process_item');

function mb2pb_shortcode_process( $atts, $content = null ){

	$atts2 = array(
		'id' => 'process',
		'columns' => 3, // max 5
		'gutter' => 'normal',
		'type' => 1,
		'rounded' => 0,
		//'smtitle' => 1,
		'tfs' => 1.4,
		'tfw' => 'global',
		'labelpos' => 'left',
		'wave' => 0,
		'height' => 0,
		'mt' => 0,
		'mb' => 0, // 0 because box item has margin bottom 30 pixels
		'boxmb' => 0,
		'desc' => 1,
		'icon' => 'fa fa-arrow-right',
		'isicon' => 0,
		'custom_class' => '',
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$cls = '';
	$style = '';

	$GLOBALS['boxmb'] = $boxmb;
	$GLOBALS['height'] = $height;
	$GLOBALS['boxicontitlefs'] = $tfs;
	$GLOBALS['boxicontitlefw'] = $tfw;
	$GLOBALS['mb2pbprocessicon'] = $icon ? $icon : 'fa fa-rocket';

	$cls .= ' gutter-' . $gutter;
	$cls .= ' desc' . $desc;
	$cls .= ' theme-col-' . $columns;
	$cls .= ' rounded' . $rounded;
	$cls .= ' isicon' . $isicon;
	$cls .= ' wave' . $wave;
	$cls .= ' type' . $type;
	$cls .= ' labelpos' . $labelpos;
	$cls .= $custom_class ? ' ' . $custom_class : '';
	$templatecls = $template ? ' mb2-pb-template-process' : '';

	//if ( $mt || $mb )
	//{
		$style .= ' style="';
		$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$style .= '"';
	//}

	$content = $content;

	if ( ! $content )
	{
		for (  $i = 1; $i <= 3; $i++ )
		{
			$content .= '[mb2pb_process_item title="Box title here" label="' . $i . '" ]Box content here.[/mb2pb_process_item]';
		}
	}

	$output .= '<div class="mb2-pb-element mb2-pb-process' . $templatecls . '"' . $style . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'process' );
	$output .= '<div class="mb2-pb-element-inner theme-boxes' . $cls . '">';
	$output .= '<div class="mb2-pb-sortable-subelements">';
	$output .= mb2_do_shortcode($content);
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}


function mb2pb_shortcode_process_item( $atts, $content = null ){

	$atts2 = array(
		'id' => 'process_item',
		'icon' => '',
		'title'=> 'Box title here',
		'label' => 1,
		'link' => '',
		'color' => '',
		'bgcolor' => '',
		'link_target' => 0,
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$fcls = '';
	$boxstyle = '';
	$stylebg = '';
	$stylecolor = '';

	$content = ! $content ? 'Box content here.' : $content;
	$atts2['content'] = $content;

	$icon = $icon ? $icon : $GLOBALS['mb2pbprocessicon'];

	if ( $GLOBALS['boxmb'] || $GLOBALS['height'] )
	{
		$boxstyle .= ' style="';
		$boxstyle .= $GLOBALS['boxmb'] ? 'margin-bottom:' . $GLOBALS['boxmb'] . 'px;' : '';
		$boxstyle .= $GLOBALS['height'] ? 'min-height:' . $GLOBALS['height'] . 'px;' : '';
		$boxstyle .= '"';
	}

	if ( $bgcolor )
	{
		$stylebg .= ' style="';
		$stylebg .= 'background-color:' . $bgcolor . ';';
		$stylebg .= '"';
	}

	if ( $color )
	{
		$stylecolor .= ' style="';
		$stylecolor .=  'color:' . $color . ';';
		$stylecolor .= '"';
	}

	$fcls .= ' fw' . $GLOBALS['boxicontitlefw'];

	$output .= '<div class="mb2-pb-subelement mb2-pb-process_item theme-box"' . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= theme_mb2nl_page_builder_el_actions( 'subelement' );
	$output .= '<div class="subelement-helper"></div>';
	$output .= '<div class="mb2-pb-subelement-inner">';

	$output .= '<div class="boxprocess">';
	$output .= '<div class="boxprocess-inner"' . $boxstyle . '>';
	$output .= '<div class="boxprocess-label">';
	$output .= '<div class="label-content"' . $stylecolor . '>';
	$output .= '<div class="boxprocess-icon"><i class="' . $icon . '"></i></div>';
	$output .= '<div class="boxprocess-text">' . $label . '</div>';
	$output .= '<div class="colorel colorel1"' . $stylebg . '></div>';
	$output .= '<div class="colorel colorel2"' . $stylebg . '></div>';
	$output .= '<div class="colorel colorel3"' . $stylebg . '></div>';
	$output .= '</div>'; // label-content
	$output .= '</div>'; // boxprocess-label
	$output .= '<div class="boxprocess-content">';
	$output .= '<h4 class="boxprocess-title' . $fcls . '" style="font-size:' . $GLOBALS['boxicontitlefs'] . 'rem;">';
	$output .= $title;
	$output .= '</h4>';
	$output .= '<div class="boxprocess-desc">' . urldecode( $content ) . '</div>';
	$output .= '</div>'; // boxprocess-content
	$output .= '</div>'; // boxprocess-inner
	$output .= '</div>'; // boxprocess
	$output .= '</div>'; // mb2-pb-subelement-inner
	$output .= '</div>'; // mb2-pb-process_item

	return $output;

}
