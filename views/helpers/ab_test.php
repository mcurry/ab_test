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

class AbTestHelper extends AppHelper {
	function render($key) {
		$View =& ClassRegistry::getObject('view');
		$variateKey = $View->requestAction(array('plugin' => 'AbTest', 'controller' => 'ab_tests', 'action' => 'view', 'key' => $key));
		return $View->element('ab_tests' . DS . $key . DS . $variateKey);
	}
}
?>