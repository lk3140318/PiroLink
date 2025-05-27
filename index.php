<?php get_header(); ?>
<div class="hero-section">
  <h1 class="text-4xl font-bold">Share and Download Files Easily</h1>
  <p class="text-lg mt-4">Upload your files and get shareable links instantly.</p>
  <a href="#upload" class="upload-btn mt-6 inline-block">Upload Now</a>
</div>

<section class="file-grid">
  <h2 class="text-2xl font-semibold text-center mb-6">Latest Files</h2>
  <?php
  $args = array('post_type' => 'file', 'posts_per_page' => 6);
  $query = new WP_Query($args);
  if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
      ?>
      <div class="file-card">
        <?php if (has_post_thumbnail()) : ?>
          <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>" class="w-full h-40 object-cover rounded">
        <?php endif; ?>
        <h3 class="text-lg font-semibold mt-2"><?php the_title(); ?></h3>
        <p class="text-sm text-gray-600"><?php echo get_post_meta(get_the_ID(), '_fileshare_file_type', true); ?></p>
        <a href="<?php the_permalink(); ?>" class="text-blue-600 hover:underline">View File</a>
      </div>
      <?php
    endwhile;
    wp_reset_postdata();
  else :
    echo '<p>No files found.</p>';
  endif;
  ?>
</section>

<section class="categories py-8">
  <h2 class="text-2xl font-semibold text-center mb-6">Browse by Category</h2>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 px-4">
    <a href="<?php echo get_post_type_archive_link('file'); ?>?type=video" class="text-center p-4 bg-gray-100 rounded">Videos</a>
    <a href="<?php echo get_post_type_archive_link('file'); ?>?type=audio" class="text-center p-4 bg-gray-100 rounded">Audio</a>
    <a href="<?php echo get_post_type_archive_link('file'); ?>?type=image" class="text-center p-4 bg-gray-100 rounded">Images</a>
    <a href="<?php echo get_post_type_archive_link('file'); ?>?type=document" class="text-center p-4 bg-gray-100 rounded">Documents</a>
  </div>
</section>

<?php get_footer(); ?>
