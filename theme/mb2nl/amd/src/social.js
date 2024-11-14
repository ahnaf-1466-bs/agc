/**
 *
 * @package   theme_mb2nl
 * @copyright 2017 - 2022 Mariusz Boloz (https://mb2themes.com)
 * @license   Commercial https://themeforest.net/licenses
 */ define(["jquery"],function(e){return{shareUrl:function(r){e(".shareurl_link").each(function(){var r=e(this),a=r.attr("data-url");r.click(function(e){e.preventDefault(),r.hasClass("copied")||(navigator.clipboard.writeText(a),r.addClass("copied"),setTimeout(function(){r.removeClass("copied"),r.blur()},1200))})})}}});