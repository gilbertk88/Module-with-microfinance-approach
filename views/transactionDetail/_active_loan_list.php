<div class="view">	
<?php for ($i=0;$i<$loanData['activeloanNo'];$i++){?>
	<tr>
		<td > 		
		<?php echo CHtml::link(CHtml::encode($loanData['activeloans'][$i]['loanname'],'',''),array('//accounting/transactiondetail/contribution','sguid'=>$space->guid,'trans_dir'=>2,'transid'=>3,'member'=>$loanData['guid'],'setting'=>$loanData['activeloans'][$i]['type_unit'])); ?> 
		</td>
		<td > 		
		<?php echo CHtml::link(CHtml::encode($loanData['activeloans'][$i]['totalDebt'],'',''),array('//accounting/transactiondetail/contribution','sguid'=>$space->guid,'trans_dir'=>2,'transid'=>3,'member'=>$loanData['guid'],'setting'=>$loanData['activeloans'][$i]['type_unit'])); ?> 
		</td>
	</tr>
<?php }?>
</div>