/**
 *
 * @package   theme_mb2nl
 * @copyright 2017 - 2022 Mariusz Boloz (mb2moodle.com)
 * @license   Commercial https://themeforest.net/licenses
 */ define(["jquery"],function($){return{contentTabs:function(){$(".enrol-course-navitem").each(function(){$(this).find("button").click(function(){$(".enrol-course-navitem").removeClass("active"),$(".enrol-course-navcontent").removeClass("active"),$(this).closest(".enrol-course-navitem").addClass("active"),$("#"+$(this).attr("aria-controls")).addClass("active")})})},contentOutTabs:function(){$(".out-navitem").each(function(){$(this).click(function(a){a.preventDefault(),$(".enrol-course-navitem").removeClass("active"),$(".enrol-course-navcontent").removeClass("active"),$('button[aria-controls="'+$(this).attr("aria-controls")+'"]').closest(".enrol-course-navitem").addClass("active"),$("#"+$(this).attr("aria-controls")).addClass("active")})})}}})
