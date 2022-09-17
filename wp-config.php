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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'toyfull' );

/** Database username */
define( 'DB_USER', 'httt_dn' );

/** Database password */
define( 'DB_PASSWORD', '7Llr!fBn82It' );

/** Database hostname */
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
define( 'AUTH_KEY',         'hy$;Hj` kT~c2G/4]Wg&_NNT4=V|W<U,r(Eb<<]Eo(y*c/R4#C^M13qPP#B!ND Y' );
define( 'SECURE_AUTH_KEY',  '!H957[E`.<ZXuCna;4+^,wT/eELhZ`T{V<zT>;J^:{N(is-=6}4A+12d!9{h3B/)' );
define( 'LOGGED_IN_KEY',    '7f50M.rj{LiOUY4d&D$6&`@3_ #diK^Hs1$Q`~`fAywP{41S20:8iPY]6rP=4PCY' );
define( 'NONCE_KEY',        'LqZbbKVk]+B.;u5<#TAp1)s+hk:oCXKwD,dFWPa&xE+S/=5B?b]#e:`2[QS(=CQ1' );
define( 'AUTH_SALT',        'J2SY}9Q5~dZTYIo{1iD Udcu)d :4hR9_m?TQ$Mb+2SkxvnW?(zq([ue7qIfRrHE' );
define( 'SECURE_AUTH_SALT', '<A2,kf}7q}n=pr^.5DiSVAOHViLP6P8^b2!~.d5rzx^iSBCL4n@9$VYz~sj|jd=d' );
define( 'LOGGED_IN_SALT',   'd02(:*[W`@}:WzbD]HZaT3D(JacHaUA1_it[g?}ZHEg)GOT}5RG?G*[bJ?ZKfs>P' );
define( 'NONCE_SALT',       ' )2*7z=XFo00`7EXby,w<zx-H5@h&;w+;3{5Y}0l1M/)iPuTnS](Mm?,|4k$>HI&' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'tf_';

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
