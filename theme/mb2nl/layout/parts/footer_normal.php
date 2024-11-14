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

$footerid = theme_mb2nl_footerid();
$socilaTt = theme_mb2nl_theme_setting($PAGE, 'socialtt' ) == 1 ? 'top' : '';
$footThemeContent =  theme_mb2nl_theme_setting($PAGE, 'foottext');
$footContent = format_text($footThemeContent, FORMAT_HTML);
$isdark = theme_mb2nl_theme_setting( $PAGE, 'footerstyle' ) === 'dark' && ! $footerid ? ' dark1' : '';
$partnerlogos = theme_mb2nl_get_footer_images();
$parnerlinks = theme_mb2nl_line_content( theme_mb2nl_theme_setting( $PAGE, 'partnerslinks' ) );
$quickview = theme_mb2nl_theme_setting( $PAGE, 'quickview' );
$customlogin = theme_mb2nl_is_login( true );
$footercss = $footerid ? 'custom-footer' : 'theme-footer';
$footercss .= $isdark;
?>
</div><!-- //end #page-b -->
<div id="page-c">
<?php if ( count( $partnerlogos ) && ! $customlogin ) : ?>
<div class="partners">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="partner-images">
					<?php foreach ( $partnerlogos as $k=>$logo ) :
						$isk = $k+1;
						$alttext = isset( $parnerlinks[$isk]['text'] ) ? $parnerlinks[$isk]['text'] : '';
						$link = isset( $parnerlinks[$isk]['url'] ) ? $parnerlinks[$isk]['url'] : '';
						$target = ( isset( $parnerlinks[$isk]['url_target'] ) && $parnerlinks[$isk]['url_target'] ) ? ' target="_blank"' : '';
						?>
						<?php if ( $link) : ?><a href="<?php echo $link; ?>"<?php echo $target; ?>><?php endif; ?>
						<img src="<?php echo $logo; ?>" alt="<?php echo $alttext; ?>">
						<?php if ( $link) : ?></a><?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
<footer id="footer" class="<?php echo $footercss; ?>">
<?php if ( $footerid ) : ?>
	<?php echo format_text('[mb2footer footerid="' . $footerid . '"]', FORMAT_HTML); ?>
<?php else : ?>
	<div class="container-fluid">
    	<div class="row">
        	<div class="col-md-12">
            	<div class="footer-content flexcols">
					<div class="footer-text">
						<p><?php echo $footContent; ?></p>
						<?php if ( theme_mb2nl_theme_setting( $PAGE,'langpos' ) == 2 ) : ?>
							<?php echo theme_mb2nl_language_list(true); ?>
						<?php endif; ?>
					</div>
                	<?php if (theme_mb2nl_theme_setting( $PAGE, 'socialfooter' ) == 1) : ?>
						<div class="footer-social">
							<?php echo theme_mb2nl_social_icons($PAGE, array('tt'=>$socilaTt,'pos'=>'footer')); ?>
						</div>
               	 	<?php endif; ?>
                </div>
				<?php echo $OUTPUT->theme_part( 'footer_tools' ); ?>
     		</div>
        </div>
    </div>
<?php endif; ?>
</footer>
</div><!-- //end #page-c -->
</div><!-- //end #page -->
</div><!-- //end #page-outer -->
<?php echo theme_mb2nl_iconnav(); ?>
<?php if ( theme_mb2nl_panel_link( 'fixedbar' ) || theme_mb2nl_show_hide_sidebars( $PAGE, $vars ) ) : ?>
<div class="fixed-bar">
	<?php echo theme_mb2nl_panel_link( 'fixedbar' ); ?>
	<?php echo theme_mb2nl_show_hide_sidebars( $PAGE, $vars ); ?>
</div>
<?php endif; ?>
<?php if (theme_mb2nl_theme_setting($PAGE, 'scrolltt',0) == 1) :?>
	<?php echo theme_mb2nl_scrolltt($PAGE); ?>
<?php endif; ?>
<a href="#page" class="sr-only sr-only-focusable"><?php echo get_string('scrolltt', 'theme_mb2nl'); ?></a>
<?php echo $OUTPUT->theme_part('course_panel'); ?>
<?php if (theme_mb2nl_theme_setting($PAGE, 'bookmarks') && isloggedin() && !isguestuser()) : ?>
	<?php echo theme_mb2nl_user_bookmarks_modal(); ?>
<?php endif; ?>
<?php if ( theme_mb2nl_is_header_tools_modal() ) : ?>
	<?php echo theme_mb2nl_modal_tmpl( 'login' ); ?>
	<?php echo theme_mb2nl_modal_tmpl( 'search' ); ?>
	<?php echo theme_mb2nl_modal_tmpl( 'settings' ); ?>
<?php endif; ?>
<?php if ( $quickview ) : ?>
	<?php
		$inline_js = 'require([\'theme_mb2nl/quickview\'], function(QuickView) {';
		$inline_js .= 'new QuickView();';
		$inline_js .= '});';
		$PAGE->requires->js_amd_inline( $inline_js );
	?>
<?php endif; ?>
<?php echo $OUTPUT->standard_end_of_body_html(); ?>
</body>
</html>
