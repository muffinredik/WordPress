<?php
//REST API Link entfernen
//Füge diesen Code in deine functions.php ein
remove_action('wp_head', 'rest_output_link_wp_head');

//Standard WordPress DNS-Prefetch entfernen
//Füge diesen Code in deine functions.php ein
add_filter( 'emoji_svg_url', '__return_false' );
remove_action('wp_head', 'wp_resource_hints', 2);

//WP-Embed JavaScript entfernen
//Füge diesen Code in deine functions.php ein
function delete_wpembed() {
wp_deregister_script( 'wp-embed' );
}
add_action('wp_enqueue_scripts', 'delete_wpembed', 9999);

//oEmbed-Links entfernen
//Füge diesen Code in deine functions.php ein
remove_action('wp_head','wp_oembed_add_discovery_links' );

//RSD Link entfernen (braucht man nicht, wenn man WordPress nur im Browser nutzt)
//Füge diesen Code in deine functions.php ein
remove_action('wp_head', 'rsd_link');

//WLW Link entfernen (Exitsiert für einen WordPress Windows Editor)
//Füge diesen Code in deine functions.php ein
remove_action('wp_head', 'wlwmanifest_link');

//Meta Generator WordPress entfernen (gibt die WordPress Version als meta Tag mit)
//Füge diesen Code in deine functions.php ein
remove_action('wp_head', 'wp_generator');

//WordPress Seiten- & Beitrags-Shortlink entfernen (z.B. domain.at?p=234, braucht man nicht, 
//wenn shorturl notwendig, dann Google url shortener verwenden) 
//Füge diesen Code in deine functions.php ein
remove_action('wp_head', 'wp_shortlink_wp_head');

//RSS Links entfernen
//Füge diesen Code in deine functions.php ein
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);

//Pingback entfernen (Kommunikation zwischen WordPress Seiten, im Fall einer Verlinkung)
//Entferne diese Zeile aus der header.php Datei deines Themes
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
