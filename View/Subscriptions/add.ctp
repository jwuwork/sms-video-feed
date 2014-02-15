<h1>Add Subscription</h1>
<?php
echo $this->Form->create('Subscription');
echo $this->Form->input('phone_number');
echo $this->Form->end('Save Subscription');
?>