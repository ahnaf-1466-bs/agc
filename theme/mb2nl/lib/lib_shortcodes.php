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



/*
 *
 * Method to get shortcode course teplate
 *
 */
function theme_mb2nl_shortcodes_course_template( $courses, $options, $builder = false )
{
	return theme_mb2nl_course_list_courses( $courses, true, $builder, $options );
}



/*
 *
 * Method to get shortcode review teplate
 *
 */
function theme_mb2nl_shortcodes_reviews_template( $reviews, $opts = array() )
{
	global $CFG, $OUTPUT;

	$output = '';

	if ( ! theme_mb2nl_is_review_plugin() )
	{
		return;
	}

	if ( ! class_exists( 'Mb2reviewsHelper' ) )
	{
		require_once( $CFG->dirroot . '/local/mb2reviews/classes/helper.php' );
	}

	$carousel = ( isset( $opts['carousel'] ) && $opts['carousel'] );
	$carouselcls = $carousel ? ' swiper-slide' : '';

	foreach ( $reviews as $review )
	{
		$coursename = get_course( $review->course );
		$reviewuser = Mb2reviewsHelper::get_user( $review->createdby );
		$username = Mb2reviewsHelper::get_user_name( $reviewuser );

		$output .= '<div class="theme-course-review theme-box review-' . $review->id . ' course-' . $review->course . ' user-' . $review->createdby . $carouselcls . '">';
		$output .= '<div class="theme-course-review-inner">';
		$output .= '<div class="review-header">';
		$output .= Mb2reviewsHelper::rating_stars( false, $review->rating );
		$output .= '<span class="review-course">';
		$output .= $coursename->fullname;
		$output .= '</span>'; // review-course
		$output .= '</div>'; // review-header
		$output .= '<div class="review-content">';
		$output .= $review->content;
		$output .= '</div>'; // review-content
		$output .= '<div class="review-footer">';

		if ( $opts['userimg'] )
		{
			$output .= '<div class="review-userimg">';
			$output .= $OUTPUT->user_picture( $reviewuser, array( 'size'=> 100, 'link' => 0 ) );
			$output .= '</div>'; // review-userimg
		}

		$output .= $username;
		$output .= '</div>'; // review-footer
		$output .= '</div>'; // theme-course-review-inner
		$output .= '</div>'; // theme-course-review
	}

	return $output;

}





/*
 *
 * Method to get shortcode teacher teplate
 *
 */
function theme_mb2nl_shortcodes_teachers_template( $teachers, $opts = array() )
{
	global $CFG, $OUTPUT;
	$output = '';
	$reviews = theme_mb2nl_is_review_plugin();

	if ( $reviews )
	{
		if ( ! class_exists( 'Mb2reviewsHelper' ) )
		{
			require_once( $CFG->dirroot . '/local/mb2reviews/classes/helper.php' );
		}
	}

	$carousel = ( isset( $opts['carousel'] ) && $opts['carousel'] );
	$carouselcls = $carousel ? ' swiper-slide' : '';

	foreach ( $teachers as $teacher )
	{

		$coursescount = theme_mb2nl_get_instructor_courses_count( $teacher->id );
		$studentscount = theme_mb2nl_get_instructor_students_count( $teacher->id );

		$output .= '<div class="theme-course-teacher theme-box teacher-' . $teacher->id . $carouselcls . '">';
		$output .= '<div class="theme-course-teacher-inner">';
		$output .= '<div class="teacher-image">';
		$output .= $OUTPUT->user_picture( $teacher, array( 'size' => 100, 'link' => 0 ) );
		$output .= '</div>'; // teacher-image
		$output .= '<h4 class="teacher-name">';
		$output .= $teacher->firstname . ' ' . $teacher->lastname;
		$output .= '</h4>'; // teacher-name
		$output .= '<div class="teacher-info">';

		if ( $reviews )
		{
			if ( Mb2reviewsHelper::course_rating( 0, $teacher->id ) )
			{
				$output .= '<div class="info-rating">';
				$output .= '<i class="glyphicon glyphicon-star"></i>';
				$output .= Mb2reviewsHelper::course_rating( 0, $teacher->id );
				$output .= ' (' . get_string('ratingscount', 'local_mb2reviews',
				array('ratings'=> Mb2reviewsHelper::course_rating_count( 0, 0, 1, $teacher->id ) ) ) . ')';
				$output .= '</div>';

				$output .= '<div class="info-reviews">';
				$output .= '<i class="fa fa-trophy"></i>';
				$output .= get_string('reviewscount', 'local_mb2reviews', array('reviews'=> Mb2reviewsHelper::course_rating_count( 0, 0, 1, $teacher->id, 1 ) ) );
				$output .= '</div>';
			}
		}

		$output .= '<div class="info-courses"><i class="fa fa-book"></i>' . get_string( 'teachercourses', 'theme_mb2nl', array( 'courses' => $coursescount ) ) . '</div>';
		$output .= '<div class="info-students"><i class="fa fa-graduation-cap"></i>' . get_string( 'teacherstudents', 'theme_mb2nl', array( 'students' => $studentscount ) ) . '</div>';

		$output .= '</div>'; // teacher-info
		$output .= '</div>'; // theme-course-teacher-inner
		$output .= '</div>'; // theme-course-teacher

	}

	return $output;


}




/*
 *
 * Method to get shortcode content template
 *
 */
function theme_mb2nl_shortcodes_content_template( $items, $options )
{

	global $CFG;
	$output = '';
	$i = 0;
	$x = 0;
	$col_style = '';
	$carousel = ( isset( $options['carousel'] ) && $options['carousel'] );
	$carouselcls = $carousel ? ' swiper-slide' : '';

	$lazycls = $options['lazy'] ? ' class="lazy"' : '';
	$lazysrc = $options['lazy'] ? 'src="' . theme_mb2nl_lazy_plc() . '" data-src' : 'src';

	foreach ($items as $item)
	{
		$i++;
		$x++;
		$item_cls = $i%2 ? ' item-odd' : ' item-even';

		// Color class
		$c_color = theme_mb2nl_shortcodes_custom_color($item->id, $options);
		$item_cls .= $c_color ? ' color' : '';

		// Show item b
		$showtext = ($options['desclimit'] > 0 || $options['linkbtn'] || $item->price);

		$output .= '<div class="mb2-pb-content-item theme-box item-' . $item->id . $item_cls . $carouselcls .'">';

		$output .= '<div class="mb2-pb-content-item-inner">';
		$output .= '<div class="mb2-pb-content-item-a">';

		//$output .= theme_mb2nl_shortcodes_image_notice($item->description);

		if ( $item->imgurl )
		{
			$output .= '<div class="mb2-pb-content-img">';
			$output .= '<a href="' . $item->link . '" tabindex="-1">';
			$output .= '<img' . $lazycls . ' ' . $lazysrc . '="' . $item->imgurl . '" alt="' . $item->imgname . '" />';
			$output .= '</a>';
			$output .= '</div>';
		}

		$output .= '<div class="mb2-pb-content1">';
		$output .= '<div class="mb2-pb-content2">';
		$output .= '<div class="mb2-pb-content3">';
		$output .= '<div class="mb2-pb-content4">';

		$output .= '<h4 class="mb2-pb-content-title">';
		$output .= '<a href="' . $item->link . '" tabindex="-1">';
		$output .= theme_mb2nl_wordlimit($item->title, $options['titlelimit']);
		$output .= '</a>';
		$output .= '</h4>';
		$output .= $item->details ? '<div class="mb2-pb-content-details">' . $item->details . '</div>' : '';
		$output .= $c_color ? '<span class="color-el" style="background-color:' . $c_color . ';"></span>' : '';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';

		if ( $showtext )
		{
			$output .= '<div class="mb2-pb-content-item-b">';

			if ( $options['desclimit'] > 0 )
			{
				$output .= '<div class="mb2-pb-content-desc">';
				$output .= theme_mb2nl_wordlimit( $item->description, $options['desclimit'] );
				$output .= '</div>';
			}

			if ( $options['linkbtn'] )
			{
				$readmoretext = $options['btntext'] ? $options['btntext'] : get_string('readmore','theme_mb2nl');

				$output .= '<div class="mb2-pb-content-readmore">';
				$output .= '<a class="btn btn-primary" href="' . $item->link . '" tabindex="-1">' . $readmoretext . '</a>';
				$output .= '</div>';
			}

			if ($item->price)
			{
				$output .= '<div class="mb2-pb-content-price">';
				$output .=  $item->price;
				$output .= '</div>';
			}

			$output .= '</div>';
		}

		$output .= '</div>'; // mb2-pb-content-item-inner
		$output .= '<a class="themekeynavlink" href="' . $item->link  . '" tabindex="0" aria-label="' . $item->title . '"></a>';
		// $output .= $options['link'] == 2 ? '</a>' : '';
		$output .= '</div>';

		// if (!$carousel && $x == $options['columns'])
		// {
		// 	$output .= '<div class="mb2-pb-content-sep clearfix"></div>';
		// 	$x = 0;
		// }
	}

	return $output;

}






/*
 *
 * Method to get image notice
 * It's require fro categories images
 *
 */
function theme_mb2nl_shortcodes_image_notice($desc)
{
	
	$urlfromdesc = theme_mb2nl_shortcodes_categories_image_from_text(s($desc),true);
	$namefromdesc = basename($urlfromdesc);

	if (preg_match('@%20@', $namefromdesc))
	{
		return '<span style="color:red;"><strong>' . get_string('imgnoticespace','local_mb2builder', array('img'=>urldecode($namefromdesc))) . '</strong></span>';
	}

	return;

}





/*
 *
 * Method to get category image from category description
 *
 */
function theme_mb2nl_shortcodes_content_get_image($attribs = array(), $name = false, $desc = '', $cid = 0)
{

	global $CFG;
	require_once($CFG->libdir . '/filelib.php');

	$output = '';
	$desc_img = true;


	if (!empty($attribs))
	{
		$files = get_file_storage()->get_area_files($attribs['context'], $attribs['mod'], $attribs['area'], $attribs['itemid']);
	}

	// Get image from course summary files
	if ($cid)
	{
		if (theme_mb2nl_moodle_from(2018120300))
	    {
			$courseObj = new core_course_list_element(get_course($cid));
	    }
	    else
	    {
	        $courseObj = new course_in_list(get_course($cid));
	    }
		$files = $courseObj->get_course_overviewfiles();
	}

	if ($desc)
	{
		$urlfromdesc = theme_mb2nl_shortcodes_categories_image_from_text(s($desc),true);
		$namefromdesc = basename($urlfromdesc);
	}

	foreach ($files as $file)
	{

		if ($desc)
		{
			$desc_img = ($namefromdesc === $file->get_filename());
		}

		$isimage = ($file->is_valid_image() && $desc_img);

		if ($isimage)
		{
			if ($name)
			{
				return $file->get_filename();
			}

			$item_id = NULL;

			if (isset($attribs['itemid']) && $attribs['itemid'])
			{
				$item_id = $file->get_itemid();
			}

			return moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(),
			$item_id, $file->get_filepath(), $file->get_filename());
		}
	}

}




/*
 *
 * Method to get image from text
 *
 */
function theme_mb2nl_shortcodes_categories_image_from_text( $text )
{

	$output = '';

	$matches = array();
	$str = '@@PLUGINFILE@@/';

	$isplug = preg_match('|' . $str . '|', $text);

	if ($isplug)
	{
		preg_match_all('!@@PLUGINFILE@@/[^?#]+\.(?:jpe?g|png|gif)!Ui', $text, $matches);
	}
	else
	{
		preg_match_all('!http://[^?#]+\.(?:jpe?g|png|gif)!Ui', $text, $matches);
	}

	foreach ($matches as $el)
	{
		$output = isset($el[0]) ? $isplug ? str_replace($str, '', $el[0]) : $el[0] : '';
	}

	return $output;

}





/*
 *
 * Method to set content carousel data attributes
 *
 */
function theme_mb2nl_shortcodes_slider_data( $atts )
{

	$output = '';
	$gridatts = isset( $atts['gutter'] ) ? $atts['gutter'] : $atts['gridwidth'];
	$touchmove = isset( $atts['touchmove'] ) ? $atts['touchmove'] : 1;

	if ( $gridatts === 'thin' )
	{
		$gridwidth = 10;
	}
	elseif ( $gridatts === 'none' )
	{
		$gridwidth = 0;
	}
	else
	{
		$gridwidth = 30;
	}

	// This is require for old slider shortcodes
	$ismobcolumns = isset( $atts['mobcolumns'] ) ? $atts['mobcolumns'] : 0;
	$isanimtime = isset( $atts['animtime'] ) ? $atts['animtime'] : $atts['sanimate'];
	$isautoplay = isset( $atts['autoplay'] ) ? $atts['autoplay'] : $atts['sautoplay'];
	$ispausetime = isset( $atts['pausetime'] ) ? $atts['pausetime'] : $atts['spausetime'];

	$output .= ' data-columns="' .  $atts['columns'] . '"';
	$output .= ' data-margin="' . $gridwidth . '"';
	$output .= ' data-gutter="' . $gridatts . '"';
	$output .= ' data-sloop="' . $atts['sloop'] . '"';
	$output .= ' data-snav="' . $atts['snav'] . '"';
	$output .= ' data-sdots="' . $atts['sdots'] . '"';
	$output .= ' data-autoplay="' . $isautoplay . '"';
	$output .= ' data-pausetime="' . $ispausetime . '"';
	$output .= ' data-animtime="' . $isanimtime . '"';
	$output .= ' data-mobcolumns="' . $ismobcolumns . '"';
	$output .= ' data-touchmove="' . $touchmove . '"';

	return $output;

}




/*
 *
 * Method to set custom color for content item
 *
 */
function theme_mb2nl_shortcodes_custom_color ($id, $atts)
{

	$colors = theme_mb2nl_shortcodes_custom_color_arr($atts);

	foreach ($colors as $color)
	{
		if ($color['id'] == $id)
		{
			return $color['color'];
		}
	}

	return false;

}




/*
 *
 * Method to get custo colors from shortcode settings
 *
 */
function theme_mb2nl_shortcodes_custom_color_arr($atts)
{

	$colors = array();
	$defColors = $atts['colors'];
	$colorArr1 = explode(',',str_replace(' ','',$defColors));
	$i=-1;

	foreach ($colorArr1 as $color)
	{
		if ($color)
		{
			$i++;
			$colorEl = explode(':',$color);
			$colors[$i]['id']= $colorEl[0];
			$colors[$i]['color'] = $colorEl[1];
		}
	}

	return $colors;

}




/*
 *
 * Method to get global options from shortcodes filter plugin
 *
 */
function theme_mb2nl_shortcodes_global_opts($shortcode, $option, $default)
{
	global $CFG;

	$plugin_file = $CFG->dirroot . '/filter/mb2shortcodes/filter.php';
	$i = 0;

	if (!file_exists($plugin_file))
	{
		return $default;
	}

	$opts = get_config('filter_mb2shortcodes', 'globalopts');

	if (!$opts)
	{
		return $default;
	}

	// Explode new line
	$line_arr = preg_split('/\s*\R\s*/', trim($opts));

	foreach ($line_arr as $line)
	{
		$i++;
		$line_arr = explode(':', $line);

		if ($shortcode === trim($line_arr[0]) && $option === trim($line_arr[1]))
		{
			return trim($line_arr[2]);
		}
	}

}



/*
 *
 * Method to get global options from shortcodes filter plugin
 *
 */
function theme_mb2nl_get_id_from_class( $cls )
{
	$ids = array();

	if ( $cls === '' )
	{
		return;
	}

	$cls = explode( ' ', $cls );

	foreach ( $cls as $c )
	{
		if ( preg_match( '@id-@', $c ) )
		{
			$ids[] = str_replace( 'id-', '', $c);
		}
	}

	$ids = implode( ' ', $ids );

	return $ids;

}







/*
 *
 * Method to get video embed url
 *
 */
function theme_mb2nl_get_video_url( $url, $lightbox = false )
{

	if ( ! $url )
	{
		return false;
	}

	$videoid = theme_mb2nl_get_video_id( $url );
	$urlaparat = '//aparat.com/video/video/embed/videohash/' . $videoid . '/vt/frame';
	$urlvimeo = '//player.vimeo.com/video/' . $videoid;
	$urlyoutube = '//youtube.com/embed/' . $videoid;

	// Support old shortcode feature
	// this means that user insert video ID instead of video url
	if ( ! filter_var( $url, FILTER_VALIDATE_URL ) && ! $lightbox )
	{
		if( preg_match( '/^[0-9]+$/', $url ) )
		{
			return $urlvimeo;
		}
		else
		{
			return $urlyoutube;
		}
	}

	if ( $lightbox )
	{
		$pref_aparat = '//aparat.com/video/video/embed/videohash/';
		$pref_youtube = 'https://www.youtube.com/watch?v=';
		$pref_vimeo = 'https://vimeo.com/';
	}
	else
	{
		$pref_aparat = '//aparat.com/video/video/embed/videohash/';
		$pref_youtube = '//youtube.com/embed/';
		$pref_vimeo = '//player.vimeo.com/video/';
	}

	// User use video url
	if ( preg_match( '@aparat.com@', $url ) )
	{
		return $pref_aparat . $videoid . '/vt/frame';
	}
	elseif ( preg_match( '@vimeo.com@', $url ) )
	{
		return $pref_vimeo . $videoid;
	}
	elseif ( preg_match( '@youtube.com@', $url ) || preg_match( '@youtu.be@', $url ) )
	{
		return $pref_youtube . $videoid;
	}

	return null;

}







/*
 *
 * Method to get video id from video url
 *
 */
function theme_mb2nl_get_video_id( $url, $list = false )
{

    $parts = parse_url($url);

	if ( isset( $parts['query'] ) )
	{
	    parse_str($parts['query'], $qs);

		if ( $list && isset( $qs['list'] ) )
		{
			return $qs['list'];
		}

	    if ( isset( $qs['v'] ) )
		{
			return $qs['v'];
        }
		elseif ( isset( $qs['vi'] ) )
		{
            return $qs['vi'];
        }
    }

	if ( ! $list && isset( $parts['path'] ) )
	{
		$path = explode('/', trim( $parts['path'], '/') );
        return $path[count($path)-1];
    }

    return false;

}



/*
 *
 * Method to set heading size class
 *
 */
function theme_mb2nl_heading_cls( $size = 1.4, $pref = 'hsize-', $rem = true )
{
	$i = 0;
	$sizes = array(1,2,3,4,5);
	$output = '';

	if ( ! $rem )
	{
		$sizes = array(0,50,100,150,200,250);
	}

	foreach( $sizes as $s )
	{
		$is = ! $rem ? ($size >= $sizes[$i]) : ($size > $sizes[$i]);

		if ( $is )
		{
			$output = $pref . $sizes[$i];
		}

		$i++;
	}

	return $output;

}






/*
 *
 * Method to get categories list
 *
 */
function theme_mb2nl_shortcodes_categories_get_items($options, $builder = false)
{

	global $CFG, $USER, $DB, $OUTPUT;

	require_once($CFG->dirroot . '/course/lib.php');

	if ( ! theme_mb2nl_moodle_from( 2018120300 ) )
    {
        require_once($CFG->libdir. '/coursecatlib.php');
    }

	$categories = array();

	$catids = str_replace(' ', '', $options['catids']);
	$exCats = $options['excats'] === 'exclude' ? ' NOT' : '';

	$query = 'SELECT * FROM ' . $CFG->prefix . 'course_categories';
	$query .= ($options['excats'] && $catids > 0) ? ' WHERE id' . $exCats . ' IN (' . $catids . ')' : '';
	$query .= ' ORDER BY sortorder';

	$categories = $DB->get_records_sql($query);
	$itemCount = count($categories);

	if ( ! $itemCount )
	{
		return array();
	}

	foreach ( $categories as $category )
	{

		$context = context_coursecat::instance($category->id);
		$coursecat_canmanage = has_capability('moodle/category:manage', $context);

		if ( ( ! isset($category->visible ) || ! $category->visible ) && ! $coursecat_canmanage )
		{
			unset( $categories[$category->id] );
		}

		// Get category image
		$imgUrlAtt = theme_mb2nl_category_image($category->id);
		$imgNameAtt = theme_mb2nl_category_image($category->id, true);

		$moodle33 = 2017051500;
		$placeholder_image = $CFG->version >= $moodle33 ? $OUTPUT->image_url('course-default','theme') : $OUTPUT->pix_url('course-default','theme');
		$category->imgurl = $imgUrlAtt ? $imgUrlAtt : $placeholder_image;
		$category->imgname = $imgNameAtt;

		// Define item elements
		$category->link = $builder ? '#' : new moodle_url($CFG->wwwroot . '/course/index.php', array('categoryid'=>$category->id));
		$category->link_edit = $builder ? '#' : new moodle_url($CFG->wwwroot . '/course/editcategory.php', array('id'=>$category->id));
		$category->edit_text = get_string('editcategorythis', 'core');

		$category->title = $category->name;
		$category->description = file_rewrite_pluginfile_urls($category->description, 'pluginfile.php', $context->id, 'coursecat', 'description', NULL);
		$category->description = format_text( $category->description );

		if ( isset( $category->visible ) && ! $category->visible )
		{
			$category->title .= ' (' . get_string('hidden','theme_mb2nl') . ')';
		}

		// Get course count in a category
		$coursesList = array();

		if ( $category->id && $category->visible )
		{
			if ( theme_mb2nl_moodle_from( 2018120300 ) )
			{
				$coursesList = core_course_category::get($category->id)->get_courses(array('recursive' => false));
			}
			else
			{
				$coursesList = coursecat::get($category->id)->get_courses(array('recursive' => false));
			}
		}

		$courseCount = theme_mb2nl_get_category_courses_count( $category->id, true ); //count($coursesList);
		$courseString = $courseCount > 1 ? get_string('courses') : get_string('course');
		$category->details = $courseCount > 0 ? $courseCount . ' ' . $courseString : get_string('nocourseincategory', 'theme_mb2nl');
		if ( ! $options['details'] )
		{
			$category->details = '';
		}
		$category->redmoretext = '';
		$category->price = '';

	}

	// Slice categories array by categories limit
	$categories = array_slice( $categories, 0, $options['limit'] );

	return $categories;

}




/*
 *
 * Method to get swiper carousel nvigation
 *
 */
function theme_mb2nl_shortcodes_swiper_nav()
{
	$output = '';
	$output .= '<div class="theme-carousel-nav">';
	$output .= '<button type="button" class="swiper-button-nav swiper-button-prev themereset"></button>';
	$output .= '<button type="button" class="swiper-button-nav swiper-button-next themereset"></button>';
	$output .= '</div>';
	return $output;

}




/*
 *
 * Method to get swiper carousel pagination
 *
 */
function theme_mb2nl_shortcodes_swiper_pagenavnav()
{
	$output = '';
	$output .= '<div class="theme-carousel-pagenavnav">';
	$output .= '<div class="swiper-pagination"></div>';
	$output .= '</div>';
	return $output;

}







/*
 *
 * Method to get content for typed animation
 *
 */
function theme_mb2nl_typed_content( $text, $typedtext )
{

	$textarr = explode(' ', $text);

	foreach ( $textarr as $k=>$t )
	{
		if ( $t === 'type' )
		{
			$textarr[$k] = '<span class="typed" aria-hidden="true"></span><span class="sr-only">' . str_replace( '|', ', ', $typedtext ) . '</span>';
		}
	}

	if ( ! preg_match('@type@', $text ) )
	{
		$textarr[] = '<span class="typed" aria-hidden="true"></span><span class="sr-only">' . str_replace( '|', ', ', $typedtext ) . '</span>';
	}

	return implode(' ', $textarr);

}




/*
 *
 * Method to get shortcode from content
 *
 */
function theme_mb2nl_get_shortcode_atts($content, $shortcode)
{

	$regex = '\\[(\\[?)(' . $shortcode . ')\\b([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
	preg_match_all( "/$regex/is", $content, $match );

	return $match[0];
}
