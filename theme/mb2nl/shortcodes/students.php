<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('students', 'mb2_shortcode_students');
function mb2_shortcode_students ($atts, $content= null){

	extract(mb2_shortcode_atts( array(
		'course_id' => 0,
		'class'=> ''
	), $atts));

	global $PAGE;

	if ( ! $course_id )
	{
		return;
	}

	$context = context_course::instance( $course_id );
	$students = get_role_users( theme_mb2nl_get_user_role_id(), $context );
	$students_count = count( $students );
	
	return $students_count;

}
