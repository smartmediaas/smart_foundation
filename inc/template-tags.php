<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package smart_foundation
 */

if ( ! function_exists( 'smart_pagination' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @return void
 */

function smart_pagination($pages = '', $range = 2)
{  
        $showitems = ($range * 2)+1;  
        
        global $paged;
        if(empty($paged)) $paged = 1;
        
        if($pages == ''){
                global $wp_query;
                $pages = $wp_query->max_num_pages;
                if(!$pages){
                        $pages = 1;
                }
        }   
        
        if(1 != $pages){
        echo '<ul class="pagination">';
        if($paged > 2 && $paged > $range+1){
                echo '<li class="arrow"><a href="'.get_pagenum_link(1).'">&laquo;</a></li>';        
        }elseif($showitems < $pages){
                echo '<li class="arrow unavailable"><a href="">&laquo;</a></li>';
        }
        if($paged > 1){
                echo '<li class="arrow"><a href="'.get_pagenum_link($paged - 1).'">&lsaquo;</a></li>';
        }elseif($showitems < $pages){
                echo '<li class="arrow unavailable"><a href="">&lsaquo;</a></li>';        
        }
        
        for ($i=1; $i <= $pages; $i++){
                if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
                        echo ($paged == $i)? '<li class="current"><a href="">'.$i.'</a></li>':'<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
                }
        }
        
        if ($paged < $pages){
                echo '<li class="arrow"><a href="'.get_pagenum_link($paged + 1).'">&rsaquo;</a>';
        }elseif($showitems < $pages){
                echo '<li class="arrow unavailable"><a href="">&rsaquo;</a>';
        }
        if ($paged < $pages-1 &&  $paged+$range-1 < $pages){
                echo '<li class="arrow"><a href="'.get_pagenum_link($pages).'">&raquo;</a></li>';
        }elseif($showitems < $pages){
                echo '<li class="arrow unavailable"><a href="">&raquo;</a></li>';
        }
         echo "</ul>\n";
        }
}
endif;

if ( ! function_exists( 'smart_img' ) ) :
/**
 * Custom image retriever.
 * Will automatically retrieve images from the theme images folder
 */ 

function smart_img( $src = '', $args = '' ){
	$bgstyles_defaults = array( 
							'background-repeat' => 'no-repeat', 
							'background-position' => 'center', 
							'background-size' => 'contain', 
							'height' => '230px');
	$defaults = array(
		'type'				=>	'imgdir',	// thumbnail, imgdir, placeholder, input
		'id'				=>	'', // image id attribute
		'class'				=>	'', // image class attribute
		'alt'				=>	'', // image alt attribute
		'title'				=>	'', // image title attribute
		'data'				=>	array(), // data tags associative array. 
		'image_size'		=>	'full', // base on image size
		'resize'			=>	true, // apply resizer	
		'width'				=>	640,
		'height'			=>	400,
		'crop'				=>	true, 
		'retina'			=> 	false, // retina image twice the dimensions
		'return'			=>	'image', // image, src
		'bgbox'				=>	false, // set image as background on a <div>
		'bgstyles'			=>	$bgstyles_defaults, // styles for bgbox associative array
		'fallback'			=>	'', // fallback image from /images/
		'echo'				=>	true
	);
	$args = wp_parse_args( $args, $defaults );
	extract( $args, EXTR_SKIP );
	$bgstyles = wp_parse_args( $bgstyles, $bgstyles_defaults );

	$retina = ($retina === true || $retina === 'true' ? true : false);
	$resize = ($resize === true || $resize === 'true' ? true : false);
	$crop = ($crop === true || $crop === 'true' ? true : false);
	$bgbox = ($bgbox === true || $bgbox === 'true' ? true : false);
	$echo = ($echo === true || $echo === 'true' ? true : false);

	if( strpos($type, ',') ) : $type_array = explode( ',', $type); $type = $type_array[0]; endif;
	
	switch ( $type ) {
		case 'thumbnail':
			$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), $image_size );
			$image_url = $image_url[0];
			break;

		case 'placeholder':
			$image_url = 'http://lorempixel.com/' . $width . '/' . $height;
			if($type_array) $image_url .= '/' . $type_array[1] . '/' . rand(1,10);
			break;

		case 'input':
			$image_url = $src;
			break;
		
		default:
			$image_url = get_stylesheet_directory_uri() . '/images/' . $src;
			if( !$src ) $image_url = 'http://lorempixel.com/' . $width . '/' . $height;
			break;
	}

	if( !$type == 'placeholder' ){
		if( $resize ){
			$image_url = matthewruddy_image_resize( $image_url, $width, $height, $crop, $retina );
			$image_url = $image_url['url'];
		}
	}
	if( !$image_url ){
		if($fallback){
			$image_url = get_stylesheet_directory_uri() . '/images/' . $fallback;
			if( $resize ){
				$image_url = matthewruddy_image_resize( $image_url, $width, $height, $crop, $retina );
				$image_url = $image_url['url'];
			}
		}
	}

	if( $data ){
		foreach ($data as $key => $value) {
			$data_return .= 'data-'. $key;
			if( $value ) $data_return .= '="' .$value . '" ';
		}
	}

	if( $bgstyles ){
		foreach ($bgstyles as $key => $value) {
			$bgstyles_return .= $key . ':' . $value . ';';
		}
	}

	if( $bgbox ){
		$image_return = '<div';
		if( $id ) $image_return .= ' id="' . $id . '"';
		$image_return .= ' class="smart-aspect ' . $class . '"';
		$image_return .= ' style="background-image:url(' . $image_url . ');';
		$image_return .= $bgstyles_return . '"';
		if( $data ) $image_return .= ' ' . $data_return;

		$image_return .= '></div>';
	
	}else{
		$image_return = '<img src="' . $image_url . '"';

		if( $id ) $image_return .= ' id="' . $id . '"';
		if( $class ) $image_return .= ' class="' . $class . '"';
		if( $alt ) $image_return .= ' alt="' . $alt . '"';
		if( $title ) $image_return .= ' title="' . $title . '"';
		if( $data ) $image_return .= ' ' . $data_return;

		$image_return .= '/>';
	}

	if( $return == 'src' ) $image_return = $image_url;

	if(!$image_url) $image_return = '';
	
	if( $echo ) {
		echo $image_return;
	} else {
		return $image_return;
	}
	
}

endif;


if ( ! function_exists( 'smart_clear' ) ) :
/**
 * Custom clear fix.
 * What it says on the box
 */
function smart_clear(){
    echo '<div class="smart-clear" style="clear:both;"></div>';
}
endif;


if ( ! function_exists( 'smart_foundation_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function smart_foundation_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'smart_foundation' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'smart_foundation' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link',     'smart_foundation' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'smart_foundation_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function smart_foundation_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( __( '<span class="posted-on">Posted on %1$s</span><span class="byline"> by %2$s</span>', 'smart_foundation' ),
		sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
			esc_url( get_permalink() ),
			$time_string
		),
		sprintf( '<span class="author"><a class="url fn n" href="%1$s">%2$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		)
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function smart_foundation_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'smart_foundation_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'smart_foundation_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so smart_foundation_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so smart_foundation_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in smart_foundation_categorized_blog.
 */
function smart_foundation_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'smart_foundation_categories' );
}
add_action( 'edit_category', 'smart_foundation_category_transient_flusher' );
add_action( 'save_post',     'smart_foundation_category_transient_flusher' );
