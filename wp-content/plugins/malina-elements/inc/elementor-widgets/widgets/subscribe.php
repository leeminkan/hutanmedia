<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Widget_ASW_subscribe extends Widget_Base {
	public function get_name() {
		return 'malina-subscribe';
	}
	public function get_title() {
		return __( 'Malina Subscribe', 'malina-elements' );
	}
	public function get_icon() {
		// Icon name from the Elementor font file, as per http://dtbaker.net/web-development/creating-your-own-custom-elementor-widgets/
		return 'eicon-posts-grid';
	}
	/**
	 * Retrieve the list of categories the accordion widget belongs to.
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
	protected function _register_controls() {

		$this->start_controls_section(
			'section_subscribe',
			[
				'label' => esc_html__( 'Malina Subscribe', 'malina-elements' ),
			]
		);
		
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Block title', 'malina-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Subscribe',
			]
		);

		$this->end_controls_section();
	}
	protected function render( $instance = [] ) {
		$settings = $this->get_settings();
		$id = rand(0, 9999);
		$out = '';
		$title = isset($settings['title']) ? $settings['title'] : esc_html__('Sign up for updates', 'malina-elements');
		if('POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['malina_submit_subscription']) && empty($_POST['website']) && empty($_POST['message']) ) {
			if( filter_var($_POST['subscriber_email'], FILTER_VALIDATE_EMAIL) ){
				
				$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
				 
				$subject = sprintf(esc_html__('New Subscription on %s','malina-elements'), $blogname);
				 
				$to = get_option('admin_email'); 
				 
				$headers = 'From: '. sprintf(esc_html__('%s Admin', 'malina-elements'), $blogname) .' <no-repy@'.$_SERVER['SERVER_NAME'] .'>' . PHP_EOL;
				 
				$message  = sprintf(esc_html__('Hi ,', 'malina-elements')) . PHP_EOL . PHP_EOL;
				$message .= sprintf(esc_html__('You have a new subscription on your %s website.', 'malina-elements'), $blogname) . PHP_EOL . PHP_EOL;
				$message .= esc_html__('Email Details', 'malina-elements') . PHP_EOL;
				$message .= esc_html__('-----------------') . PHP_EOL;
				$message .= esc_html__('User Name: ', 'malina-elements') . stripslashes($_POST['subscriber_name']) . PHP_EOL;
				$message .= esc_html__('User E-mail: ', 'malina-elements') . stripslashes($_POST['subscriber_email']) . PHP_EOL;
				$message .= esc_html__('Regards,', 'malina-elements') . PHP_EOL . PHP_EOL;
				$message .= sprintf(esc_html__('Your %s Team', 'malina-elements'), $blogname) . PHP_EOL;
				$message .= trailingslashit(get_option('home')) . PHP_EOL . PHP_EOL . PHP_EOL . PHP_EOL;
			
				if (wp_mail($to, $subject, $message, $headers)){
					$out .= '<p class="subscribe-notice success">'.esc_html__('Your e-mail', 'malina-elements').' (' . $_POST['subscriber_email'] . ') '.esc_html__('has been added to our mailing list!', 'malina-elements').'</p>';
					malina_save_subscriber_to_list(stripslashes($_POST['subscriber_email']));
				} else {
					$out .= '<p class="subscribe-notice error">'.esc_html__('There was a problem with your e-mail', 'malina-elements').' (' . $_POST['subscriber_email'] . ') </p>';
				}
			} else {
			   $out .= '<p class="subscribe-notice error">'.esc_html__('There was a problem with your e-mail', 'malina-elements').' (' . $_POST['subscriber_email'] . ') </p>';
			}
		}

		$out .= '<div class="subscribe-block">';
			$out .= '<h3 class="subscribe-block-title">'.$title.'</h3>';					
			$out .= '<form id="newsletter-block-'.esc_attr($id).'" method="POST">';			
				$out .= '<div class="newsletter-form">';
					$out .= '<div class="newsletter-name">';
						$out .= '<input type="text" name="subscriber_name" placeholder="'.esc_attr__('Name', 'malina-elements').'">';
					$out .= '</div>';
					$out .= '<div class="newsletter-email">';
						$out .= '<input type="email" name="subscriber_email" placeholder="'.esc_attr__('Email', 'malina-elements').'">';
						$out .= '<input type="text" id="website" name="website"/>';
					$out .= '</div>';
					$out .= '<div class="newsletter-submit">';
						$out .= '<input type="text" id="message" name="message"/>';
						$out .= '<input type="hidden" name="malina_submit_subscription" value="Submit"><button type="submit" class="button" name="submit_form">'.esc_html__('Sign up', 'malina-elements').'</button>';					
					$out .= '</div>';
				$out .= '</div>';
			$out .= '</form>';
		$out .= '</div>';

		echo $out;
	}
}
?>