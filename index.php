<?php get_header(); ?>

<?php get_template_part( 'navigation', 'default' ); ?>

<div class="container main-container">
  <div class="row">
    <div class="col-lg-9">
<?php
  if ( have_posts() ) :
    while ( have_posts() ) : the_post();
      get_template_part( 'content', get_post_format() );
    endwhile;
      $b4->the_posts_pagination();
  else :
    ?><p><?php _e('Sorry, no posts matched your criteria.', 'b4'); ?></p><?php
  endif;
?>
    </div><!-- .col -->
    <div class='col-lg-3'>
      <?php dynamic_sidebar('Right Sidebar'); ?>
    </div><!-- .col -->
  </div><!-- .row -->
</div><!-- .container.main-container -->

<?php get_footer(); ?>
