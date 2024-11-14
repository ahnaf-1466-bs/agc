/**
 *
 * @package   theme_mb2nl
 * @copyright 2017 - 2022 Mariusz Boloz (mb2moodle.com)
 * @license   Commercial https://themeforest.net/licenses
 */
 define(["jquery"],function(e){return{sidebarToggle:function(){var s=e("body");e(".theme-hide-sidebar").click(function(e){e.preventDefault(),s.hasClass("hide-sidebars")?(s.removeClass("hide-sidebars"),M.util.set_user_preference("theme-usersidebar","true")):(s.addClass("hide-sidebars"),M.util.set_user_preference("theme-usersidebar","false"))})}}});
