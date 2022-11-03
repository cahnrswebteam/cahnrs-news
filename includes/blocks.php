<?php 
namespace WSUWP\Plugin\Gutenberg;

require_once( ABSPATH . 'wp-content\plugins\wsuwp-plugin-gutenberg\includes\plugin.php');

class Register_Block_Video_List extends Blocks {
    protected static $register_blocks = array(
		'cahnrs/video-list'   		=> 'Block_WSUWP_Video_List',
		'cahnrs/archive-search'   	=> 'Block_WSUWP_Search_Archive',
	);

	public static function cahnrs_allowed_blocks(){
		return $allowed_blocks[] = 'cahnrs/video-list';
	}
	
    public static function get( $property ) {

		switch ( $property ) {

			case 'register_blocks':
				return self::$register_blocks;

			default:
				return '';
		}

	}

	public static function init() {		

		add_filter( 'allowed_block_types', array( __CLASS__, 'cahnrs_allowed_blocks'), 11 );

		add_action( 'init', array( __CLASS__, 'register' ) );

	}


	public static function register() {

		// Get blocks to register
		$blocks = self::$register_blocks;

		// Get the block directory
		$block_dir = Plugin::get( 'dir' ) . 'blocks/';

		foreach ( $blocks as $block => $class ) {

			// folder name should be the block name with the / replaced with - (i.e. wsuwp/name -> wsupw-name)
			$block_folder = str_replace( '/', '-', $block );

			$block_class = __NAMESPACE__ . '\\' . $class;

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'blocks/cahnrs-video-list/block.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'blocks/cahnrs-archive-search/block.php';

			// Call get('register_block') to check if the block should be registered, default is true in class-block.php
			if ( call_user_func( array( $block_class, 'get' ), 'register_block' ) ) {

				register_block_type(
					$block,
					array(
						'api_version'     => 2,
						'render_callback' => array( $block_class, 'render_block' ),
						'editor_script'   => 'wsuwp-theme-wds-2-blocks',
					)
				);
			}
		}
	}
}

Register_Block_Video_List::init();