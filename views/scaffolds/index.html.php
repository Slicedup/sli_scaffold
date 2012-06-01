<?php
/**
 * Slicedup: a fancy tag line here
 *
 * @copyright	Copyright 2011, Paul Webster / Slicedup (http://slicedup.org)
 * @license 	http://opensource.org/licenses/bsd-license.php The BSD License
 */
$this->title($t($plural));
?>
<div class="scaffold <?php echo $plural;?> index<?php echo $singular;?>">
	<h2><?php echo $t($plural);?></h2>
	<div class="summary">
		<table>
			<tr>
			<?php foreach ($fields as $field => $name):?>
				<th><?php echo $t($name);?></th>
			<?php endforeach;?>
				<th class="actions"><?php echo $t('Actions');?></th>
			</tr>
		<?php foreach ($recordSet as $record):?>
			<tr>
				<?php foreach ($fields as $field => $name):?>
				<td><?php echo $h($record->{$field});?></td>
				<?php endforeach;?>
				<td class="actions">
					<?php
						$_actions = array('view', 'edit', 'delete');
						$_links = array();
						foreach ($_actions as $action):
							if(in_array($action, $actions)):
								$_links[] = $this->html->link($t(ucfirst($action)), array('action' => $action, 'args' => $record->key()));
							endif;
						endforeach;
						echo join('&nbsp;|&nbsp;', $_links);
					?>
				</td>
			</tr>
		<?php endforeach;?>
		</table>
	</div>
	<ul class="actions">
		<?php if(in_array('add', $actions)):?>
		<li><?php echo $this->html->link($t('{:action} {:entity}', array('action' => $t('Add'), 'entity' => $t($singular))), array('action' => 'add'));?></li>
		<?php endif;?>
	</ul>
</div>