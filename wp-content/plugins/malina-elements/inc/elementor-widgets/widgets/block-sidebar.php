<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon List Widget
 */
class Widget_ASW_block_sidebar extends Widget_Base {

	/**
	 * Retrieve icon list widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'malina-sidebar';
	}

	/**
	 * Retrieve icon list widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Malina Sidebar', 'malina-elements' );
	}

	/**
	 * Retrieve icon list widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-sidebar';
	}

	/**
	 * Retrieve the list of categories the icon list widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'malina-elements' ];
	}

	/**
	 * Render icon list widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings();
		$out = '';
		global $post;
		$sticky = get_theme_mod('malina_sticky_sidebar', 'sticky');
		ob_start();
		?>
		<div id="sidebar" class="<?php echo esc_attr($sticky); ?>">
		<?php
			$name = rwmb_get_value('malina_page_sidebar');
			if($name) {
				generated_dynamic_sidebar($name);
			} else {
				$name_temp = get_post_meta($post->ID, 'sbg_selected_sidebar_replacement', true);
				if( is_array($name_temp)){
					$name = $name_temp[0];
					generated_dynamic_sidebar($name);
				} else {
					if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('blog-widgets') );
				}
			}
		?>
		</div>
		<?php
		$out = ob_get_contents();
		ob_end_clean();
		echo $out;
	}
}
