<?php
/**
 * Class for ACF Field support.
 *
 * @package WordPress
 */

// If check class exists.
if ( ! class_exists( 'Link_Shortener' ) ) {

	/**
	 * Declare class.
	 */
	class Link_Shortener {

		/**
		 * Calling construct.
		 */
		public function __construct() {
			if ( function_exists( 'register_block_type' ) ) {
				add_action( 'add_meta_boxes_post', array( $this, 'link_shortener_gutenberg_editor_metabox' ) );
			}
			add_filter( 'postbox_classes_post_link-shortener', array( $this, 'link_shortener_postbox_classes' ) );
			add_filter( 'pre_wp_unique_post_slug', array( $this, 'link_shortener_insert_post_data' ), 10, 6 );
		}

		/**
		 * Register metabox.
		 */
		public function link_shortener_gutenberg_editor_metabox() {
			add_meta_box(
				'link-shortener',
				__( 'Generate Link', 'link-shortener' ),
				array( $this, 'link_shortener_render' ),
				null,
				'side',
				'high',
				array(
					'__block_editor_compatible_meta_box' => true,
				)
			);
			add_action( 'admin_enqueue_scripts', array( $this, 'link_shortener_admin_script' ) );
		}

		/**
		 * Display metabox.
		 */
		public function link_shortener_render() {
			global $pagenow, $post;
			$button_text = __( 'Generate Link', 'link-shortener' );
			if ( 'post.php' === $pagenow ) {
				$button_text = __( 'Regenerate Link', 'link-shortener' );
			}
			$post_name = '';
			$link      = false;
			$post_id   = 0;
			if ( $post ) {
				$post_name = $post->post_name;
				$link      = esc_url( get_the_permalink( $post ) );
				$post_id   = $post->ID;
			}
			?>
			<p class="ls-preview">
				<a href="<?php echo esc_url( $link ); ?>" target="_blank" style="text-align: center; display: block;">
					<?php echo esc_html( $link ); ?>
				</a>
			</p>
			<p>
				<input type="hidden" name="shortener-link" value="<?php echo esc_attr( $post_name ); ?>">
			</p>
			<p>
				<a href="javascript:;" 
				   class="button button-primary button-large" 
				   data-ls_post_id="<?php echo esc_attr( $post_id ); ?>" 
				   data-ls_url="<?php echo esc_url( home_url( '/' ) ); ?>" 
				   style="text-align: center; display: block;">
					<?php echo esc_html( $button_text ); ?>
				</a>
			</p>
			<?php
			wp_nonce_field( 'link_shortener_action', 'link_shortener_nonce' );
		}

		/**
		 * Metabox class.
		 *
		 * @param $class array Metabox class.
		 * @return array
		 */
		public function link_shortener_postbox_classes( $class ) {
			if ( ! empty( $class ) && in_array( 'closed', $class, true ) ) {
				$class = [];
			}
			return $class;
		}

		/**
		 * Admin enqueue script.
		 */
		public function link_shortener_admin_script() {
			wp_enqueue_script(
			    'ls-admin-script',
			    plugin_dir_url( __FILE__ ) . '../assets/js/link-shortener.js',
			    array( 'jquery' ),
			    filemtime( plugin_dir_path( __FILE__ ) . '../assets/js/link-shortener.js' ),
			    true
			);
		}

		/**
		 * Save post
		 *
		 * @param int $post_id Post ID.
		 * @param object $post Post Object.
		 * @param bool $update Edit post OR not.
		 */
		public function link_shortener_insert_post_data( $null, $slug, $post_ID, $post_status, $post_type, $post_parent ) {
			
			if ( isset( $_POST['shortener-link'] ) ) {
			    // Verify nonce for security.
			    if ( ! isset( $_POST['link_shortener_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['link_shortener_nonce'] ) ), 'link_shortener_action' ) ) {
			        return $slug; // Abort if nonce fails.
			    }

			    $slug = sanitize_title( wp_unslash( $_POST['shortener-link'] ) );
			} else {
			    $slug = sanitize_title( $slug );
			}

			return $slug;
		}
	}
}