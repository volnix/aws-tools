<?php
/**
 * User: nvolgas
 * Date: 10/23/15
 * Time: 8:52 AM
 */

namespace Volnix\AWSTools\Leader;


interface PickerInterface {

	/**
	 * Returns true/false of whether or not the current instance is the leader.
	 *
	 * @return bool
	 */
	public function amILeader();

	/**
	 * Returns the instance ID of the instance that is currently the leader.
	 *
	 * @return string
	 */
	public function whoIsLeader();

	/**
	 * Returns the instance ID of your instance.
	 *
	 * @return string
	 */
	public function whoAmI();

}