=== BugFu Console Debugger ===
Contributors: fedeandri
Tags: debug, debug bar, php, error, log
Requires at least: 3.8
Tested up to: 5.0
Stable tag: 1.2.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Log and Debug your Theme/Plugin PHP code using the Browser JavaScript Console.


== Description ==

Log and Debug your Theme/Plugin PHP code using the Browser JavaScript Console.

**HOW TO CHECK IF BUGFU IS WORKING**

Open your browser console, if you see this header, BugFu is working properly
`
################################
#### BugFu Console Debugger ####
################################
`

**HOW TO OPEN YOUR BROWSER JAVASCRIPT CONSOLE**

If you've never used the JavaScript Console before, here's how you open it:

* Chrome PC shift+ctrl+j - Chrome Mac alt+cmd+j
* Firefox PC shift+ctrl+k - Firefox Mac alt+cmd+k
* Safari PC shift+ctrl+c - Safari Mac alt+cmd+c

**HOW TO USE BUGFU WITH WORDPRESS**

Call the log static method from wherever you are within the WordPress PHP code
`
<?php /* WORDPRESS CODE HERE */

/* Call it with no arguments to only output some backtrace info */
BugFu::log();

/* Call it with a string argument to output that string content */
BugFu::log($my_string_content);

/* Call it with a non-string argument to output the structured
   representation of that argument - it uses var_export() */
BugFu::log($my_object-array-variable);

/* Call it with the second optional argument set to "false"
   to turn off the backtrace info (which is on by default) */
BugFu::log($my_content, false);
`

**DEVELOPERS**

Official Github repository:  
https://github.com/fedeandri/bugfu-console-debugger  


== Installation ==

1. Unzip the plugin file bugfu-console-debugger.zip
2. Upload the unzipped folder "bugfu-console-debugger" to the `/wp-content/plugins/` directory of your WordPress blog/website
3. Activate the plugin through the 'Plugins' menu in WordPress


== Screenshots ==

1. The admin page when BugFu is ON
2. The Browser JavaScript Console when BugFu is ON
3. The admin page when BugFu is OFF


== Changelog ==

= 1.2.5 =
* Add Settings link

= 1.2.4 =
* Add compatibility with old PHP versions (tested from 5.3)

= 1.2.3 =
* Update and simplify the AJAX calls debugging feature

= 1.2.2 =
* Prevent PHP notice when not logging from a class

= 1.2.1 =
* Update the AJAX calls debugging feature to avoid CPU overload

= 1.2 =
* Add the ability to debug AJAX calls

= 1.1 =
* Fixed a bug that made it look like BugFu constantly needed to be updated (thanks to Jonathan Bossenger)
* Added a second optional argument to the log method, in order to allow you to turn off the backtrace info which is on by default

= 1.0 =
* First version, log your debug messages from PHP directly to your browser JavaScript console

