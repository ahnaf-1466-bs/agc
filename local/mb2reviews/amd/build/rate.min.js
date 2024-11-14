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
define(["jquery","core/ajax","core/event","core/notification"],function(e,s,o,t){var i=function(){this._userCache=[],this.registerEventListeners()};return i.prototype._submitForm=function(o){o.preventDefault();var i=e(document).find(".mb2reviews-review-form");i.trigger("save-form-state");var n=i.serialize();i.closest(".modal").addClass("loading"),s.call([{methodname:"local_mb2reviews_submit_review",args:{formdata:n},done:this._handleResponse.bind(this),fail:t.exception}])},i.prototype._handleResponse=function(s){setTimeout(function(){var s=e(document).find(".mb2reviews-review-form");s.closest(".modal").removeClass("loading"),s.closest(".modal").removeClass("success"),setTimeout(function(){location.reload()},1e3),t.addNotification({message:"review is dodany",type:"success"})}.bind(this),2e3),console.log("Review send success!")},i.prototype.registerEventListeners=function(){e(document).on("submit",".mb2reviews-review-form",this._submitForm.bind(this))},i});
