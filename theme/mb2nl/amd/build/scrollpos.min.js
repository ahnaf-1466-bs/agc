/**
 *
 * @package   theme_mb2nl
 * @copyright 2017 - 2022 Mariusz Boloz (mb2moodle.com)
 * @license   Commercial https://themeforest.net/licenses
 */
define(["jquery"],function($){return{panelLink:function(){$("body"),$(document).on("click",".save-location",function(){0==$(this).attr("data-scrollpos")?M.util.set_user_preference("theme-scrollpos",window.pageYOffset):M.util.set_user_preference("theme-scrollpos",0)}),$(".save-location").attr("data-scrollpos")>0&&(window.scrollTo(0,$(".save-location").attr("data-scrollpos")),M.util.set_user_preference("theme-scrollpos",0))}}})
