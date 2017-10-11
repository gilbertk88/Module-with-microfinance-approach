<?php
/* @var $this TransactionDetailController */
/* @var $model TransactionDetail */
/* @var $form CActiveForm */
?>

<div class="form">

	<p class="">Member <?php echo $loanData['username']; ?> does not have an active loan, issue a new loan here</p>
	<?php echo CHtml::link('Issue loan',array('//accounting/transactiondetail/contribution','sguid'=>$space->guid,'transid'=>3,'trans_dir'=>1),array('class'=>'btn btn-primary'));?>

</div><!-- form -->