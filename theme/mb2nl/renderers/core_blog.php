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
 * Renderers for outputting blog data
 *
 * @package    core_blog
 * @subpackage blog
 * @copyright  2012 David Monllaó
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Blog renderer
 */
class theme_mb2nl_core_blog_renderer extends plugin_renderer_base {

    /**
     * Renders a blog entry
     *
     * @param blog_entry $entry
     * @return string The table HTML
     */
    public function render_blog_entry(blog_entry $entry) {

        global $CFG, $PAGE, $OUTPUT;
        $GLOBALS['mb2blogpost']++;

        $o = '';
        $blogpage  = optional_param('blogpage', 0, PARAM_INT);
        $itemsperpage = theme_mb2nl_blog_itemsperpage();
        $syscontext = context_system::instance();
        $single = theme_mb2nl_is_blogsingle();
        $loadmore = theme_mb2nl_theme_setting( $PAGE, 'blogmore');
        $bloglayout = theme_mb2nl_theme_setting( $PAGE, 'bloglayout');
        $grid = $bloglayout === 'col2' || $bloglayout === 'col3';
        $introtext = theme_mb2nl_hrintro($entry->summary, true);
        $iscontent = ! $single && $introtext && theme_mb2nl_theme_setting( $PAGE, 'blogpageintro');
        $entryurl = new moodle_url('/blog/index.php', array('entryid' => $entry->id));
        $singletext = theme_mb2nl_hrfulltext($entry->summary, false);
        $gridcls = ! $single ? ' blog-' . $bloglayout : '';

        $stredit = get_string('edit');
        $strdelete = get_string('delete');
        //$featuredmedia = theme_mb2nl_post_attachements($entry->id)[0];

        // Header.
        $mainclass = 'post blog-post post-' . $entry->id;
        $mainclass .= theme_mb2nl_is_videopost($entry) ? ' post-video' : '';
        $mainclass .= ! theme_mb2nl_is_videopost($entry) && theme_mb2nl_is_image(theme_mb2nl_post_attachements($entry->id)[0]) ? ' post-image' : '';

        if ($entry->renderable->unassociatedentry)
        {
            $mainclass .= ' draft';
        }
        else
        {
            $mainclass .= ' ' . $entry->publishstate;
        }

        $o .= ! $single && $GLOBALS['mb2blogpost'] == 1 ? '<!-- START BLOG CONTAINER --><div class="theme-blog-container'. $gridcls .'">' : ''; // Start blog posts container

        $o .= $this->output->container_start($mainclass, 'b' . $entry->id);

        if ( $entry->renderable->usercanedit )
        {
            $o .= $this->output->container_start('commands');

            // External blog entries should not be edited.
            if (empty($entry->uniquehash))
            {
                $o .= html_writer::link(new moodle_url('/blog/edit.php', array('action' => 'edit', 'entryid' => $entry->id)), $stredit) . ' | ';
            }
            $o .= html_writer::link(new moodle_url('/blog/edit.php', array('action' => 'delete', 'entryid' => $entry->id)), $strdelete);

            $o .= $this->output->container_end(); // commands
        }

        
        // ==================== POST TITLE
        
        $o .= $single ? $this->render_blog_entry_header($entry) : '';

        $o .= $single ? '<div class="post-intro">' . format_text($introtext, $entry->summaryformat, array()) . '</div>' : '';

        $mediaonsingle = $single && theme_mb2nl_theme_setting( $PAGE, 'blogfeaturedmedia');

        if ( ! $single || $mediaonsingle || $entry->renderable->attachments )
        {
            
            $o .= $this->output->container_start('post-media');

            if ( ! $single || $mediaonsingle )
            {

                $blogplaceholder = theme_mb2nl_theme_setting( $PAGE, 'blogplaceholder', '', true );
                $postimgurl = $blogplaceholder ? $blogplaceholder : $OUTPUT->image_url( 'blog-default', 'theme' );
                $featuredmedia = theme_mb2nl_blog_featuredmedia($entry,false, true);

                $o .= $this->output->container_start('post-featured-media');

                if ( $featuredmedia )
                {
                    $o .= $featuredmedia;
                }
                else 
                {
                    $o .= ! $single ? '<a href="' . $entryurl . '" class="postlink">' : '';
                    $o .= '<img class="lazy" src="' . theme_mb2nl_lazy_plc() . '" data-src="' . $postimgurl . '" alt="' . $entry->subject . '">';
                    $o .= ! $single ? '</a>' : '';
                }

                $o .= $this->output->container_end(); // post-featured-media
            }
            else
            {
                $attachmentsoutputs = array();
                if ($entry->renderable->attachments) {
                    foreach ($entry->renderable->attachments as $attachment) {
                        $o .= $this->render($attachment, false);
                    }
                }
            }

            $o .= $this->output->container_end(); // post-media
        }   
        
        
        $o .= $single ? $this->render_blog_entry_meta($entry) : '';


        
        

        // ==================== POST TITLE
        
        $o .= ! $single ? $this->render_blog_entry_header($entry) : '';

        

        // Post content.
        $o .= $this->output->container_start('post-content');

        // Entry text
        if ( $iscontent )
        {            
            $o .= $this->output->container_start('post-text');
            $o .= format_text($introtext, $entry->summaryformat, array());
            $o .= $this->output->container_end(); // post-text
        }
        elseif ( $single )
        {
            $o .= $this->output->container_start('post-text');
            $o .= format_text($singletext, $entry->summaryformat, array());

            // Add associations.
            if (!empty($CFG->useblogassociations) && !empty($entry->renderable->blogassociations)) {

                // First find and show the associated course.
                $assocstr = '';
                $coursesarray = array();
                foreach ($entry->renderable->blogassociations as $assocrec) {
                    if ($assocrec->contextlevel == CONTEXT_COURSE) {
                        $coursesarray[] = $this->output->action_icon($assocrec->url, $assocrec->icon, null, array(), true);
                    }
                }
                if (!empty($coursesarray)) {
                    $assocstr .= get_string('associated', 'blog', get_string('course')) . ': ' . implode(', ', $coursesarray);
                }

                // Now show mod association.
                $modulesarray = array();
                foreach ($entry->renderable->blogassociations as $assocrec) {
                    if ($assocrec->contextlevel == CONTEXT_MODULE) {
                        $str = get_string('associated', 'blog', $assocrec->type) . ': ';
                        $str .= $this->output->action_icon($assocrec->url, $assocrec->icon, null, array(), true);
                        $modulesarray[] = $str;
                    }
                }
                if (!empty($modulesarray)) {
                    if (!empty($coursesarray)) {
                        $assocstr .= '<br/>';
                    }
                    $assocstr .= implode('<br/>', $modulesarray);
                }

                // Adding the asociations to the output.
                $o .= $this->output->container($assocstr, 'tags');
            }

            if ($entry->renderable->unassociatedentry) {
                $o .= $this->output->container(get_string('associationunviewable', 'blog'), 'noticebox');
            }

            if ( $single && ! empty($entry->uniquehash) ) {
                // Uniquehash is used as a link to an external blog.
                $url = clean_param($entry->uniquehash, PARAM_URL);
                if (!empty($url)) {
                    $o .= $this->output->container_start('externalblog');
                    $o .= html_writer::link($url, get_string('linktooriginalentry', 'blog'));
                    $o .= $this->output->container_end(); // externalblog
                }
            }

            $o .= $this->output->container_end(); // post-text
        } 
        
        $taglist = $this->output->tag_list(core_tag_tag::get_item_tags('core', 'post', $entry->id));
        $taglistcls = $taglist ? ' istags' : ' notags';

        $o .= $single ? $this->output->container_start('post-content-bottom' . $taglistcls) : '';

        // ================= LIST OF TAGS
        $o .= $single ? $taglist : '';

        // ================= LAST MODIFICATION DATE
        if ( $single && $entry->created != $entry->lastmodified && theme_mb2nl_theme_setting( $PAGE, 'blogmodify' ) )
        {
            //$o .= $this->output->container(get_string('modified') . ': '. userdate($entry->lastmodified), 'modify');
            $o .= $this->output->container(get_string('modified') . ': ' . date(theme_mb2nl_theme_setting( $PAGE, 'blogsingledateformat'), $entry->lastmodified ), 'modify');
        }  

        $o .= $single ? $this->output->container_end() : ''; // post-content-bottom

        $o .= $this->output->container_start('post-footer');

        

        

        


        // ================= READMORE LINK
        if ( $iscontent )
        {
            $o .= $this->output->container_start('readmore');
            $o .= html_writer::link($entryurl, get_string('continuereading', 'theme_mb2nl'), array('class'=>'mb2-pb-btn typelink fwbold'));
            $o .= $this->output->container_end(); // readmore
        }


         
        
        
        // ================= SHARE ICONS
        $o .= $single && theme_mb2nl_theme_setting( $PAGE,'blogshareicons') ?
        theme_mb2nl_course_share_list($entry->id, format_string($entry->subject), true ) : '';

        
        
        
        
        

        // ================= COMMENTS
        if ( $single && ! empty( $entry->renderable->comment ) && ( theme_mb2nl_post_comment_count($entry->id) || ( isloggedin() && ! isguestuser() ) ) )
        {
            $o .= $entry->renderable->comment->output(true);
        }

        $o .= $this->output->container_end(); // post-footer
        $o .= $this->output->container_end(); // post-content

        $o .= $this->output->container_end();

        if ( ! $single && $GLOBALS['mb2blogpost'] == $itemsperpage  )
        {
            $o .= '</div><!-- //END BLOG CONTAINER -->';
            
            if ( $loadmore && $blogpage == 0 && theme_mb2nl_blog_pagesnum() > 1 )
            {
                $o .= '<div class="theme-blog-load-posts">';
                $o .= '<button data-url="' . $PAGE->url . '" type="button" data-page="1" data-pages="' . theme_mb2nl_blog_pagesnum() . '" class="blog-more-post mb2-pb-btn typeinverse sizelg" data-strload="' . get_string('loadmore', 'theme_mb2nl') . '" data-strloading="' . get_string('loading', 'theme_mb2nl') . '" aria-hidden="true">';
                $o .= get_string('loadmore', 'theme_mb2nl');
                $o .= '</button>';
                $o .= '</div>';
            }

        }       

        return $o;
    }

    /**
     * Renders an entry attachment
     *
     * Print link for non-images and returns images as HTML
     *
     * @param blog_entry_attachment $attachment
     * @return string List of attachments depending on the $return input
     */
    public function render_blog_entry_attachment(blog_entry_attachment $attachment) {

        $syscontext = context_system::instance();

        // Image attachments don't get printed as links.
        if (file_mimetype_in_typegroup($attachment->file->get_mimetype(), 'web_image')) {
            $attrs = array('src' => $attachment->url, 'alt' => '');
            $o = html_writer::empty_tag('img', $attrs);
            $class = 'attachedimages';
        } else {
            $image = $this->output->pix_icon(file_file_icon($attachment->file),
                                             $attachment->filename,
                                             'moodle',
                                             array('class' => 'icon'));
            $o = html_writer::link($attachment->url, $image);
            $o .= format_text(html_writer::link($attachment->url, $attachment->filename),
                              FORMAT_HTML,
                              array('context' => $syscontext));
            $class = 'attachments';
        }

        return $this->output->container($o, $class);
    }




    public function render_blog_entry_header( $entry) {

        global $PAGE;

        $o ='';
        $single = theme_mb2nl_is_blogsingle();
        $syscontext = context_system::instance();

        $o .= $this->output->container_start('post-header');

        if ( $entry->renderable->usercanedit )
        {
            // Determine text for publish state.
            switch ($entry->publishstate) {
                case 'draft':
                    $blogtype = get_string('publishtonoone', 'blog');
                    break;
                case 'site':
                    $blogtype = get_string('publishtosite', 'blog');
                    break;
                case 'public':
                    $blogtype = get_string('publishtoworld', 'blog');
                    break;
                default:
                    $blogtype = '';
                    break;
            }

            $o .= $this->output->container($blogtype, 'audience sr-only');
        }

        $o .= ! $single ? $this->render_blog_entry_meta($entry) : '';

        if ( $single )
        {
            $o .= html_writer::tag('div', format_string($entry->subject), array('class' => 'subject h2'));
        }
        else
        {
            $titlelink = html_writer::link(new moodle_url('/blog/index.php', array('entryid' => $entry->id)), format_string($entry->subject));
            $o .= html_writer::tag('h3', $titlelink, array('class' => 'subject'));
        }   

        
        
        $o .= $this->output->container_end(); // post-header

        return $o;

    }



    public function render_blog_entry_meta( $entry) {

        global $PAGE, $OUTPUT;
        $o = '';
        $syscontext = context_system::instance();
        $single = theme_mb2nl_is_blogsingle();

        $o .= $this->output->container_start('post-meta');

        if ( $single )
        {
            $o .= $this->output->container_start('post-author');
            $o .= $this->output->container_start('author-image');
            $o .= $OUTPUT->user_picture( $entry->renderable->user, array( 'size' => 100, 'link' => 0 ) );
            $o .= $this->output->container_end(); // author-image
           // $o .= $this->output->container_start('author-desc');
            $o .= $this->output->container_start('author-name');
            $o .= $entry->renderable->user->firstname . ' ' . $entry->renderable->user->lastname;
            $o .= $this->output->container_end(); // author-name
          //  $o .= theme_mb2nl_get_user_description( $entry->renderable->user->description, $entry->renderable->user->id );            
           // $o .= $this->output->container_end(); // author-desc
            $o .= $this->output->container_end(); // post-author
            $o .= $this->output->container_start('post-date');
            $o .= date(theme_mb2nl_theme_setting( $PAGE, 'blogsingledateformat'), $entry->created ); 
            $o .= $this->output->container_end(); // post-author
        }
        else 
        {
            $o .= $this->output->container_start('post-date');
            $o .= date(theme_mb2nl_theme_setting( $PAGE, 'blogdateformat'), $entry->created ); 
            $o .= $this->output->container_end(); // post-date
        }       
         
        // Adding external blog link.
        if ( $single && ! empty( $entry->renderable->externalblogtext ) )
        {
            $o .= $this->output->container($entry->renderable->externalblogtext, 'externalblog');
        }

        $o .= $this->output->container_end(); // post-meta

        return $o;



        /*
        
        // ================= AUTHOR
        if ( $single )
        {
            $o .= $this->output->container_start('post-author');
            $o .= $this->output->container_start('author-image');
            $o .= $OUTPUT->user_picture( $entry->renderable->user, array( 'size' => 100, 'link' => 0 ) );
            $o .= $this->output->container_end(); // author-image
            $o .= $this->output->container_start('author-desc');
            $o .= $this->output->container_start('author-name');
            $o .= $entry->renderable->user->firstname . ' ' . $entry->renderable->user->lastname;
            $o .= $this->output->container_end(); // author-name
            $o .= theme_mb2nl_get_user_description( $entry->renderable->user->description, $entry->renderable->user->id );            
            $o .= $this->output->container_end(); // author-desc
            $o .= $this->output->container_end(); // post-author
        }
        
        */

    }
}
