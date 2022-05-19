<?php
  // Template Name: Custom JS Page
  get_header();
?>

  <div id="primary" class="content-area">

    <main id="main" class="site-main" role="main">

      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>"  <?php post_class(); ?>>

          <header class="entry-header">

            <?php the_title(); ?>

          </header>

          <div class="entry-content">

            <div id="app"></div>

          </div>

        </article>

      <?php endwhile; endif; ?>

    </main>

  </div>

  <?php get_sidebar(); ?>

<?php get_footer(); ?>
