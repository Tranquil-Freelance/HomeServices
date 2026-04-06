<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

get_header();
the_post();

$intro_text = Ashade_Core::get_rwmb( 'ashade-al-intro' );
$intro_align = Ashade_Core::get_rwmb( 'ashade-al-intro-align', 'center' );
$intro_width = Ashade_Core::get_rwmb( 'ashade-al-intro-width', 'yes' );
$type = Ashade_Core::get_rwmb( 'ashade-al-type' );
$al_title_state = Ashade_Core::get_rwmb( 'ashade-al-page-title', 'default' );
if ( 'default' == $al_title_state ) {
	$title_state = Ashade_Core::get_mod( 'ashade-page-title' );
} else {
	$title_state = Ashade_Core::get_rwmb( 'ashade-al-page-title' );
}
$lazy_state = Ashade_Core::get_mod( 'ashade-lazy-loader' );
$prefer_cover = Ashade_Core::get_rwmb( 'ashade-al-cover' );

$categs = Ashade_Core::get_rwmb( 'ashade-al-categs' );
$tax_name = Ashade_Core::get_mod( 'ashade-cpt-albums-category' );

if ( Ashade_Core::get_rwmb( 'ashade-al-back2top', 'default' ) == 'default' ) {
	$back_state = Ashade_Core::get_mod( 'ashade-back2top' );
} else {
	$back_state = Ashade_Core::get_rwmb( 'ashade-al-back2top', 'default' );
}

$content_width = Ashade_Core::get_rwmb( 'ashade-al-content-width' );
$category_labels = Ashade_Core::get_rwmb( 'ashade-al-categs-labels', 'show' );

$link_style = Ashade_Core::get_rwmb( 'ashade-al-ribbon-link', 'button' );

if ( 'ribbon' == $type ) {
    wp_enqueue_script( 'ashade-ribbon' );
    $style = Ashade_Core::get_rwmb( 'ashade-al-ribbon-style' );
    if ( 'vertical' == $style && $title_state ) {
        ?>
        <!-- Content -->
        <div class="ashade-page-title-wrap">
            <h1 class="ashade-page-title">
                <span><?php echo ( ! empty( Ashade_Core::get_rwmb( 'ashade-page-subtitle' ) ) ? esc_html( Ashade_Core::get_rwmb( 'ashade-page-subtitle' ) ) : '&nbsp;' ); ?></span>
                <?php the_title(); ?>
            </h1>
        </div>
        <?php
    }
    ?>
    <div class="ashade-albums-carousel-wrap ashade-categ-labels--<?php echo esc_attr( $category_labels ) . esc_attr( Ashade_Core::get_rwmb( 'ashade-al-ribbon-mobile', false ) ? ' vertical-mobile-layout' : '' ); ?>">
		<div class="ashade-albums-carousel is-<?php echo esc_attr( $style ); ?> link-style--<?php echo esc_attr( $link_style ) . esc_attr( Ashade_Core::get_rwmb( 'ashade-al-ribbon-mobile', false ) ? ' vertical-mobile-layout' : '' ); ?>" id="albums_carousel">
    <?php
} else if ( 'slider' == $type ) {
    wp_enqueue_script( 'ashade-slider' );
	$style = Ashade_Core::get_rwmb( 'ashade-al-slider-style' );
	$fit = Ashade_Core::get_rwmb( 'ashade-al-slider-fit', 'cover' );

    ?>
    <div class="ashade-albums-slider-wrap ashade-categ-labels--<?php echo esc_attr( $category_labels ); ?>">
		<div class="ashade-albums-slider ashade-slider--<?php echo esc_attr( $fit ); ?> is-<?php echo esc_attr( $style ); ?>" id="albums_slider">
    <?php
} else {
    if ( 'masonry' == $type ) {
        wp_enqueue_script( 'masonry' );
	}   
	if ( Ashade_Core::get_rwmb( 'ashade-al-title-layout', 'default' ) == 'default' ) {
		$layout = Ashade_Core::get_mod( 'ashade-title-layout' );
	} else {
		$layout = Ashade_Core::get_rwmb( 'ashade-al-title-layout', 'default' );
	}

    $columns = Ashade_Core::get_rwmb( 'ashade-al-grid-columns' );
    $crop = Ashade_Core::get_rwmb( 'ashade-al-grid-crop' );
    $crop_width = Ashade_Core::get_rwmb( 'ashade-al-grid-width' );
	$crop_height = Ashade_Core::get_rwmb( 'ashade-al-grid-height' );
	$filter_state = Ashade_Core::get_rwmb( 'ashade-al-filter' );
	$gallery_id = 'ashade-' . $type . '-gallery' . get_the_ID();
	
    if ( $title_state && 'vertical' == $layout ) {
		get_template_part( 'template-parts/page-title' );
    }
    ?>
    <main class="ashade-content-wrap ashade-content--<?php echo esc_attr( $content_width ); ?>">
		<div class="ashade-content-scroll">
			<?php
				if ( $title_state && 'horizontal' == $layout ) {
					get_template_part( 'template-parts/page-title' );
				}
			?>
			<div class="ashade-content">
                <?php if ( ! empty( $intro_text ) ) { ?>
				<section class="ashade-section">
					<div class="ashade-row">
						<div class="ashade-col col-12">
							<p class="ashade-intro align-<?php echo esc_attr( $intro_align ); ?> limit-width-<?php echo esc_attr( $intro_width ); ?>"><?php echo nl2br( esc_html( $intro_text ) ); ?></p>
						</div>
					</div>
				</section>
                <?php } ?>
				<section class="ashade-section">
					<div class="ashade-row">
						<div class="ashade-col col-12">
							<?php if ( 'show' == $filter_state ) { ?>
								<div class="ashade-filter-wrap" data-id="<?php echo esc_attr( $gallery_id ); ?>" data-label="<?php echo esc_attr__( 'Filter', 'ashade' ); ?>">
									<?php 
									$tax_terms = array();
									if ( ! empty( $categs ) && 'all' !== $categs[0] && 'none' !== $categs[0] ) {
										foreach ( $categs as $cat_slug ) {
											array_push( $tax_terms, get_term_by( 'slug', $cat_slug, $tax_name )->term_id );
										}
									}
									$filter_terms = get_terms(array(
										'taxonomy' => $tax_name, 
										'field' => 'slug', 
										'include' => $tax_terms
									));
									if ( count( $filter_terms ) > 0 ) {
										echo '<a href="#" data-category="*" class="is-active">' . esc_html__( 'All', 'ashade' ) . '</a>';
									}
									if ( is_array( $filter_terms ) ) {
										foreach ( $filter_terms as $cat ) {
											echo '<a href="#" data-category=".ashade-category--'. esc_attr( $cat->slug ) .'">'. esc_attr( $cat->name ) .'</a>';
										}
									}
									?>
								</div>
							<?php } ?>
                            <div id="<?php echo esc_attr( $gallery_id ); ?>" class="
                                ashade-albums-grid 
                                ashade-grid 
                                ashade-grid-<?php echo esc_attr( $columns ); ?>cols 
                                <?php echo ( 'masonry' == $type ? 'is-masonry' : '' ); ?> 
                                <?php echo ( 'show' == $filter_state ? 'has-filter' : '' ); ?> 
                                <?php echo ( 'adjusted' == $type ? 'ashade-gallery-adjusted' : '' ); ?> 
                                ashade-categ-labels--<?php echo esc_attr( $category_labels ); ?>">
    <?php
}

$args = array(
    'post_type' 	 => 'ashade-albums',
    'post_status' 	 => 'publish',
	'posts_per_page' => -1,
	'orderby' 		 => esc_attr( Ashade_Core::get_rwmb( 'ashade-al-orderby', 'date' ) ),
	'order' 		 => esc_attr( Ashade_Core::get_rwmb( 'ashade-al-order', 'DESC' ) ),
    'paged' => -1,
);

if ( ! empty( $categs ) && 'all' !== $categs[0] && 'none' !== $categs[0] ) {
	$tax_terms = array();
	foreach ( $categs as $cat_slug ) {
		array_push( $tax_terms, get_term_by( 'slug', $cat_slug, $tax_name )->term_id );
	}
	$query_tax = array(
		array(
			'taxonomy' => $tax_name,
			'field'    => 'id',
			'terms'    => $tax_terms
		)
	);
	$args['tax_query'] = $query_tax;
}

$query = new WP_Query( $args );
if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
        $query->the_post();
		$category_list = get_the_terms( get_the_id(), Ashade_Core::get_mod( 'ashade-cpt-albums-category' ) );
        $category_string = '';
        if ( is_array( $category_list ) ) {
            foreach ( $category_list as $cat ) {
                $category_string .= $cat->name . ", ";
            }
            $category_string = substr( $category_string, 0, -2 );
        } else {
            $category_string = esc_attr__( 'Uncategorized', 'ashade' );
        }
		# Select Cover Image
		if ( 'custom' == $prefer_cover ) {			
			$cover_image = Ashade_Core::get_rwmb( 'ashade-albums-image' );
			if ( ! empty( $cover_image ) ) {
				foreach ( $cover_image as $item ) {
					$featured_image_url = wp_get_attachment_url( $item[ 'ID' ] );
					$featured_image_meta = wp_get_attachment_metadata( $item[ 'ID' ] );
					$thmb_url = wp_get_attachment_image_url( $item[ 'ID' ], 'large' );
				}
			} else {
				$featured_image_url = Ashade_Core::get_fimage_url();
        		$featured_image_meta = wp_get_attachment_metadata( get_post_thumbnail_id() );
				$thmb_url = wp_get_attachment_image_url( get_post_thumbnail_id(), 'large' );
			}
		} else {
			$featured_image_url = Ashade_Core::get_fimage_url();
        	$featured_image_meta = wp_get_attachment_metadata( get_post_thumbnail_id() );
			$thmb_url = wp_get_attachment_image_url( get_post_thumbnail_id(), 'large' );
		}
		
		if ( ! $featured_image_url ) {
			// Try to get Alternative
			$cover_image = Ashade_Core::get_rwmb( 'ashade-albums-image' );
			if ( ! empty( $cover_image ) ) {
				foreach ( $cover_image as $item ) {
					$featured_image = wp_get_attachment_image_src( $item[ 'ID' ], 'full' );
					$featured_image_url = $featured_image[0];
					$featured_image_meta = wp_get_attachment_metadata( $item[ 'ID' ] );
					$thmb_url = wp_get_attachment_image_url( $item[ 'ID' ], 'large' );
				}
			} else {
				// Try to get inside image
				$gallery_type = Ashade_Core::get_rwmb( 'ashade-albums-media-type', 'images' );
				$imgID = false;
				if ( 'mixed' == $gallery_type ) {
					$images = Ashade_Core::get_rwmb( 'ashade-albums-media' );
					if ( is_array( $images ) && count( $images) ) {
						foreach ( $images as $item ) {
							if ( !$imgID && !empty( $item[ 'image' ] ) ) {
								$imgID = $item[ 'image' ];
							}
						}
					}
				} else if ( 'images' == $gallery_type ) {
					$images = Ashade_Core::get_rwmb( 'ashade-albums-images' );
					if ( is_array( $images ) && count( $images) ) {
						foreach ( $images as $item ) {
							if ( !$imgID && $item[ 'ID' ] ) {
								$imgID = $item[ 'ID' ];
							}
						}
					}
				}
				if ( $imgID ) {
					$featured_image = wp_get_attachment_image_src( $imgID, 'full' );
					$featured_image_url = $featured_image[0];
					$featured_image_meta = wp_get_attachment_metadata( $imgID );
					$thmb_url = wp_get_attachment_image_url( $imgID, 'large' );
				}
			}
		}

		if ( $featured_image_url ) {
		
			if ( 'ribbon' == $type ) {
				$image_width = $featured_image_meta[ 'width' ];
				$image_height = $featured_image_meta[ 'height' ];
			} else if ( 'slider' == $type ) {
				$image_width = $featured_image_meta[ 'width' ];
				$image_height = $featured_image_meta[ 'height' ];
			} else {
				$ratio = $featured_image_meta[ 'height' ]/$featured_image_meta[ 'width' ];
				if ( 'yes' == $crop) {
					$thmb_width = $crop_width;
					if ( 'grid' == $type ) {
						$thmb_height = $crop_height;
					} else {
						$thmb_height = $thmb_width*$ratio;
					}
				} else {
					$thmb_width = 960;
					if ( 'grid' == $type ) {
						$thmb_height = 640;
					} else {
						$thmb_height = $thmb_width*$ratio;
					}
				}
			}
			# Album Listing Item
			if ( 'ribbon' == $type ) {
				# Ribbon Item
			?>
				<div id="album-<?php the_ID(); ?>" <?php post_class( 'ashade-album-item' ); ?>>
					<div class="ashade-album-item__inner">
						<img 
							<?php if ( $lazy_state ) { ?>
							src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%20<?php echo absint( $image_width ); ?>%20<?php echo absint( $image_height ); ?>'%3E%3C/svg%3E"
							data-src="<?php echo esc_url( $featured_image_url ); ?>"
							class="ashade-lazy" 
							<?php } else { ?>
							src="<?php echo esc_url( $featured_image_url ); ?>"
							<?php } ?>
							alt="<?php echo esc_attr( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ); ?>" 
							width="<?php echo esc_attr( $image_width ); ?>" 
							height="<?php echo esc_attr( $image_height ); ?>">
						<div class="ashade-album-item__overlay"></div>
						<div class="ashade-album-item__title">
							<h2>
								<span><?php echo ( ! empty( $category_string ) ? $category_string : '&nbsp;'); ?></span>
								<?php the_title(); ?>
							</h2>
						</div>
						<?php if ( 'link' == $link_style ) { ?>
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="ashade-ribbon-link"></a>
						<?php } else { ?>
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="ashade-button"><?php echo esc_html__('Explore', 'ashade'); ?></a>
						<?php } ?>
					</div>
				</div><!-- .ashade-album-item -->
			<?php 
			} else if ( 'slider' == $type ) {
				# Slider Item
			?>
				<div id="album-<?php the_ID(); ?>" <?php post_class( 'ashade-album-item' ); ?>>
					<div class="ashade-album-item__image" data-src="<?php echo esc_url( $featured_image_url ); ?>"></div>
					<div class="ashade-album-item__overlay"></div>
					<div class="ashade-album-item__title">
						<h2>
							<span><?php echo ( ! empty( $category_string ) ? $category_string : '&nbsp;'); ?></span>
							<?php the_title(); ?>
						</h2>
					</div>
                    <?php if ( 'link' == $link_style ) { ?>
                    <a href="<?php echo esc_url( get_permalink() ); ?>" class="ashade-slider-link"></a>
                    <?php } else { ?>
					<div class="ashade-album-item__explore">
						<a href="<?php echo esc_url( get_permalink() ); ?>">
							<span><?php echo esc_html__('Click Here To', 'ashade'); ?></span>
							<?php echo esc_html__('Explore', 'ashade'); ?>
						</a>
					</div>
                    <?php } ?>
				</div><!-- .ashade-album-item -->
			<?php 
			} else {
				# Grid Item
				if ( 'show' == $filter_state ) {
					$category_filter = '';
					if ( is_array( $category_list ) ) {
						foreach ( $category_list as $cat ) {
							$category_filter .= 'ashade-category--' . $cat->slug . " ";
						}
						$category_filter = substr( $category_filter, 0, -1 );
					}
				} else {
					$category_filter = null;
				}
			?>
				<div id="album-<?php the_ID(); ?>" <?php post_class( array( 'ashade-album-item', 'ashade-grid-item', esc_attr( $category_filter ) ) ); ?>>
					<div class="ashade-grid-item--inner">
						<div class="ashade-album-item__image">
							<div class="ashade-image <?php echo esc_attr( $lazy_state ? 'ashade-lazy' : 'ashade-div-image' ); ?>" data-src="<?php echo esc_url( $thmb_url ); ?>">
								<img
									src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%20<?php echo absint( $thmb_width ); ?>%20<?php echo absint( $thmb_height ); ?>'%3E%3C/svg%3E" 
									width=<?php echo absint( $thmb_width ); ?> 
									height=<?php echo absint( $thmb_height ); ?> 
									alt="<?php echo esc_attr( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ); ?>">
							</div><!-- .ashade-image -->
						</div>
						<h5>
							<span><?php echo esc_html( $category_string ); ?></span>
							<?php the_title(); ?>
						</h5>
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="ashade-album-item__link"></a>
					</div><!-- .ashade-grid-item--inner -->
				</div><!-- .ashade-album-item -->
			<?php 
			}
		}
    }
}
wp_reset_query();

if ( 'ribbon' == $type ) {
    ?>
        </div><!-- .ashade-albums-carousel -->
	</div><!-- .ashade-albums-carousel-wrap -->
    <?php
    if ( 'vertical' == $style ) {
        get_template_part( 'template-parts/back-to-top' );
    }
    get_template_part( 'template-parts/footer-part' ); 
} else if ( 'slider' == $type ) {
    ?>
        </div><!-- .ashade-albums-slider -->
        <?php
        if ( 'show' == Ashade_Core::get_rwmb( 'ashade-al-slider-nav' ) ) {
            echo '
            <a href="#" class="ashade-slider-prev">' . esc_html__( 'Prev', 'ashade' ) . '</a>
            <a href="#" class="ashade-slider-next">' . esc_html__( 'Next', 'ashade' ) . '</a>
            ';
        }
        ?>
    </div><!-- .ashade-albums-slider-wrap -->
    <?php
    get_template_part( 'template-parts/footer-part' ); 
} else {
    ?>
                            </div><!-- .ashade-albums-grid -->
                        </div><!-- .ashade-col -->
                    </div><!-- .ashade-row -->
                </section><!-- .ashade-section -->
            </div><!-- .ashade-content -->
            <?php
			if ( $back_state && 'horizontal' == $layout ) {
				get_template_part( 'template-parts/back-to-top' );
			}
			if ( $back_state && 'vertical' == $layout ) {
				get_template_part( 'template-parts/back-to-top-mobile' );
			}
            get_template_part( 'template-parts/footer-part' );
            ?>
        </div><!-- .ashade-content-scroll -->
    </main>

    <?php
	if ( $back_state && 'vertical' == $layout ) {
        get_template_part( 'template-parts/back-to-top' );
    }
}

get_template_part( 'template-parts/aside' );
get_template_part( 'template-parts/page-ui' );

get_footer();