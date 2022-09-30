<?php namespace CAHNRS\Plugin\News;

class Functions_CAHNRS_News {

	public static $version = '2.2.8';

	public function __construct() {

		$this->init_theme_functions();

        add_image_size( 'video-thumb', 300, 200, true ); // Hard Crop Mode

	} // end __construct

    


	protected function init_theme_functions() {

		$this->add_post_types();

		$this->add_taxonomies();


	} // end init_theme_functions


	protected function add_post_types() {

		require_once __DIR__ . '/../lib/classes/post-types/class-post-type-cahnrs.php';

		require_once __DIR__ . '/../lib/classes/post-types/articles/class-articles-post-type-cahnrs.php';

		require_once __DIR__ . '/../lib/classes/post-types/podcasts/class-podcasts-post-type.php';

		require_once __DIR__ . '/../lib/classes/post-types/videos/class-video-post-type.php';


	} // End add_post_types

	protected function add_taxonomies() {

		require_once __DIR__ . '/../lib/taxonomies/podcasts/class-podcast-category.php';
		require_once __DIR__ . '/../lib/taxonomies/videos/class-videos-category.php';

	} // End add_taxonomies

} // end Functions_CAHNRS_News

$cahnrs_news_theme = new Functions_CAHNRS_News();