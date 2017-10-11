<?php
/* @var $this TransactionDetailController */
/* @var $model TransactionDetail */
/* @var $form CActiveForm */
?>

<div class="form">
	<div class="">The member <?php echo Chtml::encode($shareData['username']);?> does not have any shares. To deposit for the member, <br><br>
	<?php echo Chtml::link(Chtml::encode('Add new shares here'),array('//accounting/transactiondetail/contribution','sguid'=>$space->guid,'transid'=>1),array('class'=>'btn btn-primary')); ?></div>
</div><!-- form -->