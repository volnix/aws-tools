<?php
/**
 * User: nvolgas
 * Date: 10/22/15
 * Time: 4:32 PM
 */

namespace Volnix\AWSTools\Leader;


use Aws\ElasticLoadBalancing\ElasticLoadBalancingClient;
use GuzzleHttp\Client;

/**
 * The Picker class is used for determining if a certain instance is a leader or not.
 *
 * Class Picker
 * @package Volnix\AWSTools\Leader
 */
class Picker extends ElasticLoadBalancingClient implements PickerInterface {

	private $load_balancer_name = '';

	/**
	 * Picker constructor.
	 *
	 * @inheritdoc
	 */
	public function __construct(array $args, $load_balancer_name = '')
	{
		parent::__construct($args);

		// if we specified a load balancer name go ahead and set it
		if ( ! empty($load_balancer_name) ) {
			$this->setLoadBalancerName($load_balancer_name);
		}
	}

	/**
	 * @return string
	 */
	public function getLoadBalancerName()
	{
		return $this->load_balancer_name;
	}

	/**
	 * @param string $load_balancer_name
	 */
	public function setLoadBalancerName($load_balancer_name)
	{
		$this->load_balancer_name   = $load_balancer_name;
	}


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
		$instances  = $this->getInstancesForLoadBalancer();

		// sort the instances
		sort($instances);

		// grab the first instance in the list
		return trim($instances[0]);
	}

	/**
	 * @inheritDoc
	 */
	public function whoAmI()
	{
		$instance_id    = ( new Client )->get('http://169.254.169.254/latest/meta-data/instance-id')->getBody()->getContents();
		return trim($instance_id);
	}

	/**
	 * Get all the instance ID's under the load balancer defined.
	 *
	 * @return array
	 */
	private function getInstancesForLoadBalancer()
	{
		$instances  = [];

		// make sure we've specified a load balancer to query against
		$this->validateLoadBalancerName();

		// get all the instance ID's
		$load_balancer_data = $this->describeLoadBalancers( [
			'LoadBalancerNames' => [ $this->load_balancer_name ]
		] );

		if ( ! $load_balancer_data->hasKey('LoadBalancerDescriptions') ) {
			throw new \RuntimeException('No load balancer descriptions found.');
		}

		$instance_blocks    = $load_balancer_data->get('LoadBalancerDescriptions')[0]['Instances'];

		foreach ($instance_blocks as $block) {
			$instances[]    = $block['InstanceId'];
		}

		return $instances;
	}


	/**
	 * Make sure we've defined a load balancer name to query against.
	 *
	 * @throws \RuntimeException
	 */
	private function validateLoadBalancerName()
	{
		if ( empty($this->load_balancer_name) ) {
			throw new \RuntimeException('Load balancer must be defined.');
		}
	}
}