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

	<div class="row">
		<?php echo $form->labelEx($model,'transaction_id'); ?>
		<?php echo $form->textField($model,'transaction_id'); ?>
		<?php echo $form->error($model,'transaction_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'account_id'); ?>
		<?php echo $form->textField($model,'account_id'); ?>
		<?php echo $form->error($model,'account_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownlist($model,'type',array('1'=>'Debit','2'=>'credit')); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'amount'); ?>
		<?php echo $form->textField($model,'amount'); ?>
		<?php echo $form->error($model,'amount'); ?>
	</div>
<div class="">
				<?php // echo CHtml::label(CHtml::encode('Select Merry Go Round Fund(from transaction setting)'),'',''); ?>

                        <select name="TransactionDetail[trans_type_id]" id="TransactionDetail_trans_type_id" class="form-control">
                            <?php
							foreach ($transsetting as $contrsetting) : ?>
                                <?php if ($contrsetting->name == null) continue; ?>
                                <option value="<?php echo CHtml::encode($contrsetting->id); ?>" ><?php echo CHtml::encode($contrsetting->name); ?></option>
                            <?php endforeach; ?>
                        </select>
						<?php echo $form->error($model,'trans_type_id'); ?>
        </div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->