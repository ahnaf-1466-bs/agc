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


$customLoginPage = theme_mb2nl_is_login(true);
$pageBgImg = $customLoginPage ? theme_mb2nl_theme_setting($PAGE, 'loginbgimage', '', true) : theme_mb2nl_theme_setting($PAGE, 'pbgimage', '', true);
$isPageBg = $pageBgImg !='' ? ' style="background-image:url(\'' . $pageBgImg . '\');"' : '';


echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
    <?php echo theme_mb2nl_google_fonts($PAGE); ?>
    <?php theme_mb2nl_scripts(); ?>
	<?php echo $OUTPUT->standard_head_html() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body <?php echo $OUTPUT->body_attributes(theme_mb2nl_body_cls()) . $isPageBg; ?>>
<div id="page-outer">
<div id="page">
    <div id="page-b">
        <?php echo $OUTPUT->standard_top_of_body_html() ?>
        <div id="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div id="page-content">
							<?php echo $OUTPUT->main_content(); ?>
                		</div>
                    </div>
                </div>
            </div>
        </div>
        <footer id="footer" class="dark1">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $OUTPUT->standard_footer_html(); ?>
                    </div>
                </div>
            </div>
        </footer>
    </div><!-- end #age-b -->
</div><!-- end #page -->
</div><!-- //end #page-outer -->
<?php if (theme_mb2nl_theme_setting($PAGE, 'scrolltt',0) == 1) :?>
	<?php echo theme_mb2nl_scrolltt($PAGE); ?>
<?php endif; ?>
<?php if (theme_mb2nl_theme_setting($PAGE, 'loadingscr',0) == 1) : ?>
	<?php echo theme_mb2nl_loading_screen($PAGE); ?>
<?php endif; ?>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
<script type="text/javascript">
require(['theme_boost/loader']);
<?php if ( $CFG->version >= 2020061500 && $CFG->version < 2021051700 ) : // Moodle 3.9 - 3.10 ?>
    require(['jquery','theme_boost/bootstrap/index'], function($){$('[data-toggle="tooltip"]').tooltip();$('[data-toggle="popover"]').popover()});
<?php elseif ( $CFG->version < 2020061500 ) : // Moodle 3.6 - 3.8 ?>
    require(['jquery','theme_boost/tooltip'], function($){$('[data-toggle="tooltip"]').tooltip()});
<?php endif; ?>
</script>
</body>
</html>
