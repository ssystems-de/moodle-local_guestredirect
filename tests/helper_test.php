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
 * Local plugin 'Guest redirect' - PHPUnit tests for the helper class.
 *
 * @package    local_guestredirect
 * @copyright  2026 Alexander Bias, ssystems GmbH <abias@ssystems.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_guestredirect;

use local_guestredirect\local\helper;

/**
 * Local plugin 'Guest redirect' - PHPUnit tests for the helper class.
 *
 * @package    local_guestredirect
 * @copyright  2026 Alexander Bias, ssystems GmbH <abias@ssystems.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \local_guestredirect\local\helper
 */
final class helper_test extends \advanced_testcase {
    /**
     * Setup testcase.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest();
    }

    /**
     * Create a course and set the state of its guest access enrolment instance.
     *
     * @param string $guestaccess One of 'enabled', 'disabled' or 'missing'.
     * @param array $courseoptions Additional options for the course generator.
     * @return \stdClass The course record.
     */
    private function create_course_with_guest_access(string $guestaccess, array $courseoptions = []): \stdClass {
        global $DB;

        $course = $this->getDataGenerator()->create_course($courseoptions);
        $instance = $DB->get_record('enrol', ['courseid' => $course->id, 'enrol' => 'guest'], '*', MUST_EXIST);
        $plugin = enrol_get_plugin('guest');

        switch ($guestaccess) {
            case 'enabled':
                $plugin->update_status($instance, ENROL_INSTANCE_ENABLED);
                break;
            case 'disabled':
                $plugin->update_status($instance, ENROL_INSTANCE_DISABLED);
                break;
            case 'missing':
                $plugin->delete_instance($instance);
                break;
        }

        return $course;
    }

    /**
     * Log in the given kind of user.
     *
     * @param string $user One of 'none', 'guest' or 'user'.
     */
    private function login_user(string $user): void {
        switch ($user) {
            case 'none':
                $this->setUser(null);
                break;
            case 'guest':
                $this->setGuestUser();
                break;
            case 'user':
                $this->setUser($this->getDataGenerator()->create_user());
                break;
        }
    }

    /**
     * Data provider for test_is_enabled.
     *
     * @return array
     */
    public static function is_enabled_provider(): array {
        return [
            'Setting not set' => [null, false],
            'Setting disabled' => ['0', false],
            'Setting enabled' => ['1', true],
        ];
    }

    /**
     * Test the kill switch check.
     *
     * @param string|null $setting The value of the enable setting or null if it should be unset.
     * @param bool $expected The expected result.
     * @dataProvider is_enabled_provider
     */
    public function test_is_enabled(?string $setting, bool $expected): void {
        if ($setting === null) {
            unset_config('enable', 'local_guestredirect');
        } else {
            set_config('enable', $setting, 'local_guestredirect');
        }

        $this->assertSame($expected, helper::is_enabled());
    }

    /**
     * Data provider for test_course_has_guest_access.
     *
     * @return array
     */
    public static function course_has_guest_access_provider(): array {
        return [
            'Guest access enabled' => ['enabled', true],
            'Guest access disabled' => ['disabled', false],
            'Guest access instance missing' => ['missing', false],
        ];
    }

    /**
     * Test the detection of the guest access enrolment method in a course.
     *
     * @param string $guestaccess The state of the guest access enrolment instance.
     * @param bool $expected The expected result.
     * @dataProvider course_has_guest_access_provider
     */
    public function test_course_has_guest_access(string $guestaccess, bool $expected): void {
        $course = $this->create_course_with_guest_access($guestaccess);

        $this->assertSame($expected, helper::course_has_guest_access($course->id));
    }

    /**
     * Test that the guest access enrolment method of another course is not taken into account.
     */
    public function test_course_has_guest_access_other_course(): void {
        $course1 = $this->create_course_with_guest_access('disabled');
        $course2 = $this->create_course_with_guest_access('enabled');

        $this->assertFalse(helper::course_has_guest_access($course1->id));
        $this->assertTrue(helper::course_has_guest_access($course2->id));
    }

    /**
     * Data provider for test_should_login_as_guest.
     *
     * @return array
     */
    public static function should_login_as_guest_provider(): array {
        $cases = [];
        foreach (['0', '1'] as $killswitch) {
            foreach (['none', 'guest', 'user'] as $user) {
                foreach (['enabled', 'disabled', 'missing'] as $guestaccess) {
                    // The guest login should only happen if all conditions are met.
                    $expected = $killswitch === '1' && $user === 'none' && $guestaccess === 'enabled';
                    $name = "Kill switch {$killswitch}, user {$user}, guest access {$guestaccess}";
                    $cases[$name] = [$killswitch, $user, $guestaccess, $expected];
                }
            }
        }
        return $cases;
    }

    /**
     * Test the decision if the current user should be logged in as guest.
     *
     * @param string $killswitch The value of the enable setting.
     * @param string $user The kind of user who is logged in.
     * @param string $guestaccess The state of the guest access enrolment instance.
     * @param bool $expected The expected result.
     * @dataProvider should_login_as_guest_provider
     */
    public function test_should_login_as_guest(string $killswitch, string $user, string $guestaccess, bool $expected): void {
        set_config('enable', $killswitch, 'local_guestredirect');
        $course = $this->create_course_with_guest_access($guestaccess);
        $this->login_user($user);

        $this->assertSame($expected, helper::should_login_as_guest($course->id));
    }

    /**
     * Test that a non-logged-in user is logged in as guest and gets access to a course with guest access.
     */
    public function test_login_as_guest(): void {
        $course = $this->create_course_with_guest_access('enabled');
        $this->setUser(null);
        $this->assertFalse(isloggedin());

        @helper::login_as_guest($course); // Hide session header errors, like core does in test_complete_user_login().

        $this->assertTrue(isloggedin());
        $this->assertTrue(isguestuser());
    }

    /**
     * Test that the guest user is sent to the enrolment page of a course without guest access.
     */
    public function test_login_as_guest_without_guest_access(): void {
        $course = $this->create_course_with_guest_access('disabled');
        $this->setUser(null);

        // The redirect to the enrolment page in require_login() is converted to an exception in CLI scripts.
        $this->expectException(\moodle_exception::class);
        $this->expectExceptionMessage(get_string('redirecterrordetected', 'error'));
        @helper::login_as_guest($course); // Hide session header errors, like core does in test_complete_user_login().
    }

    /**
     * Test the URL which the user is redirected to.
     */
    public function test_get_redirect_url(): void {
        $course = $this->getDataGenerator()->create_course();

        $url = helper::get_redirect_url($course->id);

        $this->assertInstanceOf(\moodle_url::class, $url);
        $this->assertSame('/course/view.php?id=' . $course->id, $url->out_as_local_url(false));
    }
}
