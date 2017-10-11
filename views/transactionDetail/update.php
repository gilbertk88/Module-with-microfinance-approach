<div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-body">
				<div class="fc-content">
	

<?php 
echo '<h1>Update TransactionDetail '.$model->id.'</h1>';
if ($updateData['transid']==1) {
	$this->renderPartial('_contribution', array('model'=>$model,'membership'=>$membership,
					'space' => $space,
					'transsetting'=>$transsetting,
					'transid'=>$transid,
					)); 
}
elseif ($updateData['transid']==2){
	$this->renderPartial('_merrygoround', array('model'=>$model,'membership'=>$membership,
			'space' => $space,
			'transsetting'=>$transsetting,
			'transid'=>$transid,
	));
}
elseif ($updateData['transid']==3){
	$this->renderPartial('_loan', array('model'=>$model,'membership'=>$membership,
		'space' => $space,
		'transsetting'=>$transsetting,
		'transid'=>$transid,
));
}
 
?>

</div>
</div>
</div>
</div>
</div>