<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

define( 'WP_HOME', 'http://localhost/nhangvanthanh.vn' );
define( 'WP_SITEURL', 'http://localhost/nhangvanthanh.vn' );

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'bannhan' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         '5T#Ruj1Z}k,82(-4+?lp3`]{qYv[q7Ubk0Y0rySvd-3rCBySt]T)68%(Sgk[i58z' );
define( 'SECURE_AUTH_KEY',  'jz$PNG5F!MhPGn]@*XkbG#kC`~je*Vx@[Ng(6>^yBaN/]voNxjBB7Z,KOaK%]* a' );
define( 'LOGGED_IN_KEY',    '4:=]<!(]oIhD0kL1s`&8sOiflTD$L;]xI_2Tm-FF?9Ze}}KA~0%^PO:ZMLxq{e~3' );
define( 'NONCE_KEY',        '{7<p=wax]qMQ~/^r[;vPN?dO1hyr(PmEC##2 Fl9&0Ao7*G`y_@i{;Hlw|&h2n&4' );
define( 'AUTH_SALT',        'Rp]Ns!#]2XT95!)sQi?~vE`<ol~pIiJC!MB1m@Bi;I)X?q/!BiK7+oH^L}3,0L#&' );
define( 'SECURE_AUTH_SALT', 'ph1<+TKwj>mb5e,?X; +,h;=#Qu?g)WE6Xd?*B[hyllY=gHr!EW{91 I|rG-ygl(' );
define( 'LOGGED_IN_SALT',   'O|nH(z-#GqNd}/WMvoB[g--P^z6AUQ{8N08sl904AhNYZfM+.kyj]+i5Md^j^5T1' );
define( 'NONCE_SALT',       'Is]yUGJ9z]DhN_&=l0TQxl|dJAoiu=ZPe{acQE+W&0mwBM XB]USI3;yAJ{2OYc$' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpgt_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
