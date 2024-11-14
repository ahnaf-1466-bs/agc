<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 *
 * @package   theme_mb2nl
 * @copyright 2017 - 2022 Mariusz Boloz (mb2moodle.com)
 * @license   Commercial https://themeforest.net/licenses
 *
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/course/renderer.php');

class theme_mb2nl_core_course_renderer extends core_course_renderer {




	/**
     * Returns HTML to display a tree of subcategories and courses in the given category
     *
     * @param coursecat_helper $chelper various display options
     * @param core_course_category $coursecat top category (this category's name and description will NOT be added to the tree)
     * @return string
     */
    protected function coursecat_tree(coursecat_helper $chelper, $coursecat) {

        global $PAGE;


        // Start content generation
        $content = '';
        $attributes = $chelper->get_and_erase_attributes('course_category_tree clearfix');

        if (  theme_mb2nl_is_course_list() )
        {
            return theme_mb2nl_course_list_layout();
        }

        //////////////

        // Reset the category expanded flag for this course category tree first.
        $this->categoryexpandedonload = false;
        $categorycontent = $this->coursecat_category_content($chelper, $coursecat, 0);
        if (empty($categorycontent)) {
            return '';
        }

        $content .= html_writer::start_tag('div', $attributes);

        if ($coursecat->get_children_count()) {
            $classes = array(
                'collapseexpand', 'aabtn'
            );

            // Check if the category content contains subcategories with children's content loaded.
            if ($this->categoryexpandedonload) {
                $classes[] = 'collapse-all';
                $linkname = get_string('collapseall');
            } else {
                $linkname = get_string('expandall');
            }

            // Only show the collapse/expand if there are children to expand.
            $content .= html_writer::start_tag('div', array('class' => 'collapsible-actions'));
            $content .= html_writer::link('#', $linkname, array('class' => implode(' ', $classes)));
            $content .= html_writer::end_tag('div');
            $this->page->requires->strings_for_js(array('collapseall', 'expandall'), 'moodle');
        }

        $content .= html_writer::tag('div', $categorycontent, array('class' => 'content'));

        $content .= html_writer::end_tag('div'); // .course_category_tree

        return $content;
    }


	/**
     * Returns HTML to display a course category as a part of a tree
     *
     * This is an internal function, to display a particular category and all its contents
     * use {@link core_course_renderer::course_category()}
     *
     * @param coursecat_helper $chelper various display options
     * @param core_course_category $coursecat
     * @param int $depth depth of this category in the current tree
     * @return string
     */
    protected function coursecat_category(coursecat_helper $chelper, $coursecat, $depth) {


		// open category tag
        $classes = array('category');
        if (empty($coursecat->visible)) {
            $classes[] = 'dimmed_category';
        }
        if ($chelper->get_subcat_depth() > 0 && $depth >= $chelper->get_subcat_depth()) {
            // do not load content
            $categorycontent = '';
            $classes[] = 'notloaded';
            if ($coursecat->get_children_count() ||
                    ($chelper->get_show_courses() >= self::COURSECAT_SHOW_COURSES_COLLAPSED && $coursecat->get_courses_count())) {
                $classes[] = 'with_children';
                $classes[] = 'collapsed';
            }
        } else {
            // load category content
            $categorycontent = $this->coursecat_category_content($chelper, $coursecat, $depth);
            $classes[] = 'loaded';
            if (!empty($categorycontent)) {
                $classes[] = 'with_children';
                // Category content loaded with children.
                $this->categoryexpandedonload = true;
            }
        }

        // Make sure JS file to expand category content is included.
        $this->coursecat_include_js();

        $content = html_writer::start_tag('div', array(
            'class' => join(' ', $classes),
            'data-categoryid' => $coursecat->id,
            'data-depth' => $depth,
            'data-showcourses' => $chelper->get_show_courses(),
            'data-type' => self::COURSECAT_TYPE_CATEGORY,
        ));

        // category name
        $categoryname = $coursecat->get_formatted_name();
        $categoryname = html_writer::link(new moodle_url('/course/index.php',
                array('categoryid' => $coursecat->id)),
                $categoryname);
        if ($chelper->get_show_courses() == self::COURSECAT_SHOW_COURSES_COUNT
                && ($coursescount = $coursecat->get_courses_count())) {
            $categoryname .= html_writer::tag('span', ' ('. $coursescount.')',
                    array('title' => get_string('numberofcourses'), 'class' => 'numberofcourse'));
        }
        $content .= html_writer::start_tag('div', array('class' => 'info'));

        $content .= html_writer::tag(($depth > 1) ? 'h4' : 'h3', $categoryname, array('class' => 'categoryname aabtn'));
        $content .= html_writer::end_tag('div'); // .info

        // add category content to the output
        $content .= html_writer::tag('div', $categorycontent, array('class' => 'content'));

        $content .= html_writer::end_tag('div'); // .category

        // Return the course category tree HTML
        return $content;
    }




	protected function coursecat_coursebox(coursecat_helper $chelper, $course, $additionalclasses = '')
	{

	    global $CFG, $USER, $PAGE;

		if (!isset($this->strings->summary))
		{
            $this->strings->summary = get_string('summary');
        }

        if ($chelper->get_show_courses() <= self::COURSECAT_SHOW_COURSES_COUNT)
		{
            return '';
        }

        if ($course instanceof stdClass)
		{
			if (!theme_mb2nl_moodle_from(2018120300))
		    {
		        require_once($CFG->libdir. '/coursecatlib.php');
		    }

			if (theme_mb2nl_moodle_from(2018120300))
		    {
				$course = new core_course_list_element($course);
		    }
		    else
		    {
		        $course = new course_in_list($course);
		    }
        }

		$content = '';
		$showInfoBox = ($chelper->get_show_courses() >= self::COURSECAT_SHOW_COURSES_EXPANDED);
		$summaryContent = $chelper->get_course_formatted_summary($course, array('overflowdiv' => true, 'noclean' => true, 'para' => false));
		$summaryHasP = ($course->has_summary() && theme_mb2nl_check_for_tags($summaryContent, 'p'));
		$infoCls = $summaryHasP ? ' summaryisp' : ' summarynop';
		$infoCls .= !$course->has_summary() ? ' nosummary' : '';
		$infoCls .= $showInfoBox ? ' noinfobox' : ' collapsed isinfobox';
		$infoCls .= (isset($course->visible) && !$course->visible) ? ' course-hidden' : '';
		$infoCls .= is_enrolled(context_course::instance($course->id), $USER->id, '', true) ? ' mycourse' : ' notmycourse';
	 	$classes = trim('coursebox clearfix '. $additionalclasses . $infoCls);

		// .coursebox
		$content .= html_writer::start_tag('div', array(
			'class' => $classes,
			'data-courseid' => $course->id,
			'data-type' => self::COURSECAT_TYPE_COURSE,
		));



		// Collapsed course list
        if ( ! $showInfoBox )
		{
            $nametag = 'div';

			$content .= html_writer::start_tag('div', array('class' => 'info'));

			// Course name
			$coursename = theme_mb2nl_is_mlang($chelper->get_course_formatted_name($course)) ?
				format_text($chelper->get_course_formatted_name($course)) : $chelper->get_course_formatted_name($course);

			if ( theme_mb2nl_theme_setting( $PAGE, 'shortnamecourse') )
			{
				$coursename .= ' <span class="cshortname">' . $course->shortname . '</span>';
			}

			$coursenamelink = html_writer::link(new moodle_url('/course/view.php', array('id' => $course->id)),
			$coursename, array('class' => $course->visible ? '' : 'dimmed'));
			$content .= html_writer::tag($nametag, $coursenamelink, array('class' => 'coursename'));

			// If we display course in collapsed form but the course has summary or course contacts, display the link to the info page.
			$content .= html_writer::start_tag('div', array('class' => 'moreinfo'));

			if ($chelper->get_show_courses() < self::COURSECAT_SHOW_COURSES_EXPANDED)
			{
				if ($course->has_summary() || $course->has_course_contacts() || $course->has_course_overviewfiles())
				{
					$url = new moodle_url('/course/info.php', array('id' => $course->id));
					$image = $this->output->pix_icon('i/info', $this->strings->summary);
					$content .= html_writer::link($url, $image, array('title' => $this->strings->summary));

					// Make sure JS file to expand course content is included.
					$this->coursecat_include_js();
				}
			}

			$content .= html_writer::end_tag('div'); // .moreinfo

			// Print enrolmenticons
			$content .= $this->theme_mb2nl_coursecat_coursebox_enroll_icons($course);
			$content .= html_writer::end_tag('div'); // .info

		} // if $showInfoBox

	   	$content .= html_writer::start_tag('div', array('class' => 'content'));
       	$content .= $this->coursecat_coursebox_content($chelper, $course);
       	$content .= html_writer::end_tag('div'); // .content
    	$content .= html_writer::end_tag('div'); // .coursebox

        return $content;

    }





	protected function theme_mb2nl_coursecat_coursebox_enroll_icons($course)
	{
		$content = '';

		// Print enrolmenticons
		if ($icons = enrol_get_course_info_icons($course))
		{

			$content .= html_writer::start_tag('div', array('class' => 'enrolmenticons'));
			foreach ($icons as $pix_icon)
			{
				$content .= $this->render($pix_icon);
			}

			$content .= html_writer::end_tag('div'); // .enrolmenticons
		}

		return $content;
	}





	protected function theme_mb2nl_coursecat_coursebox_content_image ($chelper, $url, $course)
	{
		$img = html_writer::empty_tag('img', array('src' => $url, 'alt' => $chelper->get_course_formatted_name($course)));
		$output = html_writer::link(new moodle_url('/course/view.php', array('id' => $course->id)), $img);
		return $output;
	}





	protected function coursecat_coursebox_content(coursecat_helper $chelper, $course)
	{

		global $CFG,$PAGE,$OUTPUT,$USER;

        if ($chelper->get_show_courses() < self::COURSECAT_SHOW_COURSES_EXPANDED)
		{
            return;
        }

		$noCollBox = ($chelper->get_show_courses() >= self::COURSECAT_SHOW_COURSES_EXPANDED);

        if ($course instanceof stdClass)
		{
			if (!theme_mb2nl_moodle_from(2018120300))
		    {
		        require_once($CFG->libdir. '/coursecatlib.php');
		    }

			if (theme_mb2nl_moodle_from(2018120300))
		    {
				$course = new core_course_list_element($course);
		    }
		    else
		    {
		       $course = new course_in_list($course);
		    }
        }

      	$content = '';
		$countFiles =  count($course->get_course_overviewfiles());
		$plcImg = 1;
		$isFile = ($countFiles > 0 || $plcImg);
		$isContacts = ($course->has_course_contacts() > 0);
		$isCategory = ($chelper->get_show_courses() == self::COURSECAT_SHOW_COURSES_EXPANDED_WITH_CAT);
		$isCourseContent = true;

		$contentCls = ($isFile && $isCourseContent) ? ' fileandcontent' : '';
		$content .= html_writer::start_tag('div', array('class' => 'content-inner' . $contentCls));

		// display course overview files
      	$contentimages = $contentfiles = '';

		if ($isFile)
		{

			$content .= html_writer::start_tag('div', array('class' => 'course-media'));

			foreach ($course->get_course_overviewfiles() as $file)
			{

				$isimage = $file->is_valid_image();

				$url = file_encode_url("$CFG->wwwroot/pluginfile.php",
				'/'. $file->get_contextid(). '/'. $file->get_component(). '/'.
				$file->get_filearea(). $file->get_filepath() . $file->get_filename(), !$isimage);


				if ($isimage)
				{
					$contentimages .= $this->theme_mb2nl_coursecat_coursebox_content_image($chelper, $url,$course);
				}
				else
				{
					$image = $this->output->pix_icon(file_file_icon($file, 24), $file->get_filename(), 'moodle');
					$filename = html_writer::tag('span', $image, array('class' => 'fp-icon')) .
					html_writer::tag('span', $file->get_filename(), array('class' => 'fp-filename'));
					$contentfiles .= html_writer::tag('span', html_writer::link($url, $filename), array('class' => 'coursefile fp-filename-icon'));
				}
			}


			// Course placeholder image
			$moodle33 = 2017051500;

			if ( $contentimages === '' && $plcImg )
			{
                $courseplaceholder = theme_mb2nl_theme_setting( $PAGE, 'courseplaceholder', '', true );
                $isPlcImg = $courseplaceholder ? $courseplaceholder : $OUTPUT->image_url('course-default','theme');
				$contentimages .= $this->theme_mb2nl_coursecat_coursebox_content_image( $chelper, $isPlcImg, $course );
			}

			$content .= $contentimages . $contentfiles;

			$content .= html_writer::end_tag('div'); // .course-media

		}


      	// display course summary
      	if ($isCourseContent)
		{

			$content .= html_writer::start_tag('div', array('class' => 'course-content'));

			// Course heading
			$coursename = theme_mb2nl_is_mlang( $chelper->get_course_formatted_name( $course ) ) ?
			format_text($chelper->get_course_formatted_name($course)) : $chelper->get_course_formatted_name( $course );

			if ( theme_mb2nl_theme_setting( $PAGE, 'shortnamecourse') )
			{
				$coursename .= ' <span class="cshortname">' . $course->shortname . '</span>';
			}

			$coursenamelink = html_writer::link(new moodle_url('/course/view.php', array('id' => $course->id)), $coursename);
			$content .= html_writer::start_tag('div', array('class' => 'course-heading'));
			$content .= html_writer::tag('h3', $coursenamelink, array('class' => 'coursename'));
            $coursedate = theme_mb2nl_theme_setting( $PAGE,'coursedate' );

			if ( $coursedate == 1 )
			{
				$content .= '<div class="coursedate"><span>' . get_string('coursestartdate', 'theme_mb2nl') . ':</span> ' .
				userdate($course->startdate, get_string('strftimedatemonthabbr', 'theme_mb2nl')) . '</div>';
			}
            elseif ( $coursedate == 2 && $course->timemodified )
            {
                $content .= '<div class="coursedate"><span>' . get_string('coursemodifieddate', 'theme_mb2nl') . ':</span> ' .
				userdate($course->timemodified, get_string('strftimedatemonthabbr', 'theme_mb2nl')) . '</div>';
            }

			if ( theme_mb2nl_theme_setting( $PAGE,'coursecustomfields' )  )
			{
				$content .= theme_mb2nl_course_fields( $course->id );
			}

			$content .= $this->theme_mb2nl_coursecat_coursebox_enroll_icons($course);
			$content .= html_writer::end_tag('div');

		   	if ($course->has_summary())
		  	{
				$content .= html_writer::start_tag('div', array('class' => 'summary'));
				$content .= $chelper->get_course_formatted_summary($course, array('overflowdiv' => true, 'noclean' => true, 'para' => false));
				$content .= html_writer::end_tag('div'); // .summary
			}

			$context = context_course::instance($course->id);
			$students = get_role_users( theme_mb2nl_get_user_role_id(), $context);
			$students_count = count($students);
			$is_student = theme_mb2nl_is_user_role( $course->id, theme_mb2nl_get_user_role_id(), $USER->id );


			if ($isContacts || theme_mb2nl_theme_setting($PAGE,'coursestudentscount'))
			{

				$content .= html_writer::start_tag('ul', array('class' => 'teachers'));

				if ($isContacts)
				{
					foreach ($course->get_course_contacts() as $userid => $coursecontact)
					{
						$name = '<strong>' .$coursecontact['rolename'].':</strong> ' . html_writer::link(new moodle_url('/user/view.php', array('id' => $userid, 'course' => SITEID)), $coursecontact['username']);
						$content .= html_writer::tag('li', $name);
					}
				}


				if (theme_mb2nl_theme_setting($PAGE,'coursestudentscount'))
				{

					$students_count_text = $students_count ? $students_count : get_string('nostudentsyet');

					if ($is_student)
					{
						$students_count = $students_count - 1;
						$students_count_text = get_string('studentsandyou','theme_mb2nl',array('students'=>$students_count));
					}

					$content .= html_writer::tag('li', '<strong>' . get_string('existingstudents') . ':</strong> ' . $students_count_text);
				}

				$content .= html_writer::end_tag('ul'); // .teachers

			}


			 // display course category if necessary (for example in search results)
			if ($isCategory)
			{

				if (!theme_mb2nl_moodle_from(2018120300))
			    {
			        require_once($CFG->libdir. '/coursecatlib.php');
			    }

				if (theme_mb2nl_moodle_from(2018120300))
				{
					$cat = core_course_category::get($course->category, IGNORE_MISSING);
				}
				else
				{
					$cat = coursecat::get($course->category, IGNORE_MISSING);
				}

				if ($cat)
				{

					$content .= html_writer::start_tag('div', array('class' => 'coursecat'));

					$content .= '<strong>' . get_string('category').':</strong> '. html_writer::link(new moodle_url('/course/index.php', array('categoryid' => $cat->id)),
					$cat->get_formatted_name(), array('class' => $cat->visible ? '' : 'dimmed'));

					$content .= html_writer::end_tag('div'); // .coursecat

				}
			}


			// Red more button
			if ( $PAGE->pagetype !== 'enrol-index' )
			{
				$coursenamebtnlink = html_writer::link(new moodle_url('/course/view.php', array('id' => $course->id)), get_string('entercourse', 'theme_mb2nl'), array('class' =>'btn btn-primary'));
				$content .= html_writer::tag('div', $coursenamebtnlink, array('class' => 'course-readmore'));
			}



			$content .= html_writer::end_tag('div'); // .course-content

        }





		$content .= html_writer::end_tag('div'); // .content-inner


        return $content;

    }


    // public function render_activity_navigation(\core_course\output\activity_navigation $page)
    // {
    //     global $PAGE;
    //
    //     if ( theme_mb2nl_theme_setting($PAGE,'coursenav') )
    //     {
    //         return theme_mb2nl_customnav();
    //     }
    //
    //     $data = $page->export_for_template($this->output);
    //     return $this->output->render_from_template('core_course/activity_navigation', $data);
    //
    //
    // }
}
