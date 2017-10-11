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
				<?php echo CHtml::label(CHtml::encode('Member: '.$shareData['username']),'',''); ?><br>
	    		<?php echo CHtml::label(CHtml::encode('Available bal: '.Yii::app()->format->number($shareData['sumsharenet'])),'',''); ?>
         </div>
		 
			<?php 	echo CHtml::activeHiddenField($model,'trans_setting_type',array('value'=>'1')); ?>
			<?php 	echo CHtml::activeHiddenField($model,'transaction_direction',array('value'=>'2')); ?>
			<?php 	echo CHtml::activeHiddenField($model,'related_user_id',array('value'=>$shareData['memberid'])); ?>
			<?php 	echo CHtml::activeHiddenField($model,'trans_type_id',array('value'=>$shareData['setting'])); ?>
			<?php 	echo CHtml::activeHiddenField($model,'type_unit',array('value'=>0)); ?>
			<?php 	//echo CHtml::activeHiddenField($model,'type_subunit',array('value'=>0)); ?>
			<?php 	echo CHtml::activeHiddenField($model,'share_price',array('value'=>$shareData['share_price'])); ?>
		<div class="">
		<?php echo CHtml::label(CHtml::encode('Money transfer method'),'',''); //$form->labelEx($model,'cash_gate'); ?>
		<?php echo $form->dropdownList($model,'cash_gate',array(1=>'Cash', 2=>'Mobile Money', 3=>'Bank/ SACCO'), array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'cash_gate'); ?>
	</div>
	<div class="">
			<?php 
				echo CHtml::label('Number of Shares Member sells','','');//$form->labelEx($model,'amount'); 
			?>
			<?php echo $form->numberField($model,'type_subunit',array('class' => 'form-control')); ?>
			<?php echo $form->error($model,'type_subunit'); ?>
	</div>
	<div class="">
			<?php echo CHtml::label('Amount (Available Bal: '.Yii::app()->format->number($shareData['sumsharenet']).')','',''); ?>
			<?php echo $form->numberField($model,'amount',array('class' => 'form-control','readonly'=>true)); ?>
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
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Withdraw' : 'Save', array('class'=> 'btn btn-primary' )); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
$(document).ready(function(){
$('#TransactionDetail_type_subunit').change(function(){
	var shareno = $('#TransactionDetail_type_subunit').val();
	var shareprice = $('#TransactionDetail_share_price').val();
	var amount = shareno * shareprice;
	$('#TransactionDetail_amount').val(amount);
});
});
</script>