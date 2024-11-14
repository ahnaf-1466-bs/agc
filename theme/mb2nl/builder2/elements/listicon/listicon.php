<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'mb2pb_listicon', 'mb2pb_shortcode_mb2pb_listicon' );
mb2_add_shortcode( 'mb2pb_listicon_item', 'mb2pb_shortcode_mb2pb_listicon_item' );

function mb2pb_shortcode_mb2pb_listicon( $atts, $content = null ){

	$atts2 = array(
		'id' => 'listicon',
		'style' => 'disc',
		'icon' => 'fa fa-check-square-o',
		'bgcolor' => '',
		'iconcolor' => '',
		'textcolor' => '',
		'border' => 0,
		'borderw' => 2,
		'bordercolor' => '',
		'horizontal' => 0,
		'align' => 'none',
		'fwcls' => 'global',
		'isize' => 2.65,
		'space' => 0.45,
		'iconbg' => 1,
		'fs' => 1,
		'custom_class' => '',
		'mt' => 0,
		'mb' => 30,
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$GLOBALS['mb2pblisticon'] = $icon ? $icon : 'fa fa-check-square-o';
	$GLOBALS['mb2pblistbgcolor'] = $bgcolor;
	$GLOBALS['mb2pblisticoncolor'] = $iconcolor;
	$GLOBALS['mb2pblisttextcolor'] = $textcolor;
	$GLOBALS['mb2pblistbordercolor'] = $bordercolor;
	$GLOBALS['mb2pblistborderw'] = $borderw;

	$styleattr = '';
	$liststyle = '';
 	$output = '';
	$cls = '';

	$cls .= ' iconbg' . $iconbg;
	$cls .= ' horizontal' . $horizontal;
	$cls .= ' border' . $border;
	$cls .= ' fw' . $fwcls;
	$cls .= ' align' . $align;
	$cls .= $custom_class ? ' ' . $custom_class : '';

	$templatecls = $template ? ' mb2-pb-template-listicon' : '';

	//if ( $mt || $mb )
	//{
		$styleattr .= ' style="';
		$styleattr .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$styleattr .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$styleattr .= '"';
	//}

	$liststyle .= ' style="';
	$liststyle .= '--mb2-pb-listicon-fs:' . $fs . 'rem;';
	$liststyle .= '--mb2-pb-listicon-isize:' . $isize . 'rem;';
	$liststyle .= '--mb2-pb-listicon-space:' . $space . 'rem;';
	$liststyle .= '"';

	$content = $content;

	if ( ! $content )
	{
		for (  $i = 1; $i <= 3; $i++ )
		{
			$content .= '[mb2pb_listicon_item]List content here.[/mb2pb_listicon_item]';
		}
	}

	$output .= '<div class="mb2-pb-element mb2-pb-listicon' . $templatecls . '"' . $styleattr . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'listicon' );
	$output .= '<ul class="theme-listicon mb2-pb-sortable-subelements' . $cls . '"' . $liststyle . '>';
	$output .= mb2_do_shortcode( $content );
	$output .= '</ul>';
	$output .= '</div>';

	return $output;

}




function mb2pb_shortcode_mb2pb_listicon_item( $atts, $content = null ){

	$atts2 = array(
		'id' => 'listicon_item',
		'icon' => '',
		'bgcolor' => '',
		'iconcolor' => '',
		'textcolor' => '',
		'bordercolor' => '',
		'link' => '',
		'link_target'=> 0,
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$iconstyle = '';
	$textstyle = '';
	$icon = $icon ? $icon : $GLOBALS['mb2pblisticon'];
	$bgcolor =  $bgcolor ? $bgcolor : $GLOBALS['mb2pblistbgcolor'];
	$iconcolor = $iconcolor ? $iconcolor : $GLOBALS['mb2pblisticoncolor'];
	$textcolor = $textcolor ? $textcolor : $GLOBALS['mb2pblisttextcolor'];
	$bordercolor = $bordercolor ? $bordercolor : $GLOBALS['mb2pblistbordercolor'];

	//if ( $bgcolor || $iconcolor )
	//{
		$iconstyle .= ' style="';
		$iconstyle .= $bgcolor ? 'background-color:' . $bgcolor . ';' : '';
		$iconstyle .= $iconcolor ? 'color:' . $iconcolor . ';' : '';
		//$iconstyle .= $GLOBALS['mb2pblistisize'] ? '--mb2-pb-listicon-isize:' . $GLOBALS['mb2pblistisize'] . 'rem;' : '';
		$iconstyle .= '"';
	//}

	//if ( $textcolor )
	//{
		$textstyle .= ' style="';
		$textstyle .= 'color:' . $textcolor . ';';
		$textstyle .= 'border-bottom-width:' . $GLOBALS['mb2pblistborderw'] . 'px;';
		$textstyle .= 'border-bottom-color:' . $bordercolor . ';';
		$textstyle .= '"';
	//}

	$content = ! $content ? 'List content here.' : $content;
	$atts2['text'] = $content;

	$output .= '<li class="mb2-pb-subelement mb2-pb-listicon_item"' . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= theme_mb2nl_page_builder_el_actions( 'subelement' );
	$output .= '<div class="subelement-helper"></div>';
	$output .= '<div class="item-content">';
	$output .= '<span class="iconel"' . $iconstyle . '><i class="' . $icon . '"></i></span>';
	$output .= '<span class="list-text"' . $textstyle . '>' . urldecode( $content ) . '</span>';
	$output .= '</div>';
	$output .= '</li>';

	return $output;

}
