<div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-body">
				<div class="fc-content">
<?php 
if ($loanData['trans_dir']==1) {
	echo '<h1>Issue Loan</h1>';
	$this->renderPartial('_loan_issue',
		array('model'=>$model,'membership'=>$membership,'space' => $space,'transsetting'=>$transsetting,'loanData'=>$loanData));
}
elseif ($loanData['trans_dir']==2){
	echo '<h1>Pay Loan</h1>';
	$this->renderPartial('_loan_repayment',
		array('model'=>$model,'membership'=>$membership,'space' => $space,'transsetting'=>$transsetting,'loanData'=>$loanData));

}
elseif ($loanData['trans_dir']==3){
	echo '<h1>Active Loan(s) For '.$loanData['username'].' </h1>';
	
	echo '<table class= "table table-hover"><thead><td>';
	echo CHtml::label(CHtml::encode('Loan Name'),'','');
	echo '</td><td>';
	echo CHtml::label(CHtml::encode('Loan Balance'),'','');
	echo '</td></thead>';
	$this->renderPartial('_active_loan_list',
		array('model'=>$model,'membership'=>$membership,'space' => $space,'transsetting'=>$transsetting,'loanData'=>$loanData));
echo '</table>';
}
elseif ($loanData['trans_dir']==4){
	echo '<h1> '.$loanData['username'].' doesn\'t have an active Loan</h1>';
$this->renderPartial('_no_loan',
		array('model'=>$model,'membership'=>$membership,'space' => $space,'transsetting'=>$transsetting,'loanData'=>$loanData));
}
?>

</div>
</div>
</div>
</div>
</div>