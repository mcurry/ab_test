<?php
/*
 * CakePHP A/B Test Plugin
 * Copyright (c) 2009 Matt Curry
 * www.PseudoCoder.com
 * http://github.com/mcurry/ab_test
 *
 * @author      Matt Curry <matt@pseudocoder.com>
 * @license     MIT
 *
 */

class AbTestComponent extends Object {
	var $controller = null;
	var $components = array('Cookie');
	var $AbTest = null;

	function initialize(&$controller, $settings=array()) {
		$this->controller = $controller;
		$this->controller->helpers[] = 'AbTest.AbTest';
	}

	function variate($key) {
		$variateKey = $this->Cookie->read('AbTest.' . $key);
		if($variateKey) {
			return $variateKey;
		}
		
		$test = Configure::read('AbTest.' . $key);
		if(empty($test['variates'])) {
			$test = array('options' => array(),
										'variates' => $test);
		}
		$test['options'] = array_merge(array('new' => true, 'returning' => true), $test['options']);
		
		if ($this->__checkInclude($test)) {
			$this->AbTest = ClassRegistry::init('AbTest.AbTest');
			$test = $this->AbTest->load($key);
			$variateKey = $this->AbTest->next($test);
			$this->Cookie->write('AbTest.' . $key, $variateKey, false, '2 weeks');
			return $variateKey;
		} else {
			$test = Configure::read('AbTest.' . $key);
			$default = $test['variates'][0];
			$this->Cookie->write('AbTest.' . $key, $default, false, '2 weeks');
			return $default;
		}

	}

	function conversion($key) {
		if(!is_array($key)) {
			$key = array($key);
		}
		
		$this->AbTest = ClassRegistry::init('AbTest.AbTest');
		foreach($key as $k) {
			$variateKey = $this->Cookie->read('AbTest.' . $k);
	
			if (!$variateKey) {
				$variateKey = 'other/unknown';
			}
			
			$this->AbTest->conversion($k, $variateKey);
		}
	}
	
	function __checkInclude($test) {
		$new = empty($_COOKIE['__utma']);
			
		if($new && !$test['options']['new']) {
			return false;
		} else if (!$new && !$test['options']['returning']) {
			return false;
		}
		
		return true;
	}
}
?>