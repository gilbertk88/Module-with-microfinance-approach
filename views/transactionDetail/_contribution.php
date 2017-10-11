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
			<?php 	
			echo CHtml::activeHiddenField($model,'trans_setting_type',array('value'=>'1'));
			echo CHtml::activeHiddenField($model,'trans_type_id',array('value'=>'1'));
			?>
		<div>
			<?php echo CHtml::label(CHtml::encode('Contribution Type'),'','');?>
			<?php echo  $form->dropdownList($model,'transaction_direction', array(1=>'Depositing', 2=>'Withdrawing'), array('class'=>'form-control')); ?>
			
		 </div>
		<div class="">
				<?php echo CHtml::label(CHtml::encode('Select Contribution'),'',''); ?>

                        <select name="TransactionDetail[trans_type_id]" id="TransactionDetail_trans_type_id" class="form-control">
                            <?php
							foreach ($transsetting as $contrsetting) : ?>
                                <?php if ($contrsetting->name == null) continue; ?>
                                <option value="<?php echo CHtml::encode($contrsetting->id); ?>" ><?php echo CHtml::encode($contrsetting->name); ?></option>
                            <?php endforeach; ?>
                        </select>
						<?php echo $form->error($model,'trans_type_id'); ?>
        </div>
		<div class="">
		<?php echo CHtml::label(CHtml::encode('Money transfer method'),'',''); //$form->labelEx($model,'cash_gate'); ?>
		<?php echo $form->dropdownList($model,'cash_gate',array(1=>'Cash', 2=>'Mobile Money', 3=>'Bank/ SACCO'), array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'cash_gate'); ?>
	</div>
	<div class="">
				<?php echo $form->labelEx($cashrecipient,'cash_recipient'); ?>

                        <select name="Cash[cash_recipient]" id="Cash_cash_recipient" class="form-control">
                            <?php
							
							foreach ($space->memberships as $membership) : ?>
                                <?php if ($membership->user == null) continue; ?>
                                <option
                                    value="<?php echo $membership->user->id; ?>" <?php if ($space->isSpaceOwner($membership->user->id)): ?> selected <?php endif; ?>><?php echo CHtml::encode($membership->user->displayName); ?></option>
                            <?php endforeach; ?>
                        </select>
						<?php echo $form->error($cashrecipient,'cash_recipient'); ?>
	    
         </div>
		<div class="">
			<?php echo $form->labelEx($model,'amount'); ?>
			<?php echo $form->numberField($model,'amount',array('class' => 'form-control')); ?>
			<?php echo $form->error($model,'amount'); ?>
		</div>
		<div class="">
			<?php echo  CHtml::label(CHtml::encode('Details '),'','');
						echo CHtml::encode(' (e.g. Notes or Transaction No.)'); //$form->labelEx($transaction,'Detail'); ?>
			<?php echo $form->textArea($model,'Detail',array('rows'=>6, 'cols'=>50,'class' => 'form-control')); ?>
			<?php echo $form->error($model,'Detail'); ?>
		</div>
		
		<br>
		<div class=" buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=> 'btn btn-primary' )); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->