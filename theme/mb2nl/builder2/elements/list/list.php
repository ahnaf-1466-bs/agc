
<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode( 'mb2pb_list', 'mb2pb_shortcode_list' );
mb2_add_shortcode( 'mb2pb_list_item', 'mb2pb_shortcode_list_item' );

function mb2pb_shortcode_list( $atts, $content = null ){

	$atts2 = array(
		'id' => 'list',
		'style' => 'disc',
		'icon' => '',
		'horizontal' => 0,
		'align' => 'none',
		'custom_class' => '',
		'fwcls' => 'global',
		'color' => '',
		'mt' => 0,
		'mb' => 30,
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$GLOBALS['mb2pblisticon'] = $icon;
	$GLOBALS['mb2pbliststyle'] = $style;
	$styleattr = '';
	$output = '';
	$cls = '';

	$cls .= ' horizontal' . $horizontal;
	$cls .= ' list-' . $align;
	$cls .= ' list-' . $style;
	$cls .= ' fw' . $fwcls;
	$cls .= $custom_class ? ' ' . $custom_class : '';

	$templatecls = $template ? ' mb2-pb-template-list' : '';

	$list_tag = $style === 'number' ? 'ol' : 'ul';

	//if ( $mt || $mb )
	//{
		$styleattr .= ' style="';
		$styleattr .= $mt ? 'margin-top:' . $mt . 'px;' : '';
		$styleattr .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
		$styleattr .= $color ? 'color:' . $color . ';' : '';
		$styleattr .= '"';
	//}

	$content = $content;

	if ( ! $content )
	{
		for (  $i = 1; $i <= 3; $i++ )
		{
			$content .= '[mb2pb_list_item]List content here.[/mb2pb_list_item]';
		}
	}

	$output .= '<div class="mb2-pb-element mb2-pb-list' . $templatecls . '"' . $styleattr . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'list' );
	$output .= '<' . $list_tag . ' class="theme-list mb2-pb-sortable-subelements' . $cls . '">';
	$output .= mb2_do_shortcode( $content );
	$output .= '</' . $list_tag . '>';
	$output .= '</div>';

	return $output;

}




function mb2pb_shortcode_list_item( $atts, $content = null ){

	$atts2 = array(
		'id' => 'list_item',
		'icon' => '',
		'link'=> '',
		'link_target'=> '',
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$icon = $icon ? $icon : $GLOBALS['mb2pblisticon'];

	$content = ! $content ? 'List content here.' : $content;
	$atts2['text'] = $content;

	$output .= '<li class="mb2-pb-subelement mb2-pb-list_item"' . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= theme_mb2nl_page_builder_el_actions( 'subelement' );
	$output .= '<div class="subelement-helper"></div>';
	$output .= $icon ? '<i class="' . $icon . '"></i>' : '';
	$output .= '<span class="list-text">' . urldecode( $content ) . '</span>';
	$output .= '</li>';

	return $output;

}
