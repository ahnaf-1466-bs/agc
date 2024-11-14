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


$regionArr = explode(',', theme_mb2nl_theme_setting($PAGE,'regionnogrid'));
$regionGrid = !in_array('before-content', $regionArr);


// Style class
$cls = theme_mb2nl_theme_setting($PAGE,'bcscheme','light');
$cls .= theme_mb2nl_theme_setting($PAGE,'bcbgpre') !='' ? ' pre-bg' . theme_mb2nl_theme_setting($PAGE,'bcbgpre') : '';


// Padding top and bottom
$paddingArr = explode(',', theme_mb2nl_theme_setting($PAGE,'bcpadding','40,10'));


// Background image
$bgImage = theme_mb2nl_theme_setting($PAGE, 'bcbgimage', '', true);
$isBgImage = $bgImage !='' ? ' style="background-image:url(\'' . $bgImage . '\');"' : '';


if (theme_mb2nl_isblock($PAGE, 'before-content')) : ?>
<div id="before-content" class="<?php echo $cls; ?>"<?php echo $isBgImage; ?>>
    <div class="section-inner" style="padding-top:<?php echo $paddingArr[0]; ?>px;padding-bottom:<?php echo $paddingArr[1]; ?>px;">
        <?php if ($regionGrid) : ?>
            <div class="container-fluid">
            <div class="row">
            <div class="col-md-12">
        <?php endif; ?>
            <?php echo $OUTPUT->blocks('before-content', theme_mb2nl_block_cls($PAGE, 'before-content','none')); ?>
        <?php if ($regionGrid) : ?>
            </div>
            </div>
            </div>
        <?php endif; ?>	
    </div>
</div>
<?php endif; ?>