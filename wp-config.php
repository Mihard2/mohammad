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
define('DB_NAME', 'mohammadjawadrahimi_com');

/** MySQL database username */
define('DB_USER', 'mohammadjawadrah');

/** MySQL database password */
define('DB_PASSWORD', 'WGgDHXUM');

/** MySQL hostname */
define('DB_HOST', 'mysql.mohammadjawadrahimi.com');

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
define('AUTH_KEY',         'S+@D/T0+Iy|*e~xk"eH5"Ryn~k)/NC++6mC71;9jiuX?msma~A)I&Hghbp~v;h1c');
define('SECURE_AUTH_KEY',  'EZysu5bSY?n8s6Hl*gA9?QA9"nUsQh*t`:H7)5#W1mza|za9Xa/a@W"DI9;7:3Lm');
define('LOGGED_IN_KEY',    'D_FqfD^P&@nET4cBAtkDy~MXowXhLeExufCNpIz:/e~Su%yH5NAq_fw$^E7s?Fue');
define('NONCE_KEY',        '~zGpY)^3%zwsvqVZ^5~59`Cvfle!S:9w~uU&k%WZ+wl1%rC6G9~^5DNsmioYOFCt');
define('AUTH_SALT',        'JQ!;V`Glvv`HzbZ0Cua:rmEi`2(z/J%FscJOSZ3t*3aWGm@!a"bJ5pSfLyFZrkSj');
define('SECURE_AUTH_SALT', '$"^WtH?O2P1Bu9:VrsW*)6#3_SqT|$pf15n6sZG@YY1XTRlk~Y568;!xuSRjU1r?');
define('LOGGED_IN_SALT',   'FTb&^8%;C!qy~gl1Ld8$m(E(yO(Xr#TV4W2znx"%XaUp|+"pzdlt_zB|5VIaFFqE');
define('NONCE_SALT',       'nP51`"uJwQfAk@keLq2yUK;&wr)#U%|Oez7x0#Mc"yGN|Cuw|J)dXd*DTGhqX?oH');
define('ALLOW_UNFILTERED_UPLOADS', true);

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_65dq5x_';

/**
 * Limits total Post Revisions saved per Post/Page.
 * Change or comment this line out if you would like to increase or remove the limit.
 */
define('WP_POST_REVISIONS',  10);

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/**
 * Removing this could cause issues with your experience in the DreamHost panel
 */

if (preg_match("/^(.*)\.dream\.website$/", $_SERVER['HTTP_HOST'])) {
        $proto = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
        define('WP_SITEURL', $proto . '://' . $_SERVER['HTTP_HOST']);
        define('WP_HOME',    $proto . '://' . $_SERVER['HTTP_HOST']);
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

