/**
 *
 * @package   theme_mb2nl
 * @copyright 2017 - 2022 Mariusz Boloz (https://mb2themes.com)
 * @license   Commercial https://themeforest.net/licenses
 */ define(["jquery"],function(n){var i=function(){n(".quicklinks").addClass("open")},c=function(){n(".quicklinks").removeClass("open")};return{quickLinksInit:function(s){n(document).on("click","#quicklinks-toggle",function(s){n(this).closest(".quicklinks").hasClass("open")?c():i()}),n("body").on("click",function(i){n(i.target).closest(".quicklinks").length||c()})}}});
