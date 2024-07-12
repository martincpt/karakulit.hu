<?php


/**
 * A WordPress fő konfigurációs állománya
 *
 * Ebben a fájlban a következő beállításokat lehet megtenni: MySQL beállítások
 * tábla előtagok, titkos kulcsok, a WordPress nyelve, és ABSPATH.
 * További információ a fájl lehetséges opcióiról angolul itt található:
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 *  A MySQL beállításokat a szolgáltatónktól kell kérni.
 *
 * Ebből a fájlból készül el a telepítési folyamat közben a wp-config.php
 * állomány. Nem kötelező a webes telepítés használata, elegendő átnevezni
 * "wp-config.php" névre, és kitölteni az értékeket.
 *
 * @package WordPress
 */

// ** MySQL beállítások - Ezeket a szolgálatótól lehet beszerezni ** //
/** Adatbázis neve */
define( 'DB_NAME', 'karakulit.hu_master' );

/** MySQL felhasználónév */
define( 'DB_USER', 'karakulit.hu_master' );

/** MySQL jelszó. */
define( 'DB_PASSWORD', 'iJ2(0N&ReyRp-k(S' );

/** MySQL  kiszolgáló neve */
define( 'DB_HOST', 'localhost' );

/** Az adatbázis karakter kódolása */
define( 'DB_CHARSET', 'utf8mb4' );

/** Az adatbázis egybevetése */
define('DB_COLLATE', '');

/**#@+
 * Bejelentkezést tikosító kulcsok
 *
 * Változtassuk meg a lenti konstansok értékét egy-egy tetszóleges mondatra.
 * Generálhatunk is ilyen kulcsokat a {@link http://api.wordpress.org/secret-key/1.1/ WordPress.org titkos kulcs szolgáltatásával}
 * Ezeknek a kulcsoknak a módosításával bármikor kiléptethető az összes bejelentkezett felhasználó az oldalról.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY', 'GP+CfoxI|iWV8Ek+HLWtG&e9b=3<$&vJAq#]!D8E8nbW0+ttw17o4+weW`&HF8y@' );
define( 'SECURE_AUTH_KEY', '}$]Fiu- #k6X3e (vmGfeG4&`jW^xrOb;cRF%GUDXbX0MUnO${Q[d@c#RF8yo$]Z' );
define( 'LOGGED_IN_KEY', '!;:&4q}|;_}xRe%1.H:VQjezyKrYGwE:^S(~))x:>Yrk{]PPomHtr8*0`PIm1IU|' );
define( 'NONCE_KEY', 'p(bb3^cdk+Tn[B[t*Mfn!0GvuRpDH~GS/$:BiEfO|*`vJ7U}Ws~g#{5$G)79Bwn[' );
define( 'AUTH_SALT',        '[dRl2B=3I,E}AJ_x>;vUVd6^jgsqoF4q%#;v&z2(oC#Pq?FQYk)auKR8:E;G_E{$' );
define( 'SECURE_AUTH_SALT', 'cK]=sr><2ghda~|(L^wge%P)Bx~~BZT4s*aWF3`U[z]ic<=-TyW%i:Af}jf15XIy' );
define( 'LOGGED_IN_SALT',   '-<_vU~Sr<KU%~S$s#1beA3oC;Yb.#[jj(=t75rs.vS fUcnuaFe0gW^}oq}X_{K=' );
define( 'NONCE_SALT',       'hA);0-0n7apfG!lS9|/a/,&)S[w#fZDWg+(Zi2=;}*1+FBlA)?2d]_b(WG11Kh8_' );

/**#@-*/

/**
 * WordPress-adatbázis tábla előtag.
 *
 * Több blogot is telepíthetünk egy adatbázisba, ha valamennyinek egyedi
 * előtagot adunk. Csak számokat, betűket és alulvonásokat adhatunk meg.
 */
$table_prefix = 'wp_';

/**
 * Fejlesztőknek: WordPress hibakereső mód.
 *
 * Engedélyezzük ezt a megjegyzések megjelenítéséhez a fejlesztés során.
 * Erősen ajánlott, hogy a bővítmény- és sablonfejlesztők használják a WP_DEBUG
 * konstansot.
 */
define('WP_DEBUG', false);

/* Ennyi volt, kellemes blogolást! */
/* That's all, stop editing! Happy publishing. */

/** A WordPress könyvtár abszolút elérési útja. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Betöltjük a WordPress változókat és szükséges fájlokat. */
require_once(ABSPATH . 'wp-settings.php');
