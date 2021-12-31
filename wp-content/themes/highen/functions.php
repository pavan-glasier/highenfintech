<?php
/**
 * Highen functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @link https://developer.wordpress.org/themes/advanced-topics/child-themes/
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, @link https://developer.wordpress.org/plugins/
 *
 * @package WordPress
 * @subpackage highen
 * @since Highen 1.0
 */

// Set up the content width value based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 625;
}

/**
 * Highen setup.
 *
 * Sets up theme defaults and registers the various WordPress features that
 * Highen supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
 *  custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Highen 1.0
 */
function highen_setup() {
	/*
	 * Makes Highen available for translation.
	 *
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/highen
	 * If you're building a theme based on Highen, use a find and replace
	 * to change 'highen' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'highen' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Load regular editor styles into the new block-based editor.
	add_theme_support( 'editor-styles' );

	// Load default block styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	// Add support for custom color scheme.
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => __( 'Blue', 'highen' ),
				'slug'  => 'blue',
				'color' => '#21759b',
			),
			array(
				'name'  => __( 'Dark Gray', 'highen' ),
				'slug'  => 'dark-gray',
				'color' => '#444',
			),
			array(
				'name'  => __( 'Medium Gray', 'highen' ),
				'slug'  => 'medium-gray',
				'color' => '#9f9f9f',
			),
			array(
				'name'  => __( 'Light Gray', 'highen' ),
				'slug'  => 'light-gray',
				'color' => '#e6e6e6',
			),
			array(
				'name'  => __( 'White', 'highen' ),
				'slug'  => 'white',
				'color' => '#fff',
			),
		)
	);

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );

	// This theme uses wp_nav_menu() in one location.


		register_nav_menus( array(
            'primary_menu' => __( 'Primary Menu', 'highen' ),
            'side_menu' => __( 'Sidebar Menu', 'highen' ),
            'footer_menu'  => __( 'Footer Menu', 'highen' ),
        ) );






// add_filter( 'wp_nav_menu_items', 'add_extra_item_to_nav_menu', 10, 2 );
// function add_extra_item_to_nav_menu( $items, $args ) {
//     if (is_user_logged_in() && $args->theme_location == 'primary_menu') {
//         $items .= '<li><a href="Account">My Account</a></li>';
//     }
//     elseif (!is_user_logged_in() && $args->theme_location == 'primary_menu') {
//         $items .= '<li><a href="Sign in  /  Register">Sign in  /  Register</a></li>';
//     }
//     return $items;
// }



// add_filter('wp_nav_menu_items', 'my_wp_nav_menu_items', 10, 2);

// function my_wp_nav_menu_items( $items, $args ) {
	
// 	// get menu
// 	$menu = wp_get_nav_menu_object($args->menu);
	
	
// 	// modify primary only
// 	if( $args->theme_location == 'primary_menu' ) {
		
// 		// vars
// 		$logo = get_field('menu_button', $menu);
		
		
// 		// prepend logo
// 		$html_logo = '<li class="menu-item-logo"><a href="'.home_url().'"><img src="'.$logo['url'].'" alt="'.$logo['alt'].'" /></a></li>';
		
		
// 		// append html
// 		$items = $items . $html_logo;
		
// 	}
	
	
// 	// return
// 	return $items;
	
// }




function add_btn_menu($items, $args) {
	

   $menu = wp_get_nav_menu_object($args->menu);
    if( $args->theme_location == 'primary_menu' ){


    	$menu_button = get_field('menu_button', $menu);
    	$items .= '<li>'
            . '<a class="smooth-menu btn-top" href="'.$menu_button['url'].'">'.$menu_button['title'].'</a>'
            . '</li>';
            
    }
  return $items;
}
add_filter('wp_nav_menu_items', 'add_btn_menu', 10, 2);










	/*
	 * This theme supports custom background color and image,
	 * and here we also set up the default background color.
	 */
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'e6e6e6',
		)
	);

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop.

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'highen_setup' );




  // Register Nav Walker class_alias
  require_once('wp-bootstrap-navwalker.php');

/**
 * Add support for a custom header image.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Add block patterns.
 */
require get_template_directory() . '/inc/block-patterns.php';

/**
 * Return the Google font stylesheet URL if available.
 *
 * The use of Open Sans by default is localized. For languages that use
 * characters not supported by the font, the font can be disabled.
 *
 * @since Highen 1.2
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function highen_get_font_url() {
	$font_url = '';

	/*
	 * translators: If there are characters in your language that are not supported
	 * by Open Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'highen' ) ) {
		$subsets = 'latin,latin-ext';

		/*
		 * translators: To add an additional Open Sans character subset specific to your language,
		 * translate this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'highen' );

		if ( 'cyrillic' === $subset ) {
			$subsets .= ',cyrillic,cyrillic-ext';
		} elseif ( 'greek' === $subset ) {
			$subsets .= ',greek,greek-ext';
		} elseif ( 'vietnamese' === $subset ) {
			$subsets .= ',vietnamese';
		}

		$query_args = array(
			'family'  => urlencode( 'Open Sans:400italic,700italic,400,700' ),
			'subset'  => urlencode( $subsets ),
			'display' => urlencode( 'fallback' ),
		);
		$font_url   = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return $font_url;
}

/**
 * Enqueue scripts and styles for front end.
 *
 * @since Highen 1.0
 */
function highen_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Adds JavaScript for handling the navigation menu hide-and-show behavior.
	wp_enqueue_script( 'highen-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '20141205', true );

	$font_url = highen_get_font_url();
	if ( ! empty( $font_url ) ) {
		wp_enqueue_style( 'highen-fonts', esc_url_raw( $font_url ), array(), null );
	}

	// Loads our main stylesheet.
	wp_enqueue_style( 'highen-style', get_stylesheet_uri(), array(), '20190507' );

	// Theme block stylesheet.
	wp_enqueue_style( 'highen-block-style', get_template_directory_uri() . '/css/blocks.css', array( 'highen-style' ), '20190406' );

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'highen-ie', get_template_directory_uri() . '/css/ie.css', array( 'highen-style' ), '20150214' );
	$wp_styles->add_data( 'highen-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'highen_scripts_styles' );

/**
 * Enqueue styles for the block-based editor.
 *
 * @since Highen 2.6
 */
function highen_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'highen-block-editor-style', get_template_directory_uri() . '/css/editor-blocks.css', array(), '20190406' );
	// Add custom fonts.
	wp_enqueue_style( 'highen-fonts', highen_get_font_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'highen_block_editor_styles' );

/**
 * Add preconnect for Google Fonts.
 *
 * @since Highen 2.2
 *
 * @param array   $urls          URLs to print for resource hints.
 * @param string  $relation_type The relation type the URLs are printed.
 * @return array URLs to print for resource hints.
 */
function highen_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'highen-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '>=' ) ) {
			$urls[] = array(
				'href' => 'https://fonts.gstatic.com',
				'crossorigin',
			);
		} else {
			$urls[] = 'https://fonts.gstatic.com';
		}
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'highen_resource_hints', 10, 2 );

/**
 * Filter TinyMCE CSS path to include Google Fonts.
 *
 * Adds additional stylesheets to the TinyMCE editor if needed.
 *
 * @uses highen_get_font_url() To get the Google Font stylesheet URL.
 *
 * @since Highen 1.2
 *
 * @param string $mce_css CSS path to load in TinyMCE.
 * @return string Filtered CSS path.
 */
function highen_mce_css( $mce_css ) {
	$font_url = highen_get_font_url();

	if ( empty( $font_url ) ) {
		return $mce_css;
	}

	if ( ! empty( $mce_css ) ) {
		$mce_css .= ',';
	}

	$mce_css .= esc_url_raw( str_replace( ',', '%2C', $font_url ) );

	return $mce_css;
}
add_filter( 'mce_css', 'highen_mce_css' );

/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Highen 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function highen_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		/* translators: %s: Page number. */
		$title = "$title $sep " . sprintf( __( 'Page %s', 'highen' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'highen_wp_title', 10, 2 );

/**
 * Filter the page menu arguments.
 *
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since Highen 1.0
 */
function highen_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) ) {
		$args['show_home'] = true;
	}
	return $args;
}
add_filter( 'wp_page_menu_args', 'highen_page_menu_args' );

/**
 * Register sidebars.
 *
 * Registers our main widget area and the front page widget areas.
 *
 * @since Highen 1.0
 */
function highen_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Main Sidebar', 'highen' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'highen' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'First Front Page Widget Area', 'highen' ),
			'id'            => 'sidebar-2',
			'description'   => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'highen' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Second Front Page Widget Area', 'highen' ),
			'id'            => 'sidebar-3',
			'description'   => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'highen' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'highen_widgets_init' );

if ( ! function_exists( 'highen_content_nav' ) ) :
	/**
	 * Displays navigation to next/previous pages when applicable.
	 *
	 * @since Highen 1.0
	 */
	function highen_content_nav( $html_id ) {
		global $wp_query;

		if ( $wp_query->max_num_pages > 1 ) : ?>
			<nav id="<?php echo esc_attr( $html_id ); ?>" class="navigation" role="navigation">
				<h3 class="assistive-text"><?php _e( 'Post navigation', 'highen' ); ?></h3>
				<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'highen' ) ); ?></div>
				<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'highen' ) ); ?></div>
			</nav><!-- .navigation -->
			<?php
	endif;
	}
endif;

if ( ! function_exists( 'highen_comment' ) ) :
	/**
	 * Template for comments and pingbacks.
	 *
	 * To override this walker in a child theme without modifying the comments template
	 * simply create your own highen_comment(), and that function will be used instead.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @since Highen 1.0
	 */
	function highen_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback':
			case 'trackback':
				// Display trackbacks differently than normal comments.
				?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'highen' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'highen' ), '<span class="edit-link">', '</span>' ); ?></p>
				<?php
				break;
			default:
				// Proceed with normal comments.
				global $post;
				?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf(
						'<cite><b class="fn">%1$s</b> %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'highen' ) . '</span>' : ''
					);
					printf(
						'<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: Date, 2: Time. */
						sprintf( __( '%1$s at %2$s', 'highen' ), get_comment_date(), get_comment_time() )
					);
				?>
				</header><!-- .comment-meta -->

				<?php
				$commenter = wp_get_current_commenter();
				if ( $commenter['comment_author_email'] ) {
					$moderation_note = __( 'Your comment is awaiting moderation.', 'highen' );
				} else {
					$moderation_note = __( 'Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.', 'highen' );
				}
				?>

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php echo $moderation_note; ?></p>
				<?php endif; ?>

				<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'highen' ), '<p class="edit-link">', '</p>' ); ?>
				</section><!-- .comment-content -->

				<div class="reply">
				<?php
				comment_reply_link(
					array_merge(
						$args,
						array(
							'reply_text' => __( 'Reply', 'highen' ),
							'after'      => ' <span>&darr;</span>',
							'depth'      => $depth,
							'max_depth'  => $args['max_depth'],
						)
					)
				);
				?>
				</div><!-- .reply -->
			</article><!-- #comment-## -->
				<?php
				break;
		endswitch; // End comment_type check.
	}
endif;

if ( ! function_exists( 'highen_entry_meta' ) ) :
	/**
	 * Set up post entry meta.
	 *
	 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
	 *
	 * Create your own highen_entry_meta() to override in a child theme.
	 *
	 * @since Highen 1.0
	 */
	function highen_entry_meta() {
		/* translators: Used between list items, there is a space after the comma. */
		$categories_list = get_the_category_list( __( ', ', 'highen' ) );

		/* translators: Used between list items, there is a space after the comma. */
		$tags_list = get_the_tag_list( '', __( ', ', 'highen' ) );

		$date = sprintf(
			'<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);

		$author = sprintf(
			'<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			/* translators: %s: Author display name. */
			esc_attr( sprintf( __( 'View all posts by %s', 'highen' ), get_the_author() ) ),
			get_the_author()
		);

		if ( $tags_list && ! is_wp_error( $tags_list ) ) {
			/* translators: 1: Category name, 2: Tag name, 3: Date, 4: Author display name. */
			$utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'highen' );
		} elseif ( $categories_list ) {
			/* translators: 1: Category name, 3: Date, 4: Author display name. */
			$utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'highen' );
		} else {
			/* translators: 3: Date, 4: Author display name. */
			$utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'highen' );
		}

		printf(
			$utility_text,
			$categories_list,
			$tags_list,
			$date,
			$author
		);
	}
endif;

/**
 * Extend the default WordPress body classes.
 *
 * Extends the default WordPress body class to denote:
 * 1. Using a full-width layout, when no active widgets in the sidebar
 *    or full-width template.
 * 2. Front Page template: thumbnail in use and number of sidebars for
 *    widget areas.
 * 3. White or empty background color to change the layout and spacing.
 * 4. Custom fonts enabled.
 * 5. Single or multiple authors.
 *
 * @since Highen 1.0
 *
 * @param array $classes Existing class values.
 * @return array Filtered class values.
 */
function highen_body_class( $classes ) {
	$background_color = get_background_color();
	$background_image = get_background_image();

	if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'page-templates/full-width.php' ) ) {
		$classes[] = 'full-width';
	}

	if ( is_page_template( 'page-templates/front-page.php' ) ) {
		$classes[] = 'template-front-page';
		if ( has_post_thumbnail() ) {
			$classes[] = 'has-post-thumbnail';
		}
		if ( is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) ) {
			$classes[] = 'two-sidebars';
		}
	}

	if ( empty( $background_image ) ) {
		if ( empty( $background_color ) ) {
			$classes[] = 'custom-background-empty';
		} elseif ( in_array( $background_color, array( 'fff', 'ffffff' ), true ) ) {
			$classes[] = 'custom-background-white';
		}
	}

	// Enable custom font class only if the font CSS is queued to load.
	if ( wp_style_is( 'highen-fonts', 'queue' ) ) {
		$classes[] = 'custom-font-enabled';
	}

	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	return $classes;
}
add_filter( 'body_class', 'highen_body_class' );

/**
 * Adjust content width in certain contexts.
 *
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 * @since Highen 1.0
 */
function highen_content_width() {
	if ( is_page_template( 'page-templates/full-width.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
		global $content_width;
		$content_width = 960;
	}
}
add_action( 'template_redirect', 'highen_content_width' );

/**
 * Register postMessage support.
 *
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since Highen 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function highen_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'            => '.site-title > a',
				'container_inclusive' => false,
				'render_callback'     => 'highen_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'            => '.site-description',
				'container_inclusive' => false,
				'render_callback'     => 'highen_customize_partial_blogdescription',
			)
		);
	}
}
add_action( 'customize_register', 'highen_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @since Highen 2.0
 *
 * @see highen_customize_register()
 *
 * @return void
 */
function highen_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since Highen 2.0
 *
 * @see highen_customize_register()
 *
 * @return void
 */
function highen_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Enqueue JavaScript postMessage handlers for the Customizer.
 *
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since Highen 1.0
 */
function highen_customize_preview_js() {
	wp_enqueue_script( 'highen-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20141120', true );
}
add_action( 'customize_preview_init', 'highen_customize_preview_js' );

/**
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since Highen 2.4
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
 */
function highen_widget_tag_cloud_args( $args ) {
	$args['largest']  = 22;
	$args['smallest'] = 8;
	$args['unit']     = 'pt';
	$args['format']   = 'list';

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'highen_widget_tag_cloud_args' );

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Fire the wp_body_open action.
	 *
	 * Added for backward compatibility to support pre-5.2.0 WordPress versions.
	 *
	 * @since Highen 3.0
	 */
	function wp_body_open() {
		/**
		 * Triggered after the opening <body> tag.
		 *
		 * @since Highen 3.0
		 */
		do_action( 'wp_body_open' );
	}
endif;




function dequeue_my_css() {
  wp_dequeue_style('highen-style');
  wp_deregister_style('highen-style');

  wp_dequeue_style('wp-block-library');
  wp_deregister_style('wp-block-library');
}
add_action('wp_enqueue_scripts','dequeue_my_css');


add_filter( 'wp_enqueue_scripts', 'change_default_jquery', 1 );

function change_default_jquery( ){
    wp_dequeue_script( 'jquery');
    wp_deregister_script( 'jquery');

    wp_dequeue_script( 'jquery-core');
    wp_deregister_script( 'jquery-core');

}



function myscript_jquery() {
  
  
	  wp_enqueue_style( 'bootstrap-min', get_template_directory_uri() . '/css/bootstrap.min.css', array(), 'all');
	  wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), 'all');
	  wp_enqueue_style( 'flaticon-set', get_template_directory_uri() . '/css/flaticon-set.css', array(), 'all');
	  wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css', array(), 'all');

	  wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/css/owl.carousel.min.css', array(), 'all');
	  wp_enqueue_style( 'owl-theme-default', get_template_directory_uri() . '/css/owl.theme.default.min.css', array(), 'all');

	  wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css', array(), 'all');
	  wp_enqueue_style( 'bootsnav', get_template_directory_uri() . '/css/bootsnav.css', array(), 'all');
	  

		wp_enqueue_style( 'main-style', get_template_directory_uri() . '/css/style.css', array(), 'all');
		wp_enqueue_style( 'responsive', get_template_directory_uri() . '/css/responsive.css', array(), 'all');

	  wp_enqueue_style( 'fontAwesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
	  wp_enqueue_style( 'intlTelInput', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css');

	  wp_enqueue_style( 'fontsRoboto', 'https://fonts.googleapis.com/css?family=Roboto&display=swap');
	  wp_enqueue_style( 'fontsPoppins', 'https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800');


}
add_action( 'wp_head' , 'myscript_jquery', 1 );





function foot_theme_scripts() {
 

  // wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/jquery-1.12.4.min.js');
  // wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js');
  wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js');
  

  wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), true);
  wp_enqueue_script( 'equal-height', get_template_directory_uri() . '/js/equal-height.min.js', array(), true);
  wp_enqueue_script( 'jquery-appear', get_template_directory_uri() . '/js/jquery.appear.js', array(), true);
  wp_enqueue_script( 'jquery-easing', get_template_directory_uri() . '/js/jquery.easing.min.js', array(), true);
  wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array(), true);
  wp_enqueue_script( 'modernizr-custom', get_template_directory_uri() . '/js/modernizr.custom.13711.js', array(), true);
  wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array(), true);
  wp_enqueue_script( 'count-to', get_template_directory_uri() . '/js/count-to.js', array(), true);
  wp_enqueue_script( 'wow', get_template_directory_uri() . '/js/wow.min.js', array(), true);
  wp_enqueue_script( 'backgroundMove', get_template_directory_uri() . '/js/jquery.backgroundMove.js', array(), true);
  wp_enqueue_script( 'bootsnav', get_template_directory_uri() . '/js/bootsnav.js', array(), true);
  wp_enqueue_script( 'main', get_template_directory_uri() . '/js/main.js', array(), true);
  wp_enqueue_script( 'intl-tel-input', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js');
  wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', array(), true);


 }

add_action( 'wp_footer', 'foot_theme_scripts' );




require get_template_directory() . '/better-comments.php';


function action_wpcf7_mail_sent( $contact_form ) {

    $id = $contact_form->id;
      if ( $id === 345) {
        $submission = WPCF7_Submission::get_instance();
        if ( $submission ) {
            $posted_data = $submission->get_posted_data();
            
            $name = $posted_data['your-name'];
            $email = $posted_data['your-email'];
            $phone = $posted_data['phone'];
            $website = $posted_data['website'];
            $company_name = $posted_data['company_name'];
            $country = $posted_data['country'];
            $project_type = $posted_data['project_type'];
            $project_stage = $posted_data['project_stage'];
            $price = $posted_data['price'];
            $project_description = $posted_data['project-description'];
            $communication = $posted_data['communication'];
            $upload_file = $posted_data['upload-file'];
            $checkbox_ndaSign = $posted_data['checkbox-ndaSign'];
            $checkbox_tc = $posted_data['checkbox-tc'];

            $url = 'https://hook.integromat.com/f2e1xtxoqo6l7m4ikcn6i64naskvmda2';
            $args = array(
                'body' => array(
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
				            'website' => $website,
				            'company_name' => $company_name,
				            'country' => $country,
				            'project_type' => $project_type,
				            'project_stage' => $project_stage,
				            'price' => $price,
				            'project_description' => $project_description,
				            'communication' => $communication,
				            'upload_file' => $upload_file,
				            'checkbox_ndaSign' => $checkbox_ndaSign,
				            'checkbox_tc' => $checkbox_tc,
                )
            );

            wp_remote_post( $url, $args );
            
            retrun;

        }
     }
}
   
// add the action 
add_action( 'wpcf7_mail_sent', 'action_wpcf7_mail_sent', 10, 1 );



function disable_create_newpost() {
	if(current_user_can('editor')){
   global $wp_post_types;
    $wp_post_types['solutions']->cap->create_posts = 'do_not_allow';
    $wp_post_types['services']->cap->create_posts = 'do_not_allow';
    $wp_post_types['footer']->cap->create_posts = 'do_not_allow';
    $wp_post_types['page']->cap->create_posts = 'do_not_allow';
	}
    
}
add_action('init','disable_create_newpost');



function highen_pagination(){

	$allowed_tags = [
		'span' => [
			'class' => []
		],
		'a' => [
			'class' => [],
			'href' => [],
		]
	];

	$args = [
		'before_page_number' => '<span class="paginate-btn">',
		'after_page_number' => '</span>',

	];
	printf('<div class="pagination">%s</div>', wp_kses( paginate_links($args), $allowed_tags ) );
}