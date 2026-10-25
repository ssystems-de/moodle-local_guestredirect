<?php
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
 * Local plugin 'Guest redirect' - Redirect page.
 *
 * @package    local_guestredirect
 * @copyright  2025 Mahmoud Chehada, ssystems GmbH <mchehada@ssystems.de>
 * @copyright  2026 Alexander Bias, ssystems GmbH <abias@ssystems.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// phpcs:disable moodle.Files.RequireLogin.Missing
// Let codechecker ignore the next line because otherwise it would complain about a missing login check
// after requiring config.php. This page is intentionally accessible without login: If applicable, the guest login
// (including the course access check) is done by the helper class, otherwise the user is just redirected to the
// course page which does its own login check.
require_once(__DIR__ . '/../../config.php');

// Get course ID from URL parameters.
$courseid = required_param('id', PARAM_INT);
// Load the course by its ID.
$course = get_course($courseid);

// If the kill switch is enabled, and if the user is not logged in, and if the guest access is enabled in the course.
if (\local_guestredirect\local\helper::should_login_as_guest($courseid)) {
    // Create a guest user session and verify that the guest user has access to the course.
    // This redirects to the login page if the user does not have no access.
    \local_guestredirect\local\helper::login_as_guest($course);
}

// Redirect the user to the course page.
// Moodle Core will make sure that this page is the processed as usual.
redirect(\local_guestredirect\local\helper::get_redirect_url($courseid));
