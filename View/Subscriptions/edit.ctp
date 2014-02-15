<h1>Edit Subscription</h1>
<?php
echo $this->Form->create('Subscription');
echo $this->Form->input('phone_number');
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Save Subscription');
?>