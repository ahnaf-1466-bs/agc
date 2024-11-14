/**
 *
 * @package    local_mb2reviews
 * @copyright  2019 - 2020 Mariusz Boloz (mb2themes.com)
 * @license    Commercial https://themeforest.net/licenses
 */ define(["jquery"],function(s){return{ratingDetails:function(){s(document).on("click",".rating-details-toggle",function(e){e.preventDefault();var t=s(this).closest(".block_mb2reviews").find(".mb2reviews-rating-more");t.hasClass("show")?t.removeClass("show"):t.addClass("show")})}}});
