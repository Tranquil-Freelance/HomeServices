<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( is_home() ) {
	$post_id = get_option( 'page_for_posts' );
	if ( $post_id && class_exists('RWMB_Loader') ) {
		$subtitle = rwmb_meta( 'ashade-page-subtitle', '', $post_id );
	?>
	<div class="ashade-page-title-wrap <?php echo ( empty( $subtitle ) ? 'ashade-page-title--is-alone' : ''); ?>">
        <h1 class="ashade-page-title">
			<?php if ( ! empty( $subtitle ) ) {
				echo '<span>' . esc_html($subtitle) . '</span>';
			} else {
				if ( 'vertical' == Ashade_Core::get_mod( 'ashade-title-layout' ) ) {
					echo '<span>&nbsp;</span>';
				}
			}?>
            <?php echo get_the_title( $post_id ); ?>
        </h1>
    </div><!-- .ashade-page-title-wrap -->
	<?php
	} else {
    ?>
    <div class="ashade-page-title-wrap">
        <h1 class="ashade-page-title">
            <span><?php echo get_bloginfo( 'description' ); ?></span>
            <?php echo get_bloginfo( 'name' ); ?>
        </h1>
    </div><!-- .ashade-page-title-wrap -->
    <?php
	}
} else if( is_search() ) {
    ?>
    <div class="ashade-page-title-wrap">
        <h1 class="ashade-page-title">
            <span><?php echo esc_html__( 'Looking for ', 'ashade' ) . '"' . get_search_query() . '"'; ?></span>
            <?php echo esc_html__( 'Search Results', 'ashade' ); ?>
        </h1>
    </div><!-- .ashade-page-title-wrap -->
    <?php
} else if ( is_single() ) {
    if ( class_exists( 'WooCommerce' ) && is_woocommerce() ) {
        if ( is_product() ) {
            $product = wc_get_product( get_the_ID() );
            ?>
            <div class="ashade-page-title-wrap">
                <h1 class="ashade-page-title">
                    <span>
                    <?php 
                        echo wc_get_product_category_list( get_the_ID(), ', ', '<span class="ashade-woo-categories">', '</span>' );
                        if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) {
                            echo '<span class="ashade-sku-wrapper">'. esc_html__( 'SKU:', 'ashade' ) . ' ' . ( $product->get_sku() ? $product->get_sku() : esc_html__( 'N/A', 'ashade' ) ) . '</span><!-- .ashade-sku-wrapper -->';
                        } ?>
                    </span>
                    <?php the_title(); ?>
                </h1>
            </div><!-- .ashade-page-title-wrap -->
            <?php
        }
    } else {
        if ( 'ashade-albums' == get_post_type() ) {
            $album_author = Ashade_Core::get_prefer( 'ashade-albums-meta-author' );
            $album_date = Ashade_Core::get_prefer( 'ashade-albums-meta-date' );
            $album_category = Ashade_Core::get_prefer( 'ashade-albums-meta-category' );

            $category_list = get_the_terms( get_the_id(), Ashade_Core::get_mod( 'ashade-cpt-albums-category' ) );
            $category_string = '';
            if ( is_array( $category_list ) ) {
                foreach ( $category_list as $cat ) {
                    $category_string .= $cat->name . ', ';
                }
                $category_string = substr( $category_string, 0, -2 );
            } else {
                $category_string = esc_attr__( 'Uncategorized', 'ashade' );
            }
            # Album Title DOM
            ?>
            <div class="ashade-page-title-wrap">
                <h1 class="ashade-page-title">
                    <span>
                        <?php if ( $album_date ) { ?>
                        <span class="ashade-meta-date ashade-post-meta">
                            <?php echo get_the_date(); ?>
                        </span>
                        <?php } ?>
                        <?php if ( $album_category ) { ?>
                        <span class="ashade-meta-category ashade-post-meta">
                            <?php echo esc_html( $category_string ); ?>
                        </span>
                        <?php } ?>
                        <?php if ( $album_author ) { ?>
                        <span class="ashade-meta-author ashade-post-meta">
                            <?php echo get_the_author_posts_link(); ?>
                        </span>
                        <?php } ?>
                        &nbsp;
                    </span>
                    <?php the_title(); ?>
                </h1>
            </div><!-- .ashade-page-title-wrap -->
            <?php
        } else if ( 'ashade-clients' == get_post_type() ) {
            # Client Title DOM
            if ( 'horizontal' == Ashade_Core::get_prefer( 'ashade-title-layout' ) && empty( Ashade_Core::get_rwmb( 'ashade-page-subtitle' ) ) ) {
                ?>
            <div class="ashade-page-title-wrap ashade-page-title--is-alone">
                <h1 class="ashade-page-title">
                    <?php the_title(); ?>
                </h1>
            </div><!-- .ashade-page-title-wrap -->
                <?php
            } else {
                ?>
            <div class="ashade-page-title-wrap">
                <h1 class="ashade-page-title">
                    <span><?php echo ( ! empty( Ashade_Core::get_rwmb( 'ashade-page-subtitle' ) ) ? esc_html( Ashade_Core::get_rwmb( 'ashade-page-subtitle' ) ) : '&nbsp;' ); ?></span>
                    <?php the_title(); ?>
                </h1>
            </div><!-- .ashade-page-title-wrap -->
                <?php
            }
        } else {
            $categories = get_the_category();
            $categories_html_escaped = '';
            $categories_more_escaped = '';
            if ( count( $categories ) > 3 ) {
                $categories_html_escaped = '
                <a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name )  . '</a>, 
                <a href="' . esc_url( get_category_link($categories[1]->term_id ) ) . '">' . esc_html( $categories[1]->name )  . '</a>, 
                <a href="' . esc_url( get_category_link( $categories[2]->term_id ) ) . '">' . esc_html( $categories[2]->name )  . '</a>
                <a href="#" class="ashade-category-more">+</a>';
                unset($categories[0]);
                unset($categories[1]);
                unset($categories[2]);
                $categories_more_escaped = '<div class="ashade-more-categories-wrap"><div class="ashade-more-categories">';
                foreach( $categories as $cat ) {
                    $categories_more_escaped .= '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_html( $cat->name )  . '</a>, ';
                }
                $categories_more_escaped = substr($categories_more_escaped, 0, -2);
                $categories_more_escaped .= '<hr><a href="#" class="ashade-more-categories-close">' . esc_html__( 'Close (Esc)', 'ashade' ) . '</a></div><!-- .ashade-more-categories --></div><!-- .ashade-more-categories-wrap --><div class="ashade-categories-overlay"></div><!-- .ashade-categories-overlay -->';
            } else {
                foreach( $categories as $cat ) {
                    $categories_html_escaped .= '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_html( $cat->name )  . '</a>, ';
                }
                $categories_html_escaped = substr($categories_html_escaped, 0, -2);
            }
            if ( ! empty( $categories_more_escaped ) ) {
                echo Ashade_Core::output_escaped( $categories_more_escaped );
            }
            # Single Post Title DOM
            ?>
            <div class="ashade-page-title-wrap">
                <h1 class="ashade-page-title">
                    <span>
                    <?php if ( Ashade_Core::get_prefer( 'ashade-post-meta' ) ) { ?>
                        <?php if ( Ashade_Core::get_prefer( 'ashade-post-meta-date' ) ) { ?>
                        <span class="ashade-meta-date ashade-post-meta">
                            <?php echo get_the_date(); ?>
                        </span>
                        <?php } ?>
                        <?php if ( Ashade_Core::get_prefer( 'ashade-post-meta-category' ) ) { ?>
                        <span class="ashade-meta-category ashade-post-meta">
                            <?php echo Ashade_Core::output_escaped( $categories_html_escaped ); ?>
                        </span>
                        <?php } ?>
                        <?php if ( Ashade_Core::get_prefer( 'ashade-post-meta-author' ) ) { ?>
                        <span class="ashade-meta-author ashade-post-meta">
                            <?php echo get_the_author_posts_link(); ?>
                        </span>
                        <?php } ?>
                    <?php } else { echo '&nbsp;'; }?>
                    </span>
                    <?php the_title(); ?>
                </h1>
            </div><!-- .ashade-page-title-wrap -->
            <?php
        }
    }
} else if ( is_page() ) {
    if ( 'horizontal' == Ashade_Core::get_prefer( 'ashade-title-layout' ) && empty( Ashade_Core::get_rwmb( 'ashade-page-subtitle' ) ) ) {
        ?>
    <div class="ashade-page-title-wrap ashade-page-title--is-alone">
        <h1 class="ashade-page-title">
            <?php the_title(); ?>
        </h1>
    </div><!-- .ashade-page-title-wrap -->
        <?php
    } else {
        ?>
    <div class="ashade-page-title-wrap">
        <h1 class="ashade-page-title">
            <span><?php echo ( ! empty( Ashade_Core::get_rwmb( 'ashade-page-subtitle' ) ) ? esc_html( Ashade_Core::get_rwmb( 'ashade-page-subtitle' ) ) : '&nbsp;' ); ?></span>
            <?php the_title(); ?>
        </h1>
    </div><!-- .ashade-page-title-wrap -->
        <?php
    }
} else if ( is_archive() ) {
	?>
	<div class="ashade-page-title-wrap">
		<h1 class="ashade-page-title">
            <?php 
            # Overhead
            if ( class_exists( 'WooCommerce' ) && is_woocommerce() ) {
                # WooCommerce Territory
                if ( is_shop() ) {
                    echo '<span>' . esc_html__( 'Explore My Products', 'ashade' ) . '</span>';
                }
                if ( is_product_category() ) {
                    echo '<span>' . esc_html__( 'Category', 'ashade' ) . '</span>';
                }
                if ( is_product_tag() ) {
                    echo '<span>' . esc_html__( 'Tagged in', 'ashade' ) . '</span>';
                }
            } else {
                if ( is_category() ) {
                    echo '<span>' . esc_html__( 'Category', 'ashade' ) . '</span>';
                } elseif ( is_tag() ) {
                    echo '<span>' . esc_html__( 'Posts by Tag', 'ashade' ) . '</span>';
                } elseif ( is_author() ) {
                    echo '<span>' . esc_html__( 'Posts by Author', 'ashade' ) . '</span>';
                } elseif ( is_year() ) {
                    echo '<span>' . esc_html__( 'Posted in Year', 'ashade' ) . '</span>';
                } elseif ( is_month() ) {
                    echo '<span>' . esc_html__( 'Posted in Month', 'ashade' ) . '</span>';
                } elseif ( is_day() ) {
                    echo '<span>' . esc_html__( 'Posted in Day', 'ashade' ) . '</span>';
                } elseif ( is_post_type_archive() ) {
                    echo '<span>' . esc_html__( 'Archives', 'ashade' ) . '</span>';
                } elseif ( is_tax() ) {
                    $queried_object = get_queried_object();
                    if ( $queried_object ) {
                        $tax = get_taxonomy( $queried_object->taxonomy );
                        echo '<span>' . $tax->labels->singular_name . '</span>';
                    } else {
                        echo '<span>&nbsp;</span>';
                    }
                } else {
                    echo '<span>&nbsp;</span>';
                }
            }
            # Heading
            if ( class_exists( 'WooCommerce' ) && ( is_shop() || is_product_taxonomy() || is_product_tag() || is_product_category() ) ) {
                if ( is_shop() ) {
                    woocommerce_page_title();
                }
                if ( is_product_category() ) {
                    echo esc_html( single_cat_title( '', false ) );
                }                
                if ( is_product_tag() ) {
                    echo esc_html( single_tag_title( '', false ) );
                }
            } else {
                if ( is_category() ) {
                    echo esc_html( single_cat_title( '', false ) );
                } elseif ( is_tag() ) {
                    echo esc_html( single_tag_title( '', false ) );
                } elseif ( is_author() ) {
                    echo esc_html( get_the_author() );
                } elseif ( is_year() ) {
                    echo esc_html( get_the_date( _x( 'Y', 'yearly archives date format', 'ashade' ) ) );
                } elseif ( is_month() ) {
                    echo esc_html( get_the_date( _x( 'F Y', 'monthly archives date format', 'ashade' ) ) );
                } elseif ( is_day() ) {
                    echo esc_html( get_the_date( _x( 'F j, Y', 'daily archives date format', 'ashade' ) ) );
                } elseif ( is_post_type_archive() ) {
                    echo esc_html( post_type_archive_title( '', false ) );
                } elseif ( is_tax() ) {
                    $queried_object = get_queried_object();
                    if ( $queried_object ) {
                        echo esc_html( single_term_title( '', false ) );
                    } else {
                        echo esc_html( get_the_title() );
                    }
                } else {
                    echo esc_html( get_the_title() );
                }
            }
            ?>
		</h1>
	</div><!-- .ashade-page-title-wrap -->
	<?php
}