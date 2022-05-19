<?php

// Add Theme Support
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'html5' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'customize-selective-refresh-widgets' );

// Load in our CSS
function wphierarchy_enqueue_styles() {

  wp_enqueue_style( 'roboto-slab-font-css', 'https://fonts.googleapis.com/css?family=Roboto+Slab', [], '', 'all' );
  wp_enqueue_style( 'main-css', get_stylesheet_directory_uri() . '/style.css', ['roboto-slab-font-css'], time(), 'all' );
  wp_enqueue_style( 'custom-css', get_stylesheet_directory_uri() . '/assets/css/custom.css', [ 'main-css' ], time(), 'all' );

}
add_action( 'wp_enqueue_scripts', 'wphierarchy_enqueue_styles' );

// Load in our JS
function wphierarchy_enqueue_scripts() {

  if ( is_page_template( 'custom.php' ) ) {
    wp_enqueue_script( 'axios', 'https://unpkg.com/axios/dist/axios.min.js', [], null, true );
    wp_enqueue_script( 'vue-js', 'https://unpkg.com/vue@2.4.1', [ 'axios' ], null, true );
    wp_enqueue_script( 'my-vue-js', get_stylesheet_directory_uri() . '/assets/js/myvue.js', [ 'vue-js' ], time(), true );

    wp_localize_script('my-vue-js', 'jsforwp_vars', array(
            'site_url' => esc_url( site_url() )
        )
    );

  }
  //  wp_enqueue_script( 'jquery-theme-js', get_stylesheet_directory_uri() . '/assets/js/jquery.theme.js', [ 'jquery' ], time(), true );


}
add_action( 'wp_enqueue_scripts', 'wphierarchy_enqueue_scripts' );

// Remove version number from CDN urls
// From https://www.virendrachandak.com/techtalk/how-to-remove-wordpress-version-parameter-from-js-and-css-files/
function jsforwp_remove_ver_from_cdn( $src ) {
    if ( strpos( $src, 'unpkg.com' )  )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'jsforwp_remove_ver_from_cdn', 9999 );
add_filter( 'script_loader_src', 'jsforwp_remove_ver_from_cdn', 9999 );

// Control header for the_title
function wphierarchy_title_markup( $title, $id = null ) {

    if ( !is_singular() && in_the_loop() ) {

      $title = '<h2><a href="' . get_permalink( $id ) . '">' . $title . '</a></h2>';

    } else if ( is_singular() && in_the_loop() ) {

      $title = '<h1>' . $title . '</h1>';

    }

    return $title;
}
add_filter( 'the_title', 'wphierarchy_title_markup', 10, 2 );

// Register Menu Locations
register_nav_menus( [
  'main-menu' => esc_html__( 'Main Menu', 'wpheirarchy' ),
]);


// Setup Widget Areas
function wphierarchy_widgets_init() {
  register_sidebar([
    'name'          => esc_html__( 'Main Sidebar', 'wphierarchy' ),
    'id'            => 'main-sidebar',
    'description'   => esc_html__( 'Add widgets for main sidebar here', 'wphierarchy' ),
    'before_widget' => '<section class="widget">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ]);
}
add_action( 'widgets_init', 'wphierarchy_widgets_init' );


?>
