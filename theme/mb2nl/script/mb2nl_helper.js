/**
 *
 * @package   theme_mb2nl
 * @copyright 2017 - 2020 Mariusz Boloz (mb2moodle.com)
 * @license   Commercial https://themeforest.net/licenses
 *
 */ var mb2nl_helper=function(){return{dataAttribs:function(a){var t={};return $.each(a[0].attributes,function(){this.name.includes("data-")&&!this.name.includes("data-jarallax-")&&this.specified&&(t[this.name.replace("data-","")]=this.value)}),t}}};
