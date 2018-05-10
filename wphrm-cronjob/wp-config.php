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
define('DB_NAME', 'joomlacu_ss_dbname98d');

/** MySQL database username */
define('DB_USER', 'joomlacu_ss_d98d');

/** MySQL database password */
define('DB_PASSWORD', 'POKKitYztFhe');

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
define('AUTH_KEY', 'zP&T;N*)MznjJ_Qrd$}ll?)*WC{^{nv&!AQ^-gZbmTysZ[tYfwo[zyB%OCfD;kdjZ@rwynIvLKn^kXBG(<tfdIvcuR|R[jeJdQ+M(?oO&zA;>UqyGhxsY)oIseY$!;mG');
define('SECURE_AUTH_KEY', 'S&]c-gR>)M|=<Ia=wGp_}<KN=J/gFZoIvgjD{Q(YdNzTyj|pAtB%Dt!-KfqU@xzff<;n-;dJ<+ktTpqDVItLP(^I>_Faw}go)F![-XKkEatQdLzSr^zOQqbF<Tz+Z+D-');
define('LOGGED_IN_KEY', 'BVV!P;TyspS&QsOA)v+-M$^[Dxp]}hm<gwjaAS@GAet_df^W>l@L$U)bORWDldL+|dB)DvXIaQPQTH|xOj;WJdvdOV<=Fse)QRbMW)wwN_Pf/EMmVi@zL(PU]uWQE@{&');
define('NONCE_KEY', 'v?r@L?VPyNZ-_G?RMaMBma<GcCOlgBFq<t{rmECgD]txX)VahYpHplKmMW_[apFZA{MkP>a(xRf^]Jd_yME]Bw=-%tS;*%Z/UXD;<=oPac)Q_]|oil!E?_)YXeWlbiqo');
define('AUTH_SALT', 'NcV>;o*D*K<n%aW!^u%_r&)XnWevoSGrCX-Nuw?=Ad-e]YEK=S_nuivkpiiy(KWG%[voa=a{UaDYX-aJUIqtsFb_E=T&VjWhCmK$NJnZJMC+U;_hli%bAbSj%^pJapdi');
define('SECURE_AUTH_SALT', 'yIcL$MU*swyQUsWpyXu$ZhyBG/PhEAaTOHYBSTXnMb<+%<^|^fHmUMz;V!FPP>+LFuD?U{ihR|>vCAusD<QB+BPVjC&ydy[+BY+Ka|-nX([MHfRa+DFa=<c<OoLFlk+/');
define('LOGGED_IN_SALT', 'wQEKCC<QhSU+Q*s]nYJwQuwkj(_^}MqDgi+M^aUYHEXzz>P-lLCj?l^)DVox{@SM-%uMfRg>cH)GAl>Q|y>Z{fO-=o>^|$F;uYAUy&uRnJdQOoZ;dVNBScz@ab%/*+mI');
define('NONCE_SALT', 'GB{_XF]dw*R|G@WZ)ebnY+Tsvt/sYPHm-Dr[!=mw_$^NP}k_CF(rdE]Dg+@QaFqgS]T-J*aUWo;D?SPQnp)H>%D(xaXDi=U{]BXrI)vpfJ@cs=g%ZVn;FF?z)<iBEj}c');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_mnbt_';

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
define('WP_DEBUG', false);

define( 'AUTOSAVE_INTERVAL', 300 );
define( 'WP_POST_REVISIONS', 5 );
define( 'EMPTY_TRASH_DAYS', 7 );
define( 'WP_CRON_LOCK_TIMEOUT', 120 );
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
