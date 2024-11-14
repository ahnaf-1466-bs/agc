/**
 *
 * @module     theme_mb2nl
 * @copyright  2017 - 2021 Mariusz Boloz (https://mb2themes.com)
 * @license    Commercial https://themeforest.net/licenses
 */ define(["jquery"],function(a){return{dashboardTabs:function(){a(".dashboard-tabs button").each(function(){a(this).click(function(t){t.preventDefault();var e=a(this).attr("data-id");M.util.set_user_preference("dashboard-active",e),a(".dashboard-tabs button").removeClass("active"),a(".dashboard-bocks .tab-content").removeClass("active"),a(this).addClass("active"),a("#theme-dashboard-tab-content-"+e).addClass("active")})})}}});