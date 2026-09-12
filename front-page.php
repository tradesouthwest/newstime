<?php
/**
 * NewsTime Front Page The template for displaying the front page.
 *
 * @package            NewsTime
 */

get_header();
?>

<main id="primary" class="site-main-front newstime-front-page">

	<!-- Section 1: Post Ticker with Marquee Motion -->
	<section class="ticker-section" aria-label="<?php esc_attr_e( 'Trending News', 'newstime' ); ?>">

			<div class="ticker-wrapper">
				<div class="ticker-label"><?php esc_html_e( 'TRENDING', 'newstime' ); ?></div>
				<div class="ticker-content-wrapper">
					<div class="ticker-content">
						<?php
						$ticker_query = new WP_Query( array(
							'posts_per_page'      => 5,
							'post_status'         => 'publish',
							'ignore_sticky_posts' => 1,
						) );

						if ( $ticker_query->have_posts() ) :
							while ( $ticker_query->have_posts() ) : $ticker_query->the_post();
								?>
								<a href="<?php the_permalink(); ?>" class="ticker-item">
									<span class="ticker-bullet">&bull;</span>
									<?php echo esc_html( get_the_title() ); ?>
								</a>
								<?php
							endwhile;
							wp_reset_postdata();
						endif;
						?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Section 2: ATF Ezine Hero Layout (50/50 Split) -->
	<section class="atf-magazine-hero">
		<div class="container">
			<div class="atf-grid">

				<!-- Left Side: Featured / Sticky Post -->
				<div class="atf-left">
					<?php
					$sticky_posts = get_option( 'sticky_posts' );
					
					$left_args = array(
						'posts_per_page'      => 1,
						'post_status'         => 'publish',
						'ignore_sticky_posts' => 1,
					);

					// If sticky posts exist, prioritize them
					if ( ! empty( $sticky_posts ) ) {
						$left_args['post__in'] = $sticky_posts;
					}

					$left_query = new WP_Query( $left_args );

					if ( $left_query->have_posts() ) :
						while ( $left_query->have_posts() ) : $left_query->the_post();
							$featured_id = get_the_ID(); // Store ID to prevent duplication on the right
							?>
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'featured-main-card' ); ?>>
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="card-image">
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail( 'large' ); ?>
										</a>
									</div>
								<?php endif; ?>
								
								<div class="card-content">
									<div class="card-meta">
										<?php the_category( ', ' ); ?>
									</div>
									<h2 class="card-title">
										<a href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_title() ); ?></a>
									</h2>
									<div class="card-excerpt">
										<?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?>
									</div>
								</div>
							</article>
							<?php
						endwhile;
						wp_reset_postdata();
					endif;
					?>
				</div>

				<!-- Right Side: 4 Grid Items -->
				<div class="atf-right">
					<?php
					$right_args = array(
						'posts_per_page'      => 4,
						'post_status'         => 'publish',
						'post__not_in'        => isset( $featured_id ) ? array( $featured_id ) : array(),
						'ignore_sticky_posts' => 1,
					);

					$right_query = new WP_Query( $right_args );

					if ( $right_query->have_posts() ) :
						while ( $right_query->have_posts() ) : $right_query->the_post();
							?>
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'sub-feature-card' ); ?>>
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="card-image">
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail( 'medium' ); ?>
										</a>
									</div>
								<?php endif; ?>
								
								<div class="card-content">
									<h3 class="card-title">
										<a href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_title() ); ?></a>
									</h3>
									<div class="entry-excerpt">
                    					<p><?php echo esc_html( newstime_get_custom_excerpt( 15 ) ); ?></p>
                					</div>
										<span class="card-date">
											<?php echo esc_html( get_the_date() ); ?>
										</span>
								</div>
							</article>
						
							<?php
						endwhile;
						wp_reset_postdata();
					endif;
					?>
				</div>

			</div>
		</div>
	</section>
	
		<section class="front-page-inner-content">
			
			<?php the_content(); ?>

		</section>
</main>

<?php
get_footer();