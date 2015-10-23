<?php
/**
 * User: nvolgas
 * Date: 10/23/15
 * Time: 9:58 AM
 */

namespace Volnix\AWSTools\Tests;


use Volnix\AWSTools\Leader\Picker;

class PickerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Picker null
	 */
	private $picker    = null;

	public function setUp()
	{
		$this->picker   = new Picker( [
			'profile'   => 'default',
			'region'    => 'us-east-1',
			'service'   => 'elasticloadbalancing',
			'version'   => '2012-06-01'
		], getenv('TEST_LB_NAME') );
	}

	public function tearDown()
	{
		$this->picker   = null; unset($this->picker);
	}


	public function testWhoIsLeader()
	{
		$this->assertNotEmpty( $this->picker->whoIsLeader() );
		$this->assertInternalType( 'string', $this->picker->whoIsLeader() );
	}
}
