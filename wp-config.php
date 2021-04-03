<?php
define('WP_SITEURL', 'https://hutanmedia.com');
define('WP_HOME', 'https://hutanmedia.com');

define('WP_AUTO_UPDATE_CORE', 'minor'); // This setting is required to make sure that WordPress updates can be properly managed in WordPress Toolkit. Remove this line if this WordPress website is not managed by WordPress Toolkit anymore.

/**

 * The base configuration for WordPress

 *

 * The wp-config.php creation script uses this file during the

 * installation. You don't have to use the web site, you can

 * copy this file to "wp-config.php" and fill in the values.

 *

 * This file contains the following configurations:

 *

 * * MySQL settings

 * * Secret keys

 * * Database table prefix

 * * ABSPATH

 *

 * @link https://codex.wordpress.org/Editing_wp-config.php

 *

 * @package WordPress

 */



// ** MySQL settings ** //

/** The name of the database for WordPress */

define('DB_NAME', 'hut62311_x7ma1o');


/** MySQL database username */

define('DB_USER', 'hut62311_lkie65');


/** MySQL database password */

define('DB_PASSWORD', 'QBGZELP61@7PW6jZw');


/** MySQL hostname */

define('DB_HOST', 'localhost:3306');



/** Database Charset to use in creating database tables. */

define('DB_CHARSET', 'utf8');



/** The Database Collate type. Don't change this if in doubt. */

define('DB_COLLATE', '');



/**

 * Authentication Unique Keys and Salts.

 *

 * Change these to different unique phrases!

 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}

 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.

 *

 * @since 2.6.0

 */

define('AUTH_KEY', 's@C3Rt:5oc%Y46rD43iGf;/|VUf8cI4;S4l9Jv27:JM[;B;O5+D1E3qh|v007cc7');

define('SECURE_AUTH_KEY', 'GN]p]]H05%wp+gF31I*]Ko*3945q68A|:8c8zm]-7ANj0ZO[Z%mw:N[7498hH3(l');

define('LOGGED_IN_KEY', '7:V~F!mc:b2Y1;8_%U@w8x5Qg(69|r:8/2&-)z:)7r(%)k%4grU:vg8-M&t&~Zan');

define('NONCE_KEY', '9x8!T:27Zh)32FJO4)9Dwsa77)3K31n)-E#vGLOt|_#84!dKz[-g4(/209X(9lbv');

define('AUTH_SALT', '6Ap|jM899L;y31~PZ211t1hF*D3qs534!2kFbUkXj4t4Xmvfy9uw%0__8rW6d;my');

define('SECURE_AUTH_SALT', 'SFvZG-q+D86F69wHw||vdkKL+[o2Wei*Z59b[:Mp(p(PbC:2H6KtMcry8#3z4&Jb');

define('LOGGED_IN_SALT', '%0#U~BJ8C*&T]@*w:uXu%(71wk2p46x0:D%F+5C5E7:WuB19N3(&9N126&f;u5;:');

define('NONCE_SALT', '7[e1S00WD2/UQzqC+v8e1:jyax6|jE:UN45GgUE_!@[+jfO41Z+i6f%c#Z/9##@6');



/**

 * WordPress Database Table prefix.

 *

 * You can have multiple installations in one database if you give each

 * a unique prefix. Only numbers, letters, and underscores please!

 */

$table_prefix = 'oxiURJFeM_';





define('WP_ALLOW_MULTISITE', true);



/* That's all, stop editing! Happy blogging. */



/** Absolute path to the WordPress directory. */

if (!defined('ABSPATH'))

	define('ABSPATH', dirname(__FILE__) . '/');



/** Sets up WordPress vars and included files. */

require_once ABSPATH . 'wp-settings.php';
