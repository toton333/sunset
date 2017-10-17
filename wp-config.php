<?php
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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'sunset');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'F-^<p<mXE5w_LGst6ZT1[%F/;CE<.;ZMZP>a,r16LNh$!|Sf6~~pSBnsHLN-K `g');
define('SECURE_AUTH_KEY',  '-A?xtt8KbB4AhUi5faTG^%!ru0qmo?PXaa%T4N:r@,%rXdW+ljDFymv&;yZrD6b9');
define('LOGGED_IN_KEY',    '^yk8:ZuRlP(ox-|`41GE}w~c,R~lY%w|a~q.qi55_|z+ZBg-M]%N#GpH344w1x4:');
define('NONCE_KEY',        '6PTq>iThe=6*HxMI>I+O!x-jq4:4-`P$voT!}YdV7qOK0K]I*Oh[/P_omZU]%`L4');
define('AUTH_SALT',        'b&Whcc/2S,hU&$Z9iYXWMG,C5zIBSA`nw{0,+KDiLR=trqB2.=0>A^_<s$Kf2bw<');
define('SECURE_AUTH_SALT', 'xYU`V5T^I/3Wq9E|acG6(J.1?LeFt~qi.Sz^oDC;GCKohx,}lK$-)S,(Zzp-j(02');
define('LOGGED_IN_SALT',   '[9/_0]Z#[,+Fw$|#?g6q-JP*93!N>RT2@:bt&jlK)|iNP(>`JV=3D_MPNXQ@Wp`_');
define('NONCE_SALT',       'N$,#w},/anMDU* JsHucU{Q}9B]%I6R}cP&-[MFk*^&wWC&0E*s{1R~Sn>dUJp1X');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
