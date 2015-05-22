<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Supporter_Object {
	public $skype_id;
	public $yahoo_id;
	public $tel_number;
	public $tel_number_formatted;
	public $columns;

	public function __construct () {
		$this->name = '';
		$this->skype_id = '';
		$this->yahoo_id = '';
		$this->tel_number = '';
		$this->tel_number_formatted = '';
		$this->columns = 0;
	}

	public static function getAll() {
		global $wpdb;
		$arraySupporters = array();

		$querystr = "
			SELECT $wpdb->posts.ID,
			$wpdb->posts.post_title

			FROM $wpdb->posts
			
			WHERE $wpdb->posts.post_status = 'publish' 
			AND $wpdb->posts.post_type = 'supporter'
			AND $wpdb->posts.post_date < NOW()
			ORDER BY $wpdb->posts.post_date ASC
		";

		$supporters = $wpdb->get_results($querystr, OBJECT);

		foreach ($supporters as $key => $value) {
			$query = "
			SELECT $wpdb->postmeta.meta_key, $wpdb->postmeta.meta_value

			FROM $wpdb->postmeta

			WHERE $wpdb->postmeta.post_id = " . $supporters[$key]->ID . "
			";

			$supporters[$key]->meta_info = $wpdb->get_results($query, OBJECT);

			$sp = new Supporter_Object();
			$sp->name = $supporters[$key]->post_title;
			
			foreach ($supporters[$key]->meta_info as $meta) {

				$key = $meta->meta_key;
				$value = $meta->meta_value;
				if(!is_null($value) && strlen($value) > 0) {
					if($key == 'skype_id') {
						$sp->skype_id = $value;
						$sp->columns += 1;
					}
					else if($key == 'yahoo_id') {
						$sp->yahoo_id = $value;
						$sp->columns += 1;
					}
					else if($key == 'tel_number') {
						$sp->tel_number = $value;
						$sp->tel_number_formatted = preg_replace('/[^0-9]/', "", $value);
						$sp->columns += 1;
					}
				}
			}

			array_push($arraySupporters, $sp);

		}

		return $arraySupporters;
	}
}

?>