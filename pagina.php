<?php
/**
 * Archivo principal del tema (index.php)
 * Plantilla básica de WordPress
 */

get_header(); // Carga header.php
?>

<main id="primary" class="site-main">

    <?php if ( have_posts() ) : ?>

        <?php if ( is_home() && ! is_front_page() ) : ?>
            <header>
                <h1 class="page-title">
                    <?php single_post_title(); ?>
                </h1>
            </header>
        <?php endif; ?>

        <?php
        // Loop de WordPress
        while ( have_posts() ) :
            the_post();
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                <header class="entry-header">
                    <?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>
                </header>

                <div class="entry-content">
                    <?php the_excerpt(); ?>
                </div>

                <footer class="entry-footer">
                    <span class="posted-on">
                        Publicado el <?php echo get_the_date(); ?>
                    </span>
                </footer>

            </article>

        <?php endwhile; ?>

        <?php
        // Navegación entre páginas
        the_posts_navigation();
        ?>

    <?php else : ?>

        <section class="no-results">
            <h2>No se encontraron entradas</h2>
            <p>Intenta con otra búsqueda.</p>
        </section>

    <?php endif; ?>

</main>

<?php
get_sidebar(); // Carga sidebar.php
get_footer(); // Carga footer.php
?>
