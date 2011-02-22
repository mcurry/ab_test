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

class AbTestsController extends AppController {
	var $name = 'AbTests';
	var $uses = null;
	var $components = array('AbTest.AbTest', 'Cookie');

  function beforeFilter() {
    $this->Auth->allow('view');
		
		$cookieName = Configure::read('Cookie.name');
		if($cookieName) {
			$this->Cookie->name = $cookieName;
		}
		
    parent::beforeFilter();
  }
	
	function view($key=null) {
		if(empty($this->params['key'])) {
			die;
		}
		
		return $this->AbTest->variate($this->params['key']);
	}
	
	function stats($id) {
		if (!Configure::read('Status.allow')) {
			die;
		}
		
		$AbTest = ClassRegistry::init('AbTest.AbTest');
		$AbTest->contain('AbTestVariate');
		$data = $AbTest->find('first', array('conditions' => array('AbTest.id' => $id)));
		$this->set('data', $data);
	}
}
?>