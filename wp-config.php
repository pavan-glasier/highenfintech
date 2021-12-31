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
define( 'DB_NAME', 'highen' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'aT!QqMu _PmD(g:5(J82Qc}d!<kO-M`CW:,4hG3o=}D/vhVH:H(4Y)x_89Zw9$(,' );
define( 'SECURE_AUTH_KEY',  'zxf!xs^dCbP#N/[Me1@l]^Bhi|%%dAm}EC6/d!1t@n.VZ_`9p`i?+SO@f=3Wd+vB' );
define( 'LOGGED_IN_KEY',    '|M4H5lCfI05>vPMqSM4sX$/46d%9IZ(cC2MbBGWeS82aA/,%18@{o6^dgJ~L#8l;' );
define( 'NONCE_KEY',        '~w.5,](~5cSO(V*;MvHi!K<BiQx0=|on.l<nM&t4-_?9x[*wx$?5J.#s[Vta,T]|' );
define( 'AUTH_SALT',        'NrtuQi^,/}b`*T)={N5 airaMbuc:z!IdL!<R)Yz.~j.uu;.V;i~ED`U(3VoX=t7' );
define( 'SECURE_AUTH_SALT', 'g{rC(~%Cve&{T%jQQ,{RVN_4tJa2(sHc~()LMh?IqAr<MIxK9+t_AQH({]xZwxYk' );
define( 'LOGGED_IN_SALT',   '(qt=jpV,v(dBM(d-ifDG8zC1J4jI}(!%[F^ZQ^vSEPjMz %Y~(&ejc#E=C>sh[Z|' );
define( 'NONCE_SALT',       '$U;,@OIpIV`>Y#p8j,~OIPJM%f%g(WZ3N*t~MwQ^-$nAg4Ls*N_9TTpl1=9PF(~L' );

/**#@-*/

/**
 * WordPress database table prefix.
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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
