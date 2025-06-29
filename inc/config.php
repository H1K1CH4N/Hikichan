<?php

/*
 *  Copyright (c) 2010-2013 Tinyboard Development Group
 *
 *  WARNING: This is a project-wide configuration file and is overwritten when upgrading to a newer
 *  version of vichan. Please leave this file unchanged, or it will be a lot harder for you to upgrade.
 *  If you would like to make instance-specific changes to your own setup, please use secrets.php.
 *
 *  This is the default configuration. You can copy values from here and use them in
 *  your secrets.php
 *
 *  You can also create per-board configuration files. Once a board is created, locate its directory and
 *  create a new file named config.php (eg. b/config.php). Like secrets.php, you can copy values
 *  from here and use them in your per-board configuration files.
 *
 *  Some directives are commented out. This is either because they are optional and examples, or because
 *  they are "optionally configurable", and given their default values by vichan's code later if unset.
 *
 *  More information: https://github.com/vichan-devel/vichan/wiki/config
 *
 *  vichan documentation: https://github.com/vichan-devel/vichan/wiki/
 *
 */

	defined('TINYBOARD') or exit;

/*
 * =======================
 *  General/misc settings
 * =======================
 */

	// Global announcement -- the very simple version.
	// This used to be wrongly named $config['blotter'] (still exists as an alias).
	// $config['global_message'] = 'This is an important announcement!';
	$config['blotter'] = &$config['global_message'];

	// Automatically check if a newer version of vichan is available when an administrator logs in.
	$config['check_updates'] = false;
	// How often to check for updates
	$config['check_updates_time'] = 43200; // 12 hours

	// Shows some extra information at the bottom of pages. Good for development/debugging.
	$config['debug'] = false;
	// For development purposes. Displays (and "dies" on) all errors and warnings. Turn on with the above.
	$config['verbose_errors'] = false;
	// Warn about deprecations? See vichan-devel/vichan#363 and https://www.youtube.com/watch?v=9crnlHLVdno
	$config['deprecation_errors'] = false;
	// Skip cache in twig. this is already enabled with debug
	$config['twig_auto_reload'] = false;

	// EXPLAIN all SQL queries (when in debug mode).
	$config['debug_explain'] = false;

	// Directory where temporary files will be created.
	$config['tmp'] = sys_get_temp_dir();

	// The HTTP status code to use when redirecting. http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
	// Can be either 303 "See Other" or 302 "Found". (303 is more correct but both should work.)
	// There is really no reason for you to ever need to change this.
	$config['redirect_http'] = 303;

	// A tiny text file in the main directory indicating that the script has been ran and the board(s) have
	// been generated. This keeps the script from querying the database and causing strain when not needed.
	$config['has_installed'] = '.installed';

	// Deprecated, use 'log_system'.
	$config['syslog'] = false;

	$config['log_system'] = [
		/*
		 * Log all error messages and unauthorized login attempts.
		 * Can be "syslog", "error_log" (default), "file", or "stderr".
		 */
		'type' => 'error_log',
		// The application name used by the logging system. Defaults to "tinyboard" for backwards compatibility.
		'name' => 'tinyboard',
		/*
		 * Only relevant if 'log_system' is set to "syslog". If true, double print the logs also in stderr. Defaults to
		 * false.
		 */
		'syslog_stderr' => false,
		/*
		 * Only relevant if "log_system" is set to `file`. Sets the file that vichan will log to. Defaults to
		 * '/var/log/vichan.log'.
		 */
		'file_path' => '/var/log/vichan.log',
	];

	// Use `host` via shell_exec() to lookup hostnames, avoiding query timeouts. May not work on your system.
	// Requires safe_mode to be disabled.
	$config['dns_system'] = false;

	// Check validity of the reverse DNS of IP addresses. Highly recommended.
	$config['fcrdns'] = true;

	// When executing most command-line tools (such as `convert` for ImageMagick image processing), add this
	// to the environment path (seperated by :).
	$config['shell_path'] = '/usr/local/bin';

	// Automatically execute some maintenance tasks when some pages are opened, which may result in higher
	// latencies.
	// If set to false, ensure to periodically invoke the tools/maintenance.php script.
	$config['auto_maintenance'] = true;

	// Batch size for rebuild tasks (index pages, threads, replies, archive boards)
	$config['rebuild_batch_size'] = 10;

/*
 * ====================
 *  Database settings
 * ====================
 */

	// Database driver (http://www.php.net/manual/en/pdo.drivers.php)
	// Only MySQL is supported by vichan at the moment, sorry.
	$config['db']['type'] = 'mysql';
	// Hostname, IP address or Unix socket (prefixed with ":")
	$config['db']['server'] = 'localhost';
	// Example: Unix socket
	// $config['db']['server'] = ':/tmp/mysql.sock';
	// Login
	$config['db']['user'] = '';
	$config['db']['password'] = '';
	// vichan database
	$config['db']['database'] = '';
	// Table prefix (optional)
	$config['db']['prefix'] = '';
	// Use a persistent database connection when possible
	$config['db']['persistent'] = false;
	// Anything more to add to the DSN string (eg. port=xxx;foo=bar)
	$config['db']['dsn'] = '';
	// Connection timeout duration in seconds
	$config['db']['timeout'] = 30;

/*
 * ====================
 *  Cache, lock and queue settings
 * ====================
 */

	/*
	 * On top of the static file caching system, you can enable the additional caching system which is
	 * designed to minimize request processing can significantly increase speed when posting or using
	 * the moderator interface.
	 *
	 * https://github.com/vichan-devel/vichan/wiki/cache
	 */

	// Uses a PHP array. MUST NOT be used in multiprocess environments.
	$config['cache']['enabled'] = 'php';
	// The recommended in-memory method of caching. Requires the extension. Due to how APCu works, this should be
	// disabled when you run tools from the cli.
	// $config['cache']['enabled'] = 'apcu';
	// The Memcache server. Requires the memcached extension, with a final D.
	// $config['cache']['enabled'] = 'memcached';
	// The Redis server. Requires the extension.
	// $config['cache']['enabled'] = 'redis';
	// Use the local cache folder. Slower than native but available out of the box and compatible with multiprocess
	// environments. You can mount a ram-based filesystem in the cache directory to improve performance.
	// $config['cache']['enabled'] = 'fs';
	// Technically available, offers a no-op fake cache. Don't use this outside of testing or debugging.
	// $config['cache']['enabled'] = 'none';

	// Timeout for cached objects such as posts and HTML.
	$config['cache']['timeout'] = 60 * 60 * 48; // 48 hours

	// Optional prefix if you're running multiple vichan instances on the same machine.
	$config['cache']['prefix'] = '';

	// Memcached servers to use. Read more: http://www.php.net/manual/en/memcached.addservers.php
	$config['cache']['memcached'] = array(
		array('localhost', 11211)
	);

	// Redis server to use. Location, port, password, database id.
	// Note that vichan may clear the database at times, so you may want to pick a database id just for
	// vichan to use.
	$config['cache']['redis'] = array('localhost', 6379, '', 1);

	// EXPERIMENTAL: Should we cache configs? Warning: this changes board behaviour, i'd say, a lot.
	// If you have any lambdas/includes present in your config, you should move them to instance-functions.php
	// (this file will be explicitly loaded during cache hit, but not during cache miss).
	$config['cache_config'] = false;

	// Define a lock driver.
	$config['lock']['enabled'] = 'fs';

	// Define a queue driver.
	$config['queue']['enabled'] = 'fs'; // xD

/*
 * ====================
 *  Cookie settings
 * ====================
 */

	// Used for moderation login.
	$config['cookies']['mod'] = 'mod';

	// Used for communicating with Javascript; telling it when posts were successful.
	$config['cookies']['js'] = 'serv';

	// Cookies path. Defaults to $config['root']. If $config['root'] is a URL, you need to set this. Should
	// be '/' or '/board/', depending on your installation.
	// $config['cookies']['path'] = '/';
	// Where to set the 'path' parameter to $config['cookies']['path'] when creating cookies. Recommended.
	$config['cookies']['jail'] = true;

	// How long should the cookies last (in seconds). Defines how long should moderators should remain logged
	// in (0 = browser session).
	$config['cookies']['expire'] = 60 * 60 * 24 * 7; // 1 week.

	// Make this something long and random for security.
	$config['cookies']['salt'] = 'abcdefghijklmnopqrstuvwxyz09123456789!@#$%^&*()';

	// Whether or not you can access the mod cookie in JavaScript. Most users should not need to change this.
	$config['cookies']['httponly'] = true;

	// Do not allow logins via unsecure connections.
	// 0 = off. Allow logins on unencrypted HTTP connections. Should only be used in testing environments.
	// 1 = on, trust HTTP headers. Allow logins on (at least reportedly partial) HTTPS connections. Use this only if you
	// use a proxy, CDN or load balancer via an unencrypted connection. Be sure to filter 'HTTP_X_FORWARDED_PROTO' in
	// the remote server, since an attacker could inject the header from the client.
	// 2 = on, do not trust HTTP headers. Secure default, allow logins only on HTTPS connections.
	$config['cookies']['secure_login_only'] = 0;

	// Used to salt secure tripcodes ("##trip") and poster IDs (if enabled).
	$config['secure_trip_salt'] = ')(*&^%$#@!98765432190zyxwvutsrqponmlkjihgfedcba';

	// Used to salt poster passwords.
	$config['secure_password_salt'] = 'wKJSb7M5SyzMcFWD2gPO3j2RYUSO9B789!@#$%^&*()';

/*
 * ====================
 *  Flood/spam settings
 * ====================
 */

	/*
	 * To further prevent spam and abuse, you can use DNS blacklists (DNSBL). A DNSBL is a list of IP
	 * addresses published through the Internet Domain Name Service (DNS) either as a zone file that can be
	 * used by DNS server software, or as a live DNS zone that can be queried in real-time.
	 *
	 * Read more: https://github.com/vichan-devel/vichan/wiki/dnsbl
	 */

	// Prevents most Tor exit nodes from making posts. Recommended, as a lot of abuse comes from Tor because
	// of the strong anonymity associated with it.
	// Example: $config['dnsbl'][] = 'another.blacklist.net';
	// $config['dnsbl'][] = array('tor.dnsbl.sectoor.de', 1); //sectoor.de site is dead. the number stands for (an) ip adress(es) I guess.

	// Replacement for sectoor.de
	$config['dnsbl'][] = array('rbl.efnetrbl.org', 4);

	// http://www.sorbs.net/using.shtml
	// $config['dnsbl'][] = array('dnsbl.sorbs.net', array(2, 3, 4, 5, 6, 7, 8, 9));

	// http://www.projecthoneypot.org/httpbl.php
	// $config['dnsbl'][] = array('<your access key>.%.dnsbl.httpbl.org', function($ip) {
	//	$octets = explode('.', $ip);
	//
	//	// days since last activity
	//	if ($octets[1] > 14)
	//		return false;
	//
	//	// "threat score" (http://www.projecthoneypot.org/threat_info.php)
	//	if ($octets[2] < 5)
	//		return false;
	//
	//	return true;
	// }, 'dnsbl.httpbl.org'); // hide our access key

	// Skip checking certain IP addresses against blacklists (for troubleshooting or whatever)
	$config['dnsbl_exceptions'][] = '127.0.0.1';

	// To prevent bump attacks; returns the thread to last position after the last post is deleted.
	$config['anti_bump_flood'] = false;

	// Enable simple anti-spam measure. Requires the end-user to answer a question before making a post.
	// Works very well against uncustomized spam. Answers are case-insensitive.
	// $config['simple_spam'] = array (
	//	'question' => 'What\'s 2+3?',
	//	'answer' => '5'
	//);
	$config['simple_spam'] = false;

	$config['captcha'] = [
		// Can be false, 'recaptcha', 'hcaptcha' or 'native'.
		'provider' => 'native',
		/*
		 * If not false, the captcha is dynamically injected on the client if the web server set the `captcha-required`
		 * cookie to 1. The configuration value should be set the IP for which the captcha should be verified.
		 *
		 * Example:
		 *
		 * // Verify the captcha for users sending posts from the loopback address.
		 * $config['captcha']['dynamic'] = '127.0.0.1';
		 */
		'dynamic' => false,
		'recaptcha' => [
			'sitekey' => '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI',
			'secret' => '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe',
		],
		'hcaptcha' => [
			'sitekey' => '8bba9614-aa40-41ba-b868-a5d2058a2710',
			'secret' => 'ES_99ca690913774fc3a6d76ca47ecacaee',
		],
		'native' => [
			// New thread captcha. Require solving a captcha to post a thread.
			'new_thread_capt' => false
		]
	];

	// Ability to lock a board for normal users and still allow mods to post.  Could also be useful for making an archive board
	$config['board_locked'] = false;

	// If poster's proxy supplies X-Forwarded-For header, check if poster's real IP is banned.
	$config['proxy_check'] = false;

	// If poster's proxy supplies X-Forwarded-For header, save it for further inspection and/or filtering.
	$config['proxy_save'] = false;

	/*
	 * Custom filters detect certain posts and reject/ban accordingly. They are made up of a condition and an
	 * action (for when ALL conditions are met). As every single post has to be put through each filter,
	 * having hundreds probably isn't ideal as it could slow things down.
	 *
	 * By default, the custom filters array is populated with basic flood prevention conditions. This
	 * includes forcing users to wait at least 5 seconds between posts. To disable (or amend) these flood
	 * prevention settings, you will need to empty the $config['filters'] array first. You can do so by
	 * adding "$config['filters'] = array();" to inc/instance-config.php. Basic flood prevention used to be
	 * controlled solely by config variables such as $config['flood_time'] and $config['flood_time_ip'], and
	 * it still is, as long as you leave the relevant $config['filters'] intact. These old config variables
	 * still exist for backwards-compatability and general convenience.
	 *
	 * Read more: https://github.com/vichan-devel/vichan/wiki/flood_filters
	 */

	// Minimum time between between each post by the same IP address.
	$config['flood_time'] = 10;
	// Minimum time between between each post with the exact same content AND same IP address.
	$config['flood_time_ip'] = 120;
	// Same as above but by a different IP address. (Same content, not necessarily same IP address.)
	$config['flood_time_same'] = 30;

	// Minimum time between posts by the same IP address (all boards).
	$config['filters'][] = array(
		'condition' => array(
			'flood-match' => array('ip'), // Only match IP address
			'flood-time' => &$config['flood_time']
		),
		'action' => 'reject',
		'message' => &$config['error']['flood']
	);

	// Minimum time between posts by the same IP address with the same text.
	$config['filters'][] = array(
		'condition' => array(
			'flood-match' => array('ip', 'body'), // Match IP address and post body
			'flood-time' => &$config['flood_time_ip'],
			'!body' => '/^$/', // Post body is NOT empty
		),
		'action' => 'reject',
		'message' => &$config['error']['flood']
	);

	// Minimum time between posts with the same text. (Same content, but not always the same IP address.)
	$config['filters'][] = array(
		'condition' => array(
			'flood-match' => array('body'), // Match only post body
			'flood-time' => &$config['flood_time_same']
		),
		'action' => 'reject',
		'message' => &$config['error']['flood']
	);

	//max threads per hour
	$config['filters'][] = array(
		'condition' => array(
			'custom' => 'check_thread_limit'
		),
		'action' => 'reject',
		'message' => &$config['error']['too_many_threads']
	);

	// Example: Minimum time between posts with the same file hash.
	// $config['filters'][] = array(
	// 	'condition' => array(
	// 		'flood-match' => array('file'), // Match file hash
	// 		'flood-time' => 60 * 2 // 2 minutes minimum
	// 	),
	// 	'action' => 'reject',
	// 	'message' => &$config['error']['flood']
	// );

	// Example: Use the "flood-count" condition to only match if the user has made at least two posts with
	// the same content and IP address in the past 2 minutes.
	// $config['filters'][] = array(
	// 	'condition' => array(
	// 		'flood-match' => array('ip', 'body'), // Match IP address and post body
	// 		'flood-time' => 60 * 2, // 2 minutes
	// 		'flood-count' => 2 // At least two recent posts
	// 	),
	// 	'!body' => '/^$/',
	// 	'action' => 'reject',
	// 	'message' => &$config['error']['flood']
	// );

	// Example: Blocking an imaginary known spammer, who keeps posting a reply with the name "surgeon",
	// ending his posts with "regards, the surgeon" or similar.
	// $config['filters'][] = array(
	// 	'condition' => array(
	// 		'name' => '/^surgeon$/',
	// 		'body' => '/regards,\s+(the )?surgeon$/i',
	// 		'OP' => false
	// 	),
	// 	'action' => 'reject',
	// 	'message' => 'Go away, spammer.'
	// );

	// Example: Same as above, but issuing a 3-hour ban instead of just reject the post and
	// add an IP note with the message body
	// $config['filters'][] = array(
	// 	'condition' => array(
	// 		'name' => '/^surgeon$/',
	// 		'body' => '/regards,\s+(the )?surgeon$/i',
	// 		'OP' => false
	// 	),
	// 	'action' => 'ban',
	//	'add_note' => true,
	// 	'expires' => 60 * 60 * 3, // 3 hours
	// 	'reason' => 'Go away, spammer.'
	// );

	// Example: PHP 5.3+ (anonymous functions)
	// There is also a "custom" condition, making the possibilities of this feature pretty much endless.
	// This is a bad example, because there is already a "name" condition built-in.
	// $config['filters'][] = array(
	// 	'condition' => array(
	// 		'body' => '/h$/i',
	// 		'OP' => false,
	// 		'custom' => function($post) {
	// 			if($post['name'] == 'Anonymous')
	// 				return true;
	// 			else
	// 				return false;
	// 		}
	// 	),
	// 	'action' => 'reject'
	// );

	// Example: Expand shortened links in a post, looking for and blocking URLs that lead to an unwanted
        // endpoint. Many botspam posts include a variety of shortened URLs which all point to the same few
        // webhosts. You can use this filter to block the endpoint webhost instead of just the apparent URL.
	// $config['filters'][] = array(
	// 	'condition' => array(
	// 		'unshorten' => '/endpoint.net/i',
	// 	),
	// 	'action' => 'reject',
	// 	'message' => 'None of that, please.'
	// );

	// Filter flood prevention conditions ("flood-match") depend on a table which contains a cache of recent
	// posts across all boards. This table is automatically purged of older posts, determining the maximum
	// "age" by looking at each filter. However, when determining the maximum age, vichan does not look
	// outside the current board. This means that if you have a special flood condition for a specific board
	// (contained in a board configuration file) which has a flood-time greater than any of those in the
	// global configuration, you need to set the following variable to the maximum flood-time condition value.
	// Set to -1 to disable.
	// $config['flood_cache'] = 60 * 60 * 24; // 24 hours
	$config['flood_cache'] = -1;

/*
 * ====================
 *  Post settings
 * ====================
 */

	// Do you need a body for your reply posts?
	$config['force_body'] = true;
	// Do you need a body for new threads?
	$config['force_body_op'] = true;
	// Require an image for threads?
	$config['force_image_op'] = false;

	// Strip superfluous new lines at the end of a post.
	$config['strip_superfluous_returns'] = true;
	/// Strip combining characters from Unicode strings (eg. "Zalgo").  This will impact some non-English languages.
	$config['strip_combining_chars'] = true;
    // Maximum number of combining characters in a row allowed in Unicode strings so that they can still be used in moderation.
    // Requires $config['strip_combining_chars'] = true;
    $config['max_combining_chars'] = 3;

	// Maximum numbers of threads that can be created every hour on a board.
	$config['max_threads_per_hour'] = 300;
	// Maximum post body length.
	$config['max_body'] = 100000;
	// Maximum number of lines allowed in a post.
	$config['maximum_lines'] = 10000;
	// Maximum number of post body lines to show on the index page.
	$config['body_truncate'] = 15;
	// Maximum number of characters to show on the index page.
	$config['body_truncate_char'] = 2500;

	// Typically spambots try to post many links. Refuse a post with X links?
	$config['max_links'] = 20;
	// Maximum number of cites per post (prevents abuse, as more citations mean more database queries).
	$config['max_cites'] = 45;
	// Maximum number of cross-board links/citations per post.
	$config['max_cross'] = $config['max_cites'];

	// Track post citations (>>XX). Rebuilds posts after a cited post is deleted, removing broken links.
	// Puts a little more load on the database.
	$config['track_cites'] = true;

	// Maximum filename length (will be truncated).
	$config['max_filename_len'] = 255;
	// Maximum filename length to display (the rest can be viewed upon mouseover).
	$config['max_filename_display'] = 30;

	// Allow users to delete their own posts?
	$config['allow_delete'] = true;
	// How long after posting should you have to wait before being able to delete that post? (In seconds.)
	$config['delete_time'] = 10;
	// How long should a user be able to delete their post for? (In seconds. Set to 0 to disable.)
	$config['max_delete_time'] = 0;
	// Allow users to edit their own posts?
	$config['allow_edit'] = true;
	// Reply limit (stops bumping thread when this is reached).
	$config['reply_limit'] = 250;

	// Image hard limit (stops allowing new image replies when this is reached if not zero).
	$config['image_hard_limit'] = 0;
	// Reply hard limit (stops allowing new replies when this is reached if not zero).
	$config['reply_hard_limit'] = 0;


	$config['robot_enable'] = false;
	// Strip repeating characters when making hashes.
	$config['robot_strip_repeating'] = true;
	// Enabled mutes? vichan uses ROBOT9000's original 2^x implementation where x is the number of times
	// you have been muted in the past.
	$config['robot_mute'] = true;
	// How long before vichan forgets about a mute?
	$config['robot_mute_hour'] = 336; // 2 weeks
	// If you want to alter the algorithm a bit. Default value is 2.
	$config['robot_mute_multiplier'] = 2; // (n^x where x is the number of previous mutes)
	$config['robot_mute_descritpion'] = _('You have been muted for unoriginal content.');

	// Automatically convert things like "..." to Unicode characters ("…").
	$config['auto_unicode'] = true;
	// Whether to turn URLs into functional links.
	$config['markup_urls'] = true;

	// Optional URL prefix for links (eg. "http://anonym.to/?").
	$config['link_prefix'] = '';
	$config['url_ads'] = &$config['link_prefix'];	 // leave alias

	// Allow "uploading" images via URL as well. Users can enter the URL of the image and then vichan will
	// download it. Not usually recommended.
	$config['allow_upload_by_url'] = true;
	// The timeout for the above, in seconds.
	$config['upload_by_url_timeout'] = 15;

	// Enable early 404? With default settings, a thread would 404 if it was to leave page 3, if it had less
	// than 3 replies.
	$config['early_404'] = false;

	$config['early_404_page'] = 3;
	$config['early_404_replies'] = 5;
	$config['early_404_staged'] = false;

	// A wordfilter (sometimes referred to as just a "filter" or "censor") automatically scans users’ posts
	// as they are submitted and changes or censors particular words or phrases.

	// For a normal string replacement:
	// $config['wordfilters'][] = array('cat', 'dog');
	// Advanced raplcement (regular expressions):
	// $config['wordfilters'][] = array('/ca[rt]/', 'dog', true); // 'true' means it's a regular expression

	// Always act as if the user had typed "noko" into the email field.
	$config['always_noko'] = false;

	// Example: Custom tripcodes. The below example makes a tripcode of "#test123" evaluate to "!HelloWorld".
	// $config['custom_tripcode']['#test123'] = '!HelloWorld';
	// Example: Custom secure tripcode.
	// $config['custom_tripcode']['##securetrip'] = '!!somethingelse';

	//Disable tripcodes. This will make it so all new posts will act as if no tripcode exists.
	$config['disable_tripcodes'] = false;

	// Allow users to mark their image as a "spoiler" when posting. The thumbnail will be replaced with a
	// static spoiler image instead (see $config['spoiler_image']).
	$config['spoiler_images'] = true;

	$config['enable_adult_posts'] = true;

	// With the following, you can disable certain superfluous fields or enable "forced anonymous".

	// When true, all names will be set to $config['anonymous'].
	$config['field_disable_name'] = false;
	// When true, there will be no email field.
	$config['field_disable_email'] = false;
	// When true, there will be no subject field.
	$config['field_disable_subject'] = false;
	// When true, there will be no subject field for replies.
	$config['field_disable_reply_subject'] = false;
	// When true, a blank password will be used for files (not usable for deletion).
	$config['field_disable_password'] = false;

	// When true, users are instead presented a selectbox for email. Contains, blank, noko and sage.
	$config['field_email_selectbox'] = false;

	// When true, the sage won't be displayed
	$config['hide_sage'] = false;

	// Don't display user's email when it's not "sage"
	$config['hide_email'] = false;

	// Attach country flags to posts.
	$config['country_flags'] = true;

	// Allow the user to decide whether or not he wants to display his country
	$config['allow_no_country'] = false;

	// Load all country flags from one file
	$config['country_flags_condensed'] = true;
	$config['country_flags_condensed_css'] = 'static/flags/flags.css';

	// Allow the user choose a /pol/-like user_flag that will be shown in the post. For the user flags, please be aware
	// that you will have to disable BOTH country_flags and contry_flags_condensed optimization (at least on a board
	// where they are enabled).
	$config['user_flag'] = false;

	// List of user_flag the user can choose. Flags must be placed in the directory set by $config['uri_flags']
	$config['user_flags'] = array();
	/* example: 
	$config['user_flags'] = array (
		'nz' => 'Nazi',
		'cm' => 'Communist',
		'eu' => 'Europe'
	);
	*/

	// Maximum number inline of dice rolls per markup.
	$config['max_roll_count'] = 50;

	// Allow dice rolling: an email field of the form "dice XdY+/-Z" will result in X Y-sided dice rolled and summed,
	// with the modifier Z added, with the result displayed at the top of the post body.
	$config['allow_roll'] = false;

	// Use semantic URLs for threads, like /b/res/12345/daily-programming-thread.html
	$config['slugify'] = false;

	// Max size for slugs
	$config['slug_max_size'] = 80;

/*
* ====================
*  Ban settings
* ====================
*/

	// Require users to see the ban page at least once for a ban even if it has since expired.
	$config['require_ban_view'] = true;

	// Show the post the user was banned for on the "You are banned" page.
	$config['ban_show_post'] = false;

	// Optional HTML to append to "You are banned" pages. For example, you could include instructions and/or
	// a link to an email address or IRC chat room to appeal the ban.
	$config['ban_page_extra'] = '';

	// Pre-configured ban reasons that pre-fill the ban form when clicked.
	// $config['premade_ban_reasons'] = array(
	// 	array(
	// 		'reason' => 'Low-quality posting',
	// 		'length' =>  '1d'
	// 	),
	// 	array(
	// 		'reason' => 'Off-topic',
	// 		'length' => '1d'
	// 	),
	// 	array(
	// 		'reason' => 'Ban evasion',
	// 		'length' => '30d'
	// 	),
	// 	array(
	// 		'reason' => 'Illegal content',
	// 		'length' => ''
	// 	)
	//);
	$config['premade_ban_reasons'] = false;

	// How often (minimum) to purge the ban list of expired bans (which have been seen).
	$config['purge_bans'] = 60 * 60 * 12; // 12 hours

	// Allow users to appeal bans through vichan.
	$config['ban_appeals'] = false;

	// Do not allow users to appeal bans that are shorter than this length (in seconds).
	$config['ban_appeals_min_length'] = 60 * 60 * 6; // 6 hours

	// How many ban appeals can be made for a single ban?
	$config['ban_appeals_max'] = 1;

	// Maximum character length of appeal.
	$config['ban_appeal_max_chars'] = 250;

	// Show moderator name on ban page.
	$config['show_modname'] = false;

/*
 * ====================
 *  Markup settings
 * ====================
 */

	$config['markup'] = [
		// Inline dice roll markup.
		[ "/!([-+]?\d+)?([d])([-+]?\d+)([-+]\d+)?/iu", fn($m) => inline_dice_roll_markup($m, 'static/d10.svg') ],
		// "Wiki" markup syntax ($config['wiki_markup'] in pervious versions):
		[ "/'''(.+?)'''/", "<strong>\$1</strong>" ],
		[ "/''(.+?)''/", "<em>\$1</em>" ],
		[ "/\*\*(.+?)\*\*/", "<span class=\"spoiler\">\$1</span>" ],
		[ "/^[ |\t]*==(.+?)==[ |\t]*$/m", "<span class=\"heading\">\$1</span>" ],
	];

	// Code markup. This should be set to a regular expression, using tags you want to use. Examples:
	// "/\[code\](.*?)\[\/code\]/is"
	// "/```([a-z0-9-]{0,20})\n(.*?)\n?```\n?/s"
	$config['markup_code'] = false;

	// Repair markup with HTML Tidy. This may be slower, but it solves nesting mistakes. vichan, at the
	// time of writing this, can not prevent out-of-order markup tags (eg. "**''test**'') without help from
	// HTML Tidy.
	$config['markup_repair_tidy'] = false;

	// Use 'bare' config option of tidy::repairString.
	// This option replaces some punctuation marks with their ASCII counterparts.
	// Dashes are replaced with (single) hyphens, for example.
	$config['markup_repair_tidy_bare'] = true;

	// Always regenerate markup. This isn't recommended and should only be used for debugging; by default,
	// vichan only parses post markup when it needs to, and keeps post-markup HTML in the database. This
	// will significantly impact performance when enabled.
	$config['always_regenerate_markup'] = false;

/*
 * ====================
 *  Image settings
 * ====================
 */
	// Maximum number of images allowed. Increasing this number enabled multi image.
	// If you make it more than 1, make sure to enable the below script for the post form to change.
	// $config['additional_javascript'][] = 'js/multi-image.js';
	$config['max_images'] = 1;

	// Method to use for determing the max filesize.
	// "split" means that your max filesize is split between the images. For example, if your max filesize
	// is 2MB, the filesizes of all files must add up to 2MB for it to work.
	// "each" means that each file can be 2MB, so if your max_images is 3, each post could contain 6MB of
	// images. "split" is recommended.
	$config['multiimage_method'] = 'split';

	// For resizing, maximum thumbnail dimensions.
	$config['thumb_width'] = 255;
	$config['thumb_height'] = 255;
	// Maximum thumbnail dimensions for thread (OP) images.
	$config['thumb_op_width'] = 255;
	$config['thumb_op_height'] = 255;

	// Thumbnail extension ("png" recommended). Leave this empty if you want the extension to be inherited
	// from the uploaded file.
	$config['thumb_ext'] = 'png';

	// Maximum amount of animated GIF frames to resize (more frames can mean more processing power). A value
	// of "1" means thumbnails will not be animated. Requires $config['thumb_ext'] to be 'gif' (or blank) and
	//  $config['thumb_method'] to be 'imagick', 'convert', or 'convert+gifsicle'. This value is not
	// respected by 'convert'; will just resize all frames if this is > 1.
	$config['thumb_keep_animation_frames'] = 1;

	/*
	 * Thumbnailing method:
	 *
	 *   'gd'		   PHP GD (default). Only handles the most basic image formats (GIF, JPEG, PNG).
	 *				  GD is a prerequisite for vichan no matter what method you choose.
	 *
	 *   'imagick'	  PHP's ImageMagick bindings. Fast and efficient, supporting many image formats.
	 *				  A few minor bugs. http://pecl.php.net/package/imagick
	 *
	 *   'convert'	  The command line version of ImageMagick (`convert`). Fixes most of the bugs in
	 *				  PHP Imagick. `convert` produces the best still thumbnails and is highly recommended.
	 *
	 *   'gm'		   GraphicsMagick (`gm`) is a fork of ImageMagick with many improvements. It is more
	 *				  efficient and gets thumbnailing done using fewer resources.
	 *
	 *   'convert+gifscale'
	 *	OR  'gm+gifsicle'  Same as above, with the exception of using `gifsicle` (command line application)
	 *					   instead of `convert` for resizing GIFs. It's faster and resulting animated
	 *					   thumbnails have less artifacts than if resized with ImageMagick.
	 */
	$config['thumb_method'] = 'gd';
	// $config['thumb_method'] = 'convert';

	// Command-line options passed to ImageMagick when using `convert` for thumbnailing. Don't touch the
	// placement of "%s" and "%d".
	$config['convert_args'] = '-size %dx%d %s -thumbnail %dx%d -auto-orient +profile "*" %s';

	// Strip EXIF metadata from JPEG files.
	$config['strip_exif'] = false;
	// Use the command-line `exiftool` tool to strip EXIF metadata without decompressing/recompressing JPEGs.
	// Ignored when $config['redraw_image'] is true.
	$config['use_exiftool'] = false;

	// Redraw the image to strip any excess data (commonly ZIP archives) WARNING: This might strip the
	// animation of GIFs, depending on the chosen thumbnailing method. It also requires recompressing
	// the image, so more processing power is required.
	$config['redraw_image'] = false;

	// Automatically correct the orientation of JPEG files using -auto-orient in `convert`. This only works
	// when `convert` or `gm` is selected for thumbnailing. Again, requires more processing power because
	// this basically does the same thing as $config['redraw_image']. (If $config['redraw_image'] is enabled,
	// this value doesn't matter as $config['redraw_image'] attempts to correct orientation too.)
	$config['convert_auto_orient'] = false;

	// Regular expression to check for an XSS exploit with IE 6 and 7. To disable, set to false.
	// Details: https://github.com/savetheinternet/Tinyboard/issues/20
	$config['ie_mime_type_detection'] = '/<(?:body|head|html|img|plaintext|pre|script|table|title|a href|channel|scriptlet)/i';

	// Allowed image file extensions.
	$config['allowed_ext'] = [
		'jpg',
		'jpeg',
		'bmp',
		'gif',
		'png',
		'webp',
		'webm'
	];
	// $config['allowed_ext'][] = 'svg';

	// Allowed extensions for OP. Inherits from the above setting if set to false. Otherwise, it overrides both allowed_ext and
	// allowed_ext_files (filetypes for downloadable files should be set in allowed_ext_files as well). This setting is useful
	// for creating fileboards.
	$config['allowed_ext_op'] = false;

	// Allowed additional file extensions (not images; downloadable files).
	$config['allowed_ext_files'][] = 'txt';
	$config['allowed_ext_files'][] = 'zip';
	$config['allowed_ext_files'][] = 'mp4';
	$config['allowed_ext_files'][] = 'webm';
	$config['allowed_ext_files'][] = 'mp3';


	// An alternative function for generating image filenames, instead of the default UNIX timestamp.
	// $config['filename_func'] = function($post) {
	//	  return sprintf("%s", time() . substr(microtime(), 2, 3));
	// };

	// Thumbnail to use for the non-image file uploads.
	$config['file_icons'] = [
		'default' => 'file.png',
		'zip' => 'zip.png',
		'webm' => 'video.png',
		'mp4' => 'video.png'
	];
	// Example: Custom thumbnail for certain file extension.
	// $config['file_icons']['extension'] = 'some_file.png';

	// Location of above images.
	$config['file_thumb'] = 'static/%s';
	// Location of thumbnail to use for spoiler images.
	$config['spoiler_image'] = 'static/spoiler.png';
	// Location of thumbnail to use for deleted images.
	$config['image_deleted'] = 'static/deleted.png';
	// Location of thumbnail to use for no images.
	$config['no_image'] = 'static/no_image.png';

	// When a thumbnailed image is going to be the same (in dimension), just copy the entire file and use
	// that as a thumbnail instead of resizing/redrawing.
	$config['minimum_copy_resize'] = false;

	// Maximum image upload size in bytes.
	$config['max_filesize'] = 10 * 1024 * 1024; // 10MB
	// Maximum image dimensions.
	$config['max_width'] = 10000;
	$config['max_height'] = $config['max_width'];
	// Reject duplicate image uploads.
	$config['image_reject_repost'] = true;
	// Reject duplicate image uploads within the same thread. Doesn't change anything if
	//  $config['image_reject_repost'] is true.
	$config['image_reject_repost_in_thread'] = false;

	// Display the aspect ratio of uploaded files.
	$config['show_ratio'] = false;
	// Display the file's original filename.
	$config['show_filename'] = true;

	// WebM Settings
	$config['webm'] = [
		'use_ffmpeg' => false,
		'allow_audio' => false,
		'max_length' => 120,
		'ffmpeg_path' => 'ffmpeg',
		'ffprobe_path' => 'ffprobe'
	];

	// Display image identification links for ImgOps, regex.info/exif, Google Images and iqdb.
	$config['image_identification'] = false;
	// Which of the identification links to display. Only works if $config['image_identification'] is true.
	$config['image_identification_imgops'] = true;
	$config['image_identification_exif'] = true;
	$config['image_identification_google'] = true;
	$config['image_identification_yandex'] = true;
	// Anime/manga search engine.
	$config['image_identification_iqdb'] = false;

	// Set this to true if you're using a BSD
	$config['bsd_md5'] = false;

	// Set this to true if you're using Linux and you can execute `md5sum` binary.
	$config['gnu_md5'] = false;

	// Use Tesseract OCR to retrieve text from images, so you can use it as a spamfilter.
	$config['tesseract_ocr'] = false;

	// Tesseract parameters
	$config['tesseract_params'] = '';

	// Tesseract preprocess command
	$config['tesseract_preprocess_command'] = 'convert -monochrome %s -';

	// Number of posts in a "View Last X Posts" page
	$config['noko50_count'] = 50;
	// Number of posts a thread needs before it gets a "View Last X Posts" page.
	// Set to an arbitrarily large value to disable.
	$config['noko50_min'] = 100;
/*
 * ====================
 *  Board settings
 * ====================
 */

	// Maximum amount of threads to display per page.
	$config['threads_per_page'] = 10;
	// Maximum number of pages. Content past the last page is automatically purged.
	$config['max_pages'] = 10;
	// Replies to show per thread on the board index page.
	$config['threads_preview'] = 5;
	// Same as above, but for stickied threads.
	$config['threads_preview_sticky'] = 1;

	// How to display the URI of boards. Usually '/%s/' (/b/, /mu/, etc). This doesn't change the URL. Find
	//  $config['board_path'] if you wish to change the URL.
	$config['board_abbreviation'] = '/%s/';

	// The default name (ie. Anonymous). Can be an array - in that case it's picked randomly from the array.
	// Example: $config['anonymous'] = array('Bernd', 'Senpai', 'Jonne', 'ChanPro');
	$config['anonymous'] = 'Anonymous';

	// Number of reports you can create at once.
	$config['report_limit'] = 3;

	// Maximum number of characters per report.
	$config['report_max_length'] = 30;

	//the amount of reports per page.
	$config['mod']['recent_reports'] = 5;

	// Allow unfiltered HTML in board subtitle. This is useful for placing icons and links.
	$config['allow_subtitle_html'] = false;

/*
 * ====================
 *  Display settings
 * ====================
 */

	// vichan has been translated into a few langauges. See inc/locale for available translations.
	$config['locale'] = 'en'; // (en, ru_RU.UTF-8, fi_FI.UTF-8, pl_PL.UTF-8)

	// Timezone to use for displaying dates/times.
	$config['timezone'] = 'America/Los_Angeles';
	// The format string passed to DateTime::format() for displaying dates. ISO 8601-like by default.
	// https://www.php.net/manual/en/datetime.format.php
	$config['post_date'] = 'm/d/y (D) H:i:s';
	// Same as above, but used for "you are banned' pages.
	$config['ban_date'] = 'l j F, Y';

	// The names on the post buttons. (On most imageboards, these are both just "Post").
	$config['button_newtopic'] = _('New Topic');
	$config['button_reply'] = _('New Reply');

	// Assign each poster in a thread a unique ID, shown by "ID: xxxxx" before the post number.
	$config['poster_ids'] = false;
	// Number of characters in the poster ID (maximum is 40).
	$config['poster_id_length'] = 5;

	// Show thread subject in page title.
	$config['thread_subject_in_title'] = false;

	// Additional lines added to the footer of all pages.
	$config['footer'][] = _('All trademarks, copyrights, comments, and images on this page are owned by and are the responsibility of their respective parties.');

	// Characters used to generate a random password (with Javascript).
	$config['genpassword_chars'] = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+';

	// Banner settings.
	// Banners are rotating, random images displayed to users at the top of thread pages and the catalog.
	// You should upload your banners to static/banners.
	$config['url_banner'] = '/banner.php';	// Custom script may be used.
	// Setting the banner dimensions stops the page shifting as it loads. If you have banners of various different sizes, unset these.
	$config['banner_width'] = 300;
	$config['banner_height'] = 100;

	// Custom stylesheets available for the user to choose. See the "stylesheets/" folder for a list of
	// available stylesheets (or create your own).
	$config['stylesheets'] = [
		// Default; there is no additional/custom stylesheet for this.
		'Yotsuba B' => '',
		'Yotsuba' => 'yotsuba.css'
	];
	// $config['stylesheets']['Futaba'] = 'futaba.css';
	// $config['stylesheets']['Dark'] = 'dark.css';

	// The prefix for each stylesheet URI. Defaults to $config['root']/stylesheets/
	// $config['uri_stylesheets'] = 'http://static.example.org/stylesheets/';

	// The default stylesheet to use.
	$config['default_stylesheet'] = array('Yotsuba B', $config['stylesheets']['Yotsuba B']);

	// Make stylesheet selections board-specific.
	$config['stylesheets_board'] = false;

	// Use Font-Awesome for displaying lock and pin icons, instead of the images in static/.
	// http://fortawesome.github.io/Font-Awesome/icon/pushpin/
	// http://fortawesome.github.io/Font-Awesome/icon/lock/
	$config['font_awesome'] = true;
	$config['font_awesome_css'] = 'stylesheets/font-awesome/css/font-awesome.min.css';

	/*
	 * For lack of a better name, “boardlinks” are those sets of navigational links that appear at the top
	 * and bottom of board pages. They can be a list of links to boards and/or other pages such as status
	 * blogs and social network profiles/pages.
	 *
	 * "Groups" in the boardlinks are marked with square brackets. vichan allows for infinite recursion
	 * with groups. Each array() in $config['boards'] represents a new square bracket group.
	 */

	// $config['boards'] = array(
	// 	array('a', 'b'),
	// 	array('c', 'd', 'e', 'f', 'g'),
	// 	array('h', 'i', 'j'),
	// 	array('k', array('l', 'm')),
	// 	array('status' => 'http://status.example.org/')
	// );

	$config['boards'] = array(
		"icon_hikichan" => array("index" => "index.html"), # would refer to /static/icons/vichan.png
		"Boards" => array('b'),
		"Linkage" => array('a', "Offsite board name" => '//int.vichan.net/s/'),
		"d_Mod" => array("mod" => "/hikichan/mod?/"),
		"fa_search" => array("Search" => "/hikichan/search.php"),# would refer to a search 
														# font-awesome icon
	   );

	// Whether or not to put brackets around the whole board list
	$config['boardlist_wrap_bracket'] = false;

	// Show page navigation links at the top as well.
	$config['page_nav_top'] = false;

	// Show "Catalog" link in page navigation. Use with the Catalog theme. Set to false to disable.
	$config['catalog_link'] = 'catalog.html';

	// Board categories. Only used in the "Categories" theme.
	// $config['categories'] = array(
	// 	'Group Name' => array('a', 'b', 'c'),
	// 	'Another Group' => array('d')
	// );
	// Optional for the Categories theme. This is an array of name => (title, url) groups for categories
	// with non-board links.
	// $config['custom_categories'] = array(
	// 	'Links' => array(
	// 		'Github' => 'https://github.com/my/project',
	// 		'Donate' => 'donate.html'
	// 	)
	// );

	// Automatically remove unnecessary whitespace when compiling HTML files from templates.
	$config['minify_html'] = true;

	/*
	 * Advertisement HTML to appear at the top and bottom of board pages.
	 */

	// $config['ad'] = array(
	//	'top' => '',
	//	'bottom' => '',
	// );

	// Display flags (when available). This config option has no effect unless poster flags are enabled (see
	// $config['country_flags']). Disable this if you want all previously-assigned flags to be hidden.
	$config['display_flags'] = true;

	// Location of post flags/icons (where "%s" is the flag name). Defaults to static/flags/%s.png.
	// $config['uri_flags'] = 'http://static.example.org/flags/%s.png';

	// Width and height (and more?) of post flags. Can be overridden with the vichan post modifier:
	// <tinyboard flag style>.
	$config['flag_style'] = 'width:16px;height:11px;';

	// Lazy loading
	// https://developer.mozilla.org/en-US/docs/Web/Performance/Lazy_loading
	$config['content_lazy_loading'] = false;

/*
 * ====================
 *  Javascript
 * ====================
 */

	// Additional Javascript files to include on board index and thread pages. See js/ for available scripts.
	// $config['additional_javascript'][] = 'js/jquery.min.js';
	// $config['additional_javascript'][] = 'js/inline-expanding.js';
	// $config['additional_javascript'][] = 'js/local-time.js';

	// Some scripts require jQuery. Check the comments in script files to see what's needed. When enabling
	// jQuery, you should first empty the array so that "js/query.min.js" can be the first, and then re-add
	// "js/inline-expanding.js" or else the inline-expanding script might not interact properly with other
	// scripts.
	// $config['additional_javascript'] = array();
	// $config['additional_javascript'][] = 'js/jquery.min.js';
	// $config['additional_javascript'][] = 'js/inline-expanding.js';
	// $config['additional_javascript'][] = 'js/auto-reload.js';
	// $config['additional_javascript'][] = 'js/post-hover.js';
	// $config['additional_javascript'][] = 'js/style-select.js';
	// $config['additional_javascript'][] = 'js/captcha.js';

	// Where these script files are located on the web. Defaults to $config['root'].
	// $config['additional_javascript_url'] = 'http://static.example.org/vichan-javascript-stuff/';

	// Compile all additional scripts into one file ($config['file_script']) instead of including them seperately.
	$config['additional_javascript_compile'] = false;

	// Minify Javascript using http://code.google.com/p/minify/.
	$config['minify_js'] = false;

	// Version number for main.js (or $config['url_javascript']).
	// You can use this to bypass the user's browsers and CDN caches.
	$config['resource_version'] = 0;

	// Dispatch thumbnail loading and image configuration with JavaScript. It will need a certain javascript
	// code to work.
	$config['javascript_image_dispatch'] = false;

/*
 * ====================
 *  Video embedding
 * ====================
 */

	// Enable embedding (see below).
	$config['enable_embedding'] = true;

	// Enable voice recording (see below).
	$config['enable_voice'] = true;
	
	// Enable making polls.
	$config['enable_poll'] = true;

	// Custom embedding (YouTube, vimeo, etc.)
	// It's very important that you match the entire input (with ^ and $) or things will not work correctly.
	// Be careful when creating a new embed, because depending on the URL you end up exposing yourself to an XSS.
		$config['embedding'] = array(
		array(
			'/^https?:\/\/(\w+\.)?(youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9\-_]{10,11})?$/i',
			'<iframe style="float: left; margin: 10px 20px;" width="%%tb_width%%" height="%%tb_height%%" frameborder="0" id="ytplayer" src="https://www.youtube.com/embed/$3"></iframe>'
		),		
		array(
			'/^https?:\/\/(\w+\.)?vimeo\.com\/(\d{2,10})(\?.+)?$/i',
			'<iframe style="float: left; margin: 10px 20px;" width="%%tb_width%%" height="%%tb_height%%" frameborder="0" src="https://player.vimeo.com/video/$2"></iframe>'
		),
		array(
			'/^https?:\/\/(\w+\.)?dailymotion\.com\/video\/([a-zA-Z0-9]{2,10})(_.+)?$/i',
			'<iframe style="float: left; margin: 10px 20px;" width="%%tb_width%%" height="%%tb_height%%" frameborder="0" src="https://www.dailymotion.com/embed/video/$2" allowfullscreen></iframe>'
		),
		array(
			'/^https?:\/\/(www\.)?rumble\.com\/embed\/([a-zA-Z0-9]+)(\/\?[^\'"<>]*)?$/i',
			'<iframe class="rumble" width="%%tb_width%%" height="%%tb_height%%" src="https://rumble.com/embed/$2/" frameborder="0" allowfullscreen></iframe>'
		),
		array(
			'/^https?:\/\/(www\.)?bitchute\.com\/(?:video|embed)\/([a-zA-Z0-9]+)(\/)?(\?[^\'"<>]*)?$/i',
			'<iframe allowfullscreen="true" width="%%tb_width%%" height="%%tb_height%%" scrolling="no" frameborder="0" style="border: none;" src="https://www.bitchute.com/embed/$2"></iframe>'
		),
		array(
        		'/^https?:\/\/(?:www\.)?odysee\.com\/(?:@[^\/]+\/)?([-a-zA-Z0-9_]+:[a-zA-Z0-9]+)(\/)?(\?[^\'"<>]*)?$/i',
        		'<iframe width="%%tb_width%%" height="%%tb_height%%" src="https://odysee.com/$/embed/$1" allowfullscreen></iframe>'
		),
		array(
				'/^https?:\/\/(www\.)?kick\.com\/([a-zA-Z0-9_]+)(\?[^\'"<>]*)?$/i',
				'<iframe src="https://player.kick.com/$2" height="%%tb_height%%" width="%%tb_width%%" frameborder="0" scrolling="no" allowfullscreen="true"></iframe>'
		),
		array(
			'/^https?:\/\/(www\.)?tiktok\.com\/@([a-zA-Z0-9_.]+)\/video\/([0-9]+)(\?[^\'"<>]*)?$/i',
			'<blockquote class="tiktok-embed" cite="https://www.tiktok.com/@$2/video/$3" data-video-id="$3" style="max-width: %%tb_width%%px;min-width: 325px;"><section></section></blockquote><script async src="https://www.tiktok.com/embed.js"></script>'
		),
		/*
  		//Both TikTok and Instagram are commented out since they contain some extra scripting you might not want natively on your website.
		array(
			'/^https?:\/\/(www\.)?tiktok\.com\/@([a-zA-Z0-9_.]+)\/video\/([0-9]+)(\?[^\'"<>]*)?$/i',
			'<blockquote class="tiktok-embed" cite="https://www.tiktok.com/@$2/video/$3" data-video-id="$3" style="max-width: %%tb_width%%px;min-width: 325px;"><section></section></blockquote><script async src="https://www.tiktok.com/embed.js"></script>'
		),
		array(
			'/^https?:\/\/(www\.)?instagram\.com\/(p|reel|tv)\/([a-zA-Z0-9_-]+)(\/)?(\?[^\'"<>]*)?$/i',
			'<blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/$2/$3/" data-instgrm-version="14" style="max-width: %%tb_width%%px; min-width: 326px; width: 100%;"></blockquote><script async src="//www.instagram.com/embed.js"></script>'
		),
  		*/
		array(
			'/^https?:\/\/(\w+\.)?(vocaroo\.com\/|voca\.ro\/)([a-zA-Z0-9]{2,12})$/i',
			'<iframe style="float: left; margin: 10px 20px;" width="300" height="60" frameborder="0" src="https://vocaroo.com/embed/$3"></iframe>'
		),
				
	);

	// Embedding width and height.
	$config['embed_width'] = 300;
	$config['embed_height'] = 246;

/*
 * ====================
 *  Error messages
 * ====================
 */

	$config['error'] = [
		// General error messages
		'bot' 					=> _('You look like a bot.'),
		'referer'				=> _('Your browser sent an invalid or no HTTP referer.'),
		'toolong'				=> _('The %s field was too long.'),
		'toolong_body'			=> _('The body was too long.'),
		'tooshort_body'			=> _('The body was too short or empty.'),
		'toomanylines'			=> _('Your post contains too many lines!'),
		'noimage'				=> _('You must upload an image.'),
		'toomanyimages' 		=> _('You have attempted to upload too many images!'),
		'nomove'				=> _('The server failed to handle your upload.'),
		'fileext'				=> _('Unsupported image format.'),
		'noboard'				=> _('Invalid board!'),
		'nonexistant'			=> _('Thread specified does not exist.'),
		'nopost'				=> _('Post specified does not exist.'),
		'locked'				=> _('Thread locked. You may not reply at this time.'),
		'reply_hard_limit'		=> _('Thread has reached its maximum reply limit.'),
		'image_hard_limit'		=> _('Thread has reached its maximum image limit.'),
		'nopost'				=> _('You didn\'t make a post.'),
		'flood'					=> _('Flood detected; Post discarded.'),
		'too_many_threads'		=> _('The hourly thread limit has been reached. Please post in an existing thread.'),
		'spam'					=> _('Your request looks automated; Post discarded.'),
		'simple_spam'			=> _('You must answer the question to make a new thread. See the last field.'),
		'unoriginal'			=> _('Unoriginal content!'),
		'muted'					=> _('Unoriginal content! You have been muted for %d seconds.'),
		'youaremuted'			=> _('You are muted! Expires in %d seconds.'),
		'dnsbl'					=> _('Your IP address is listed in %s.'),
		'toomanylinks'			=> _('Too many links; flood detected.'),
		'toomanycites'			=> _('Too many cites; post discarded.'),
		'toomanycross'			=> _('Too many cross-board links; post discarded.'),
		'nodelete'				=> _('You didn\'t select anything to delete.'),
		'noreport'				=> _('You didn\'t select anything to report.'),
		'toolongreport'			=> _('The reason was too long.'),
		'toomanyreports'		=> _('You can\'t report that many posts at once.'),
		'noban'					=> _('That ban doesn\'t exist or is not for you.'),
		'tooshortban'			=> _('You cannot appeal a ban of this length.'),
		'toolongappeal'			=> _('The appeal was too long.'),
		'toomanyappeals'		=> _('You cannot appeal this ban again.'),
		'pendingappeal'			=> _('There is already a pending appeal for this ban.'),
		'invalidpassword'		=> _('Wrong password…'),
		'invalidimg'			=> _('Invalid image.'),
		'phpfileserror'			=> _('Upload failure (file #%index%): Error code %code%. Refer to <a href=>"http://php.net/manual/en/features.file-upload.errors.php">http://php.net/manual/en/features.file-upload.errors.php</a>; post discarded.'),
		'unknownext'			=> _('Unknown file extension.'),
		'filesize'				=> _('Maximum file size: %maxsz% bytes<br>Your file\'s size: %filesz% bytes'),
		'maxsize'				=> _('The file was too big.'),
		'genwebmerror'			=> _('There was a problem processing your webm.'),
		'invalidwebm' 			=> _('Invalid webm uploaded.'),
		'webmhasaudio' 			=> _('The uploaded webm contains an audio or another type of additional stream.'),
		'webmtoolong'			=>_('The uploaded webm is longer than %d seconds.'),
		'fileexists'			=> _('That file <a href=>"%s">already exists</a>!'),
		'fileexistsinthread'	=> _('That file <a href=>"%s">already exists</a> in this thread!'),
		'delete_too_soon'		=> _('You\'ll have to wait another %s before deleting that.'),
		'delete_too_late'		=> _('You cannot delete a post this old.'),
		'mime_exploit'			=> _('MIME type detection XSS exploit (IE) detected; post discarded.'),
		'invalid_embed'			=> _('Couldn\'t make sense of the URL of the video you tried to embed.'),
		'captcha'				=> _('You seem to have mistyped the verification.'),
		'flag_undefined'		=> _('The flag %s is undefined, your PHP version is too old!'),
		'flag_wrongtype'		=> _('defined_flags_accumulate(): The flag %s is of the wrong type!'),
		'remote_io_error'		=> _('IO error while interacting with a remote service.'),
		'local_io_error'		=> _('IO error while interacting with a local resource or service.'),

		// Moderator errors
		'toomanyunban'	=> _('You are only allowed to unban %s users at a time. You tried to unban %u users.'),
		'invalid'		=> _('Invalid username and/or password.'),
		'insecure'		=> _('Login on insecure connections is disabled.'),
		'notamod'		=> _('You are not a mod…'),
		'invalidafter'	=> _('Invalid username and/or password. Your user may have been deleted or changed.'),
		'malformed'		=> _('Invalid/malformed cookies.'),
		'missedafield'	=> _('Your browser didn\'t submit an input when it should have.'),
		'required'		=> _('The %s field is required.'),
		'invalidfield'	=> _('The %s field was invalid.'),
		'boardexists'	=> _('There is already a %s board.'),
		'noaccess'		=> _('You don\'t have permission to do that.'),
		'invalidpost'	=> _('That post doesn\'t exist…'),
		'404'			=> _('Page not found.'),
		'modexists'		=> _('That mod <a href="?/users/%d">already exists</a>!'),
		'invalidtheme'	=> _('That theme doesn\'t exist!'),
		'csrf'			=> _('Invalid security token! Please go back and try again.'),
		'badsyntax'		=> _('Your code contained PHP syntax errors. Please go back and correct them. PHP says: ')
	];

/*
 * =========================
 *  Directory/file settings
 * =========================
 */

	// The root directory, including the trailing slash, for vichan.
	// Examples: '/', 'http://boards.chan.org/', '/chan/'.
	if (isset($_SERVER['REQUEST_URI'])) {
		$request_uri = $_SERVER['REQUEST_URI'];
		if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '')
			$request_uri = substr($request_uri, 0, - 1 - strlen($_SERVER['QUERY_STRING']));
		$config['root']	 = str_replace('\\', '/', dirname($request_uri)) == '/'
			? '/' : str_replace('\\', '/', dirname($request_uri)) . '/';
		unset($request_uri);
	} else
		$config['root'] = '/'; // CLI mode

	// The scheme and domain. This is used to get the site's absolute URL (eg. for image identification links).
	// If you use the CLI tools, it would be wise to override this setting.
	$config['domain'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://')
		 . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost');

	// If for some reason the folders and static HTML index files aren't in the current working direcotry,
	// enter the directory path here. Otherwise, keep it false.
	$config['root_file'] = false;

	// Location of primary files.
	$config['file_index'] = 'index.html';
	$config['file_page'] = '%d.html'; // NB: page is both an index page and a thread
	$config['file_catalog'] = 'catalog.html';
	$config['file_page50'] = '%d+50.html';
	$config['file_page_slug'] = '%d-%s.html';
	$config['file_page50_slug'] = '%d-%s+50.html';
	$config['file_mod'] = 'mod.php';
	$config['file_post'] = 'post.php';
	$config['file_script'] = 'main.js';

	$config['file_board_index'] = 'index.html';
	$config['file_page_template'] = 'page.html';
	$config['file_report'] = 'report.html';
	$config['file_error'] = 'error.html';
	$config['file_login'] = 'login.html';
	$config['file_banned'] = 'banned.html';
	$config['file_fileboard'] = 'fileboard.html';
	$config['file_thread'] = 'thread.html';
	$config['file_post_reply'] = 'post_reply.html';
	$config['file_post_thread'] = 'post_thread.html';
	$config['file_post_thread_fileboard'] = 'post_thread_fileboard.html';

	// Mod page file settings
	$config['file_mod_dashboard'] = 'mod/dashboard.html';
	$config['file_mod_login'] = 'mod/login.html';
	$config['file_mod_register'] = 'mod/register.html';
	$config['file_mod_confim'] = 'mod/confirm.html';
	$config['file_mod_board'] = 'mod/board.html';
	$config['file_mod_news'] = 'mod/news.html';
	$config['file_mod_log'] = 'mod/log.html';

	$config['file_mod_view_ip'] = 'mod/view_ip.html';
	$config['file_mod_ban_form'] = 'mod/ban_form.html';
	$config['file_mod_ban_list'] = 'mod/ban_list.html';
	$config['file_mod_ban_appeals'] = 'mod/ban_appeals.html';

	$config['file_mod_noticeboard'] = 'mod/noticeboard.html';
	$config['file_mod_search_results'] = 'mod/search_results.html';

	$config['file_mod_move'] = 'mod/move.html';
	$config['file_mod_move_reply'] = 'mod/move_reply.html';
	$config['file_mod_edit_post_form'] = 'mod/edit_post_form.html';

	$config['file_mod_user'] = 'mod/user.html';
	$config['file_mod_users'] = 'mod/users.html';

	$config['file_mod_pm'] = 'mod/pm.html';
	$config['file_mod_new_pm'] = 'mod/new_pm.html';
	$config['file_mod_inbox'] = 'mod/inbox.html';

	$config['file_mod_rebuilt'] = 'mod/rebuilt.html';
	$config['file_mod_rebuild'] = 'mod/rebuild.html';
	$config['file_mod_report'] = 'mod/report.html';
	$config['file_mod_reports'] = 'mod/reports.html';
	$config['file_mod_recent_posts'] = 'mod/recent_posts.html';

	$config['file_mod_config_editor'] = 'mod/config-editor.html';
	$config['file_mod_config_editor_php'] = 'mod/config-editor-php.html';

	$config['file_mod_themes'] = 'mod/themes.html';
	$config['file_mod_theme_installed'] = 'mod/theme_installed.html';
	$config['file_mod_theme_config'] = 'mod/theme_config.html';
	$config['file_mod_theme_rebuilt'] = 'mod/theme_rebuilt.html';

	$config['file_mod_pages'] = 'mod/pages.html';
	$config['file_mod_edit_page'] = 'mod/edit_page.html';

	$config['file_mod_debug_antispam'] = 'mod/debug/antispam.html';
	$config['file_mod_debug_recent_posts'] = 'mod/debug/recent_posts.html';
	$config['file_mod_debug_sql'] = 'mod/debug/sql.html';

	// Board directory, followed by a forward-slash (/).
	$config['board_path'] = 'channel/%s/';
	// Misc directories.
	$config['dir']['img'] = 'src/';
	$config['dir']['thumb'] = 'thumb/';
	$config['dir']['res'] = 'res/';
		
	// Directory for archived threads
	$config['dir']['archive'] = 'archive/';
	// Directory for "Featured Threads" (threads makred for permanent storage)
	$config['dir']['featured'] = 'featured/';
	// Directory for "Featured Threads" (threads makred for permanent storage)
	$config['dir']['mod_archive'] = 'mod_archive/';
		
	// For load balancing, having a seperate server (and domain/subdomain) for serving static content is
	// possible. This can either be a directory or a URL. Defaults to $config['root'] . 'static/'.
	// $config['dir']['static'] = 'http://static.example.org/';

	// Where to store the .html templates. This folder and the template files must exist.
	$config['dir']['template'] = getcwd() . '/templates';
	// Location of Tinyboard "themes".
	$config['dir']['themes'] = getcwd() . '/templates/themes';
	// Same as above, but a URI (accessable by web interface).
	$config['dir']['themes_uri'] = 'templates/themes';
	// Home directory. Used by themes.
	$config['dir']['home'] = '';

	// Location of a blank 1x1 gif file. Only used when country_flags_condensed is enabled
	// $config['image_blank'] = 'static/blank.gif';

	// Static images. These can be URLs OR base64 (data URI scheme). These are only used if
	// $config['font_awesome'] is false (default).
	// $config['image_sticky']	= 'static/sticky.png';
	// $config['image_locked']	= 'static/locked.gif';
	// $config['image_bumplocked']	= 'static/sage.png';
	// $config['image_cyclical']	= 'static/cycle.png';

	// If you want to put images and other dynamic-static stuff on another (preferably cookieless) domain.
	// This will override $config['root'] and $config['dir']['...'] directives. "%s" will get replaced with
	//  $board['dir'], which includes a trailing slash.
	// $config['uri_thumb'] = 'http://images.example.org/%sthumb/';
	// $config['uri_img'] = 'http://images.example.org/%ssrc/';

	// Set custom locations for stylesheets and the main script file. This can be used for load balancing
	// across multiple servers or hostnames.
	// $config['url_stylesheet'] = 'http://static.example.org/style.css'; // main/base stylesheet
	// $config['url_javascript'] = 'http://static.example.org/main.js';

	// Website favicon.
	// $config['url_favicon'] = '/favicon.gif';

	// Try not to build pages when we shouldn't have to.
	$config['try_smarter'] = true;
	
/*
 * ====================
 *  Archive settings
 * ====================
 */

	// Indicate if threads should be archived
	$config['archive']['threads'] = true;
	// Indicate if it is possible to mark threads as featured (stored forever)
	$config['feature']['threads'] = true;
	// Indicate if link to featured archive should be shown on post and thread page
	$config['feature']['link_post_page'] = false;

	// Indicate if it is possible to mark threads as nostalgic (stored forever but will only be accessable to mods)
	$config['mod_archive']['threads'] = true;

	// Days to keep archived threads before deletion (ex. "60 minutes", "6 hours", "1 day", "1 week"), if set to false all archived threads are kept forever
	$config['archive']['lifetime'] = false;

	// Number of chars in snippet
	$config['archive']['snippet_len'] = 400;

	$config['archive']['threads_per_page'] = 10;
	
	// If any is set to run in crom both will be run in cron regardless
	// Archiving is run in cron job
	$config['archive']['cron_job']['archiving'] = false;
	// Purging of archive is run in cron job
	$config['archive']['cron_job']['purge'] = false;


	// Automatically send threads with thiese trips to Featured Archive
	// $config['archive']['auto_feature_trips'] = array("!!securetrip", "!trip");
	$config['archive']['auto_feature_trips'] = array();

/*
 * ====================
 *  Advanced build
 * ====================
 */

	// Strategies for file generation. Also known as an "advanced build". If you don't have performance
	// issues, you can safely ignore that part, because it's hard to configure and won't even work on
	// your free webhosting.
	//
	// A strategy is a function, that given the PHP environment and ($fun, $array) variable pair, returns
	// an $action array or false.
	//
	// $fun - a controller function name, see inc/controller.php. This is named after functions, so that
	//        we can generate the files in daemon.
	//
	// $array - arguments to be passed
	//
	// $action - action to be taken. It's an array, and the first element of it is one of the following:
	//   * "immediate" - generate the page immediately
	//   * "defer" - defer page generation to a moment a worker daemon gets to build it (serving a stale
	//               page in the meantime). The remaining arguments are daemon-specific. Daemon isn't
	//               implemented yet :DDDD inb4 while(true) { generate(Queue::Get()) }; (which is probably it).
	//   * "build_on_load" - defer page generation to a moment, when the user actually accesses the page.
	//                       This is a smart_build behaviour. You shouldn't use this one too much, if you
	//                       use it for active boards, the server may choke due to a possible race condition.
	//                       See my blog post: https://engine.vichan.net/blog/res/2.html
	//
	// So, let's assume we want to build a thread 1324 on board /b/, because a new post appeared there.
	// We try the first strategy, giving it arguments: 'sb_thread', array('b', 1324). The strategy will
	// now return a value $action, denoting an action to do. If $action is false, we try another strategy.
	//
	// As I said, configuration isn't easy.
	//
	// 1. chmod 0777 directories: tmp/locks/ and tmp/queue/.
	// 2. serve 403 and 404 requests to go thru smart_build.php
	//    for nginx, this blog post contains config snippets: https://engine.vichan.net/blog/res/2.html
	// 3. disable indexes in your webserver
	// 4. launch any number of daemons (eg. twice your number of threads?) using the command:
	//    $ tools/worker.php
	//    You don't need to do that step if you are not going to use the "defer" option.
	// 5. enable smart_build_helper (see below)
	// 6. edit the strategies (see inc/functions.php for the builtin ones). You can use lambdas. I will test
	//    various ones and include one that works best for me.
	$config['generation_strategies'] = [
		/*
		 * Add a sane strategy. It forces to immediately generate a page user is about to land on. Otherwise,
		 * it has no opinion, so it needs a fallback strategy.
		 */
		'strategy_sane',
		/*
		 * Add an immediate catch-all strategy. This is the default function of imageboards: generate all pages
		 * on post time.
		 */
		'strategy_immediate',
	];

	// NOT RECOMMENDED: Instead of an all-"immediate" strategy, you can use an all-"build_on_load" one (used
	// to be initialized using $config['smart_build']; ) for all pages instead of those to be build
	// immediately. A rebuild done in this mode should remove all your static files
	// $config['generation_strategies'][1] = 'strategy_smart_build';

	// Deprecated. Leave it false. See above.
	$config['smart_build'] = false;

	// Use smart_build.php for dispatching missing requests. It may be useful without smart_build or advanced
	// build, for example it will regenerate the missing files.
	$config['smart_build_helper'] = true;

	// smart_build.php: when a file doesn't exist, where should we redirect?
	$config['page_404'] = '/404.html';

	// Extra controller entrypoints. Controller is used only by smart_build and advanced build.
	$config['controller_entrypoints'] = [];

/*
 * ====================
 *  Mod settings
 * ====================
 */

	// Mod links (full HTML).
	$config['mod'] = [
		// Limit how many bans can be removed via the ban list. Set to false (or zero) for no limit.
		'unban_limit' => false,
		// Whether or not to lock moderator sessions to IP addresses. This makes cookie theft less effective.
		'lock_ip' => true,
		// The page that is first shown when a moderator logs in. Defaults to the dashboard (?/).
		'default' => '/',
		// Do DNS lookups on IP addresses to get their hostname for the moderator IP pages (?/IP/x.x.x.x).
		'dns_lookup' => true,
		// How many recent posts, per board, to show in ?/IP/x.x.x.x.
		'ip_recentposts' => 5,
		// Number of actions to show per page in the moderation log.
		'modlog_page' => 350,
		// Number of bans to show per page in the ban list.
		'banlist_page'=> 350,
		// Number of news entries to display per page.
		'news_page' => 40,
		// Number of results to display per page.
		'search_page' => 200,
		// Number of entries to show per page in the moderator noticeboard.
		'noticeboard_page' => 50,
		// Number of entries to show per page in the moderator inbox.
		'inbox_page' => 50,
		// Number of entries to show per page in moderator reports.
		'reports_page' => 10,
		// Number of entries to summarize and display on the dashboard.
		'noticeboard_dashboard' => 5,

		// Check public ban message by default.
		'check_ban_message' => false,
		// Default public ban message. In public ban messages, %length% is replaced with "for x days" or
		// "permanently" (with %LENGTH% being the uppercase equivalent).
		'default_ban_message' => _('USER WAS BANNED FOR THIS POST'),
		// $config['mod']['default_ban_message'] = 'USER WAS BANNED %LENGTH% FOR THIS POST';
		// HTML to append to post bodies for public bans messages (where "%s" is the message).
		'ban_message' => '<span class="public_ban">(%s)</span>',

		// When moving a thread to another board and choosing to keep a "shadow thread", an automated post (with
		// a capcode) will be made, linking to the new location for the thread. "%s" will be replaced with a
		// standard cross-board post citation (>>>/board/xxx)
		'shadow_mesage' => _('Moved to %s.'),
		// Capcode to use when posting the above message.
		'shadow_capcode' => 'Mod',
		// Name to use when posting the above message. If false, $config['anonymous'] will be used.
		'shadow_name' => false,

		// PHP time limit for ?/rebuild. A value of 0 should cause PHP to wait indefinitely.
		'rebuild_timelimit' => 0,

		// PM snippet (for ?/inbox) length in characters.
		'snippet_length' => 75,

		// Edit raw HTML in posts by default.
		'raw_html_default' => false,

		// Automatically dismiss all reports regarding a thread when it is locked.
		'dismiss_reports_on_lock' => true,

		// Replace ?/config with a simple text editor for editing inc/instance-config.php.
		'config_editor_php' => false,

		'link_delete' => '[D]',
		'link_ban' => '[B]',
		'link_bandelete' => '[B&amp;D]',
		'link_deletefile' => '[F]',
		'link_spoilerimage' => '[S]',
		'link_deletebyip' => '[D+]',
		'link_deletebyip_global' => '[D++]',
		'link_sticky' => '[Sticky]',
		'link_desticky' => '[-Sticky]',
		'link_lock' => '[Lock]',
		'link_unlock' => '[-Lock]',
		'link_bumplock' => '[Sage]',
		'link_bumpunlock' => '[-Sage]',
		'link_editpost' => '[Edit]',
		'link_move' => '[Move]',
		'link_cycle' => '[Cycle]',
		'link_uncycle' => '[-Cycle]'
	];

	$config['mod']['link_send_to_archive'] = '[Archive]';
	// Moderator capcodes.
	$config['capcode'] = ' <span class="capcode">## %s</span>';

	// "## Custom" becomes lightgreen, italic and bold:
	//$config['custom_capcode']['Custom'] ='<span class="capcode" style="color:lightgreen;font-style:italic;font-weight:bold"> ## %s</span>';

	// "## Mod" makes everything purple, including the name and tripcode:
	//$config['custom_capcode']['Mod'] = array(
	//	'<span class="capcode" style="color:purple"> ## %s</span>',
	//	'color:purple', // Change name style; optional
	//	'color:purple' // Change tripcode style; optional
	//);

	// "## Admin" makes everything red and bold, including the name and tripcode:
	//$config['custom_capcode']['Admin'] = array(
	//	'<span class="capcode" style="color:red;font-weight:bold"> ## %s</span>',
	//	'color:red;font-weight:bold', // Change name style; optional
	//	'color:red;font-weight:bold' // Change tripcode style; optional
	//);

	// Enable the moving of single replies
	$config['move_replies'] = true;

/*
 * ====================
 *  Mod permissions
 * ====================
 */

	// Probably best not to change this unless you are smart enough to figure out what you're doing. If you
	// decide to change it, remember that it is impossible to redefinite/overwrite groups; you may only add
	// new ones.
	$config['mod']['groups'] = [
		1	=> 'User',
		10	=> 'Janitor',
		20	=> 'Mod',
		30	=> 'Admin',
		// 98	=> 'God',
		99	=> 'Disabled'
	];

	// If you add stuff to the above, you'll need to call this function immediately after.
	define_groups();

	// Example: Adding a new permissions group.
	// $config['mod']['groups'][0] = 'NearlyPowerless';
	// define_groups();

	// Capcode permissions.
	$config['mod']['capcode'] = [
		// JANITOR		=> [ 'Janitor' ],
		MOD		=> [ 'Mod' ],
		ADMIN		=> true
	];

	// Example: Allow mods to post with "## Moderator" as well
	// $config['mod']['capcode'][MOD][] = 'Moderator';
	// Example: Allow janitors to post with any capcode
	// $config['mod']['capcode'][JANITOR] = true;

	// Set any of the below to "DISABLED" to make them unavailable for everyone.

	// Don't worry about per-board moderators. Let all mods moderate any board.
	$config['mod']['skip_per_board'] = false;

	/* Post Controls */
	// View IP addresses
	$config['mod']['show_ip'] = MOD;
	// Delete a post
	$config['mod']['delete'] = JANITOR;
	// Ban a user for a post
	$config['mod']['ban'] = MOD;
	// Ban and delete (one click; instant)
	$config['mod']['bandelete'] = MOD;
	// Remove bans
	$config['mod']['unban'] = MOD;
	// Spoiler image
	$config['mod']['spoilerimage'] = JANITOR;
	// Edit bans
	$config['mod']['edit_ban'] = &$config['mod']['ban'];
	// Delete file (and keep post)
	$config['mod']['deletefile'] = JANITOR;
	// Delete all posts by IP
	$config['mod']['deletebyip'] = MOD;
	// Delete all posts by IP across all boards
	$config['mod']['deletebyip_global'] = ADMIN;
	// Sticky a thread
	$config['mod']['sticky'] = MOD;
	// Cycle a thread
	$config['mod']['cycle'] = MOD;
	$config['cycle_limit'] = &$config['reply_limit'];
	// Lock a thread
	$config['mod']['lock'] = MOD;
	// Post in a locked thread
	$config['mod']['postinlocked'] = MOD;
	// Prevent a thread from being bumped
	$config['mod']['bumplock'] = MOD;
	// View whether a thread has been bumplocked ("-1" to allow non-mods to see too)
	$config['mod']['view_bumplock'] = MOD;
	// Edit posts
	$config['mod']['editpost'] = ADMIN;
	// "Move" a thread to another board (EXPERIMENTAL; has some known bugs)
	$config['mod']['move'] = ADMIN;
	// Bypass "field_disable_*" (forced anonymity, etc.)
	$config['mod']['bypass_field_disable'] = MOD;
	// Post bypass unoriginal content check on robot-enabled boards
	$config['mod']['postunoriginal'] = ADMIN;
	// Bypass flood check
	$config['mod']['bypass_filters'] = ADMIN;
	$config['mod']['flood'] = &$config['mod']['bypass_filters'];
	// Raw HTML posting
	$config['mod']['rawhtml'] = ADMIN;

	/* Administration */
	// View the report queue
	$config['mod']['reports'] = JANITOR;
	// Dismiss an abuse report
	$config['mod']['report_dismiss'] = JANITOR;
	// Dismiss all abuse reports by an IP
	$config['mod']['report_dismiss_ip'] = JANITOR;
	// Dismiss all abuse reports for a post
	$config['mod']['report_dismiss_post'] = JANITOR;

	// Send  Threads directly to Archive (need to be greater than or equal to ['mod']['delete'] permission)
	$config['mod']['send_threads_to_archive'] = MOD;
	if($config['mod']['send_threads_to_archive'] < $config['mod']['delete'])
		$config['mod']['send_threads_to_archive'] = $config['mod']['delete'];
	// Feature Archived Threads
	$config['mod']['feature_archived_threads'] = JANITOR;
	// Delete Featured Archived Threads
	$config['mod']['delete_featured_archived_threads'] = ADMIN;
	// Delete Archived Threads
	$config['mod']['delete_archived_threads'] = ADMIN;

	// View Mod Archive
	$config['mod']['view_mod_archive'] = MOD;
	// Archive Threads for Mods
	$config['mod']['add_to_mod_archive'] = MOD;
	// Archive Threads for Mods
	$config['mod']['remove_from_mod_archive'] = ADMIN;

	// View list of bans
	$config['mod']['view_banlist'] = MOD;
	// View the username of the mod who made a ban
	$config['mod']['view_banstaff'] = MOD;
	// If the moderator doesn't fit the $config['mod']['view_banstaff''] (previous) permission, show him just
	// a "?" instead. Otherwise, it will be "Mod" or "Admin".
	$config['mod']['view_banquestionmark'] = false;
	// Show expired bans in the ban list (they are kept in cache until the culprit returns)
	$config['mod']['view_banexpired'] = true;
	// View ban for IP address
	$config['mod']['view_ban'] = $config['mod']['view_banlist'];
	// View IP address notes
	$config['mod']['view_notes'] = JANITOR;
	// Create notes
	$config['mod']['create_notes'] = $config['mod']['view_notes'];
	// Remote notes
	$config['mod']['remove_notes'] = ADMIN;
	// Create a new board
	$config['mod']['newboard'] = ADMIN;
	// Manage existing boards (change title, etc)
	$config['mod']['manageboards'] = ADMIN;
	// Delete a board
	$config['mod']['deleteboard'] = ADMIN;
	// List/manage users
	$config['mod']['manageusers'] = MOD;
	// Promote/demote users
	$config['mod']['promoteusers'] = ADMIN;
	// Edit any users' login information
	$config['mod']['editusers'] = ADMIN;
	// Change user's own password
	$config['mod']['change_password'] = JANITOR;
	// Delete a user
	$config['mod']['deleteusers'] = ADMIN;
	// Create a user
	$config['mod']['createusers'] = ADMIN;
	// View the moderation log
	$config['mod']['modlog'] = ADMIN;
	// View IP addresses of other mods in ?/log
	$config['mod']['show_ip_modlog'] = ADMIN;
	// View relevant moderation log entries on IP address pages (ie. ban history, etc.) Warning: Can be
	// pretty resource intensive if your mod logs are huge.
	$config['mod']['modlog_ip'] = MOD;
	// Create a PM (viewing mod usernames)
	$config['mod']['create_pm'] = USER;
	// Read any PM, sent to or from anybody
	$config['mod']['master_pm'] = ADMIN;
	// Rebuild everything
	$config['mod']['rebuild'] = ADMIN;
	// Search through posts, IP address notes and bans
	$config['mod']['search'] = USER;
	// Allow searching posts (can be used with board configuration file to disallow searching through a
	// certain board)
	$config['mod']['search_posts'] = USER;
	// Read the moderator noticeboard
	$config['mod']['noticeboard'] = USER;
	// Post to the moderator noticeboard
	$config['mod']['noticeboard_post'] = MOD;
	// Delete entries from the noticeboard
	$config['mod']['noticeboard_delete'] = ADMIN;
	// Public ban messages; attached to posts
	$config['mod']['public_ban'] = MOD;
	// Manage and install themes for homepage
	$config['mod']['themes'] = ADMIN;
	// Post news entries
	$config['mod']['news'] = ADMIN;
	// Custom name when posting news
	$config['mod']['news_custom'] = ADMIN;
	// Delete news entries
	$config['mod']['news_delete'] = ADMIN;
	// Execute un-filtered SQL queries on the database (?/debug/sql)
	$config['mod']['debug_sql'] = DISABLED;
	// Edit the current configuration (via web interface)
	$config['mod']['edit_config'] = ADMIN;
	// View ban appeals
	$config['mod']['view_ban_appeals'] = MOD;
	// Accept and deny ban appeals
	$config['mod']['ban_appeals'] = MOD;
	// View the recent posts page
	$config['mod']['recent'] = MOD;
	// Create pages
	$config['mod']['edit_pages'] = MOD;
	$config['pages_max'] = 10;

	// Config editor permissions
	$config['mod']['config'] = array();

	// Disable the following configuration variables from being changed via ?/config. The following default
	// banned variables are considered somewhat dangerous.
	$config['mod']['config'][DISABLED] = array(
		'mod>config',
		'mod>config_editor_php',
		'mod>groups',
		'convert_args',
		'db>password',
	);

	$config['mod']['config'][JANITOR] = array(
		'!', // Allow editing ONLY the variables listed (in this case, nothing).
	);

	$config['mod']['config'][MOD] = array(
		'!', // Allow editing ONLY the variables listed (plus that in $config['mod']['config'][JANITOR]).
		'global_message',
	);

	// Example: Disallow ADMIN from editing (and viewing) $config['db']['password'].
	// $config['mod']['config'][ADMIN] = array(
	// 	'db>password',
	// );

	// Example: Allow ADMIN to edit anything other than $config['db']
	// (and $config['mod']['config'][DISABLED]).
	// $config['mod']['config'][ADMIN] = array(
	// 	'db',
	// );

	// Allow OP to remove arbitrary posts in his thread
	$config['user_moderation'] = false;

	// File board. Like 4chan /f/
	$config['file_board'] = false;

	// Thread tags. Set to false to disable
	// Example: array('A' => 'Chinese cartoons', 'M' => 'Music', 'P' => 'Pornography');
	$config['allowed_tags'] = false;

/*
 * ====================
 *  Public pages
 * ====================
 */

	// Public post search settings
	$config['search'] = [
		// Enable the search form
		'enable' => true,
		// Maximal number of queries per IP address per minutes
		'queries_per_minutes' => [ 15, 2 ],
		// Global maximal number of queries per minutes
		'queries_per_minutes_all' => [ 50, 2 ],
		// Limit of search results
		'search_limit' => 100,
	];

	// Enable search in the board index.
	$config['board_search'] = true;

	// Boards for searching
	//$config['search']['boards'] = array('a', 'b', 'c', 'd', 'e');

	// Blacklist boards for searching, basically the opposite of the one above
	//$config['search']['disallowed_boards'] = array('j', 'z');

	// Enable public logs? 0: NO, 1: YES, 2: YES, but drop names
	$config['public_logs'] = 0;

/*
 * ====================
 *  Events (PHP 5.3.0+)
 * ====================
 */

	// https://github.com/vichan-devel/vichan/wiki/events

	// event_handler('post', function($post) {
	// 	// do something
	// });

	// event_handler('post', function($post) {
	// 	// do something else
	//
	// 	// return an error (reject post)
	// 	return 'Sorry, you cannot post that!';
	// });

/*
 * =============
 *  API settings
 * =============
 */

	// Whether or not to enable the 4chan-compatible API, disabled by default. See
	// https://github.com/4chan/4chan-API for API specification.
	$config['api']['enabled'] = true;

	// Extra fields in to be shown in the array that are not in the 4chan-API. You can get these by taking a
	// look at the schema for posts_ tables. The array should be formatted as $db_column => $translated_name.
	// Example: Ad`ding the pre-markup post body to the API as "com_nomarkup".
	// $config['api']['extra_fields'] = array('body_nomarkup' => 'com_nomarkup');

/*
 * ====================
 *  Other/uncategorized
 * ====================
 */

	// Meta keywords. It's probably best to include these in per-board configurations.
	// $config['meta_keywords'] = 'chan,anonymous discussion,imageboard,vichan';

	// Link imageboard to your Google Analytics account to track users and provide traffic insights.
	// $config['google_analytics'] = 'UA-xxxxxxx-yy';
	// Keep the Google Analytics cookies to one domain -- ga._setDomainName()
	// $config['google_analytics_domain'] = 'www.example.org';

	// Link imageboard to your Statcounter.com account to track users and provide traffic insights without the Google botnet.
	// Extract these values from Statcounter's JS tracking code:
	// $config['statcounter_project'] = '1234567';
	// $config['statcounter_security'] = 'acbd1234';

	// If you use Varnish, Squid, or any similar caching reverse-proxy in front of vichan, you can
	// configure vichan to PURGE files when they're written to.
	// $config['purge'] = array(
	// 	array('127.0.0.1', 80)
	// 	array('127.0.0.1', 80, 'example.org')
	// );

	// Connection timeout for $config['purge'], in seconds.
	$config['purge_timeout'] = 3;

	// Additional mod.php?/ pages. Look in inc/mod/pages.php for help.
	// $config['mod']['custom_pages']['/something/(\d+)'] = function($id) {
	// 	global $config;
	// 	if (!hasPermission($config['mod']['something']))
	// 		error($config['error']['noaccess']);
	// 	// ...
	// };

	// You can also enable themes (like ukko) in mod panel like this:
	// require_once("templates/themes/ukko/theme.php");
	//
	// $config['mod']['custom_pages']['/\*/'] = function() {
	//        global $mod;
	//
	//        $ukko = new ukko();
	//        $ukko->settings = array();
	//        $ukko->settings['uri'] = '*';
	//        $ukko->settings['title'] = 'derp';
	//        $ukko->settings['subtitle'] = 'derpity';
	//        $ukko->settings['thread_limit'] = 15;
	//        $ukko->settings['exclude'] = '';
	//
	//        echo $ukko->build($mod);
	// };

	// Example: Add links to dashboard (will all be in a new "Other" category).
	// $config['mod']['dashboard_links']['Something'] = '?/something';

	// Create gzipped static files along with ungzipped.
	// This is useful with nginx with gzip_static on.
	$config['gzip_static'] = false;

	// Regex for board URIs. Don't add "`" character or any Unicode that MySQL can't handle. 58 characters
	// is the absolute maximum, because MySQL cannot handle table names greater than 64 characters.
	$config['board_regex'] = '[0-9a-zA-Z$_\x{0080}-\x{FFFF}]{1,58}';

	// Youtube.js embed HTML code
	$config['youtube_js_html'] = '<div class="video-container" data-video="$2">'.
		'<a href="https://youtu.be/$2" target="_blank" class="file">'.
		'<img style="width:360px;height:270px;" src="//img.youtube.com/vi/$2/0.jpg" class="post-image"/>'.
		'</a></div>';

	// Password hashing function
	//
	// $5$ <- SHA256
	// $6$ <- SHA512
	//
	// 25000 rounds make for ~0.05s on my 2015 Core i3 computer.
	//
	// https://secure.php.net/manual/en/function.crypt.php
	$config['password_crypt'] = '$6$rounds=25000$';

	// Password hashing method version
	// If set to 0, it won't upgrade hashes using old password encryption schema, only create new.
	// You can set it to a higher value, to further migrate to other password hashing function.
	$config['password_crypt_version'] = 1;

	// Use CAPTCHA for reports?
	$config['report_captcha'] = true;

	// Allowed HTML tags in ?/edit_pages.
	$config['allowed_html'] = 'a[href|title],p,br,li,ol,ul,strong,em,u,h2,b,i,tt,div,img[src|alt|title],hr';

	// Secret passphrase for IP cloaking
	// Disabled if empty.
	$config['ipcrypt_key'] = '';

	// IP cloak prefix
	$config['ipcrypt_prefix'] = 'Cloak';

	// Whether to append domain names to IP cloaks
	$config['ipcrypt_dns'] = false;
