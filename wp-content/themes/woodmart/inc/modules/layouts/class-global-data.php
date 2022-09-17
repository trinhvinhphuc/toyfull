<?php
/**
 * Global data class.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Layouts;

use XTS\Singleton;

/**
 * This class is designed to manipulate global data.
 */
class Global_Data extends Singleton {
	/**
	 * This static property stores an array of global data
	 * that can be written and retrieved using a setter($this->set_data()) and getter ($this->get_data()) of this class.
	 *
	 * @var array
	 */
	private $global_data = array();

	/**
	 * This method is executed immediately after the instance of the class is created.
	 */
	public function init() {
	}

	/**
	 * This method set data to global array.
	 * If key exist return false.
	 *
	 * @param string $prop  key for global data array.
	 * @param string $value value for global data array.
	 */
	public function set_data( $prop, $value = '' ) {
		$this->global_data[ $prop ] = $value;
	}

	/**
	 * This method get data by key.
	 * If data not exist return false.
	 *
	 * @param string $prop key for global data array.
	 *
	 * @return false|mixed
	 */
	public function get_data( $prop ) {
		if ( array_key_exists( $prop, $this->global_data ) ) {
			return $this->global_data[ $prop ];
		}

		return false;
	}
}
