<?php
/**
 * Adds support for Jetpack Subscribe Modal feature
 *
 * @package automattic/jetpack-mu-wpcom
 * @since $$next-version$$
 */

/**
 * Jetpack_Subscribe_Modal class.
 */
class Jetpack_Subscribe_Modal {
	/**
	 * Jetpack_Subscribe_Modal singleton instance.
	 *
	 * @var Jetpack_Subscribe_Modal|null
	 */
	private static $instance;

	/**
	 * Jetpack_Subscribe_Modal instance init.
	 */
	public static function init() {
		if ( self::$instance === null ) {
			self::$instance = new Jetpack_Subscribe_Modal();
		}

		return self::$instance;
	}

	/**
	 * Jetpack_Subscribe_Modal class constructor.
	 */
	public function __construct() {
		if ( $this->should_enable_subscriber_modal() ) {
			add_action( 'wp_footer', array( $this, 'wpcom_add_subscribe_modal_to_frontend' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'wpcom_enqueue_subscribe_modal_assets' ) );
			add_filter( 'get_block_template', array( $this, 'add_block_template' ), 10, 3 );
			add_filter( 'get_block_templates', array( $this, 'add_block_templates' ), 10, 3 );
		}
	}

	/**
	 * @return WP_Block_Template
	 */
	public function get_custom_template() {
		$template                 = new WP_Block_Template();
		$template->theme          = 'Jetpack';
		$template->content        = $this->get_subscribe_template_content();
		$template->slug           = 'jetpack-subscribe-modal2';
		$template->source         = 'plugin';
		$template->type           = 'wp_template_part';
		$template->title          = 'Subscribe Modal Template 2';
		$template->status         = 'publish';
		$template->has_theme_file = false;
		$template->is_custom      = true;
		$template->description    = 'Subscribe Modal Templateasdf';

		return $template;
	}

	/**
	 * @return string
	 * @
	 */
	public function add_block_templates( $query_result, $query, $template_type ) {
		if ( empty( $query ) && $template_type === 'wp_template_part' ) {
			$query_result[] = $this->get_custom_template();
		}

		return $query_result;
	}

	/**
	 * @return string
	 */
	public function add_block_template( $block_template, $id, $template_type ) {
		$custom_template = $this->get_custom_template();

		if ( empty( $block_template ) && $template_type === 'wp_template_part' && $id === $custom_template->id ) {
			$block_template = $custom_template;
		}

		return $block_template;
	}

	/**
	 * Adds modal with Subscribe Modal content.
	 *
	 * @return void
	 */
	public function wpcom_add_subscribe_modal_to_frontend() {
		if ( $this->is_front_end_single_post() ) {

			/*
			 * Jetpack requires escaping html for the render_block() call below.
			 * I'm using wp_kses() and specifying the allowed tags.
			 * But this is fragile: users can edit the Subscribe Modal
			 * template and add tags that are not allowed here.
			 */
			$allowed_html = array(
				'div'    => array(
					'class' => array(),
					'style' => array(),
				),
				'h2'     => array(
					'class' => array(),
					'style' => array(),
				),
				'p'      => array(
					'type'  => array(),
					'class' => array(),
					'style' => array(),
					'id'    => array(),
				),
				'form'   => array(
					'action'                 => array(),
					'method'                 => array(),
					'accept-charset'         => array(),
					'data-blog'              => array(),
					'data-post_access_level' => array(),
					'id'                     => array(),
				),
				'label'  => array(
					'id'    => array(),
					'for'   => array(),
					'class' => array(),
				),
				'input'  => array(
					'id'          => array(),
					'type'        => array(),
					'name'        => array(),
					'value'       => array(),
					'class'       => array(),
					'style'       => array(),
					'placeholder' => array(),
					'required'    => array(),
				),
				'button' => array(
					'type'  => array(),
					'class' => array(),
					'style' => array(),
					'name'  => array(),
				),
			);

			$template_part_block = array(
				'blockName' => 'core/block',
				'attrs'     => array(
					'ref' => 'jetpack-subscribe-modal2', // the slug of your template part
				),
			);

			?>
					<div class="jetpack-subscribe-modal">
						<div class="jetpack-subscribe-modal__modal-content">
				<?php
				block_template_part( 'jetpack-subscribe-modal' );
				?>
				<?php
				echo wp_kses( render_block( $template_part_block ), $allowed_html );
				?>
							<Dashicon icon="minus" className="jp-idc__idc-screen__card-action-separator" />
						</div>
					</div>
			<?php
		}
	}

	/**
	 * Enqueues JS to load modal.
	 *
	 * @return void
	 */
	public function wpcom_enqueue_subscribe_modal_assets() {
		if ( $this->is_front_end_single_post() ) {
			wp_enqueue_style( 'subscribe-modal-css', plugins_url( 'subscribe-modal.css', __FILE__ ), array(), JETPACK__VERSION );
			wp_enqueue_script( 'subscribe-modal-js', plugins_url( 'subscribe-modal.js', __FILE__ ), array( 'wp-dom-ready' ), JETPACK__VERSION, true );
		}
	}

	/**
	 * Returns true if we should enable Newsletter content.
	 * This is currently limited to lettre theme or newsletter sites.
	 * We could open it to all themes or site intents.
	 *
	 * @return bool
	 */
	public function should_enable_subscriber_modal() {
		if ( 'lettre' !== get_option( 'stylesheet' ) && 'newsletter' !== get_option( 'site_intent' ) ) {
			return false;
		}
		if ( ! get_option( 'sm_enabled', false ) ) {
			return false;
		}
		if ( ! wp_is_block_theme() ) {
			return false;
		}

		/**
		 * Allows force-enabling or disabling the Subscriptions modal.
		 *
		 * @param bool $should_enable_subscriber_modal Whether the Subscriptions modal should be enabled.
		 *
		 * @since $$next-version$$
		 */
		return (bool) apply_filters( 'jetpack_subscriptions_modal_force_enabled', true );
	}

	/**
	 * Returns true if we are on frontend of single post.
	 * Note: Because of how WordPress works, this function will
	 * only return the correct value after a certain point in the
	 * WordPress loading process. You cannot, for example, use this
	 * method in the class contructor method - it will always return false.
	 *
	 * @return bool
	 */
	public function is_front_end_single_post() {
		return ! is_admin() && is_singular( 'post' );
	}

	/**
	 * Returns the slug for the Subscribe template.
	 *
	 * @return string
	 */
	public function get_subscribe_template_slug() {
		return 'subscribe-modal';
	}

	/**
	 * Returns the initial content of the Subscribe Modal template.
	 * This can then be edited by the user.
	 *
	 * @return string
	 */
	public function get_subscribe_template_content() {
		return '<!-- wp:group {"style":{"spacing":{"padding":{"top":"50px","bottom":"50px","left":"20px","right":"20px"}}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group" style="padding-top:50px;padding-right:20px;padding-bottom:50px;padding-left:20px"><!-- wp:group {"style":{"dimensions":{"minHeight":"0px"},"spacing":{"blockGap":"8px"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"center"}} -->
		<div class="wp-block-group" style="min-height:0px"><!-- wp:heading {"style":{"typography":{"fontStyle":"normal","fontWeight":"600","fontSize":"26px"},"layout":{"selfStretch":"fit","flexSize":null}}} -->
		<h2 class="wp-block-heading" style="font-size:26px;font-style:normal;font-weight:600">' . __( 'Discover more from', 'jetpack' ) . '</h2>
		<!-- /wp:heading -->
		
		<!-- wp:site-title {"level":2,"textAlign":"center","style":{"typography":{"fontStyle":"normal","fontWeight":"600","lineHeight":"1.2","fontSize":"26px"}}} /--></div>
		<!-- /wp:group -->
		
		<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"15px"},"spacing":{"margin":{"top":"4px","bottom":"0px"}}}} -->
		<p class="has-text-align-center" style="margin-top:4px;margin-bottom:0px;font-size:15px">' . __( 'Subscribe to the newsletter to keep reading', 'jetpack' ) . '</p>
		<!-- /wp:paragraph -->
		
		<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"15px"},"spacing":{"margin":{"bottom":"20px","top":"0px"}}}} -->
		<p class="has-text-align-center" style="margin-top:0px;margin-bottom:20px;font-size:15px">and get access to the full archive.</p>
		<!-- /wp:paragraph -->
		
		
		<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#666666"},"typography":{"fontSize":"14px","textDecoration":"underline"}},"className":"jetpack-subscribe-modal__close"} -->
		<p class="has-text-align-center jetpack-subscribe-modal__close has-text-color" style="color:#666666;font-size:14px;text-decoration:underline"><a href="#">' . __( 'Continue Reading', 'jetpack' ) . '</a></p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group -->';
	}
}

/**
 * Temporary feature flag for the subscription modal
 *
 * @param bool Should load subscription modal. Defaults to false.
 *
 * @since $$next-version$$
 */
if ( apply_filters( 'jetpack_subscriptions_modal_enabled', false ) ) {
	Jetpack_Subscribe_Modal::init();
}
