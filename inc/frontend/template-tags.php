<?php
/**
 * InkPro template tags
 *
 * @package WordPress
 * @subpackage InkPro
 * @since 1.0.0
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Output the logo on 404 pages
 *
 * @version 2.0.3
 * @return string
 */
function inkpro_404_logo() {
	$logo_light = apply_filters( 'inkpro_logo_404', wolf_get_theme_mod( 'logo_light' ) );

	if ( $logo_light ) {
		echo '<img src="' . esc_url( $logo_light ) . '" alt="logo-404">';
	}
}

/**
 * Output the Logo
 *
 * @version 2.0.3
 * @return string
 */
function inkpro_logo( $echo = true ) {

	$logo_light = apply_filters( 'inkpro_logo_light', wolf_get_theme_mod( 'logo_light' ) );
	$logo_dark = apply_filters( 'inkpro_logo_dark', wolf_get_theme_mod( 'logo_dark' ) );

	if ( $logo_light || $logo_dark ) {

		$output = '<div class="logo-container">
			<div class="logo">
			<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" class="logo-link">
			<span class="logo-img-inner">';

					if ( $logo_light ) {
						$output .= '<img src="' . esc_url( $logo_light ) . '" alt="logo-light" class="logo-img logo-light">';
					}

					if ( $logo_dark ) {
						$output .= '<img src="' . esc_url( $logo_dark  ). '" alt="logo-dark" class="logo-img logo-dark">';
					}

		$output .= '</span></a>
			</div><!-- .logo -->
		</div><!-- .logo-container -->';

		if ( $echo ) {
			echo wp_kses( $output,
				array(
					'span' => array(
						'id' => array(),
						'class' => array(),
					),
					'div' => array(
						'id' => array(),
						'class' => array(),
					),
					'a' => array(
						'href' => array(),
						'rel' => array(),
						'class' =>array(),
					),
					'img' => array(
						'src' => array(),
						'alt' => array(),
						'class' => array(),
						'id' => array(),
					),
				)
			);
		}

		return wp_kses( $output,
			array(
				'div' => array(
					'id' => array(),
				),
				'a' => array(
					'href' => array(),
					'rel' => array(),
				),
				'img' => array(
					'src' => array(),
					'alt' => array(),
					'class' => array(),
					'id' => array(),
				),
			)
		);
	}
}

/**
 * Output the mobile Logo
 */
function inkpro_mobile_logo( $echo = true ) {

	// get defautl logo if mobile one not set
	$logo_light = apply_filters( 'inkpro_logo_mobile_light', wolf_get_theme_mod( 'logo_mobile_light', wolf_get_theme_mod( 'logo_light' ) ) );
	$logo_dark = apply_filters( 'inkpro_logo_mobile_dark', wolf_get_theme_mod( 'logo_mobile_dark', wolf_get_theme_mod( 'logo_dark' ) ) );

	if ( $logo_light || $logo_dark ) {

		$output = '<div class="logo-container">
			<div class="logo">
			<a href="' . esc_url( home_url( '/' ) ) . '" rel="home"><span class="logo-img-inner">';

		if ( $logo_light ) {
			$output .= '<img src="' . esc_url( $logo_light ) . '" alt="logo-light" class="logo-img logo-light">';
		}

		if ( $logo_dark ) {
			$output .= '<img src="' . esc_url( $logo_dark  ). '" alt="logo-dark" class="logo-img logo-dark">';
		}

		$output .= '</span></a>
			</div><!-- .logo -->
		</div><!-- .logo-container -->';

		if ( $echo ) {
			echo wp_kses( $output,
				array(
					'span' => array(
						'id' => array(),
						'class' => array(),
					),
					'div' => array(
						'id' => array(),
						'class' => array(),
					),
					'a' => array(
						'href' => array(),
						'rel' => array(),
					),
					'img' => array(
						'src' => array(),
						'alt' => array(),
						'class' => array(),
						'id' => array(),
					),
				)
			);
		}

		return wp_kses( $output,
			array(
				'div' => array(
					'id' => array(),
				),
				'a' => array(
					'href' => array(),
					'rel' => array(),
				),
				'img' => array(
					'src' => array(),
					'alt' => array(),
					'class' => array(),
					'id' => array(),
				),
			)
		);
	}
}

/**
 * Prints the post title
 *
 * The title will be linked to the post if we're on an archive page
 *
 * @since InkPro 1.0.0
 */
function inkpro_entry_title( $echo = true ) {

	$title = '';
	$format = get_post_format() ? get_post_format() : 'standard';
	$no_title = array( 'status', 'aside', 'quote','chat' );

	if ( is_sticky() && ! is_paged() ) {
		$title = '<span class="sticky-post">' . esc_html__( 'Featured', 'inkpro' ) . '</span>';
	}

	if ( has_post_format( 'link' ) && ! is_single() ) :

		$title .= '<h2 itemprop="headline" class="entry-title"><a href="' . esc_url( inkpro_get_first_url() ) . '" class="entry-link" rel="bookmark">' . get_the_title() . '</a></h2>';

	elseif ( is_single() ) :

		$title .= '<h1 itemprop="headline" class="entry-title">' . get_the_title() . '</h1>';

	elseif ( ! in_array( $format, $no_title ) ) :

		$title .= '<h2 itemprop="headline" class="entry-title"><a itemprop="url" href="' . esc_url( get_permalink() ) . '" class="entry-link" rel="bookmark">' . get_the_title() . '</a></h2>';

	endif;

	if ( $echo ) {
		echo apply_filters( 'inkpro_entry_title', wp_kses( $title, array(
				'h2' => array(
					'class' => array(),
					'itemprop' => array(),
				),
				'h1' => array(
					'class' => array(),
					'itemprop' => array(),
				),
				'h3' => array(
					'class' => array(),
					'itemprop' => array(),
				),
				'a' => array(
					'class' => array(),
					'href' => array(),
					'rel' => array(),
					'itemprop' => array(),
				),
				'span' => array(
					'class' => array(),
				),
			)
		) );
	}

	return apply_filters( 'inkpro_entry_title', wp_kses( $title, array(
				'h2' => array(
					'class' => array(),
					'itemprop' => array(),
				),
				'h1' => array(
					'class' => array(),
					'itemprop' => array(),
				),
				'h3' => array(
					'class' => array(),
					'itemprop' => array(),
				),
				'a' => array(
					'class' => array(),
					'href' => array(),
					'rel' => array(),
					'itemprop' => array(),
				),
			)
		)
	);
}

/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own inkpro_entry_meta() to override in a child theme.
 *
 * @param bool $display_date
 * @param bool $display_author
 * @param bool $display_category
 * @param bool $display_tags
 */
function inkpro_entry_meta( $display_date = true, $display_author = true, $display_category = true, $display_tags = true ) {

	$post_id = get_the_ID();
	$output = '';

	if ( is_sticky() && is_home() && ! is_paged() )
		$output .= '<span class="featured-post">' . esc_html__( 'Sticky', 'inkpro' ) . '</span>';

	if ( ! is_single() && $display_date && ! has_post_format( 'link' ) && 'post' == get_post_type() || 'video' == get_post_type() || 'work' == get_post_type() ) {
		inkpro_entry_date();
	}

	// Post author
	if (
		'post' == get_post_type()
		&& ! wolf_get_theme_mod( 'blog_hide_author' )
		&& $display_author
		&& ! is_single()
	) {
		$output .= '<span class="author-meta">';
		$output .= '<a class="author-link" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author">';
		$output .= get_avatar( get_the_author_meta( 'user_email' ), 20 );
		$output .= '</a>';

		$output .= sprintf(
			'<span class="author vcard" itemprop="author" itemscope itemtype="http://schema.org/Person"><a class="url fn n" href="%1$s" title="%2$s" rel="author"><span itemprop="name">%3$s</span></a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( esc_html__( 'View all posts by %s', 'inkpro' ), get_the_author() ) ),
			get_the_author()
		);
		$output .= '</span><!--.author-meta-->';
	}

	if ( 'post' == get_post_type() ) {
		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list( esc_html__( ', ', 'inkpro' ) );
		if ( $categories_list && $display_category ) {
			$output .= '<span class="categories-links" itemprop="genre">' . $categories_list . '</span>';
		}

		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list( '', esc_html__( ', ', 'inkpro' ) );
		if ( $tag_list && $display_tags ) {
			$output .= '<span class="tags-links">' . $tag_list . '</span>';
		}
	}

	if ( 'video' == get_post_type() ) {
		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_term_list( $post_id, 'video_type', '', esc_html__( ', ', 'inkpro' ), '' );

		if ( $categories_list && $display_category ) {
			$output .= '<span class="categories-links" itemprop="genre">' . $categories_list . '</span>';
		}

		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_term_list( $post_id, 'video_tag', '', esc_html__( ', ', 'inkpro' ), '' );

		if ( $tag_list && $display_tags ) {
			$output .= '<span class="tags-links">' . $tag_list . '</span>';
		}
	}

	if ( 'work' == get_post_type() ) {
		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_term_list( $post_id, 'work_type', '', esc_html__( ', ', 'inkpro' ), '' );

		if ( $categories_list && $display_category ) {
			$output .= '<span class="categories-links" itemprop="genre">' . $categories_list . '</span>';
		}

		$client = get_post_meta( $post_id, '_work_client', true );
		if ( $client ) {
			$output .= '<span class="work-client">' . sanitize_text_field( $client ) .  '</span>';
		}

		$client_url = get_post_meta( $post_id, '_work_link', true );

		if ( $client_url ) {
			$output .= '<span class="work-client-url"><a target="_blank" href="' . esc_url( $client_url ) .  '">' . inkpro_shorten_link( $client_url ) .  '</a></span>';
		}
	}

	echo apply_filters( 'inkpro_entry_meta', $output );
}

/**
 * Diplay likes, views, comments count with icons
 *
 * @param bool $display_views
 * @param bool $display_likes
 * @param bool $display_comments
 */
function inkpro_entry_icon_meta( $display_views = true, $display_likes = true, $display_comments = true ) {

	$post_id = get_the_ID();

	$output = '';

	if ( $display_views ) {
		$views = get_post_meta( $post_id, '_inkpro_views', true );
		$output .= '<span class="views-meta">' . inkpro_format_number( absint( $views ) ) . '</span>';
	}

	if ( $display_likes ) {
		$likes = get_post_meta( $post_id, '_inkpro_likes', true );
		$output .= '<span class="likes-meta">
			<span class="likes-meta-count">' . inkpro_format_number( absint( $likes ) ) . '</span>
		</span>';
	}

	if ( comments_open() && $display_comments ) {
		$output .= '<span class="comments-link">';
		$output .= '<a class="comment-count" href="' . get_the_permalink() . '">';
		$output .= get_comments_number( 0, 1, '%' );
		$output .= '</a>';
		$output .= '</span><!-- .comments-link -->';
	}

	echo apply_filters( 'inkpro_entry_icon_meta', $output );
}

/**
 * Prints HTML with date information for current post.
 *
 * Create your own inkpro_entry_date() to override in a child theme.
 *
 *
 * @param boolean $echo Whether to echo the date. Default true.
 * @param bool $link
 * @return string
 */
function inkpro_entry_date( $echo = true, $link = true ) {

	$display_time = get_the_date();
	$modified_display_time = get_the_modified_date();

	if ( 'human_diff' == wolf_get_theme_mod( 'date_format' ) ) {
		$display_time = sprintf( esc_html__( '%s ago', 'inkpro' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) );
		$modified_display_time = sprintf( esc_html__( '%s ago', 'inkpro' ), human_time_diff( get_the_modified_time( 'U' ), current_time( 'timestamp' ) ) );
	}

	$date = $display_time;

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time itemprop="datePublished" class="entry-date published" datetime="%1$s">%2$s</time><time itemprop="dateModified" class="updated" datetime="%3$s">%4$s</time>';
	} else {
		$time_string = '<time itemprop="datePublished" class="entry-date published updated" datetime="%1$s">%2$s</time>';
	}

	$_time = sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( $display_time ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( $modified_display_time )
	);

	if ( $link ) {
		$date = sprintf(
			'<span class="posted-on date"><a href="%1$s" rel="bookmark">%2$s</a></span>',
			esc_url( get_permalink() ),
			$_time
		);
	} else {
		$date = sprintf(
			'<span class="posted-on date">%2$s</span>',
			esc_url( get_permalink() ),
			$_time
		);
	}

	if ( $echo ) {
		echo apply_filters( 'inkpro_entry_date', wp_kses( $date, array(
			'span' => array(
				'class' => array(),
			),
			'time' => array(
				'class' => array(),
				'datetime' => array(),
				'itemprop' => array(),
			),
			'a' => array(
				'href' => array(),
				'rel' => array(),
				'class' => array(),
			),
		) ) );
	}

	return apply_filters( 'inkpro_entry_date', wp_kses( $date, array(
				'span' => array(
					'class' => array(),
				),
				'time' => array(
					'class' => array(),
					'datetime' => array(),
					'itemprop' => array(),
				),
				'a' => array(
					'href' => array(),
					'rel' => array(),
					'class' => array(),
				),
			)
		)
	);
}

/**
 * Get a different post thumbnail depending on context
 *
 * @param boolean $echo Whether to echo the date. Default true.
 * @return string
 */
function inkpro_entry_thumbnail( $echo = true ) {

	$thumbnail = null;
	$format = get_post_format() ? get_post_format() : 'standard';
	$no_thumb = array( 'video', 'gallery', 'link', 'status', 'quote', 'aside', 'link', 'chat' );

	if ( has_post_thumbnail() ) {

		if ( 'image' == $format ) {

			$img_excerpt = get_post( get_post_thumbnail_id() )->post_excerpt;
			$img_alt = esc_attr( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) );

			$caption = ( $img_excerpt ) ? $img_excerpt : get_the_title();
			$caption = '';

			$img = wolf_get_post_thumbnail_url( 'image-thumb' );

			$full_img = wolf_get_post_thumbnail_url( 'full' );

			$lightbox_class = 'lightbox';
			$thumbnail = '<div class="entry-thumbnail">';
			$thumbnail .= "<a title='$caption' class='$lightbox_class zoom' href='$full_img'><img src='$img' alt='$img_alt'></a>";
			$thumbnail .= '</div>';

		} elseif ( ! in_array( $format, $no_thumb ) ) {
			$thumbnail = '<div class="entry-thumbnail">';
			$thumbnail .= '<a href="' . get_permalink( get_the_ID() ) . '">';
			$thumbnail .= get_the_post_thumbnail( get_the_ID(), 'image-thumb' );
			$thumbnail .= '</a>';
			$thumbnail .= '</div>';
		}
	}

	if ( $echo ) {
		echo apply_filters( 'inkpro_entry_thumbnail', wp_kses( $thumbnail, array(
				'span' => array(
					'id' => array(),
					'class' => array(),
				),
				'div' => array(
					'id' => array(),
					'class' => array(),
				),
				'a' => array(
					'title' => array(),
					'href' => array(),
					'rel' => array(),
					'class' => array(),
				),
				'img' => array(
					'src' => array(),
					'alt' => array(),
					'class' => array(),
					'id' => array(),
				),
			)
		) );
	}

	return apply_filters( 'inkpro_entry_thumbnail', wp_kses( $thumbnail, array(
				'span' => array(
					'id' => array(),
					'class' => array(),
				),
				'div' => array(
					'id' => array(),
					'class' => array(),
				),
				'a' => array(
					'title' => array(),
					'href' => array(),
					'rel' => array(),
					'class' => array(),
				),
				'img' => array(
					'src' => array(),
					'alt' => array(),
					'class' => array(),
					'id' => array(),
				),
			)
		)
	);
}

if ( ! function_exists( 'inkpro_excerpt' ) ) {
	/**
	 * Excerpt function
	 *
	 * @since InkPro 1.0.0
	 * @param bool $echo
	 * @return string
	 */
	function inkpro_excerpt( $echo = true ) {

		$media = inkpro_post_media( false );
		$excerpt = str_replace( $media, '', get_the_excerpt() );

		if ( $echo )
			echo '<p>' . $excerpt . '</p>';

		return '<p>' . $excerpt . '</p>';
	}
}

if ( ! function_exists( 'inkpro_paging_nav' ) ) {
	/**
	 * Displays navigation to next/previous set of posts when applicable.
	 *
	 * @since InkPro 1.0.0
	 * @param object $loop
	 */
	function inkpro_paging_nav( $loop = null ) {

		if ( ! $loop ) {
			global $wp_query;
			$max = $wp_query->max_num_pages;
		} else {
			$max = $loop->max_num_pages;
		}

		// Don't print empty markup if there's only one page.
		if ( $max < 2 )
			return;

		?>
		<nav class="navigation paging-navigation">
			<div class="nav-links clearfix">
				<?php if ( get_next_posts_link( '', $max ) ) : ?>
				<div class="nav-previous"><?php next_posts_link( esc_html__( '<span class="meta-nav">&larr;</span> Older posts', 'inkpro' ), $max ); ?></div>
				<?php endif; ?>

				<?php if ( get_previous_posts_link( '', $max ) ) : ?>
				<div class="nav-next"><?php previous_posts_link( esc_html__( 'Newer posts <span class="meta-nav">&rarr;</span>', 'inkpro' ), $max ); ?></div>
				<?php endif; ?>

			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}
}

/**
 * Get the author
 *
 * @param bool $echo
 * @return string $author
 */
function inkpro_the_author( $echo = true ) {
	global $post;
	if ( ! is_object( $post ) )
		return;
	$author_id = $post->post_author;
	$author = get_the_author_meta( 'user_nicename', $author_id );

	if ( get_the_author_meta( 'nickname', $author_id ) ) {
		$author = get_the_author_meta( 'nickname', $author_id );
	}

	if ( get_the_author_meta( 'first_name', $author_id ) ) {
		$author = get_the_author_meta( 'first_name', $author_id );

		if ( get_the_author_meta( 'last_name', $author_id ) ) {
			$author .= ' ' .  get_the_author_meta( 'last_name', $author_id );
		}
	}

	$author = sprintf( '<span class="vcard author"><span class="fn">%s</span></span>', $author );

	if ( $echo )
		echo apply_filters( 'inkpro_the_author', wp_kses( $author, array(
			'span' => array(
				'class' => array()
			),
			'a' => array(
				'href' => array(),
				'rel' => array(),
				'class' => array()
			),
		) ) );

	return apply_filters( 'inkpro_the_author', wp_kses( $author, array(
			'span' => array(
				'class' => array()
			),
			'a' => array(
				'href' => array(),
				'rel' => array(),
				'class' => array()
			),
		) )
	);
}

if ( ! function_exists( 'inkpro_post_nav' ) ) {
	/**
	 * Displays navigation to next/previous work post when applicable.
	 *
	 * @since InkPro 1.0.0
	 */
	function inkpro_post_nav() {
		global $post;

		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}

		$next_post = get_next_post();
		$prev_post = get_previous_post();

		$index_url = inkpro_get_blog_url();

		if ( 'work' == get_post_type() && function_exists( 'wolf_get_portfolio_url' ) ) {
			$index_url = wolf_get_portfolio_url();
		}
		?>
		<nav class="nav-single clearfix">
			<div class="nav-previous"<?php
				if( ! empty( $prev_post ) && wolf_get_post_thumbnail_url( 'inkpro-XL', $prev_post->ID ) ) : ?>
					data-bg="<?php echo esc_url( wolf_get_post_thumbnail_url( 'inkpro-XL', $prev_post->ID ) ); ?>"
				<?php endif; ?>>
				<?php previous_post_link( '%link', '<span class="nav-label"><i class="fa fa-angle-left"></i> ' . esc_html__( 'Previous post', 'inkpro' ) . '</span><span class="meta-nav"></span> %title' ); ?>
			</div><!-- .nav-previous -->
			<div class="nav-index">
				<a href="<?php echo esc_url( $index_url ); ?>">
					<span class="dashicons-screenoptions"></span>
				</a>
			</div>
			<div class="nav-next"<?php
				if( ! empty( $next_post ) && wolf_get_post_thumbnail_url( 'inkpro-XL', $next_post->ID ) ) : ?>
					data-bg="<?php echo esc_url( wolf_get_post_thumbnail_url( 'inkpro-XL', $next_post->ID ) ); ?>"
				<?php endif; ?>>
				<?php next_post_link( '%link', '<span class="nav-label">' . esc_html__( 'Next post', 'inkpro' ) . ' <i class="fa fa-angle-right"></i></span> %title <span class="meta-nav"></span>' ); ?>
			</div><!-- .nav-next -->
		</nav><!-- .nav-single -->
		<?php
	}
}

/**
 * Return the subheading of a post
 *
 * @param int $post_id
 * @return string
 */
function inkpro_get_the_subheading( $post_id = null ) {

	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	return get_post_meta( $post_id, '_post_subheading', true );
}

/**
 * Echoes the subheading of a post
 *
 * @param int $post_id
 * @return string
 */
function inkpro_the_subheading( $post_id = null ) {

	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	if ( inkpro_get_the_subheading( $post_id ) ) {
		echo inkpro_get_the_subheading( $post_id );
	}
}

/**
 * Display Page Title
 *
 * @since 1.0.0
 */
function inkpro_output_page_header() {

	if ( is_404() ) {
		return;
	}

	$post_id = inkpro_get_header_post_id();

	if ( 'none' != inkpro_get_header_type() ) {

		$type = ( get_post_meta( $post_id, '_post_bg_type', true ) ) ? get_post_meta( $post_id, '_post_bg_type', true ) : 'image';
		$video_mp4 = get_post_meta( $post_id, '_post_video_bg_mp4', true );
		$video_webm = get_post_meta( $post_id, '_post_video_bg_webm', true );
		$video_ogv = get_post_meta( $post_id, '_post_video_bg_ogv', true );
		$video_img = get_post_meta( $post_id, '_post_video_bg_img', true );
		$video_opacity = absint( get_post_meta( $post_id, '_post_video_bg_opacity', true ) ) / 100;
		$video_bg_type = ( get_post_meta( $post_id, '_post_video_bg_type', true ) ) ? get_post_meta( $post_id, '_post_video_bg_type', true ) : 'selfhosted';
		$video_youtube_url = get_post_meta( $post_id, '_post_video_bg_youtube_url', true );

		$attachment_id = get_post_meta( $post_id, '_post_bg_img', true );
		$header_bg_color = get_post_meta( $post_id, '_post_bg_color', true );
		$header_effect = get_post_meta( $post_id, '_post_bg_effect', true );

		$class = 'post-header-container';

		if (
			'image' == $type
			&& wolf_get_theme_mod( 'auto_header' )
			&& ( has_post_thumbnail( $post_id ) || get_header_image() )
			&& ! $header_bg_color
			&& ! $attachment_id
		) {

			if ( function_exists( 'is_product_category' ) && is_product_category() && get_woocommerce_term_meta( get_queried_object()->term_id, 'thumbnail_id', true ) ) {

				$attachment_id = get_woocommerce_term_meta( get_queried_object()->term_id, 'thumbnail_id', true );

			} elseif ( has_post_thumbnail( $post_id ) ) {

				$attachment_id = get_post_thumbnail_id( $post_id );

			} else {

				$attachment_id = get_custom_header()->attachment_id;
			}

			$header_effect = wolf_get_theme_mod( 'auto_header_effect', 'parallax' );
		}

		$do_parallax = 'parallax' == $header_effect;

		if ( $do_parallax && $attachment_id ) {
			$class .= ' post-header-parallax';
		}

		$_image = esc_url( wolf_get_url_from_attachment_id( $attachment_id, 'inkpro-XL' ) );

		echo '<section class="' . esc_attr( $class ) . '">';

		if ( inkpro_has_hero() ) {
			echo '<div class="header-overlay"></div>';
		}

		if ( 'video' == $type && ! is_search() ) {

			$video_img = esc_url( wolf_get_url_from_attachment_id( $video_img, 'inkpro-XL' ) );
			?>
			<div class="video-container">
				<?php
				if ( $video_mp4 && 'selfhosted' == $video_bg_type ) {

					echo inkpro_video_bg( $video_mp4, $video_webm, $video_ogv, $video_img );
				}

				elseif( $video_youtube_url && 'youtube' == $video_bg_type ) {
					// debug(  $video_img );
					echo inkpro_youtube_video_bg( $video_youtube_url, $video_img );
				}
				?>
			</div>
			<?php
		}

		if (
			'zoomin' == $header_effect
			&& $attachment_id
			&& 'image' == $type
		) {
			echo '<div class="zoom-bg"><img src="' . $_image . '" alt="zooming-background"></div>';

		}

		if (
			'parallax' == $header_effect
			&& $attachment_id
			&& 'image' == $type
		) {
			echo '<div class="parallax-window" data-background-url="' . esc_url( $_image ) . '"></div>';

		}

		echo '<div class="post-header-inner">';
			echo '<div class="post-header text-center">';
				echo '<div class="wrap intro">';

					if ( 'breadcrumb' == inkpro_get_header_type() ) {
						inkpro_breadcrumb();
					}

					echo '<div class="post-title-container">';

					echo inkpro_get_post_title();

					/**
					 * Allo plugins to add content in header
					 */
					do_action( 'inkpro_after_header_post_title' );

					echo '</div><!--.post-title-container-->';
				echo '</div><!--.wrap.intro-->';
			echo '</div><!--.post-header -->';
		echo '</div><!--.post-header-inner --></section>';
	} else {
		echo '<div class="post-header-holder"></div>';
	}
}
add_action( 'wolf_content_start', 'inkpro_output_page_header' );

if ( ! function_exists( 'inkpro_loader' ) ) {
	/**
	 * Template tag to display the loader
	 */
	function inkpro_loader() {
		$spinner = wolf_get_theme_mod( 'loader_type', 'loader5' );
		$loading_logo_animation = wolf_get_theme_mod( 'loading_logo_animation' );
		?>
		<div class="loader">
		<?php if ( wolf_get_theme_mod( 'loading_logo' ) ) : ?>
			<img class="loading-logo <?php echo sanitize_html_class( $loading_logo_animation ); ?>" src="<?php echo esc_url( wolf_get_url_from_attachment_id( wolf_get_theme_mod( 'loading_logo' ), 'logo' ) ); ?>" alt="loading-logo">
		<?php endif; ?>
			<?php if ( 'none' != $spinner ) : ?>
				<?php get_template_part( 'partials/spinners/spinner', $spinner ) ?>
			<?php endif; ?>
		</div><!-- #loader.loader -->
		<?php

	}
}

if ( ! function_exists( 'inkpro_author_socials' ) ) {
	/**
	 * Display social networks in author bio box
	 *
	 * @access public
	 * @return string
	 */
	function inkpro_author_socials() {

		$website = get_the_author_meta( 'user_url' );
		$googleplus = get_the_author_meta( 'googleplus' );
		$twitter = get_the_author_meta( 'twitter' );
		$facebook = get_the_author_meta( 'facebook' );
		$name = get_the_author_meta( 'user_nicename' );

		if ( $website ) {
			echo '<a target="_blank" title="' . sprintf( esc_html__( 'Visit %s\'s website', 'inkpro' ), $name ) . '" href="'. esc_url( $website ) .'" class="author-link">' . esc_html__( 'Website', 'inkpro' ) . '</a>';
		}

		if ( $facebook ) {
			echo '<a target="_blank" title="' . sprintf( esc_html__( 'Visit %s\'s Facebook profile', 'inkpro' ), $name ) . '" href="'. esc_url( $facebook ) .'" class="author-link">' . esc_html__( 'Facebook', 'inkpro' ) . '</a>';
		}

		if ( $twitter ) {
			echo '<a target="_blank" title="' . sprintf( esc_html__( 'Visit %s\'s Twitter feed', 'inkpro' ), $name ) . '" href="'. esc_url( 'https://twitter.com/' . $twitter ) .'" class="author-link">' . esc_html__( 'Twitter', 'inkpro' ) . '</a>';
		}

		if ( $googleplus ) {
			echo '<a target="_blank" title="' . sprintf( esc_html__( 'Visit %s\'s Google+ profile', 'inkpro' ), $name ) . '" href="'. esc_url( $googleplus ) .'" class="author-link">' . esc_html__( 'Google+', 'inkpro' ) . '</a>';
		}
	}
}

if ( ! function_exists( 'inkpro_search_menu_item' ) ) {
	/**
	 * Search icon menu item
	 */
	function inkpro_search_menu_item() {

		$search_menu_item_icon = wolf_get_theme_mod( 'search_menu_item_icon', 'fa-search' );
		$search_menu_item_type = wolf_get_theme_mod( 'search_menu_item', 'overlay' );

		$search_item = '<a class="search-toggle search-toggle-' . $search_menu_item_type . ' wpb-social-link" href="#">
			<span class="wpb-social fa ' . esc_attr( $search_menu_item_icon ) . ' wpb-normal wpb-social-1x wpb-hover-none wpb-social-no-custom-style"></span>
			<span class="search-menu-item-text menu-item-inner">' . esc_html__( 'Search', 'inkpro' ) . '</span>
			</a>';

		return $search_item;
	}
}

if ( ! function_exists( 'inkpro_socials_menu_item' ) ) {
	/**
	 * Search icon menu item
	 */
	function inkpro_socials_menu_item() {

		$socials_item = '';

		$services = wolf_get_theme_mod( 'menu_socials_services' );
		if ( $services && function_exists( 'wpb_socials' ) ) {
			$socials_item .= wpb_socials( array( 'services' => $services ) );
		}

		return $socials_item;
	}
}

if ( ! function_exists( 'inkpro_wishlist_menu_item' ) ) {
	/**
	 * Cart icon menu item
	 */
	function inkpro_wishlist_menu_item() {
		if ( class_exists( 'WooCommerce' ) && function_exists( 'wolf_get_wishlist_url' ) ) {
			$item = '<a href="' . esc_url( wolf_get_wishlist_url() ) . '">';
			$item .= 'wishlist';
			$item .= '</a>';
			return $item;
		}
	}
}

if ( ! function_exists( 'inkpro_cart_menu_item' ) ) {
	/**
	 * Cart icon menu item
	 */
	function inkpro_cart_menu_item() {

		if ( class_exists( 'WooCommerce' ) && function_exists( 'wc_get_page_id' ) ) {

			$woo_item = '<span class="cart-menu-item-container">';
			$cart_url = get_permalink( wc_get_page_id( 'cart' ) );
			$cart_menu_item_icon = wolf_get_theme_mod( 'cart_menu_item_icon', 'fa-shopping-cart' );
			$cart_menu_panel_icon = wolf_get_theme_mod( 'cart_menu_panel_icon', 'fa-shopping-cart' );
			$woo_item .= '<a class="cart-menu-item-link ' . esc_attr( $cart_menu_item_icon  ). '" href="' . esc_url( $cart_url ) . '">';
			$woo_item .= '<span class="product-count">' . absint( WC()->cart->get_cart_contents_count() ) . '</span>';

			$woo_item .= '<span class="cart-text menu-item-inner">' . esc_html__( 'Cart', 'inkpro' ) . '</span>';

			$woo_item .= '</a>';

				$woo_item .= '<span class="cart-menu-panel">';
					$woo_item .= '<a href="' . esc_url( $cart_url ) . '" class="cart-menu-panel-link">';
						$woo_item .= '<span class="icon-cart ' . esc_attr( $cart_menu_panel_icon ) . '"></span>';

						$woo_item .= '<span class="panel-product-count">';
						$woo_item .= sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'inkpro' ), WC()->cart->get_cart_contents_count() );
						$woo_item .= '</span><br>'; // count

			$woo_item .= '<span class="panel-total">';
			$woo_item .= esc_html__( 'Total', 'inkpro' ) . ' ' .  WC()->cart->get_cart_total();
			$woo_item .= '</span>'; // total

						$woo_item .= '</a>';
			$woo_item .= '</span>';

			$woo_item .= '</span><!-- .cart-menu-item-container -->';

			return $woo_item;
		}
	}
}

if ( ! function_exists( 'inkpro_breadcrumb' ) ) {
	/**
	* Breadcrumb function
	*/
	function inkpro_breadcrumb() {

		global $post, $wp_query;

		if ( ! is_front_page() ) {

			$delimiter = ' / ';
			$before = '';
			$after = '';

			echo '<div class="breadcrumb">';

			echo '<a href="';
			echo esc_url( home_url( '/' ) );
			echo '">';
			esc_html_e( 'Home', 'inkpro' );
			echo "</a> / ";

			if ( 'post' == get_post_type() && ! inkpro_is_blog_index() ) {

				echo '<a href="' . inkpro_get_blog_url() . '">' . get_the_title( get_option( 'page_for_posts' ) ) . '</a>';
					echo esc_attr( $delimiter );
			}

			if ( inkpro_is_woocommerce() && is_shop() ) {
				echo get_the_title( inkpro_get_woocommerce_shop_page_id() );
			}

			if ( inkpro_is_woocommerce() && is_product_category() ) {

				$shop_page_id = wc_get_page_id( 'shop' );
				echo '<a href="' . get_permalink( wc_get_page_id( 'shop' ) ) . '">' . get_the_title( $shop_page_id ) . '</a>' . $delimiter;

				$current_term = $wp_query->get_queried_object();
				$ancestors = array_reverse( get_ancestors( $current_term->term_id, 'product_cat' ) );

				foreach ( $ancestors as $ancestor ) {
					$ancestor = get_term( $ancestor, 'product_cat' );

					echo '<a href="' . get_term_link( $ancestor ) . '">' . esc_html( $ancestor->name ) . '</a>' . $delimiter;
				}

				echo sanitize_text_field( $before . esc_html( $current_term->name ) . $after );
			}

			if ( inkpro_is_woocommerce() && is_product_tag() ) {

				$shop_page_id = wc_get_page_id( 'shop' );
				echo '<a href="' . get_permalink( $shop_page_id ) . '">' . get_the_title( $shop_page_id ) . '</a>' . $delimiter;
				$queried_object = $wp_query->get_queried_object();
				echo$before . esc_html__( 'Products tagged &ldquo;', 'inkpro' ) . $queried_object->name . '&rdquo;' . $after;
			}

			if ( is_category() ) {

				$cat_obj = $wp_query->get_queried_object();
				$this_category = get_category( $cat_obj->term_id );

				if ( 0 != $this_category->parent ) {
					$parent_category = get_category( $this_category->parent );
					if ( ( $parents = get_category_parents( $parent_category, TRUE, $after . $delimiter . $before ) ) && ! is_wp_error( $parents ) ) {
						echo sanitize_text_field( $before . rtrim( $parents, $after . $delimiter . $before ) . $after . $delimiter );
					}
				}

				echo sanitize_text_field( $before . single_cat_title( '', false ) . $after );

			} elseif ( is_tag() ) {

				echo get_the_tag_list( '', $delimiter);

			} elseif ( is_author() ) {

				echo get_the_author();

			} elseif ( is_day() ) {

				echo get_the_date();

			} elseif ( is_month() ) {

				echo get_the_date( 'F Y' );

			} elseif ( is_year() ) {

				echo get_the_date( 'Y' );

			} elseif( is_tax( 'work_type' ) ) {

				$portfolio_page_id = wolf_portfolio_get_page_id();
				echo '<a href="' . get_permalink( $portfolio_page_id ) . '">' . get_the_title( $portfolio_page_id ) . '</a>' . $delimiter;

				$the_tax = get_taxonomy( get_query_var( 'taxonomy' ) );
				if ( $the_tax && $wp_query && isset( $wp_query->queried_object->name ) ) {

					echo sanitize_text_field( $wp_query->queried_object->name );
				}

			} elseif( is_tax( 'gallery_type' ) ) {

				$albums_page_id = wolf_albums_get_page_id();
				echo '<a href="' . get_permalink( $albums_page_id ) . '">' . get_the_title( $albums_page_id ) . '</a>' . $delimiter;

				$the_tax = get_taxonomy( get_query_var( 'taxonomy' ) );
				if ( $the_tax && $wp_query && isset( $wp_query->queried_object->name ) ) {

					echo sanitize_text_field( $wp_query->queried_object->name );
				}

			} elseif( is_tax( 'video_type' ) ) {

				$videos_page_id = wolf_videos_get_page_id();
				echo '<a href="' . get_permalink( $videos_page_id ) . '">' . get_the_title( $videos_page_id ) . '</a>' . $delimiter;

				$the_tax = get_taxonomy( get_query_var( 'taxonomy' ) );
				if ( $the_tax && $wp_query && isset( $wp_query->queried_object->name ) ) {

					echo sanitize_text_field( $wp_query->queried_object->name );
				}

			} elseif( is_tax( 'plugin_cat' ) ) {

				$plugins_page_id = wolf_plugins_get_page_id();
				echo '<a href="' . get_permalink( $plugins_page_id ) . '">' . get_the_title( $plugins_page_id ) . '</a>' . $delimiter;

				$the_tax = get_taxonomy( get_query_var( 'taxonomy' ) );
				if ( $the_tax && $wp_query && isset( $wp_query->queried_object->name ) ) {

					echo sanitize_text_field( $wp_query->queried_object->name );

				}

			} elseif( is_tax( 'theme_cat' ) ) {

				$themes_page_id = wolf_themes_get_page_id();
				echo '<a href="' . get_permalink( $themes_page_id ) . '">' . get_the_title( $themes_page_id ) . '</a>' . $delimiter;

				$the_tax = get_taxonomy( get_query_var( 'taxonomy' ) );
				if ( $the_tax && $wp_query && isset( $wp_query->queried_object->name ) ) {

					echo esc_attr( $wp_query->queried_object->name );

				}

			} elseif ( is_tax() && ! is_tax( 'product_cat' ) && ! is_tax( 'product_tag' ) ) {

				$the_tax = get_taxonomy( get_query_var( 'taxonomy' ) );
				if ( $the_tax && $wp_query && isset( $wp_query->queried_object->name ) ) {

					echo esc_attr( $wp_query->queried_object->name );

				}

			} elseif ( is_search() )  {

				if ( inkpro_is_woocommerce() ) {
					echo esc_attr( $delimiter );
				}

				esc_html_e( 'Search', 'inkpro' );
			}

			if ( is_attachment() ) {

				esc_html_e( 'Attachment', 'inkpro' );
				echo esc_attr( $delimiter );
				echo empty( $post->post_parent ) ? get_the_title() : '<a href="' . get_permalink( $post->post_parent ) . '">' . get_the_title( $post->post_parent ) . '</a> / ' . get_the_title();

			} elseif ( is_page() ) {

				echo empty( $post->post_parent ) ? get_the_title() : '<a href="' . get_permalink( $post->post_parent ) . '">' . get_the_title( $post->post_parent ) . '</a> / ' . get_the_title();
			}

			if ( is_single() ) {

				if ( is_singular( 'work' ) ) {

					echo '<a href="' . get_permalink( wolf_portfolio_get_page_id() ) . '">' . get_the_title( wolf_portfolio_get_page_id() ) . '</a>';
					echo esc_attr( $delimiter );

					echo get_the_term_list( $post->ID, 'work_type', '', $delimiter, '');

					if ( has_term( '', 'work_type' ) )
						echo esc_attr( $delimiter );

				} elseif ( is_singular( 'video' ) ) {

					echo '<a href="' . get_permalink( wolf_videos_get_page_id() ) . '">' . get_the_title( wolf_videos_get_page_id() ) . '</a>';
					echo esc_attr( $delimiter );

					echo get_the_term_list( $post->ID, 'video_type', '', $delimiter, '');

					if ( has_term( '', 'video_type' ) )
						echo esc_attr( $delimiter );

				} elseif ( is_singular( 'gallery' ) ) {

					echo '<a href="' . get_permalink( wolf_albums_get_page_id() ) . '">' . get_the_title( wolf_albums_get_page_id() ) . '</a>';
					echo esc_attr( $delimiter );

					echo get_the_term_list( $post->ID, 'gallery_type', '', $delimiter, '');

					if ( has_term( '', 'gallery_type' ) )
						echo esc_attr( $delimiter );

				} elseif ( is_singular( 'plugin' ) ) {

					echo '<a href="' . get_permalink( wolf_plugins_get_page_id() ) . '">' . get_the_title( wolf_plugins_get_page_id() ) . '</a>';
					echo esc_attr( $delimiter );

					echo get_the_term_list( $post->ID, 'plugin_cat', '', $delimiter, '');

					if ( has_term( '', 'plugin_cat' ) )
						echo esc_attr( $delimiter );

				} elseif ( is_singular( 'product' ) ) {

					echo '<a href="' . get_permalink( wc_get_page_id( 'shop' ) ) . '">' . get_the_title( wc_get_page_id( 'shop' ) ) . '</a>';
					echo esc_attr( $delimiter );

					if ( $terms = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) ) ) {
						$main_term = $terms[0];
						$ancestors = get_ancestors( $main_term->term_id, 'product_cat' );
						$ancestors = array_reverse( $ancestors );

						foreach ( $ancestors as $ancestor ) {
							$ancestor = get_term( $ancestor, 'product_cat' );

							if ( ! is_wp_error( $ancestor ) && $ancestor ) {
								echo '<a href="' . get_term_link( $ancestor ) . '">' . $ancestor->name . '</a>' . $delimiter;
							}
						}

						echo '<a href="' . get_term_link( $main_term ) . '">' . $main_term->name . '</a> / ';
					}

				} elseif ( is_singular( 'event' ) ) {

					// echo '<a href="' . get_permalink( get_the_ID() ) . '">' . get_the_title( get_the_ID() ) . '</a>';
					// echo esc_attr( $delimiter );

					// echo get_the_term_list( $post->ID, 'gallery_type', '', $delimiter, '');

					// if ( has_term( '', 'gallery_type' ) )
					// 	echo esc_attr( $delimiter );

				} else {
					the_category($delimiter);
					echo esc_attr( $delimiter );
				}

				the_title();

			} elseif (
				$wp_query && isset($wp_query->queried_object->ID)
				&& $wp_query->queried_object->ID == get_option( 'page_for_posts' )
			) {

				echo sanitize_text_field( $wp_query->queried_object->post_title );
			}

			echo '</div>';
		}
	}
}

/**
 * Add additional post attributes
 *
 * Used to add the post ID on blog pages
 */
function inkpro_get_post_attr( $post_attr = '' ) {

	$post_attr .= 'data-post-id="' . get_the_ID() . '"';

	if ( inkpro_is_blog() ) {
		$post_attr .= ' post-id="' . get_the_ID() . '"';
	}

	return $post_attr;
}
add_filter( 'inkpro_post_attr', 'inkpro_get_post_attr' );
add_filter( 'wpb_post_attr', 'inkpro_get_post_attr' );

/**
 * Ouptut additional post attributes
 */
function inkpro_post_attr( $post_attr = '' ) {
	echo apply_filters( 'inkpro_post_attr', $post_attr );
}

if ( ! function_exists( 'inkpro_wpml_flags' ) ) {
	/**
	 * Display coutry flags if WPML translation plugin is installed
	 *
	 * @return string
	 */
	function inkpro_wpml_flags() {
		if ( function_exists( 'icl_get_languages' ) ) {
			if ( 'list' == wolf_get_theme_option( 'top_bar_flags' ) ) {

				$languages = icl_get_languages( 'skip_missing=0&orderby=code' );

				if ( ! empty( $languages ) ) {
					echo '<div class="wolf-flags-container">';
					foreach( $languages as $l ) {
						if ( ! $l['active'] ) echo '<a href="'. esc_url( $l['url'] ) . '" class="wolf-wpml-flag">';
						echo '<img src="' . esc_url( $l['country_flag_url'] ) . '" height="12" alt="' . esc_attr( $l['language_code'] ) . '" width="18" />';
						if ( ! $l['active'] ) echo '</a>';
					}
					echo '</div>';
				}

			} else {
				do_action( 'icl_language_selector' );
			}
		}
	}
}

if ( ! function_exists( 'inkpro_add_to_wishlist' ) ) {
	/**
	 * Fire add to wishlist function
	 *
	 * If Wolf WooCommerce Wishlist is installed, it will output the add to wishlist button
	 */
	function inkpro_add_to_wishlist() {
		if ( function_exists( 'wolf_add_to_wishlist' ) ) {
			wolf_add_to_wishlist();
		}
	}
}

/**
 * Custom excerpt
 *
 * Get post content text only
 */
function inkpro_get_the_excerpt( $lenght = 35 ) {

	global $post;
	$url_regex = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@";
	$text = $post->post_content;
	$text = preg_replace( $url_regex, '', $text ); // remove URLs
	$text = wolf_sample( $text, $lenght );

	return $text;
}