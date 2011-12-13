<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'orchid');

/** MySQL database username */
define('DB_USER', 'naist');

/** MySQL database password */
define('DB_PASSWORD', '@naist');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'iH|I~~savQcu33t5H1jyAmq`xyf7Sm/qgYkRw_/}Mhvw*L@s A~,D=JTO;WPlJFh');
define('SECURE_AUTH_KEY',  '2Zv(F1i-/_2^#Gx-SylJ4jO<jqhl(&U,F49QUWu^jQS$12, ]w4MmKI_ :|yfPEV');
define('LOGGED_IN_KEY',    'Z+N`JV/,!p+k!o+ZxDgA4r:jQ3F`jq-k7IGG 4g1LSwqxRpWu+ biA-FKfNuO)cN');
define('NONCE_KEY',        '*_c6Q,foAR3w?Y#K8{%>)FZwyh*C7}K&Z3Xc!]?Cdh 1SUuoJZ1Bong0$y*J;GrV');
define('AUTH_SALT',        't.oI&|vo|J.y96#.9d B@Bw@O[1%ftK[y=R0wB[Q7TddwCnk6mIdD=Ruy52:Hxx|');
define('SECURE_AUTH_SALT', '^}e)?q0_WIjj6}DPcFcRh.AB[=l$3I7fj[3O>Oc6)_<R|iYq+y=dX!I!h=/0G7hW');
define('LOGGED_IN_SALT',   'q 0}ck}s~!lrMxY,!cQ@uyir@u8T7o_[.-i1)h99:FCezpq}``/L!a2%4!DW36lo');
define('NONCE_SALT',       'h#,:klLz3!3MsbL;Ejx4k)LDh5{{{s~ 4/!&)ipItA%]SkBN$q+rlSIdKrxowp5f');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
