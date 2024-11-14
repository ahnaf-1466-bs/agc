/**
 *
 * @package   theme_mb2nl
 * @copyright 2017 - 2022 Mariusz Boloz (https://mb2themes.com)
 * @license   Commercial https://themeforest.net/licenses
 */ define(["jquery"],function(t){var s=function(){t(".mb2mm-wrap.width-max").each(function(){var s=t(this).closest(".ismega").offset().left,e=t("#page");t("body").hasClass("theme-lfx")&&(s-=e.offset().left,t(this).css("width",e.outerWidth())),t(this).css("left",-1*s)}),t(".mb2mm-wrap.width-aw").each(function(){var s=t(this).closest(".ismega"),e=s.offset().left,i=t(this).attr("data-aw");t(this).css("width",i);var o=.5*i-.5*s.find(">.mb2mm-action").outerWidth();t(this).css("left",-1*(o>e?e:o))})};return{setWrapPos:function(){t(window).resize(function(){s()}),t(window).scroll(function(){s()}),s()},toggleSubmenus:function(){t(document).on("click",".mb2mm-toggle",function(){var s=t(this).closest(".isparent");s.hasClass("open")?s.removeClass("open"):s.addClass("open"),console.log("clicked")})}}});