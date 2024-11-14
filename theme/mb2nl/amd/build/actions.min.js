/**
 *
 * @package   theme_mb2nl
 * @copyright 2017 - 2022 Mariusz Boloz (https://mb2themes.com)
 * @license   Commercial https://themeforest.net/licenses
 */ define(["jquery"],function(n){var t=function(){n(document).on("click",".show-menu",function(){var t=n("#main-navigation");t.hasClass("open")?t.removeClass("open"):t.addClass("open")})},a=function(){n(".menu-extra-controls-btn").each(function(){n(this).click(function(t){n(this).hasClass("active")?e():o(n(this))})})},o=function(t){e(),t.addClass("active"),n("#"+t.attr("aria-controls")).addClass("open")},e=function(){n(".menu-extracontent-content").removeClass("open"),n(".menu-extra-controls-btn").removeClass("active")};return{Init:function(){a(),t()}}});