<?php
/* @var $this AccountController */
/* @var $data Account */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parent_id')); ?>:</b>
	<?php echo CHtml::encode($data->parent_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Type')); ?>:</b>
	<?php echo CHtml::encode($data->Type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('space_individualtype')); ?>:</b>
	<?php echo CHtml::encode($data->space_individualtype); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('system_user')); ?>:</b>
	<?php echo CHtml::encode($data->system_user); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('space_id')); ?>:</b>
	<?php echo CHtml::encode($data->space_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('related_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->related_user_id); ?>
	<br />

	*/ ?>

</div>