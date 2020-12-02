<?php
get_header();
?>

<div class="md:flex container mx-auto pt-4">
    <div class="md:w-2/3 md:mr-2">
        <?php
        //
        // Only used for archive and search
        //
        $pageHeader = null;
        if (is_category()) {
            $categories = get_the_category();
            $pageHeader = 'Category: '.esc_html($categories[0]->name);
            
        } 

        if (is_search()) {
            $pageHeader = 'Search results for: <span class="italic">'.esc_html($_GET['s']).'</span>';
        }
        
        if (null !== $pageHeader) {
            ?>
            <div class="bg-white shadow-md mx-2 lg:mx-0 mb-4 p-6">
                <h1 class="text-2xl mb-1"><?php echo $pageHeader;?></h1>
            </div>
            <?php
        }        

        ?>
        <?php 
            if ( have_posts() ) {
                while ( have_posts() ) {
                    the_post();                
                    ?>
                    <div class="bg-white shadow-md mx-2 mb-4">
                        <?php
                        $postThumbnail = get_the_post_thumbnail(null, 'post-thumbnail', ['class' => 'mb-0 ']);
                        if (!empty($postThumbnail)) {
                            echo '<a href="'.get_permalink().'">'.$postThumbnail.'</a>';
                        }                        
                        ?>
                        <article class="p-4 w-content">
                            <a href="<?php echo get_permalink();?>"><h1><?php the_title(); ?></h1></a>
                            <div class="text-xs flex">Publicerad <?php the_date();?><span class="mx-1">|</span><?php the_category(); ?></div>
                            <hr class="mt-3 mb-4 text-gray-200" />
                            <?php the_content(); ?>                            
                        </article>
                    </div>
                    <?php
                    tailwindPagination();
                } // end while
            }
            else {
                ?>
                <div class="bg-white shadow-md mx-2 lg:mx-0 mb-4">
                    <div class="p-4 w-content">
                        <p>404 - Not found</p>
                    </div>
                </div>
                <?php
            } // end if
            ?>
    </div>
    <div class="md:w-1/3 md:ml-2">
        <?php get_sidebar('sidebar-1'); ?>
    </div>
</div>

<?php get_footer();