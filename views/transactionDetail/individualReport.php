<div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-body">
				<div class="fc-content text-left">
<div class="text-right">
<?php	
echo CHtml::link(CHtml::htmlButton('All Transactions',array('class'=>'pull-right btn btn-primary')),array('//accounting/transactiondetail/index','sguid'=>$space->guid));
?>
</div >
<center class="reporthead" ><h1><b>
<?php 
echo CHtml::label(CHtml::encode('Individual Reports For:  '),'','');
echo CHtml::label(CHtml::encode(' '.$data['username']),'','');

?></b></h1></center>
<div class="col-md-12">
<hr class="col-md-11">
	<table class= "col-md-6">
		<thead>
			<td><center><h1><?php echo CHtml::label(CHtml::encode('Savings'),'',''); ?></h1></center></td>
		</thead>		
		<tr class="">
				<td><?php echo CHtml::label(CHtml::encode('Total Deposits'),'',''); ?></td>
				<td><?php echo CHtml::encode(Yii::app()->format->number($data['savingDepositsum'])); ?></td>					
		</tr>
		<tr >
				<td><?php echo CHtml::label(CHtml::encode('Total Withrawals'),'',''); ?></td>
				<td class="">
				<?php echo CHtml::encode(Yii::app()->format->number($data['savingWithdrawalsum'])); ?>
				</td>			
		</tr>
		<tr class="">
				<td><?php echo CHtml::label(CHtml::encode('Net Savings'),'',''); ?></td>		
				<td><b>
				<?php
				$data['savingNet']=$data['savingDepositsum']-$data['savingWithdrawalsum'];
				echo CHtml::encode(Yii::app()->format->number($data['savingNet'])); ?></b>
				</td>					
		</tr>
	</table>
	<table class= "col-md-6">
		<thead>
			<center><h1><?php echo CHtml::label(CHtml::encode('Loans'),'',''); ?></h1></center>
		</thead>
		<tr class="">
				<td><?php echo CHtml::label(CHtml::encode('Total Loans issued'),'',''); ?></td>
				<td><?php echo CHtml::encode(Yii::app()->format->number($data['loanIssuesum'])); ?></td>				
		</tr>
		<tr class="">
				<td><?php echo CHtml::label(CHtml::encode('Total Loan Repayments'),'',''); ?></td>
				<td><?php echo CHtml::encode(Yii::app()->format->number($data['loanRepaymentsum'])); ?></td>					
		</tr>
		<tr class="">
				<td><?php echo CHtml::label(CHtml::encode('Outstanding Loans'),'',''); ?></td>		
				<td><b>
				<?php $data['OutstandingLoan']=$data['loanIssuesum']-$data['loanRepaymentsum'];
				echo CHtml::encode(Yii::app()->format->number($data['OutstandingLoan'])); ?></b>
				</td>		
						
		</tr>
	</table>
	<hr class="col-md-11">
	<table class= "col-md-6">
		<thead>
			<td><center><h1><?php echo CHtml::label(CHtml::encode('Merry Go Round'),'',''); ?></h1></center></td>
		</thead>
		<tr class="">
				<td><?php echo CHtml::label(CHtml::encode('Total Contribution'),'',''); ?></td>
				<td>
				<?php echo CHtml::encode(Yii::app()->format->number($data['mgrContributionsum'])); ?>
				</td>				
		</tr>
		<tr class="">
				<td><?php echo CHtml::label(CHtml::encode('Total Issues'),'',''); ?></td>
				<td>
				<?php echo CHtml::encode(Yii::app()->format->number($data['mgrIssuesum'])); ?>
				</td>				
		</tr>
		<tr class="">
				<td><?php echo CHtml::label(CHtml::encode('Current Pool Balance'),'',''); ?></td>		
				<td>
				<b><?php 
				$data['mgrPoolBalance']=$data['mgrContributionsum']-$data['mgrIssuesum'];
				echo CHtml::encode(Yii::app()->format->number($data['mgrPoolBalance'])); ?></b>
				</td>		
						
		</tr>
	</table>	
	<hr class="col-md-11">
	
</div>
</div>
</div>
</div>
</div>
</div>