<?php
/**
 * Posts grid widget.
 *
 * @package RahPowerAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Posts grid widget class.
 */
class rahad_Widget_Posts_Grid extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rahad_posts_grid';
	}

	public function get_title() {
		return __( 'Posts Grid', 'rah-power-addons' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return array( 'rahad_widgets' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'rahad_posts_grid_content',
			array(
				'label' => __( 'Query', 'rah-power-addons' ),
			)
		);

		$this->add_control(
			'rahad_posts_count',
			array(
				'label'   => __( 'Posts Count', 'rah-power-addons' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'max'     => 12,
			)
		);

		$this->add_control(
			'rahad_show_excerpt',
			array(
				'label'        => __( 'Show Excerpt', 'rah-power-addons' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'rah-power-addons' ),
				'label_off'    => __( 'No', 'rah-power-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$rahad_settings   = $this->get_settings_for_display();
		$rahad_posts_count = isset( $rahad_settings['rahad_posts_count'] ) ? absint( $rahad_settings['rahad_posts_count'] ) : 3;
		$rahad_show_excerpt = ! empty( $rahad_settings['rahad_show_excerpt'] );

		$rahad_query = new WP_Query(
			array(
				'post_type'           => 'post',
				'post_status'         => 'publish',
				'posts_per_page'      => max( 1, $rahad_posts_count ),
				'ignore_sticky_posts' => true,
			)
		);

		if ( ! $rahad_query->have_posts() ) {
			echo '<p>' . esc_html__( 'No posts found.', 'rah-power-addons' ) . '</p>';
			return;
		}
		?>
		<div class="rahad-posts-grid-widget">
			<div class="rahad-posts-grid">
				<?php
				while ( $rahad_query->have_posts() ) :
					$rahad_query->the_post();
					?>
					<article class="rahad-post-card">
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php echo esc_url( get_permalink() ); ?>" class="rahad-post-thumb"><?php the_post_thumbnail( 'medium' ); ?></a>
						<?php endif; ?>
						<h3><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></h3>
						<?php if ( $rahad_show_excerpt ) : ?>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
						<?php endif; ?>
					</article>
				<?php endwhile; ?>
			</div>
		</div>
		<?php
		wp_reset_postdata();
	}
}
