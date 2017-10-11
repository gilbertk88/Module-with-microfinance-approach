<div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-body">
				<div class="fc-content">
<?php 
if($mgrIdRoundCycle['trans_dir']==1){
	echo '<br/><br/><h1>Merry Go Round Deposit</h1>';
	$this->renderPartial('_merrygoround_depo',
		array('model'=>$model,'mgrIdRoundCycle'=>$mgrIdRoundCycle,'mgrsetting'=>$setting,'membership'=>$membership,'space' => $space,'transsetting'=>$transsetting)); 
}
elseif ($mgrIdRoundCycle['trans_dir']==2){
	echo '<br/><br/><h1>Merry Go Round Issue</h1>';
	$this->renderPartial('_merrygoround_issue',
		array('model'=>$model,'mgrIdRoundCycle'=>$mgrIdRoundCycle,'mgrsetting'=>$setting,'membership'=>$membership,'space' => $space,'transsetting'=>$transsetting));

}
?>

</div>
</div>
</div>
</div>
</div>