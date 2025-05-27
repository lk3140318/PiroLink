<?php
/**
 * FileShare Theme Functions
 */

// Theme Setup
function fileshare_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('automatic-feed-links');
  add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
  add_theme_support('custom-logo');
}
add_action('after_setup_theme', 'fileshare_setup');

// Enqueue Scripts and Styles
function fileshare_enqueue_scripts() {
  wp_enqueue_style('fileshare-style', get_stylesheet_uri());
  wp_enqueue_script('fileshare-script', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'fileshare_enqueue_scripts');

// Register Custom Post Type for Files
function fileshare_register_file_post_type() {
  $args = array(
    'public' => true,
    'label'  => __('Files', 'fileshare'),
    'supports' => array('title', 'thumbnail', 'custom-fields'),
    'rewrite' => array('slug' => 'file'),
    'has_archive' => true,
    'menu_icon' => 'dashicons-media-default',
  );
  register_post_type('file', $args);
}
add_action('init', 'fileshare_register_file_post_type');

// Add Meta Fields for File Information
function fileshare_add_file_meta() {
  add_meta_box('fileshare_file_info', __('File Info', 'fileshare'), 'fileshare_file_meta_callback', 'file', 'normal', 'high');
}
add_action('add_meta_boxes', 'fileshare_add_file_meta');

function fileshare_file_meta_callback($post) {
  $file_url = get_post_meta($post->ID, '_fileshare_file_url', true);
  $file_type = get_post_meta($post->ID, '_fileshare_file_type', true);
  $file_size = get_post_meta($post->ID, '_fileshare_file_size', true);
  ?>
  <p>
    <label for="fileshare_file_url"><?php _e('File URL', 'fileshare'); ?></label>
    <input type="text" name="fileshare_file_url" value="<?php echo esc_attr($file_url); ?>" class="widefat" />
  </p>
  <p>
    <label for="fileshare_file_type"><?php _e('File Type', 'fileshare'); ?></label>
    <input type="text" name="fileshare_file_type" value="<?php echo esc_attr($file_type); ?>" class="widefat" />
  </p>
  <p>
    <label for="fileshare_file_size"><?php _e('File Size', 'fileshare'); ?></label>
    <input type="text" name="fileshare_file_size" value="<?php echo esc_attr($file_size); ?>" class="widefat" />
  </p>
  <?php
}

function fileshare_save_file_meta($post_id) {
  if (isset($_POST['fileshare_file_url'])) {
    update_post_meta($post_id, '_fileshare_file_url', sanitize_text_field($_POST['fileshare_file_url']));
  }
  if (isset($_POST['fileshare_file_type'])) {
    update_post_meta($post_id, '_fileshare_file_type', sanitize_text_field($_POST['fileshare_file_type']));
  }
  if (isset($_POST['fileshare_file_size'])) {
    update_post_meta($post_id, '_fileshare_file_size', sanitize_text_field($_POST['fileshare_file_size']));
  }
}
add_action('save_post', 'fileshare_save_file_meta');

// SEO and Social Meta Tags
function fileshare_seo_meta() {
  if (is_singular('file')) {
    $file_url = get_post_meta(get_the_ID(), '_fileshare_file_url', true);
    $file_type = get_post_meta(get_the_ID(), '_fileshare_file_type', true);
    ?>
    <meta name="description" content="Download <?php the_title(); ?> (<?php echo esc_attr($file_type); ?>)">
    <meta property="og:title" content="<?php the_title(); ?>">
    <meta property="og:description" content="Download or preview this <?php echo esc_attr($file_type); ?> file.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php the_permalink(); ?>">
    <meta property="og:image" content="<?php echo get_the_post_thumbnail_url(); ?>">
    <?php
  }
}
add_action('wp_head', 'fileshare_seo_meta');
?>
