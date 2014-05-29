<div class="off-canvas-wrap hide-for-large-up">
  <div class="inner-wrap">

    <nav class="tab-bar fixed">
      <section class="left tab-bar-section">
        <h1>
            <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
        </h1>
      </section>
      <section class="right-small">
        <a class="left-off-canvas-toggle menu-icon" >
          <span></span>
        </a>
      </section>
    </nav>

    <aside class="left-off-canvas-menu">
        <ul class="off-canvas-list">
          <li><label><?php _e('Menu', 'smart'); ?></label></li>
        </ul>
        <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => '', 'items_wrap' => '<ul id="%1$s" class="%2$s off-canvas-list">%3$s</ul>' ) ); ?>
        <?php dynamic_sidebar( 'offcanvas-1' ); ?>
    </aside>

    <a class="exit-off-canvas"></a>

  </div>
</div>