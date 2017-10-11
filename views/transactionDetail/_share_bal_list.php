<?php
/* @var $this TransactionDetailController */
/* @var $model TransactionDetail */
/* @var $form CActiveForm */
?>

<div class="form">
	<div class="">
	 <?php echo CHtml::encode('Member '.$shareData['username'].' has the following balances. Select to withdraw.');?>
	<table class= "table table-hover">
	<thead>
		<td>Share Name</td>
		<td>Available Balance</td>	
	</thead>
	<?php for ($i=0;$i<$shareData['shareoptionno'];$i++){ ?>
	<tr>
		<td><?php  echo CHtml::link(CHtml::encode($shareData[$i]['sharename']),array('//accounting/transactiondetail/contribution','transid'=>1,'trans_dir'=>2,'sguid'=>$space->guid,'member'=>$shareData['guid'],'setting'=>$shareData[$i]['shareid']));?></td>
		<td><?php echo CHtml::link(CHtml::encode(Yii::app()->format->number($shareData[$i]['sumsharenet'])),array('//accounting/transactiondetail/contribution','transid'=>1,'trans_dir'=>2,'sguid'=>$space->guid,'member'=>$shareData['guid'],'setting'=>$shareData[$i]['shareid']));?></td>
	</tr>
	<?php }?>
	</table>
	</div>
</div><!-- form -->