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
		$this->AbTest = ClassRegistry::init('AbTest.AbTest');
	}

	function variate($key) {
		$variateKey = $this->Cookie->read('AbTest.' . $key);
		if (!$variateKey) {
			$test = $this->AbTest->load($key);
			$variateKey = $this->AbTest->next($test);
			$this->Cookie->write('AbTest.' . $key, $variateKey, false);
		}

		return $variateKey;
	}

	function conversion($key) {
		$variateKey = $this->Cookie->read('AbTest.' . $key);

		if ($variateKey) {
			$this->AbTest->conversion($key, $variateKey);
		}
	}
}
?>