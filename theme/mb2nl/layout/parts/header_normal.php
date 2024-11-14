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

$stickynav = theme_mb2nl_is_stycky();
$socialheader = theme_mb2nl_theme_setting( $PAGE, 'socialheader' );
$socialtt = theme_mb2nl_theme_setting($PAGE, 'socialtt') == 1 ? 'top' : '';
$isPageBg = theme_mb2nl_pagebg_image($PAGE);
$headernav = theme_mb2nl_theme_setting( $PAGE, 'headernav' );
$headercontent = theme_mb2nl_theme_setting($PAGE, 'headercontent') && theme_mb2nl_static_content( theme_mb2nl_theme_setting($PAGE, 'headercontent'), false );
$modaltools = theme_mb2nl_is_header_tools_modal();
$headerlistopt = array( 'listcls' => 'main-header-list' );
$enrolment_page = theme_mb2nl_is_custom_enrolment_page();



?>
<body <?php echo $OUTPUT->body_attributes( theme_mb2nl_body_cls() ) . $isPageBg; ?>>
<?php echo $OUTPUT->standard_top_of_body_html(); ?>
<?php echo theme_mb2nl_acsb_block(); ?>
<?php if ( theme_mb2nl_theme_setting( $PAGE,'loadingscr' ) ) : ?>
	<?php echo theme_mb2nl_loading_screen(); ?>
<?php endif; ?>
<?php echo $OUTPUT->theme_part( 'sliding_panel' ); ?>
<div id="page-outer">
<div id="page">
<div id="page-a">
    <div id="main-header">
		<?php echo theme_mb2nl_notice('top'); ?>
		<?php if ( theme_mb2nl_header_content_pos() == 2 ) : ?>
			<div class="top-bar">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="flexcols">
								<?php if ( $headercontent ) : ?>
									<div class="header-content"><?php echo theme_mb2nl_static_content( theme_mb2nl_theme_setting($PAGE, 'headercontent'), true, true, $headerlistopt ); ?></div>
								<?php endif; ?>
								<?php if ( $socialheader ) : ?>
									<div><?php echo theme_mb2nl_social_icons( $PAGE, array( 'tt'=> $socialtt, 'pos' => 'topbar') ); ?></div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<div class="header-innner">
		<div class="header-inner2">
			<?php if ( $stickynav == 3 ) : ?>
				<div class="sticky-replace-el"></div>
			<?php endif; ?>
			<div id="master-header">
			<div class="master-header-inner">
	        	<div class="container-fluid">
	            	<div class="row">
	                	<div class="col-md-12">
						<div class="flexcols">
		                    <?php echo $OUTPUT->theme_part('logo'); ?>
							<?php echo theme_mb2nl_site_menu(); ?>							
							<?php if ( $headernav ) : ?>
								<?php echo $OUTPUT->theme_part('mobile_button'); ?>
						        <?php echo theme_mb2nl_main_menu(); ?>
						    <?php endif; ?>
							<?php if ( theme_mb2nl_header_tools_pos() == 1 ) : ?>
								<?php echo theme_mb2nl_header_buttons(1); ?>
							<?php endif; ?>
							<?php if ( theme_mb2nl_header_content_pos() == 1) : ?>
								<?php if ( $headercontent ) : ?>
									<div class="header-content"><?php echo theme_mb2nl_static_content( theme_mb2nl_theme_setting($PAGE, 'headercontent'), true, true, $headerlistopt ); ?></div>
								<?php endif; ?>
								<?php if ( $socialheader || theme_mb2nl_header_tools_pos() == 1 ) : ?>
									<div class="header-tools-wrap">
										<?php if ( theme_mb2nl_header_tools_pos() == 1 ) : ?>
											<?php echo theme_mb2nl_header_tools($modaltools, 'tools-pos1'); ?>
										<?php endif; ?>
										<?php if ( $socialheader ) : ?>
											<?php echo theme_mb2nl_social_icons( $PAGE, array( 'tt'=> $socialtt, 'pos' => 'header') ); ?>
										<?php endif; ?>
									</div>
								<?php endif; ?>								
							<?php endif; ?>
							<?php if ( theme_mb2nl_header_tools_pos() == 2 ) : ?>
								<?php echo theme_mb2nl_header_tools( $modaltools, 'tools-pos2' ); ?>
								<?php echo theme_mb2nl_header_buttons(); ?>
							<?php endif; ?>
							<?php if ( ! $headernav ) : ?>
								<?php echo $OUTPUT->theme_part('mobile_button'); ?>
							<?php endif; ?>
						</div>
	                </div>
	            </div>
			</div>
	        </div>
			</div>			
			<?php if ( $stickynav == 1 ) : ?>
				<div class="sticky-replace-el"></div>
			<?php endif; ?>
		    <?php if (! $headernav ) : ?>
		        <?php /*<div id="main-navigation" class="navigation-bar"<?php echo theme_mb2nl_main_menu_style(); ?>>
		            <div class="main-navigation-inner">
		                <div class="container-fluid">
		                    <div class="row">
		                        <div class="col-md-12">
		                            <?php echo theme_mb2nl_main_menu(); ?>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div> */ ?>
				<?php echo theme_mb2nl_main_menu(0, 2); ?>

		    <?php endif; ?>
		</div><!-- //end .header-inner2 -->
	</div><!-- //end .header-innner -->
	</div><!-- //end #main-header -->
<?php echo ! $enrolment_page ? $OUTPUT->theme_part('page_header') : ''; ?>
</div><!-- //end #page-a -->
<div id="page-b" class="page-b">