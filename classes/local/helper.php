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
 * Local plugin 'Guest redirect' - Helper class.
 *
 * @package    local_guestredirect
 * @copyright  2025 Mahmoud Chehada, ssystems GmbH <mchehada@ssystems.de>
 * @copyright  2026 Alexander Bias, ssystems GmbH <abias@ssystems.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_guestredirect\local;

/**
 * Local plugin 'Guest redirect' - Helper class.
 *
 * @package    local_guestredirect
 * @copyright  2025 Mahmoud Chehada, ssystems GmbH <mchehada@ssystems.de>
 * @copyright  2026 Alexander Bias, ssystems GmbH <abias@ssystems.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class helper {
    /**
     * Check if the guest redirect is enabled by the kill switch.
     *
     * @return bool
     */
    public static function is_enabled(): bool {
        return get_config('local_guestredirect', 'enable') == true;
    }

    /**
     * Check if the guest access enrolment method is enabled in the given course.
     *
     * @param int $courseid The course ID.
     * @return bool
     */
    public static function course_has_guest_access(int $courseid): bool {
        $enrolinstances = enrol_get_instances($courseid, true);
        foreach ($enrolinstances as $instance) {
            if ($instance->enrol == 'guest') {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if the current user should be logged in as guest before being redirected to the given course.
     *
     * @param int $courseid The course ID.
     * @return bool
     */
    public static function should_login_as_guest(int $courseid): bool {
        // If the kill switch is enabled, and if the user is not logged in, and if the guest access is enabled in the course.
        return self::is_enabled() && !isloggedin() && self::course_has_guest_access($courseid);
    }

    /**
     * Create a guest user session and verify that the guest user has access to the given course.
     *
     * This redirects to the login page (or throws a require_login_exception in tests) if the guest user does not have access.
     *
     * @param \stdClass $course The course record.
     */
    public static function login_as_guest(\stdClass $course): void {
        // Note: This intentionally runs on a plain GET request without a sesskey / CSRF token check.
        // The redirect URL is meant to be shared as a link, so a per-session token cannot be embedded.
        // The only possible outcome is that a visitor who is not logged in gets a session as the zero-privilege
        // guest user, just like with core's autologinguests setting.

        // Create a guest user session.
        $user = guest_user();
        complete_user_login($user);

        // Verify that the guest user has access to the course.
        require_login($course, true);
    }

    /**
     * Get the URL of the course page to redirect to.
     *
     * @param int $courseid The course ID.
     * @return \moodle_url
     */
    public static function get_redirect_url(int $courseid): \moodle_url {
        return new \moodle_url('/course/view.php', ['id' => $courseid]);
    }
}
