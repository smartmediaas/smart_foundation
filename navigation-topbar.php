<div class="contain-to-grid fixed hide-for-large-up">
    <nav class="top-bar" data-topbar>
        <ul class="title-area">
            <li class="name">
                <h1>
                    <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
                </h1>
            </li>
            <?php if( has_nav_menu( 'primary' ) ){ ?>
                <li class="toggle-topbar menu-icon">
                    <a href="#">
                        <?php _e('Menu', 'smart'); ?> 
                    </a>
                </li>
            <?php } ?>
        </ul>
        <section class="top-bar-section">
            <?php foundation_top_bar(); ?>
        </section>
    </nav>
</div>