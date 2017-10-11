<?php
/* @var $this TransactionDetailController */
/* @var $model TransactionDetail */
/* @var $form CActiveForm */
/* merry go round deposit*/
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
		<div class="">
				<?php echo $form->labelEx($model,'related_user_id'); ?>

                        <select name="TransactionDetail[related_user_id]" id="TransactionDetail_related_user_id" class="form-control">
                            <?php
							
							foreach ($space->memberships as $membership) : ?>
                                <?php if ($membership->user == null) continue; ?>
                                <option
                                    value="<?php echo $membership->user->id; ?>" <?php if ($space->isSpaceOwner($membership->user->id)): ?> selected <?php endif; ?>><?php echo CHtml::encode($membership->user->displayName); ?></option>
                            <?php endforeach; ?>
                        </select>
						<?php echo $form->error($model,'related_user_id'); ?>
	    
         </div>
		 <?php 	echo CHtml::activeHiddenField($model,'trans_setting_type',array('value'=>'2')); ?>
		 <?php 	echo CHtml::activeHiddenField($model,'type_unit',array('value'=>$mgrIdRoundCycle['cycle'])); ?>
		 <?php 	echo CHtml::activeHiddenField($model,'type_subunit',array('value'=>$mgrIdRoundCycle['round'])); ?>
		 <?php echo CHtml::activeHiddenField($model,'transaction_direction',array('value'=>'1'));?>
		 <?php 	echo CHtml::activeHiddenField($model,'trans_type_id',array('value'=>$mgrsetting)); ?>
		 			
		<div class="">
			<?php echo $form->labelEx($model,'amount'); ?>
			<?php echo $form->numberField($model,'amount',array('class' => 'form-control')); ?>
			<?php echo $form->error($model,'amount'); ?>
		</div>
		<div class="">
			<?php echo CHtml::label(CHtml::encode('Money transfer method'),'',''); //$form->labelEx($model,'cash_gate'); ?>
			<?php echo $form->dropdownList($model,'cash_gate',array(1=>'Cash', 2=>'Mobile Money', 3=>'Bank/ SACCO'), array('class' => 'form-control')); ?>
			<?php echo $form->error($model,'cash_gate'); ?>
		</div>
		<div class="">
			<?php echo  CHtml::label(CHtml::encode('Details (e.g. Notes or Transaction No.)'),'',''); ?>
			<?php echo $form->textArea($model,'Detail',array('rows'=>6, 'cols'=>50,'class' => 'form-control')); ?>
			<?php echo $form->error($model,'Detail'); ?>
		</div>
		
		<br>
		<div class=" buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Deposit to fund' : 'Save', array('class'=> 'btn btn-primary' )); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->