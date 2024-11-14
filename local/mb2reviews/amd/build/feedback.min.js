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
define(["jquery","core/ajax","core/event","core/notification"],function(e,t,a,i){var r=function(){this._userCache=[],this.registerEventListeners(),this._feedbackActive()};return r.prototype._feedback=function(a){a.preventDefault();var r=e(a.currentTarget),s="mb2reviews_review_feedback_"+r.attr("data-review"),o="";Cookies.get(s)&&(o=Cookies.get(s)),r.parent().find(".mb2reviews-review-thumb").removeClass("active"),r.parent().removeClass("hasfeedback"),Cookies.get(s)===r.attr("data-thumb")?Cookies.remove(s):(Cookies.set(s,r.attr("data-thumb"),{expires:7,path:"/"}),r.addClass("active"),r.parent().addClass("hasfeedback")),t.call([{methodname:"local_mb2reviews_feedback",args:{review:r.attr("data-review"),feedback:r.attr("data-thumb"),oldfeedback:o},done:this._handleResponse.bind(this),fail:i.exception}])},r.prototype._feedbackActive=function(t){e(document).find(".mb2reviews-review-thumb").each(function(){var t="mb2reviews_review_feedback_"+e(this).attr("data-review");Cookies.get(t)===e(this).attr("data-thumb")&&(e(this).addClass("active"),e(this).parent().addClass("hasfeedback"))})},r.prototype._handleResponse=function(e){},r.prototype.registerEventListeners=function(){e(document).on("click",".mb2reviews-review-thumb",this._feedback.bind(this))},r});
