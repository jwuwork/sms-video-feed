<h1>Subscriptions</h1>
<?php echo $this->Html->link('Add Subscription', array('controller' => 'subscriptions', 'action' => 'add')); ?>
<table>
	<tr>
		<th>Id</th>
		<th>Phone Number</th>
		<th>Action</th>
	</tr>

<!-- Here’s where we loop through our $subscriptions array, printing out subscription info -->

	<?php foreach ($subscriptions as $subscription): ?>
	<tr>
		<td><?php echo $subscription['Subscription']['id']; ?></td>
		<td><?php echo $subscription['Subscription']['phone_number']; ?></td>
		<td>
			<?php
				echo $this->Form->postLink(
					'Delete',
					array('action' => 'delete', $subscription['Subscription']['id']),
					array('confirm' => 'Are you sure?')
				);
			?>
			<?php
				echo $this->Html->link(
					'Edit',
					array('action' => 'edit', $subscription['Subscription']['id'])
				);
			?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>