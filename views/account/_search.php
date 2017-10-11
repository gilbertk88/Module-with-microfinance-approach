<?php
/* @var $this AccountController */
/* @var $model Account */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>32,'maxlength'=>32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'parent_id'); ?>
		<?php echo $form->textField($model,'parent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Type'); ?>
		<?php echo $form->textField($model,'Type',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'space_individualtype'); ?>
		<?php echo $form->textField($model,'space_individualtype'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'system_user'); ?>
		<?php echo $form->textField($model,'system_user'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'space_id'); ?>
		<?php echo $form->textField($model,'space_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'related_user_id'); ?>
		<?php echo $form->textField($model,'related_user_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->