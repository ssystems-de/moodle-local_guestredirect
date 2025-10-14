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
 * Local plugin 'Guest redirect' - Behat steps.
 *
 * @package    local_guestredirect
 * @copyright  2025 Mahmoud Chehada, ssystems GmbH <mchehada@ssystems.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../lib/behat/behat_base.php');

/**
 * Class behat_local_guestredirect
 *
 * @package    local_guestredirect
 * @copyright  2025 Mahmoud Chehada, ssystems GmbH <mchehada@ssystems.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_local_guestredirect extends behat_base {
    /**
     * Open the guest redirect URL.
     *
     * @When I visit the guest redirect URL with course name :arg1
     * @param string $coursename The course name.
     */
    public function i_visit_guest_redirect_url($coursename) {
        // Get the course ID from the course name.
        // We have to do this as Behat uses arbitrary course IDs.
        $courseid = $this->get_course_id($coursename);

        // Visit the guest redirect URL with the course ID.
        $this->execute('behat_general::i_visit', ['/local/guestredirect/index.php?id=' . $courseid]);
    }
}
