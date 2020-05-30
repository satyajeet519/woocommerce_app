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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'task' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost:8889' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'zH8ME4[Ig*R/}hrVU MN9S!Q#*HIc9MUM&kMj6)F&gd{E@Fzn/.Et!BIu_v2+OmF' );
define( 'SECURE_AUTH_KEY',  'F~rSfwj?CG_rV}*+~pfOGh1Kb!QS{6(yyN3>T;V@_,<Im3SV@NmkFftzO0BS|u.P' );
define( 'LOGGED_IN_KEY',    'c`][vv?_sZslLjtYVhyR(K+1]s(66T1{`VZ9x!@?w?m4n#LM-8d%5qike4d?4C1_' );
define( 'NONCE_KEY',        '1rMQXL.V2pq(}L !uEs+c6K|kT/@-^<wt8v9m6*W+{Gd-R84$Cw_)Ijx8@}UmCew' );
define( 'AUTH_SALT',        'TkFzzAEVXkh-&~eE(?u<&8T+00Pa$Hl-H{.jAF>jF:7KD%*sYCt1q|B3s09{62l]' );
define( 'SECURE_AUTH_SALT', 'wE8FyRfk`4yas.#+X|kPSwGWquOB4UMn,C>_.%ZMd,s-31y? HAOg~qb#C*79aem' );
define( 'LOGGED_IN_SALT',   '&j*gR4z7Qn@axWT-l1l,*FqlTKTjt8*WlckS3!>9{CnKJVTdW8u}g%wm&[JPP!#c' );
define( 'NONCE_SALT',       'HGdd3IaQUVa1(oKCbzz)$v@xEnv[B5JkHLo@hmgwW=VwfeK}+MVi`Wo!J5<eEj_E' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
