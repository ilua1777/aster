<?php

namespace PAMIClient;

use PAMI\Client\Impl\ClientImpl;

class CallAMI {

	private $config;

	public function __construct() {
        $this->config = new Config();
    }

	/**
	 * Create new ClientImpl 
	 *
	 * @return ClientImpl
	 */
	public function NewPAMIClient()
    {
		$impl = new ClientImpl($this->config->getConfig());
		return $impl;
	}

	/**
	 * Close PAMI client connection
	 *
	 * @param ClientImpl $pamiClient
	 *
	 * @return mixed
	 */
	public function ClosePAMIClient($pamiClient)
    {
	    return $pamiClient->close();
	}
}