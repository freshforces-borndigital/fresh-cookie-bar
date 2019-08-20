<?php
/**
 * Setup cookie bar
 *
 * @package FreshCookieBar
 */

namespace Freshcookiebar;

/**
 * Setup Cookie Bar
 */
class Setup {
	/**
	 * Freshjet option's meta key
	 *
	 * @var string $options_key
	 */
	private $options_key = 'freshcookiebar_options';

	/**
	 * Setup actions & filters
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_custom_pages' ], 999 );
		add_action( 'admin_head', [ $this, 'inline_styles' ] );
		add_action( 'admin_init', [ $this, 'register_settings' ] );

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) );
		add_action( 'login_enqueue_scripts', array( $this, 'front_enqueue' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'front_enqueue' ) );
	}

	/**
	 * Add inline styles
	 */
	public function inline_styles() {?>
		<style>
		#toplevel_page_freshjet .wp-menu-image img {
			max-width: 25px;
			padding-top: 5px;
		}
		</style>
		<?php
	}

	/**
	 * Add custom pages
	 */
	public function add_custom_pages() {
		add_submenu_page(
			'options-general.php',
			__( 'Cookie Bar', 'freshcookiebar' ),
			__( 'Cookie Bar', 'freshcookiebar' ),
			'manage_options',
			'freshcookiebar',
			[ $this, 'render_setting_page' ]
		);
	}

	/**
	 * Render settings page output
	 */
	public function render_setting_page() {
		?>
		<div class="wrap settingstuff freshcookiebar-keys">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

			<form method="post" action="options.php">
				<div class="neatbox has-subboxes has-bigger-heading">
					<?php
					settings_fields( 'freshcookiebar-general-group' );
					do_settings_sections( 'freshcookiebar-general-page' );
					submit_button();
					?>
					<div class="response"></div>
				</div>
			</form>
		</div>
		<?php
	}

	/**
	 * Register Freshjet settings fields.
	 */
	public function register_settings() {
		// Setup setting groups.
		register_setting( 'freshcookiebar-general-group', $this->options_key );

		// Setup setting sections.
		add_settings_section( 'freshcookiebar-styles-section', __( 'Bar Attributes', 'freshcookiebar' ), '', 'freshcookiebar-general-page' );
		add_settings_section( 'freshcookiebar-button-section', __( 'Button Attributes', 'freshcookiebar' ), '', 'freshcookiebar-general-page' );

		// Setup style fields.
		add_settings_field( 'freshcookiebar-enable-field', __( 'Enable Cookie Bar', 'freshcookiebar' ), [ $this, 'render_enable_field' ], 'freshcookiebar-general-page', 'freshcookiebar-styles-section' );
		add_settings_field( 'freshcookiebar-font-size-field', __( 'Font Size', 'freshcookiebar' ), [ $this, 'render_font_size_field' ], 'freshcookiebar-general-page', 'freshcookiebar-styles-section' );
		add_settings_field( 'freshcookiebar-text-color-field', __( 'Text Color', 'freshcookiebar' ), [ $this, 'render_text_color_field' ], 'freshcookiebar-general-page', 'freshcookiebar-styles-section' );
		add_settings_field( 'freshcookiebar-bg-color-field', __( 'Background Color', 'freshcookiebar' ), [ $this, 'render_bg_color_field' ], 'freshcookiebar-general-page', 'freshcookiebar-styles-section' );
		add_settings_field( 'freshcookiebar-content-field', __( 'Content', 'freshcookiebar' ), [ $this, 'render_content_field' ], 'freshcookiebar-general-page', 'freshcookiebar-styles-section' );

		// Setup button fields.
		add_settings_field( 'freshcookiebar-button-text-field', __( 'Text Content', 'freshcookiebar' ), [ $this, 'render_button_text_field' ], 'freshcookiebar-general-page', 'freshcookiebar-button-section' );
		add_settings_field( 'freshcookiebar-button-text-color-field', __( 'Text Color', 'freshcookiebar' ), [ $this, 'render_button_text_color_field' ], 'freshcookiebar-general-page', 'freshcookiebar-button-section' );
		add_settings_field( 'freshcookiebar-bg-color-field', __( 'Background Color', 'freshcookiebar' ), [ $this, 'render_button_bg_color_field' ], 'freshcookiebar-general-page', 'freshcookiebar-button-section' );
	}

	/**
	 * Render public key field
	 */
	public function render_enable_field() {
		$opts   = get_option( $this->options_key );
		$enable = isset( $opts['enable'] ) ? absint( $opts['enable'] ) : 0;

		echo '
			<p>
				<label>
					<input type="checkbox" name="' . esc_attr( $this->options_key ) . '[enable]" value="1" ' . checked( $enable, 1, false ) . '/>
					' . esc_html__( 'Yes', 'freshcookiebar' ) . '
				</label>
			</p>
		';
	}

	/**
	 * Render public key field
	 */
	public function render_font_size_field() {
		$opts      = get_option( $this->options_key );
		$font_size = isset( $opts['font_size'] ) ? $opts['font_size'] : '1rem';

		echo '
			<p>
				<label>
					<input type="text" name="' . esc_attr( $this->options_key ) . '[font_size]" value="' . esc_attr( $font_size ) . '" class="regular-text" />
				</label>
			</p>
		';
	}

	/**
	 * Render text color field
	 */
	public function render_text_color_field() {
		$opts       = get_option( $this->options_key );
		$text_color = isset( $opts['text_color'] ) ? $opts['text_color'] : '#ffffff';

		echo '
			<p>
				<label>
					<input type="text" name="' . esc_attr( $this->options_key ) . '[text_color]" value="' . esc_attr( $text_color ) . '" class="regular-text color-picker" data-alpha="true" />
				</label>
			</p>
		';
	}

	/**
	 * Render bg color field
	 */
	public function render_bg_color_field() {
		$opts     = get_option( $this->options_key );
		$bg_color = isset( $opts['bg_color'] ) ? $opts['bg_color'] : '#151515';

		echo '
			<p>
				<label>
					<input type="text" name="' . esc_attr( $this->options_key ) . '[bg_color]" value="' . esc_attr( $bg_color ) . '" class="regular-text color-picker" data-alpha="true" />
				</label>
			</p>
		';
	}

	/**
	 * Render content field
	 */
	public function render_content_field() {
		$opts    = get_option( $this->options_key );
		$content = isset( $opts['content'] ) ? $opts['content'] : __( 'By using our website, you agree to the use of our cookies.', 'freshcookiebar' );

		wp_editor(
			$content,
			'privacy_policy_content',
			[
				'textarea_name' => esc_attr( $this->options_key ) . '[content]',
				'media_buttons' => false,
				'quicktags'     => true,
				'tinymce'       => [
					'toolbar1' => 'bold, italic, strikethrough, underline, link, forecolor, backcolor, charmap, undo, redo, fontsizeselect, fontselect',
				],
			]
		);
	}

	/**
	 * Render button text field
	 */
	public function render_button_text_field() {
		$opts        = get_option( $this->options_key );
		$button_text = isset( $opts['button_text'] ) ? $opts['button_text'] : __( 'OK', 'freshcookiebar' );

		echo '
			<p>
				<label>
					<input type="text" name="' . esc_attr( $this->options_key ) . '[button_text]" value="' . esc_attr( $button_text ) . '" class="regular-text" />
				</label>
			</p>
		';
	}

	/**
	 * Render button text color field
	 */
	public function render_button_text_color_field() {
		$opts              = get_option( $this->options_key );
		$button_text_color = isset( $opts['button_text_color'] ) ? $opts['button_text_color'] : '#ffffff';

		echo '
			<p>
				<label>
					<input type="text" name="' . esc_attr( $this->options_key ) . '[button_text_color]" value="' . esc_attr( $button_text_color ) . '" class="regular-text color-picker" data-alpha="true" />
				</label>
			</p>
		';
	}

	/**
	 * Render button bg color field
	 */
	public function render_button_bg_color_field() {
		$opts            = get_option( $this->options_key );
		$button_bg_color = isset( $opts['button_bg_color'] ) ? $opts['button_bg_color'] : '#f36418';

		echo '
			<p>
				<label>
					<input type="text" name="' . esc_attr( $this->options_key ) . '[button_bg_color]" value="' . esc_attr( $button_bg_color ) . '" class="regular-text color-picker" data-alpha="true" />
				</label>
			</p>
		';
	}

	/**
	 * Setting page styles
	 */
	public function admin_enqueue() {
		$current_screen = get_current_screen();

		if ( 'settings_page_freshcookiebar' !== $current_screen->id ) {
			return;
		}

		// styles.
		wp_enqueue_style( 'wp-color-picker', admin_url( 'css/color-picker.css' ), [], FRESHCOOKIEBAR_PLUGIN_VERSION, true );
		wp_enqueue_style( 'settings-page', FRESHCOOKIEBAR_PLUGIN_URL . '/assets/css/settings-page.css', [], FRESHCOOKIEBAR_PLUGIN_VERSION );

		// scripts.
		wp_register_script( 'iris', admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), '1.0.7', true );
		wp_register_script( 'wp-color-picker', admin_url( 'js/color-picker.min.js' ), [ 'iris' ], FRESHCOOKIEBAR_PLUGIN_VERSION, true );
		wp_enqueue_script( 'wp-color-picker-alpha', FRESHCOOKIEBAR_PLUGIN_URL . '/assets/js/wp-color-picker-alpha.min.js', [ 'wp-color-picker' ], '2.1.3', true );
		wp_enqueue_script( 'freshcookiebar-settings', FRESHCOOKIEBAR_PLUGIN_URL . '/assets/js/settings.js', [ 'wp-color-picker-alpha' ], FRESHCOOKIEBAR_PLUGIN_VERSION, true );
	}

	/**
	 * Bar styles
	 *
	 * @return void
	 */
	public function front_enqueue() {
		$opts = get_option( $this->options_key );

		if ( ! isset( $opts['enable'] ) || empty( $opts['enable'] ) ) {
			return;
		}

		wp_enqueue_script( 'freshcookiebar-bar', FRESHCOOKIEBAR_PLUGIN_URL . '/assets/js/bar.js', [ 'jquery' ], FRESHCOOKIEBAR_PLUGIN_VERSION, true );
		wp_localize_script( 'freshcookiebar-bar', 'freshcookiebarOpts', $opts );
	}
}
