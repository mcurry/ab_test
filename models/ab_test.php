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

class AbTest extends AppModel {
  var $name = 'AbTest';

  var $hasMany = array('AbTest.AbTestVariate');
  var $actsAs = array('Containable');

  function load($key) {
    $variates = Configure::read('AbTest.' . $key);
		if(isset($variates['variates'])) {
			$variates = $variates['variates'];
		}

    $found = $this->find('first', array('conditions' => array('AbTest.key' => $key)));
    if (!$found) {
      $this->save(array('key' => $key));
    } else {
      $this->id = $found['AbTest']['id'];
    }

    $this->AbTestVariate->init($this->id, $variates);

    $this->contain('AbTestVariate');
    return $this->find('first', array('conditions' => array('AbTest.key' => $key)));
  }

  function next($test) {
    $min = false;

    foreach($test['AbTestVariate'] as $variate) {
			if($variate['key'] == 'other/unknown') {
				continue;
			}
			
      if ($min === false || $variate['views'] < $min['views']) {
        $min = $variate;
      }
    }

    if ($min !== false) {
      $this->AbTestVariate->incrementView($min['id']);
      return $min['key'];
    } else {
      return false;
    }
  }

  function conversion($key, $variateKey) {
		$this->contain('AbTestVariate');
    $found = $this->find('first', array('conditions' => array('AbTest.key' => $key)));
    $variateId = array_pop(Set::extract('/AbTestVariate[key=' . $variateKey . ']/id', $found));
    $this->AbTestVariate->incrementConversion($variateId);
  }
}
?>