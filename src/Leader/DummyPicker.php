<?php
/**
 * User: nvolgas
 * Date: 10/23/15
 * Time: 8:54 AM
 */

namespace Volnix\AWSTools\Leader;

/**
 * The DummyPicker class is to be used for local development where you don't have more than one instance (or a load balancer for that matter).
 *
 * Class DummyPicker
 * @package Volnix\AWSTools\Leader
 */
class DummyPicker implements PickerInterface {

	/**
	 * @inheritDoc
	 */
	public function amILeader()
	{
		return $this->whoAmI() == $this->whoIsLeader();
	}

	/**
	 * @inheritDoc
	 */
	public function whoIsLeader()
	{
		return $this->whoAmI();
	}

	/**
	 * @inheritDoc
	 */
	public function whoAmI()
	{
		return gethostname();
	}

}