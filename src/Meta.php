<?php
/**
 * User: nvolgas
 * Date: 10/23/15
 * Time: 7:54 AM
 */

namespace AWSTools;


class Meta {

	const VERSION   = '1.0.0';

	/**
	 * Get the current version of the AWS tools package.
	 *
	 * @return string
	 */
	public final static function getVersion()
	{
		return self::VERSION;
	}

}