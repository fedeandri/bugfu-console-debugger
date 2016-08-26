=== BugFu Console Debugger ===
Contributors: fedeandri
Tags: debug, debugging, debug bar, debug notification, dev, develop, development, error, log, display error, error log, error notification, error reporting, bug, bugs, find bug, bug report, issue, issues, multisite, plugin, browser, console, php, javascript, stacktrace, backtrace
Requires at least: 3.8
Tested up to: 4.6
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

BugFu lets you log from PHP directly to your Browser JavaScript Console - Meant as an aid to those practicing the ancient art of debugging


== Description ==

BugFu lets you log from PHP directly to your Browser JavaScript Console
- Meant as an aid to those practicing the ancient art of debugging -

**HOW TO CHECK IF BUGFU IS WORKING**

Open your browser console, if you see this header, BugFu is working properly
`
################################
#### BugFu Console Debugger ####
################################
`

**HOW TO OPEN YOUR BROWSER JAVASCRIPT CONSOLE**

If you've never used the JavaScript Console before, here's how you open it:

* Chrome PC shift+ctrl+j   Chrome Mac alt+cmd+j
* Firefox PC shift+ctrl+k   Firefox Mac alt+cmd+k
* Safari PC shift+ctrl+c   Safari Mac alt+cmd+c

**HOW TO USE BUGFU WITH WORDPRESS**

Call the log static method from wherever you are within the WordPress PHP code
`
<?php /* WORDPRESS CODE HERE */

# Call it with no arguments to only output some backtrace info
BugFu::log();

# Call it with a string argument to output that string content
BugFu::log($my_string_content);

# Call it with a non-string argument to output the structured
# representation of that argument - it uses var_export() 
BugFu::log($my_object-array-variable);
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

= 1.0 =
* First version, log your debug messages from PHP directly to your browser JavaScript console

