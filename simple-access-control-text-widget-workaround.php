<?php
/**
 * Plugin Name: Simple Access Control Logggedin Text Widget Workaround
 * Plugin URI: https://core.trac.wordpress.org/ticket/41540
 * Description: Workaround for Simple Access Control plugin not extending Text widget properly.
 * Author: Weston Ruter, XWP
 * Author URI: https://make.xwp.co/
 * Version: 0.1.0
 * License: GPLv2+
 *
 * Copyright (c) 2017 XWP (https://xwp.co/)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */

require_once ABSPATH . '/wp-includes/widgets/class-wp-widget-text.php';

/**
 * Logged In Text widget class
 */
class Logggedin_Widget_Text_Fixed extends WP_Widget_Text {

	/**
	 * Constructor.
	 */
	function __construct() {
		parent::__construct();
		$this->id_base = 'litext';
		$this->name = __( 'Loggedin Text!' );
		$this->option_name = 'widget_' . $this->id_base;

		$this->widget_options['description'] = __( 'Text that shows when the user is logged-in', 'simple-access-control' );
		$this->control_options['id_base'] = $this->id_base;
	}

	/**
	 * Outputs the content for the current Text widget instance, if the user is logged-in.
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Text widget instance.
	 */
	function widget( $args, $instance ) {
		if ( is_user_logged_in() ) {
			parent::widget( $args, $instance );
		}
	}
}

/**
 * Prevent Simple Access Control from registering its faulty widget.
 */
function simple_access_control_workaround_prevent_faulty_widget_registration() {
	remove_action( 'widgets_init', 'sac_load_widgets' );
}
add_action( 'plugins_loaded', 'simple_access_control_workaround_prevent_faulty_widget_registration' );

/**
 * Register the a fixed "Logggedin Text" widget.
 */
function simple_access_control_workaround_register_widget() {
	register_widget( 'Logggedin_Widget_Text_Fixed' );
}
add_action( 'widgets_init', 'simple_access_control_workaround_register_widget' );
