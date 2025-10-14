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
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

// Get course ID from URL parameters.
$courseid = required_param('id', PARAM_INT);
// Load the course by its ID.
$course = get_course($courseid);

// If the kill switch is enabled, and if the user is not logged in.
if (get_config('local_guestredirect', 'enable') == true && !isloggedin()) {
    // If the guest access is enabled in the course settings.
    $enrolinstances = enrol_get_instances($courseid, true);
    foreach ($enrolinstances as $key => $instance) {
        if ($instance->enrol == 'guest') {
            // Create a guest user session.
            $user = guest_user();
            complete_user_login($user);

            // Verify that the guest user has access to the course.
            // This redirects to the login page if the user does not have no access.
            require_login($course, true);

            break;
        }
    }
}

// Create the URL for course page redirection.
$redirecturl = new moodle_url('/course/view.php', ['id' => $courseid]);

// Redirect the user to the course page.
// Moodle Core will make sure that this page is the processed as usual.
redirect($redirecturl);
