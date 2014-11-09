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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'h[)pQ:9kw7`cIk.qTvYHn#hZQP>MTCJ}K0 4y{7w7/UQucF[f)b!GmAw6^NV79+U');
define('SECURE_AUTH_KEY',  'uA+a;=Va:wt+>6el:;k|+zJO4!S+CwumuInr%h9U  2vZ|z(=bZ2Q}2Jj^+&~j+J');
define('LOGGED_IN_KEY',    ',0r|S53 (hb= 4.0-8kvTk;(;{PiRqjvfsfZzgxKuL52_yF]gT-+[vuE]_fpH`P+');
define('NONCE_KEY',        'U}|rDTY?g[%yC^rs*TycZPH&+-@URumr_L)R2Y|*<0LiCcV-&2dp4 IV$i~/[s_d');
define('AUTH_SALT',        'RFWVBVg-9(a0;|a0`+/?71)vZ|hhq1:)r#811Z_6 Z@QGLF-c!GcR4R)u3ie$dmi');
define('SECURE_AUTH_SALT', ']~q~[^6tB<D&El%6!|JqFg -tiG9:L>7?s44G(v,`^Rj/GoIW2d<_UR4K^yT<F|x');
define('LOGGED_IN_SALT',   'BH^vEkae~dpy=UVc-o;+P0L%5JqgCNhQ$ArC1k#5|M<cG%p-|QJ>,1pp5OSO8FDS');
define('NONCE_SALT',       '.2pk}sMyW?3/F2-krg|^-XgTO7^v;v6=Ensx2ut7+:e_DinaGJtTE&yJ/<gZYp*)');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
