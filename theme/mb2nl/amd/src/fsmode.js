/**
 *
 * @package   theme_mb2nl
 * @copyright 2017 - 2022 Mariusz Boloz (https://mb2themes.com)
 * @license   Commercial https://themeforest.net/licenses
 */ define(["jquery"],function(s){return{sidebarToggle:function(){var e=s(".fsmod-course");s(".fsmod-showhide-sidebar").each(function(){s(this).click(function(s){s.preventDefault(),e.hasClass("issidebar")?(e.removeClass("issidebar"),M.util.set_user_preference("fsmod-open-nav","false")):(e.addClass("issidebar"),M.util.set_user_preference("fsmod-open-nav","true")),e.hasClass("ismsidebar")?e.removeClass("ismsidebar"):e.addClass("ismsidebar")})}),s(".fsmod-toggle-sidebar>button").click(function(e){s(".fsmod-toggle-sidebar>button").removeClass("active"),s(".fsmod-section").removeClass("active"),s(this).addClass("active"),s("#"+s(this).attr("aria-controls")).addClass("active"),M.util.set_user_preference("fsmod-toggle-sidebar",s(this).attr("data-id"))})}}});
