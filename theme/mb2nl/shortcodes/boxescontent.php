<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('boxescontent_item', 'shortcode_boxescontent_item');

function shortcode_boxescontent_item( $atts, $content = null ){

	$atts2 = array(
		'id' => 'boxescontent_item',
		'icon' => '',
		'title'=> 'Box title here',
		'link' => '',
		'bgimage' => '',
		'scheme' => 'light',
		'color' => '',
		'bgcolor' => '',
		'link_target' => 0		
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
	$cls .= $bgimage ? ' lazy' : '';

	$btntext = $GLOBALS['boxbtntext'] ? $GLOBALS['boxbtntext'] : get_string( 'readmorefp', 'local_mb2builder' );
	$target = $link_target ? ' target="_blank"' : '';

	if ( $GLOBALS['boxcwidth'] )
	{
		$boxscttyle .= ' style="';
		$boxscttyle .= 'max-width:' . $GLOBALS['boxcwidth'] . 'px;';
		$boxscttyle .= '"';
	}

	$lazybg = $bgimage ? ' data-bg="'. $bgimage . '"' : '';

	if ( $GLOBALS['boxmb'] )
	{
		$boxstyle .= ' style="';
		$boxstyle .= $GLOBALS['boxmb'] ? 'margin-bottom:' . $GLOBALS['boxmb'] . 'px;' : '';
		//$boxstyle .= $bgimage ? 'background-image:url(\''. $bgimage . '\');' : '';
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

	if ( $color )
	{
		$stylecolor .= ' style="';
		$stylecolor .=  'background-color:' . $color . ';';
		$stylecolor .=  'border-color:' . $color . ';';
		$stylecolor .= '"';
	}

	$fcls .= ' fw' . $GLOBALS['boxtfw'];

	$output .= '<div class="mb2-pb-subelement mb2-pb-boxescontent_item theme-box">';
	$output .= '<div class="mb2-pb-subelement-inner">';
	$output .= '<div class="boxcontent' . $cls . '"' . $boxstyle . $lazybg . '>';
	$output .= '<div class="boxcontent-inner"' . $heightstyle . '>';
	$output .= '<div class="boxcontent-content"' . $boxscttyle . '>';
	$output .= '<h4 class="boxcontent-title' . $fcls . '" style="font-size:' . $GLOBALS['boxtfs'] . 'rem;">';
	$output .= format_text( $title, FORMAT_HTML );
	$output .= '</h4>';
	$output .= '<div class="boxcontent-desc">' . format_text(  urldecode( $content ), FORMAT_HTML ) . '</div>';
	$output .= '</div>'; // boxcontent-content

	if ( $link )
	{
		$output .= '<div class="boxcontent-readmore">';
		$output .= $GLOBALS['boxlinkbtn'] == 1 ? '<a href="' . $link . '"' . $target . ' class="arrowlink">' . $btntext . '</a>' : '';
		$output .= $GLOBALS['boxlinkbtn'] == 2 ? '<a href="' . $link . '"' . $target . ' class="mb2-pb-btn type' . $GLOBALS['boxlinkbtntype'] . ' size' .
		$GLOBALS['boxlinkbtnsize'] . ' rounded' . $GLOBALS['boxlinkbtnborder'] . ' btnborder' . $GLOBALS['boxlinkbtnborder'] . ' fw' .
		$GLOBALS['boxlinkbtnfwcls'] . '">' . $btntext . '</a>' : '';
		$output .= '</div>'; // theme-boxicon-readmore
	}

	$output .= '</div>'; // boxcontent-inner
	$output .= $bgcolor ? '<div class="bgcolor"' . $stylebgcolor . '></div>' : '';
	$output .= '<div class="elcolor-el">';
	$output .= '<div class="elcolor1"' . $stylecolor . '></div>';
	$output .= '<div class="elcolor2"' . $stylecolor . '></div>';
	$output .= '</div>'; // elcolor-el
	$output .= '</div>'; // boxcontent
	$output .= $link ? '<a class="linkabs" href="' . $link . '"' . $target . ' tabindex="0" aria-label="' . format_text( $title, FORMAT_HTML ) . '"></a>' : '';
	$output .= '</div>'; // mb2-pb-subelement-inner
	$output .= '</div>'; // mb2-pb-boxescontent_item

	return $output;

}
