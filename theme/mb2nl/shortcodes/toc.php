<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('toc', 'mb2_shortcode_toc');


function mb2_shortcode_toc($atts, $content= null){

	global $PAGE, $DB;

	extract(mb2_shortcode_atts( array(
		'color' => 'default',
		'class'=> ''
	), $atts));


	$output = '';

	if ( $PAGE->pagetype !== 'mod-page-view' )
	{
		return;
	}

	// Get page ID
	$pageid = $DB->get_record( 'course_modules', array( 'id' => $PAGE->cm->id ), 'instance', MUST_EXIST );
	$pageid = $pageid->instance;

	// Get page content
	$pcontent = $DB->get_record( 'page', array( 'id' => $pageid ), '*', MUST_EXIST );
	$pcontent = theme_mb2nl_toc_get_headlines($pcontent->content);

	if ( ! count( $pcontent ) )
	{
		return;
	}

	// Get table of content HTML
	$output .= '<div class="theme-toc">';
	$output .= '<p>' . get_string('onthispage', 'theme_mb2nl') . ':</p>';
	$output .= theme_mb2nl_toc_get_html( $pcontent );
	$output .= '</div>';

	$PAGE->requires->js_call_amd( 'theme_mb2nl/toc','tocInit' );

	return $output;


}


function theme_mb2nl_toc_get_html($toc, $class = true)
{

	$output = '';
	$cls =  $class ? 'toc-list' : '';
	$output .= '<ol class="' . $cls . '">';

	foreach( $toc as $t )
	{
		$output .= '<li>';
		$output .= '<a href="#' . theme_mb2nl_string_url_safe( $t['text'] ) . '" aria-describedby="' . theme_mb2nl_string_url_safe( $t['text'] ) . '">' . $t['text'] . '</a>';

		if ( count( $t['sub_toc'] ) )
		{
			$output .= theme_mb2nl_toc_get_html( $t['sub_toc'], false );
		}

		$output .= '</li>';
	}

	$output .= '</ol>';

	return $output;
}



function theme_mb2nl_toc_get_headlines( $html, $depth = 3 )
{

	if( $depth > 7 )
	{
		return array();
	}

    $headlines = explode( '<h' . $depth, $html );
    unset( $headlines[0] );       // contains only text before the first headline

    if (count($headlines) == 0)
	{
		return array();
	}

    $toc = array();      // will contain the (sub-) toc

    foreach( $headlines as $headline )
    {

		list($hl_info, $temp) = explode('>', $headline, 2);

        // $hl_info contains attributes of <hi ... > like the id.
        list($hl_text, $sub_content) = explode('</h' . $depth . '>', $temp, 2);

        // $hl contains the headline
        // $sub_content contains maybe other <hi>-tags
        $id = '';

        if (strlen( $hl_info ) > 0 && ( $id_tag_pos = stripos( $hl_info, 'id' ) ) !== false )
        {
            $id_start_pos = stripos( $hl_info, '"', $id_tag_pos );
            $id_end_pos = stripos( $hl_info, '"', $id_start_pos );
            $id = substr( $hl_info, $id_start_pos, $id_end_pos - $id_start_pos );
        }

        $toc[] = array(
			'id' => $id,
			'text' => $hl_text,
			'sub_toc' => theme_mb2nl_toc_get_headlines( $sub_content, $depth + 1 )
		);

    }

    return $toc;

}
