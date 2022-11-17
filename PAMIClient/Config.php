<?php

namespace PAMIClient;

use Exception;

class Config
{
    /**
     * All options config
     * 
     * @var array $config
     */

    private $config;

    public function __construct($nameConfig = 'asterisk') {
        $config = require(__DIR__.'/../config/' . $nameConfig . '.php');
		$this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setConfig($params, $value)
    {
        if(!is_array($this->config)) throw new Exception("Incorrect is config");
        $this->config[$params] = $value;
    }
}
