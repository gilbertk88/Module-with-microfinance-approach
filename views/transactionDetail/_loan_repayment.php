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

	<?php 
		echo $form->errorSummary($model);
	?>

	<div class="">
		<div class="">
		<?php //@todo review issue when content of database is not reflected on the database ?>
				<?php  echo CHtml::label(CHtml::encode('Member Name: '),'',''); ?>                        
				<?php echo CHtml::encode($loanData['username'],'',array('class'=>'form-control')); ?>
	    
         </div>
		 <?php 	echo CHtml::activeHiddenField($model,'trans_setting_type',array('value'=>'3')); ?>
		 <?php 	echo CHtml::activeHiddenField($model,'related_user_id',array('value'=>$loanData['userid'])); ?>
		 <?php 	echo CHtml::activeHiddenField($model,'transaction_direction',array('value'=>'2')); ?>
		 <?php 	echo CHtml::activeHiddenField($model,'trans_type_id',array('value'=>3)); ?>
		 <?php 	echo CHtml::activeHiddenField($model,'type_unit',array('value'=>$loanData['activeloans']['type_unit'])); ?>
		 <?php  echo CHtml::activeHiddenField($model,'type_subunit',array('value'=>4)); ?>	
		
		<div class="">
				<?php echo CHtml::label(CHtml::encode('Loan Name: '),'',''); ?>
                <?php echo CHtml::encode($loanData['activeloans']['loanname'],'',array('class'=>'form-control')); ?>
        </div>
		<div class="">
		<?php echo CHtml::label(CHtml::encode('Money transfer method'),'','');?>
		<?php echo $form->dropdownList($model,'cash_gate',array(1=>'Cash', 2=>'Mobile Money', 3=>'Bank/ SACCO'), array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'cash_gate'); ?>
	</div>
	<div class="">
			<?php echo CHtml::label(CHtml::encode('Amount, Outstanding Bal: '.$loanData['activeloans']['totalDebt']),'',''); ?> 
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
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Pay' : 'Save', array('class'=> 'btn btn-primary' )); ?>
	</div>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->