<?php
get_header();
?>

<div class="md:flex container mx-auto pt-4">
    <div class="md:w-2/3 md:mr-2">
        <div class="bg-white shadow-md mx-2 lg:mx-0 mb-4">
        <?php 
            if ( have_posts() ) {
                while ( have_posts() ) {
                    the_post(); 

                    $postThumbnail = get_the_post_thumbnail(null, 'post-thumbnail', ['class' => 'mb-4 ']);
                    if (!empty($postThumbnail)) {
                        echo $postThumbnail;
                    }
                    ?>
                    <article class="p-4 w-content">
                        <h1><?php the_title(); ?></h1>
                        <hr class="mb-4 text-gray-200" />
                        <?php the_content(); ?>
                    </article>
                    <?php
                } // end while
            } // end if
            ?>
        </div>
    </div>
    <div class="md:w-1/3 md:ml-2">
        <?php get_sidebar('sidebar-1'); ?>
    </div>
</div>

<?php get_footer();