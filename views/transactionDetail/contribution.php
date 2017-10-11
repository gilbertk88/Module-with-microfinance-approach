<div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-body">
				<div class="fc-content">
<?php 
 
$model->trans_setting_type=1;
if($shareData['trans_dir']==1){
	echo '<br/><br/><h1>Deposit Savings</h1>';
	$this->renderPartial('_share_buy',
			array('model'=>$model,'shareData'=>$shareData,'membership'=>$membership,'space' => $space,'transsetting'=>$transsetting,'cashrecipient'=>$cashrecipient,));
}
elseif ($shareData['trans_dir']==2){
	echo '<br/><br/><h1>Withdrawal Savings</h1>';
	$this->renderPartial('_share_sell',
			array('model'=>$model,'shareData'=>$shareData,'membership'=>$membership,'space' => $space,'transsetting'=>$transsetting,'cashrecipient'=>$cashrecipient,));

}
elseif ($shareData['trans_dir']==3){
	echo '<br/><br/><h1>No Savings Withdraw</h1>';
	$this->renderPartial('_share_none',
			array('model'=>$model,'shareData'=>$shareData,'space' => $space));

}
elseif ($shareData['trans_dir']==4){
	echo '<br/><br/><h1>Select Savings to Withdraw</h1>';
	$this->renderPartial('_share_bal_list',
			array('model'=>$model,'shareData'=>$shareData,'space' => $space));

}
 ?>

</div>
</div>
</div>
</div>
</div>