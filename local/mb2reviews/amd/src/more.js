// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 *
 * @package    local_mb2reviews
 * @copyright  2019 - 2020 Mariusz Boloz (mb2themes.com)
 * @license    Commercial https://themeforest.net/licenses
 */
define(["jquery","core/ajax","core/event","core/notification"],function(e,t,a,i){var r=function(){this._userCache=[],this.registerEventListeners()};return r.prototype._showMore=function(a){a.preventDefault();e(document).find(".mb2reviews-review-list");var r=e(document).find(".mb2reviews-more");if(r.hasClass("loading")||r.attr("data-page")==r.attr("data-maxpages"))return null;r.addClass("loading"),t.call([{methodname:"local_mb2reviews_show_more",args:{courseid:r.attr("data-courseid"),page:r.attr("data-page")},done:this._handleResponse.bind(this),fail:i.exception}])},r.prototype._handleResponse=function(t){setTimeout(function(){e(document).find(".mb2reviews-review-list").append(t.reviews);var a=e(document).find(".mb2reviews-more"),i=parseInt(a.attr("data-page"));a.attr("data-page",i+1),a.removeClass("loading"),a.attr("data-page")==a.attr("data-maxpages")&&a.addClass("nodata"),this._feedbackActive()}.bind(this),2e3)},r.prototype._feedbackActive=function(){e(document).find(".mb2reviews-review-thumb").each(function(){var t="mb2reviews_review_feedback_"+e(this).attr("data-review");Cookies.get(t)===e(this).attr("data-thumb")&&(e(this).addClass("active"),e(this).parent().addClass("hasfeedback"))})},r.prototype.registerEventListeners=function(){e(document).on("click",".mb2reviews-more",this._showMore.bind(this))},r});
