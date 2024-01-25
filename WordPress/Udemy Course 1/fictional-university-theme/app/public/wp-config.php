<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'b6330Kq?9`bb5w#O>,^[G9y,e7#Y1jCdB~GrKj&q5E,T6X.J(6wpwpn7KAbjd)%5' );
define( 'SECURE_AUTH_KEY',   'us_-w^YnZtP^o5lyvXdY[Rok2qxQR;+oc,Z{0Sb^8OB*+W-@ray$mvu]mn)mI^Gu' );
define( 'LOGGED_IN_KEY',     'gF4(^@+Q*`IXLcT%:F[`o*h8o:d7MUm_X$(K#<&en[_z*2+x3%Egq!&a;UIHGY@Z' );
define( 'NONCE_KEY',         '&;!yb~j*G>75rV=t7% $okV?y&|m&(LO5c0gk6n=*Ne*{b.dqA9X~~^4ey5I*H0G' );
define( 'AUTH_SALT',         'Pw7E-5[Jld[a$,}VjB<^=oRT<#?YQ?sfW:T02@BqtSLq!u~>l*9za&#MM }35*bc' );
define( 'SECURE_AUTH_SALT',  'Q7 ;/+/<p#55!_7 g_Tbz=&U$g*a]0]+lE4a|8x_<;8=yp2$?R,1AhGGky()hWn~' );
define( 'LOGGED_IN_SALT',    'kZ+F>>EPBxQzF~]yH6=V1)h|0w6K]<!ZNO61Z4~iV7H.Q(1cewYgnoy qJKIMm1)' );
define( 'NONCE_SALT',        'HaS}QGFs&9 5U.!?x(0L3xvFy!675-]a^.8ClrX_OlXYp.4 8lp_gX|%q-?]>S:9' );
define( 'WP_CACHE_KEY_SALT', 'E7POo<i3_0!mjemYEma]]N:}MA^9C=9=);99cKXlIc!KVX@t@I~$xl)TrMsQRorO' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
