<?php
	$tests = ClassRegistry::init('AbTest')->find('list', array('fields' => array('id', 'key'),
																														 'order' => 'created DESC'));
?>


<?php echo $form->create('AbTest', array('id' => 'AbTestForm')); ?>
<h1>
  <?php __('A/B Tests'); ?>
  <?php echo $form->input('id', array('type' => 'select', 'div' => false, 'label' => false,
                                               'options' => $tests));
  ?>
</h1>
<?php echo $form->end(); ?>

<div id="ab-test-table">
  <p><?php echo $html->image('/status/img/ajax-loader.gif') ?></p>
</div>

<script type="text/javascript">
  $(function(){
    $("#AbTestId").change(function() {
      $("#ab-test-table").html("<p><img src=\"/status/img/ajax-loader.gif\" \></p>");
      $.get("/ab_test/ab_tests/stats/" + $(this).val(), function(data) {
        $("#ab-test-table").html(data);
      });
    }).change();
  });
</script>
