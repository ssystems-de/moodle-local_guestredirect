@local @local_guestredirect
Feature: Testing local_guestredirect in local_guestredirect
  In order to allow guest auto enrolment for particular courses
  As an admin
  I need to be able to compose special guest links

  Scenario Outline: Guest redirect - Verify guest redirect functionality for non-logged-in users
    Given the following config values are set as admin:
      | config           | value              |
      | guestloginbutton | <guestloginbutton> |
      | autologinguests  | <autologinguests>  |
    And the following config values are set as admin:
      | config | value        | plugin              |
      | enable | <killswitch> | local_guestredirect |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And I log in as "admin"
    And I am on the "Course 1" "enrolment methods" page
    And I click on "Edit" "link" in the "Guest access" "table_row"
    And I set the following fields to these values:
      | Allow guest access | <guestaccessenabled> |
    And I press "Save changes"
    And I log out
    And I am on site homepage
    When I visit the guest redirect URL with course name "Course 1"
    Then I should see "<ishouldseestring>" in the "<ishouldseecss>" "css_element"

    Examples:
      | killswitch | guestloginbutton | autologinguests | guestaccessenabled | ishouldseestring               | ishouldseecss                      |
      | 0          | 0                | 0               | No                 | Log in to Acceptance test site | .loginform                         |
      | 1          | 0                | 0               | No                 | Log in to Acceptance test site | .loginform                         |
      | 1          | 0                | 0               | Yes                | Course 1                       | body.path-course-view #page-header |
      | 1          | 1                | 0               | No                 | Log in to Acceptance test site | .loginform                         |
      | 1          | 1                | 0               | Yes                | Course 1                       | body.path-course-view #page-header |
      | 1          | 1                | 1               | No                 | Enrolment options              | #page-content                      |
      | 1          | 1                | 1               | Yes                | Course 1                       | body.path-course-view #page-header |

  Scenario Outline: Guest redirect - Verify guest redirect functionality for logged-in users (who follow the guest redirect link for any reason)
    Given the following config values are set as admin:
      | config           | value              |
      | guestloginbutton | <guestloginbutton> |
      | autologinguests  | <autologinguests>  |
    And the following config values are set as admin:
      | config | value        | plugin              |
      | enable | <killswitch> | local_guestredirect |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "users" exist:
      | username | firstname | lastname |
      | user1    | User      | One      |
    And I log in as "admin"
    And I am on the "Course 1" "enrolment methods" page
    And I click on "Edit" "link" in the "Guest access" "table_row"
    And I set the following fields to these values:
      | Allow guest access | <guestaccessenabled> |
    And I press "Save changes"
    And I log out
    And I log in as "user1"
    And I am on site homepage
    When I visit the guest redirect URL with course name "Course 1"
    Then I should see "<ishouldseestring>" in the "<ishouldseecss>" "css_element"

    Examples:
      | killswitch | guestloginbutton | autologinguests | guestaccessenabled | ishouldseestring  | ishouldseecss                      |
      | 0          | 0                | 0               | No                 | Enrolment options | #page-content                      |
      | 1          | 0                | 0               | No                 | Enrolment options | #page-content                      |
      | 1          | 0                | 0               | Yes                | Course 1          | body.path-course-view #page-header |
      | 1          | 1                | 0               | No                 | Enrolment options | #page-content                      |
      | 1          | 1                | 0               | Yes                | Course 1          | body.path-course-view #page-header |
      | 1          | 1                | 1               | No                 | Enrolment options | #page-content                      |
      | 1          | 1                | 1               | Yes                | Course 1          | body.path-course-view #page-header |

  Scenario Outline: Guest redirect - Verify guest redirect functionality for logged-in and enrolled users (who follow the guest redirect link for any reason)
    Given the following config values are set as admin:
      | config           | value              |
      | guestloginbutton | <guestloginbutton> |
      | autologinguests  | <autologinguests>  |
    And the following config values are set as admin:
      | config | value        | plugin              |
      | enable | <killswitch> | local_guestredirect |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "users" exist:
      | username | firstname | lastname |
      | user1    | User      | One      |
    And the following "course enrolments" exist:
      | user  | course | role    |
      | user1 | C1     | student |
    And I log in as "admin"
    And I am on the "Course 1" "enrolment methods" page
    And I click on "Edit" "link" in the "Guest access" "table_row"
    And I set the following fields to these values:
      | Allow guest access | <guestaccessenabled> |
    And I press "Save changes"
    And I log out
    And I log in as "user1"
    And I am on site homepage
    When I visit the guest redirect URL with course name "Course 1"
    Then I should see "<ishouldseestring>" in the "<ishouldseecss>" "css_element"

    Examples:
      | killswitch | guestloginbutton | autologinguests | guestaccessenabled | ishouldseestring | ishouldseecss                      |
      | 0          | 0                | 0               | No                 | Course 1         | body.path-course-view #page-header |
      | 1          | 0                | 0               | No                 | Course 1         | body.path-course-view #page-header |
      | 1          | 0                | 0               | Yes                | Course 1         | body.path-course-view #page-header |
      | 1          | 1                | 0               | No                 | Course 1         | body.path-course-view #page-header |
      | 1          | 1                | 0               | Yes                | Course 1         | body.path-course-view #page-header |
      | 1          | 1                | 1               | No                 | Course 1         | body.path-course-view #page-header |
      | 1          | 1                | 1               | Yes                | Course 1         | body.path-course-view #page-header |

  # Scenario: Guest redirect - Verify that guest redirect does not work when an invalid course ID is provided
  # Unfortunately, this can't be tested with Behat as Moodle core would throw a
  # 'Can't find data record in database table course' exception when calling the URL with an invalid course ID.
