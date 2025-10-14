moodle-local_guestredirect
==========================

[![Moodle Plugin CI](https://github.com/ssystems-de/moodle-local_guestredirect/actions/workflows/moodle-plugin-ci.yml/badge.svg?branch=MOODLE_405_STABLE)](https://github.com/ssystems-de/moodle-local_guestredirect/actions?query=workflow%3A%22Moodle+Plugin+CI%22+branch%3AMOODLE_405_STABLE)

Moodle plugin which provides a dedicated URL to grant users guest access to courses without going through the login page


Requirements
------------

This plugin requires Moodle 4.5+


Motivation for this plugin
--------------------------

If you plan to offer guest access to courses on your Moodle instance and you intend to provide this guest access to non-logged in users as well in the easiest way possible, you normally enable the `autologinguests` setting in your Moodle instance. That way, non-logged in users who access a course's URL where guest access is enabled are logged in as guest users automatically. Unfortunately, the `autologinguests` setting changes important aspects of the way how the login process works and especially turns the `forcelogin` setting ineffective. This means that as soon as `autologinguests` is enabled, practically all users are loggedin as guests and real users have to click on the 'Login' link before they can log in with their full Moodle account.

To solve this catch-22, this plugin was built. It was built especially for Moodle instances which want to keep the `forcelogin` behaviour, but it is not necessarily limited to sites with `forcelogin` enabled.

The plugin provides a dedicated guest access URL for courses which can be handed out to guests. If a user accesses this dedicated URL for a particular course, he is logged in as guest and is directly redirected to the course. Regardless if `autologinguests` is enabled or not and even regardless if the `guestloginbutton` setting is enabled, i.e. even if the guest login button is not shown on the login page.

That way, you can provide an unobtrusive guest access to particular courses without affecting / changing the configuration of your Moodle instance at all.


Installation
------------

Install the plugin like any other plugin to folder
/local/guestredirect

See http://docs.moodle.org/en/Installing_plugins for details on installing Moodle plugins


Usage & Settings
----------------

After installing the plugin, it does not do anything to Moodle yet.

To configure the plugin and its behaviour, please visit:
Site administration -> Authentication -> Guest Redirect

There, you find just one setting:

### Enable guest redirect

As soon as this setting is enabled, users who visit the /local/guestredirect/index.php?id=<courseid> URL (where <courseid> is replaced with the particular course ID of a course where guest access is enabled and which is visible, of course) will be redirected to the course page and logged in as guest if necessary.

Please note that this redirect mechanism even works if the guest login button is not enabled on the login page. This is useful for cases where you want to allow guest access to specific courses without exposing the guest login button globally.


Capabilities
------------

This plugin does not add any additional capabilities.


Scheduled Tasks
---------------

This plugin does not add any additional scheduled tasks.


How this plugin works
---------------------

The plugin provides a simple redirect mechanism through the `/local/guestredirect/index.php` file:

1. When a user visits the URL `/local/guestredirect/index.php?id=<courseid>`, the plugin checks if:
   - The plugin is enabled in the settings
   - The user is not already logged in
   - The specified course exists and has guest enrollment enabled

2. If all conditions are met, the plugin:
   - Creates a guest user session
   - Logs the user in as a guest
   - Verifies guest access to the course
   - Redirects the user to the course page

3. If any of the conditions are not met, the user is redirected to the regular login page without any error message

Security considerations:
- The plugin only works for courses that explicitly have guest enrollment enabled
- It respects all existing course visibility and access restrictions
- No personal data is stored or processed by this plugin


Theme support
-------------

This plugin acts behind the scenes, therefore it should work with all Moodle themes.
This plugin is developed and tested on Moodle Core's Boost theme.
It should also work with Boost child themes, including Moodle Core's Classic theme. However, we can't support any other theme than Boost.


Plugin repositories
-------------------

This plugin is published and regularly updated in the Moodle plugins repository:
http://moodle.org/plugins/view/local_guestredirect

The latest development version can be found on Github:
https://github.com/ssystems-de/moodle-local_guestredirect


Bug and problem reports
-----------------------

This plugin is carefully developed and thoroughly tested, but bugs and problems can always appear.

Please report bugs and problems on Github:
https://github.com/ssystems-de/moodle-local_guestredirect/issues


Community feature proposals
---------------------------

The functionality of this plugin is primarily implemented for the needs of our clients and published as-is to the community. We are aware that members of the community will have other needs and would love to see them solved by this plugin.

Please issue feature proposals on Github:
https://github.com/ssystems-de/moodle-local_guestredirect/issues

Please create pull requests on Github:
https://github.com/ssystems-de/moodle-local_guestredirect/pulls


Paid support
------------

We are always interested to read about your issues and feature proposals or even get a pull request from you on Github. However, please note that our time for working on community Github issues is limited.

As solution provider, we also offer paid support for this plugin. If you are interested, please have a look at our services on [ssystems.de](https://www.ssystems.de/) or get in touch with us directly via vertrieb@ssystems.de.


Moodle release support
----------------------

This plugin is only maintained for the most recent major release of Moodle as well as the most recent LTS release of Moodle. Bugfixes are backported to the LTS release. However, new features and improvements are not necessarily backported to the LTS release.

Apart from these maintained releases, previous versions of this plugin which work in legacy major releases of Moodle are still available as-is without any further updates in the Moodle Plugins repository.

There may be several weeks after a new major release of Moodle has been published until we can do a compatibility check and fix problems if necessary. If you encounter problems with a new major release of Moodle - or can confirm that this plugin still works with a new major release - please let us know on Github.

If you are running a legacy version of Moodle, but want or need to run the latest version of this plugin, you can get the latest version of the plugin, remove the line starting with $plugin->requires from version.php and use this latest plugin version then on your legacy Moodle. However, please note that you will run this setup completely at your own risk. We can't support this approach in any way and there is an undeniable risk for erratic behavior.


Translating this plugin
-----------------------

This Moodle plugin is shipped with an english language pack only. All translations into other languages must be managed through AMOS (https://lang.moodle.org) by what they will become part of Moodle's official language pack.

As the plugin creator, we manage the translation into german for our own local needs on AMOS. Please contribute your translation into all other languages in AMOS where they will be reviewed by the official language pack maintainers for Moodle.


Right-to-left support
---------------------

This plugin has not been tested with Moodle's support for right-to-left (RTL) languages.
If you want to use this plugin with a RTL language and it doesn't work as-is, you are free to send us a pull request on Github with modifications.


Maintainers
-----------

The plugin is maintained by\
ssystems GmbH


Copyright
---------

The copyright of this plugin is held by\
ssystems GmbH

Individual copyrights of individual developers are tracked in PHPDoc comments and Git commits.
