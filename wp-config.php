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
define('DB_NAME', 'wordpress2');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost:3307');

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
define('AUTH_KEY',         'R #Fav$`)Zyt7TGi6R=@h(W,7B`6MZ($%[H|KW v4_.Df?@<_u]f6{UH]|^g@(?h');
define('SECURE_AUTH_KEY',  'JLPByp=IVK)iBhG(dxt,qZh^4/p f@f,ih;%LIMIWGn*i(eZ_l)H.q0}6I l[jd/');
define('LOGGED_IN_KEY',    'D%l-Gw=[3RfJ3.,41:?->SHw)Xy8>yNNA#G3ZlC||(n9g7;Sr]v_m1egwzXp~:z7');
define('NONCE_KEY',        'f/+yR]buJ$m,Euxe+(xdcX6LGXV}VToq~,k(g^K+u^d 4F?B+3J~ 6Dy4@&:QqX4');
define('AUTH_SALT',        'V=rESYi*(562/DTDOs662,cZ2GgMB`.Ta.G_r[Y!xP>R}oS~q3]b26s|gMeA95>~');
define('SECURE_AUTH_SALT', 'B(Ez.nq;Ld[|v>S?+JI T%amF7(?,G9K?eW}J^V1Rgg&T,I`y`:3b1!e5*7BHk$O');
define('LOGGED_IN_SALT',   '|c_My{Z;2yiPQ@O42)<?);ZTq{_Ipi:^]S54^+jRu/L7-z7yP=<t#U4ZdJb+FM%C');
define('NONCE_SALT',       'pIC32LP0|l4K2iP!^]8v)CujMN3)WW7$8}50}u4mT@j|F8q4XUzFOr6)FDEGO5zP');

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
