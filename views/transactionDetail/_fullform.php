<?php
/* @var $this TransactionDetailController */
/* @var $model TransactionDetail */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transaction-detail-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="">
		<?php echo $form->labelEx($model,'transaction_id'); ?>
		<?php echo $form->textField($model,'transaction_id',array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'transaction_id'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'account_id'); ?>
		<?php echo $form->textField($model,'account_id',array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'account_id'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownlist($model,'type',array('1'=>'Debit','2'=>'credit',),array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'amount'); ?>
		<?php echo $form->textField($model,'amount', array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'amount'); ?>
	</div>
	<br>
	<div class=" buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class' => 'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->