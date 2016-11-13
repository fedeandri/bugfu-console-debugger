<?php

/*
 *	Plugin Name: BugFu Console Debugger
 *	Plugin URI: https://github.com/fedeandri/bugfu-console-debugger
 *	Description: BugFu lets you log from PHP directly to your Browser JavaScript Console - Meant as an aid to those practicing the ancient art of debugging
 *	Version: 1.2.3
 *	Author: Federico Andrioli
 *	Author URI: https://it.linkedin.com/in/fedeandri
 *	GPLv2 or later
 *
*/


defined( 'ABSPATH' ) or die();


if ( !class_exists( 'BugFu' ) ) {
	class BugFu
	{

		const PLUGIN_VERSION = '1.2.3';
		const PLUGIN_PREFIX = 'bugfu';
		const PLUGIN_SHORT_NAME = 'BugFu';
		const PLUGIN_NAME = 'BugFu Console Debugger';
		const PLUGIN_SLUG = 'bugfu-console-debugger';
		
		const OPTION_NAME_VERSION = self::PLUGIN_PREFIX.'_plugin_version';
		const OPTION_NAME_LOG = self::PLUGIN_PREFIX.'_debug_log';
		const OPTION_NAME_STATUS = self::PLUGIN_PREFIX.'_debug_status';
		
		const LOG_HEADER = '#### BugFu Console Debugger ####';
		const LOG_HEADER_BAR = '################################';

		public function __construct() {

			add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_custom_files') );
			
			add_action( 'admin_menu', array( &$this, 'menu_init' ) );
			add_action( 'admin_init', array( &$this, 'register_db_settings' ) );

			$this->plugin_update();
			$this->debugger_init();
			$this->read_input();
		}

		public function menu_init() {

			add_management_page(
				self::PLUGIN_SHORT_NAME,
				self::PLUGIN_SHORT_NAME,
				'manage_options',
				self::PLUGIN_SLUG,
				array( &$this, 'add_settings_page' )
				);

		}

		public function add_settings_page() {

			if( !current_user_can('manage_options') ){

				wp_die('You do not have sufficient permissions to access this page.');
			}

			require('views/settings-page.php');

		}

		public function add_toolbar_link( $wp_admin_bar ) {
			
			$args = array(
				'id'    => self::PLUGIN_SLUG,
				'title' => self::PLUGIN_SHORT_NAME.' ON',
				'href'  => network_admin_url( 'tools.php?page='.self::PLUGIN_SLUG ),
				'meta'  => array( 'class' => self::PLUGIN_SLUG )
			);
			
			$wp_admin_bar->add_node( $args );
		}

		public function register_db_settings() {
			register_setting( self::PLUGIN_SLUG.'-group', self::OPTION_NAME_VERSION );
			register_setting( self::PLUGIN_SLUG.'-group', self::OPTION_NAME_LOG );
			register_setting( self::PLUGIN_SLUG.'-group', self::OPTION_NAME_STATUS );
		}

		public function enqueue_custom_files( $hook ) {

			wp_register_style( self::PLUGIN_SLUG.'-css', plugin_dir_url( __FILE__ ) . 'css/'.self::PLUGIN_SLUG.'.css', false, '1.0.0' );
			wp_enqueue_style( self::PLUGIN_SLUG.'-css', plugin_dir_url( __FILE__ ) . 'css/'.self::PLUGIN_SLUG.'.css', false, '1.0.0' );
			
		}

		public function enqueue_debugger_custom_files( $hook ) {

	        wp_enqueue_script( self::PLUGIN_SLUG.'-js', plugin_dir_url( __FILE__ ) . 'js/ajax-'.self::PLUGIN_SLUG.'.js', array( 'jquery' ), '1.0.0', true );
			wp_localize_script( self::PLUGIN_SLUG.'-js', str_replace('-','_',self::PLUGIN_SLUG).'_ajax_params', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' )
			));
			
		}

		public function bugfu_ajax_read_debug_log() {

			$response = array();

			$header = self::get_bugfu_header();
			$log = self::read_debug_log();
			
			if( $log != '' ) {
				update_option( self::OPTION_NAME_LOG, '' );
			}

			$response['header'] = $header;
			$response['log'] = $log;

			wp_send_json_success( $response );

			exit();
		}

		public static function get_bugfu_header() {
			$header = self::LOG_HEADER_BAR."\n".self::LOG_HEADER."\n".self::LOG_HEADER_BAR;
			return $header;
		}

		public static function log( $debug_mixed = '', $backtrace_on = true ) {

			$bugfu_status = get_option(self::OPTION_NAME_STATUS);

			if( $bugfu_status == '1' ) {
				
				if ( gettype( $debug_mixed ) != 'string' ) {
					$debug_mixed = var_export( $debug_mixed, true );
				}

				$debug_content = "\n\n";

				if ( $backtrace_on ) {

					$debug_backtrace = debug_backtrace();

					$debug_content .= 'FILE : '.$debug_backtrace[0]['file']."\n";
					if ( isset( $debug_backtrace[1]['class'] ) )
						$debug_content .= 'CLASS: '.$debug_backtrace[1]['class']."\n";
					if ( isset( $debug_backtrace[1]['function'] ) )
						$debug_content .= 'FUNC : '.$debug_backtrace[1]['function']."\n";
					$debug_content .= 'LINE : '.$debug_backtrace[0]['line']."\n";
					$debug_content .= "\n";

				}


				if( isset($debug_mixed) && $debug_mixed != '' ) {
					$debug_content .= $debug_mixed."\n";
				}
				
				$debug_content .= "\n".self::LOG_HEADER_BAR;

				self::write_debug_log( self::read_debug_log().$debug_content );

			}

		}

		private static function read_debug_log() {

			$debug_log = trim( unserialize( get_option( self::OPTION_NAME_LOG ) ) );

			return $debug_log;
		}

		private static function write_debug_log( $debug_log_content ) {

			update_option( self::OPTION_NAME_LOG, serialize( $debug_log_content ) );

		}
		
		private function debugger_init() {

			$bugfu_status = get_option(self::OPTION_NAME_STATUS);

			if( $bugfu_status == '1' ) {
				$this->debugger_start();
			} else {
				$this->debugger_stop();
			}

		}

		private function debugger_start() {

			add_action( 'wp_ajax_'.self::PLUGIN_PREFIX.'_ajax_read_debug_log',  array( &$this, self::PLUGIN_PREFIX.'_ajax_read_debug_log') );			
			add_action( 'wp_ajax_nopriv_'.self::PLUGIN_PREFIX.'_ajax_read_debug_log',  array( &$this, self::PLUGIN_PREFIX.'_ajax_read_debug_log') );			

			add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_custom_files') );
			add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_debugger_custom_files') );
			add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_debugger_custom_files') );

			add_action( 'admin_bar_menu', array( &$this, 'add_toolbar_link' ), 999 );

		}		

		private function debugger_stop() {

			remove_action( 'wp_ajax_'.self::PLUGIN_PREFIX.'_ajax_read_debug_log',  array( &$this, self::PLUGIN_PREFIX.'_ajax_read_debug_log')  );
			remove_action( 'wp_ajax_nopriv_'.self::PLUGIN_PREFIX.'_ajax_read_debug_log',  array( &$this, self::PLUGIN_PREFIX.'_ajax_read_debug_log')  );

			remove_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_custom_files') );
			remove_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_debugger_custom_files') );
			remove_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_debugger_custom_files') );

			remove_action( 'admin_bar_menu', array( &$this, 'add_toolbar_link' ), 999 );

		}		

		private function read_input() {

	        if( isset( $_REQUEST[self::OPTION_NAME_STATUS] ) && $_REQUEST[self::OPTION_NAME_STATUS] != '' ) {

	        	$new_bugfu_status = '0';

	        	if( $_REQUEST[self::OPTION_NAME_STATUS] == '0' ) {
	        		$new_bugfu_status = '1';
	        	}

		        update_option( self::OPTION_NAME_STATUS, $new_bugfu_status );

		        $this->debugger_init();
	        }

		}

		private function plugin_update() {

			if ( get_option( self::OPTION_NAME_VERSION ) != self::PLUGIN_VERSION ) {
				update_option( self::OPTION_NAME_VERSION, self::PLUGIN_VERSION );
			}

			if ( get_option( self::OPTION_NAME_STATUS ) === false ) {
				update_option( self::OPTION_NAME_STATUS, '1' );
			}

			if ( get_option( self::OPTION_NAME_LOG ) === false ) {
				update_option( self::OPTION_NAME_LOG, '' );
			}

		}

	}

	new BugFu;
}
