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

class AbTestVariate extends AppModel {
  var $name = 'AbTestVariate';

  var $belongsTo = array('AbTest.AbTest');
  var $actsAs = array('Containable');

  function init($ab_test_id, $variates) {
    $existing = $this->find('all', array('fields' => array('AbTestVariate.key'),
                                         'conditions' => array('ab_test_id' => $ab_test_id)));

    $existing = Set::extract('/AbTestVariate/key', $existing);
    $diff = array_diff($variates, $existing);

    foreach($diff as $variate) {
      $this->create();
      $this->save(array('ab_test_id' => $ab_test_id,
                        'key' => $variate));
    }
  }

  function incrementView($id) {
    $this->query(sprintf('UPDATE %s SET views = views + 1 WHERE id = %d', $this->useTable, $id));
  }

  function incrementConversion($id) {
    $this->query(sprintf('UPDATE %s SET conversions = conversions + 1 WHERE id = %d', $this->useTable, $id));
  }
}
?>