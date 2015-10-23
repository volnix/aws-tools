<?php
/**
 * User: nvolgas
 * Date: 10/23/15
 * Time: 11:00 AM
 */

namespace Volnix\AWSTools\Tests;


use Volnix\AWSTools\Leader\DummyPicker;

class DummyPickerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var DummyPicker null
	 */
	private $picker    = null;

	public function setUp()
	{
		$this->picker   = new DummyPicker;
	}

	public function tearDown()
	{
		$this->picker   = null; unset($this->picker);
	}

	public function testWhoAmI()
	{
		$this->assertEquals( gethostname(), $this->picker->whoAmI() );
	}


	public function testWhoIsLeader()
	{
		$this->assertEquals( gethostname(), $this->picker->whoIsLeader() );
	}

	public function testAmILeader()
	{
		$this->assertTrue( $this->picker->amILeader() );
	}

}
