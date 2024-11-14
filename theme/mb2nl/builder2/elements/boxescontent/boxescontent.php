<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('mb2pb_boxescontent', 'mb2pb_shortcode_boxescontent');
mb2_add_shortcode('mb2pb_boxescontent_item', 'mb2pb_shortcode_boxescontent_item');

function mb2pb_shortcode_boxescontent( $atts, $content = null ){

	$atts2 = array(
		'id' => 'boxescontent',
		'columns' => 3, // max 5
		'gutter' => 'normal',
		'type' => 1,
		'rounded' => 0,
		'tfs' => 1.4,
		'tfw' => 'global',
		'wave' => 0,
		'height' => 0,
		'mt' => 0,
		'mb' => 0, // 0 because box item has margin bottom 30 pixels
		'boxmb' => 0,
		'padding' => 'm',
		'shadow' => 0,
		'custom_class' => '',
		//
		'btnhor' => 0,
		'cwidth' => 2000,
		'linkbtn' => 0,
		'btntype' => 'primary',
		'btnsize' => 'normal',
		'btnfwcls' => 'global',
		'btnrounded' => 0,
		'btnborder' => 0,
		'btntext' => '',
		//
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$cls = '';
	$style = '';

	$GLOBALS['boxmb'] = $boxmb;
	$GLOBALS['height'] = $height;
	$GLOBALS['boxcontenttlefs'] = $tfs;
	$GLOBALS['boxcontenttlefw'] = $tfw;
	//
	$GLOBALS['boxcontentcwidth'] = $cwidth;
	$GLOBALS['boxcontentbtntext'] = $btntext;
	$GLOBALS['boxcontentbtntype'] = $btntype;
	$GLOBALS['boxcontentbtnsize'] = $btnsize;
	$GLOBALS['boxcontentbtnfwcls'] = $btnfwcls;
	$GLOBALS['boxcontentbtnborder'] = $btnborder;
	$GLOBALS['boxcontentbtnrounded'] = $btnrounded;

	$cls .= ' gutter-' . $gutter;
	$cls .= ' theme-col-' . $columns;
	$cls .= ' rounded' . $rounded;
	$cls .= ' linkbtn' . $linkbtn;
	$cls .= ' wave' . $wave;
	$cls .= ' type-' . $type;
	$cls .= ' btnhor' . $btnhor;
	$cls .= ' padding' . $padding;
	$cls .= ' shadow' . $shadow;
	$cls .= $custom_class ? ' ' . $custom_class : '';
	$templatecls = $template ? ' mb2-pb-template-boxescontent' : '';

	$style .= ' style="';
	$style .= $mt ? 'margin-top:' . $mt . 'px;' : '';
	$style .= $mb ? 'margin-bottom:' . $mb . 'px;' : '';
	$style .= '"';

	$content = $content;

	if ( ! $content )
	{
		for (  $i = 1; $i <= 3; $i++ )
		{
			$content .= '[mb2pb_boxescontent_item title="Box title here" label="' . $i . '" ]Box content here.[/mb2pb_boxescontent_item]';
		}
	}

	$output .= '<div class="mb2-pb-element mb2-pb-boxescontent' . $templatecls . '"' . $style . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= '<div class="element-helper"></div>';
	$output .= theme_mb2nl_page_builder_el_actions( 'element', 'boxescontent' );
	$output .= '<div class="mb2-pb-element-inner theme-boxes theme-boxescontent' . $cls . '">';
	$output .= '<div class="mb2-pb-sortable-subelements">';
	$output .= mb2_do_shortcode($content);
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}


function mb2pb_shortcode_boxescontent_item( $atts, $content = null ){

	$atts2 = array(
		'id' => 'boxescontent_item',
		'icon' => '',
		'title'=> 'Box title here',
		'link' => '',
		'bgimage' => '',
		'scheme' => 'light',
		'color' => '',
		'bgcolor' => '',
		'link_target' => 0,
		'template' => ''
	);

	extract( mb2_shortcode_atts( $atts2, $atts ) );

	$output = '';
	$fcls = '';
	$boxstyle = '';
	$stylebgimg = '';
	$stylebgcolor = '';
	$stylecolor = '';
	$boxscttyle = '';
	$heightstyle = '';
	$cls = '';

	$cls .= ' ' . $scheme;

	$btntext = $GLOBALS['boxcontentbtntext'] ? $GLOBALS['boxcontentbtntext'] : get_string( 'readmorefp', 'local_mb2builder' );
	$content = ! $content ? 'Box content here.' : $content;
	$atts2['content'] = $content;

	$boxscttyle .= ' style="';
	$boxscttyle .= 'max-width:' . $GLOBALS['boxcontentcwidth'] . 'px;';
	$boxscttyle .= '"';

	if ( $GLOBALS['boxmb'] || $bgimage )
	{
		$boxstyle .= ' style="';
		$boxstyle .= $GLOBALS['boxmb'] ? 'margin-bottom:' . $GLOBALS['boxmb'] . 'px;' : '';
		$boxstyle .= $bgimage ? 'background-image:url(\''. $bgimage . '\');' : '';
		$boxstyle .= '"';
	}

	if ( $GLOBALS['height'] )
	{
		$heightstyle .= ' style="';
		$heightstyle .= 'min-height:' . $GLOBALS['height'] . 'px;';
		$heightstyle .= '"';
	}

	if ( $bgcolor )
	{
		$stylebgcolor .= ' style="';
		$stylebgcolor .= 'background-color:' . $bgcolor . ';';
		$stylebgcolor .= '"';
	}

	// if ( $bgimage )
	// {
	// 	$stylebgimg .= ' style="';
	// 	$stylebgimg .= 'background-image:url(\''. $bgimage . '\');';
	// 	$stylebgimg .= '"';
	// }

	if ( $color )
	{
		$stylecolor .= ' style="';
		$stylecolor .=  'background-color:' . $color . ';';
		$stylecolor .=  'border-color:' . $color . ';';
		$stylecolor .= '"';
	}

	$fcls .= ' fw' . $GLOBALS['boxcontenttlefw'];

	$output .= '<div class="mb2-pb-subelement mb2-pb-boxescontent_item theme-box"' . theme_mb2nl_page_builder_el_datatts( $atts, $atts2 ) . '>';
	$output .= theme_mb2nl_page_builder_el_actions( 'subelement' );
	$output .= '<div class="subelement-helper"></div>';
	$output .= '<div class="mb2-pb-subelement-inner">';

	$output .= '<div class="boxcontent' . $cls . '"' . $boxstyle . '>';
	$output .= '<div class="boxcontent-inner"' . $heightstyle . '>';
	$output .= '<div class="boxcontent-content"' . $boxscttyle . '>';
	$output .= '<h4 class="boxcontent-title' . $fcls . '" style="font-size:' . $GLOBALS['boxcontenttlefs'] . 'rem;">';
	$output .= $title;
	$output .= '</h4>';
	$output .= '<div class="boxcontent-desc">' . urldecode( $content ) . '</div>';
	$output .= '</div>'; // boxcontent-content
	$output .= '<div class="boxcontent-readmore">';
	$output .= '<a href="#" class="arrowlink">' . $btntext . '</a>';
	$output .= '<a href="#" class="mb2-pb-btn type' . $GLOBALS['boxcontentbtntype'] . ' size' . $GLOBALS['boxcontentbtnsize'] . ' rounded' .
	$GLOBALS['boxcontentbtnrounded'] . ' btnborder' . $GLOBALS['boxcontentbtnborder'] . ' fw' . $GLOBALS['boxcontentbtnfwcls'] . '">' . $btntext . '</a>';
	$output .= '</div>'; // theme-boxicon-readmore
	$output .= '</div>'; // boxcontent-inner
	$output .= '<div class="bgcolor"' . $stylebgcolor . '></div>';
	$output .= '<div class="elcolor-el">';
	$output .= '<div class="elcolor1"' . $stylecolor . '></div>';
	$output .= '<div class="elcolor2"' . $stylecolor . '></div>';
	$output .= '</div>'; // elcolor-el
	$output .= '</div>'; // boxcontent
	$output .= '</div>'; // mb2-pb-subelement-inner
	$output .= '</div>'; // mb2-pb-boxescontent_item

	return $output;

}
