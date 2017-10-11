<?php

class TransactiondetailController extends ContentContainerController
{
	 /**
	 * @return array action filters
	 */
	
	public $subLayout = "application.modules_core.space.views.space._layout";
	
	public function behaviors()
    {
        return array(
           // 'ProfileControllerBehavior' => array('class' => 'application.modules_core.space.behaviors.SpaceControllerBehavior',),
        	//'NoticeControllerBehavior' => array('class' => 'application.modules_core.space.behaviors.SpaceModelMembershipBehavior',),	
            //'ViewController' => array('class' => 'application.modules.calendar.controllers.ViewController',),
        );
    } 
	
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	public function beforeAction($action)
	{
		if($this->getSpace()->isSimba())
			return parent::beforeAction($action);
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	
	public function accessRules()
	{
		return array(
			array('allow',  // give unauthenticated users nothing
				'actions'=>array(),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update','contribution','delete','report','typeunit'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	
	public function actionView($id)
	{
		
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'space'=>Yii::app()->getController()->getSpace(),
		));
	}
	
	public function actionNotification($id)
	{	
		$this->render('notification',array(
				'model'=>$this->loadModel($id),
				'space'=>Yii::app()->getController()->getSpace(),
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id, $transid)
	{
		$this->adminOnly();
		$model=$this->loadModel($id);
		$space = Yii::app()->getController()->getSpace();
		//$transaction = TransactionController::loadModel($model->transaction_id);
			// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		//$transaction = $model->transaction;
		if(isset($_POST['TransactionDetail']))
		{
			$model->attributes=$_POST['TransactionDetail'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		$model->related_user_id= 2;
		$membership = SpaceMembership::model()->findAllByAttributes(array('space_id' => $this->getSpace()->id));
		if($transid==1)
			$transsetting = ContributionSettings::model()->findAllByAttributes(array('space' => $this->getSpace()->id));
		elseif($transid==2)
		$transsetting = MerriGoRoundSettings::model()->findAllByAttributes(array('space' => $this->getSpace()->id));
		elseif($transid==3)
		$transsetting = LoanSettings::model()->findAllByAttributes(array('space' => $this->getSpace()->id));
		
		
		$this->render('update',array(
					'model'=>$model,
					'membership'=>$membership,
					'space' => $space,
					'transsetting'=>$transsetting,
					'transid'=>$transid,
			)); 
			
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->adminOnly();
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($luid=0,$indiv=0)
	{
		if ($this->getSpace()->isAdmin()) {
			if ($indiv==1 && $luid==0) {
				$this->redirect(array('//space/mlist/translist','sguid'=>Yii::app()->getController()->getSpace()->guid));
			}
			$isadmin=true;			
			if ($luid==0 ) {
				$dataProvider=new CActiveDataProvider('TransactionDetail',array('criteria'=>array('condition'=>'space_id='.Yii::app()->getController()->getSpace()->id,'order'=> 'id DESC'),'pagination'=>array('pageSize'=>20,)));
				
				$this->render('index',array(
						'dataProvider'=>$dataProvider,
						'space'=>Yii::app()->getController()->getSpace(),
						'isadmin'=>$isadmin,
						'memberData'=>'all members',
				));
			}
			else {
				$dataProvider=new CActiveDataProvider('TransactionDetail',array('criteria'=>array('condition'=>'related_user_id='.$luid.' and space_id='.Yii::app()->getController()->getSpace()->id,'order'=> 'id DESC'),'pagination'=>array('pageSize'=>20,)));
				$memberData=User::model()->findByAttributes(array('id'=>$luid));
				
				$this->render('index',array(
						'dataProvider'=>$dataProvider,
						'space'=>Yii::app()->getController()->getSpace(),
						'isadmin'=>$isadmin,
						'memberData'=>$memberData['username'],
				));
			}
		}
		elseif (!$this->getSpace()->isAdmin()){
			$isadmin=false;
			$dataProvider=new CActiveDataProvider('TransactionDetail',array('criteria'=>array('condition'=>'related_user_id='.Yii::app()->user->id,'order'=> 'id DESC'),'pagination'=>array('pageSize'=>20,)));
			
			$this->render('index',array(
					'dataProvider'=>$dataProvider,
					'space'=>Yii::app()->getController()->getSpace(),
					'isadmin'=>$isadmin,
			));
		}
		
		
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->adminOnly();
		$model=new TransactionDetail('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TransactionDetail']))
			$model->attributes=$_GET['TransactionDetail'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TransactionDetail the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TransactionDetail::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TransactionDetail $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='transaction-detail-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function doubleentry($account_id, $drcr,$catchup_account_id,$transactiondetaildata,$displayID)
	{
		$model=new TransactionDetail;
		
		$model->attributes=$transactiondetaildata;
		$model->user_id =  $model->created_by= Yii::app()->user->ID;
		$model->Detail = $catchup_account_id['Detail'];		
			//$image
		$model->space_id = $this->getSpace()->id;				
		$model->account_id= $account_id;
		$model->type= $drcr;
		$model->primary_catchup=$catchup_account_id['catchup_account_id'];
		unset($transactiondetaildata['Detail']);
		//$model->primary_catchup=$primary_catchup;
				
			//$amount
			//Dr Bank
			//$model->cash_gate= $transactiondata['cash_gate'];
		
		$model->save();
			//continue;
			if($displayID){
				return $model->id;
			}
	}
	
	public function cashgate($TransactionDetail)
	{
				
		if($TransactionDetail['cash_gate']==1) //// if cash acc=20 elseif  mobile acc=21 elseif bank acc=22
		{
			$accoID['catchup_account_id']=20;
			$accoID['Detail']= 'Cash '.$TransactionDetail['Detail'];
		}
		elseif($TransactionDetail['cash_gate']==2)
		{
			$accoID['catchup_account_id']=21 ;
			$accoID['Detail']= 'Cash '.$TransactionDetail['Detail'];
		}
		elseif($TransactionDetail['cash_gate']==3)
		{
			$accoID['catchup_account_id']=22;
			$accoID['Detail']= 'Bank/SACCO '.$TransactionDetail['Detail'];
		}
		else
		{
			$accoID['catchup_account_id']=20;
			$accoID['Detail']= 'Cash '.$TransactionDetail['Detail'];
		}
		
		return $accoID;		
	}
	
	public function mgrIdSetting(){
		//onrequest of mgrtransaction with no mgrsetting && direction:
		//if there is no mgrsetting: redirect to mgrsetting create, afterwards redirect to create new deposit transaction
		$mgrSetting_array= MerriGoRoundSettings::model()->findAllByAttributes(array('space_id' => $this->getSpace()->id));
		$mgrSetting_no=count($mgrSetting_array);
		if ($mgrSetting_no==0) {
			$this->redirect(array('//setting/merrigoroundsettings/create','type'=>2,'sguid'=>$this->getSpace()->guid));
		}
		//if there is  mgrsetting:
		elseif (0<$mgrSetting_no){
			//if one mgr setting: auto redirect to create new transaction with the single mgrsetting as the one in use
			if ($mgrSetting_no == 1){
				//return $mgrSetting_array['0']->id;
				$this->redirect(array('//accounting/transactiondetail/contribution','sguid'=>$this->getSpace()->guid,'transid'=>2, 'trans_dir'=>1, 'setting'=>$mgrSetting_array['0']->id));
			}		
			//more than one mgrsetting: let admin user select one merry go round setting
			if (1<$mgrSetting_no) {
				$this->redirect(array('//setting/merrigoroundsettings/mgroptions','sguid'=>$this->getSpace()->guid));
			}
			
		}
		//mgridroundcyle()=  return relevant direction, round and cycle
		
		//after identifying mgrsettin, cyle && round && balance in find(if issue) && contribution amount(if deposit):
		
		//if merry go round setting was not set, redirect to merry go round settings
		
		//@todo create cycle and round display
		
	}
	
	public function mgrIdRoundCycle($mgrsetting)
	{
		//@todo enter end_date on end of cycle
		$model=new TransactionDetail;
		$space = Yii::app()->getController()->getSpace();
		// work in progress on the merry do round cycle an rounds **********************************************
		$cycledata=MgrCycle::model()->findByAttributes(array('space' => $this->getSpace()->id,'cycle_status'=>1,'setting_id'=>$mgrsetting));		
		//*******************************************************************************************************
		//Is there an active cycle and round.
	if (!isset($cycledata))
	{
		// redirect to create new cycle then redirect new round
		$this->redirect(array('//setting/mgrcycle/create','setting_id'=>$mgrsetting,'sguid'=>$space->guid));
	}
	elseif (isset($cycledata)) {
		$rounddata=MgrRound::model()->findByAttributes(array('space_id' => $this->getSpace()->id,'status'=>1,'mgr_cycle'=>$cycledata->id));
		if (!isset($rounddata)){
		$this->redirect(array('//setting/mgrround/create','mgr_cycle'=>$cycledata->id,'sguid'=>$this->getSpace()->guid));
		}
		$mgr_depo_arra = TransactionDetail::model()->findAllByAttributes(array('space_id'=>$this->getSpace()->id,'type_unit'=>$cycledata->id,'type_subunit'=>$rounddata->id,'account_id'=>25,'type'=>'Cr'));
	
		$mgr_depo_count=count($mgr_depo_arra);
		
		
		if($mgr_depo_count==count($space->memberships)||$mgr_depo_count>count($space->memberships)){  //has everyone contributed for this round
			
				$mgr_issue_arra=TransactionDetail::model()->findAllByAttributes(array('space_id'=>$space->id,'type_unit'=>$cycledata->id,'account_id'=>25,'type'=>'Dr'));
				$mgr_issue_count=count($mgr_issue_arra);
				if ($mgr_issue_count==count($space->memberships)||$mgr_issue_count>count($space->memberships)) //has everyone received the contribution from this cycle
				{
					// create new merry go round cycle
					//@todo review mgr cycle creation page.
					$this->redirect(array('//setting/mgrcycle/create','setting_id'=>$mgrsetting,'sguid'=>$this->getSpace()->guid));
				}
				elseif ($mgr_issue_count<count($space->memberships))
				{
					// is there money in the mgr fund : yes ->issue mgr contribution  no->create new round
					//(sum of current mrg round contribution)-(issued mgr fund of this round)
					//Merry go round : contributions-issues = remaining
					$merygoroundContribution= $this->loadtransactions(25,'Cr',$cycledata->id,$rounddata->id);
					if (isset($merygoroundContribution)) {
						$mgrContributionsum=$this->addtransactions($merygoroundContribution);
					}					
					$merygoroundIssue= $this->loadtransactions(25,'Dr',$cycledata->id,$rounddata->id);
					if (isset($merygoroundIssue)) {
						$mgrIssuesum=$this->addtransactions($merygoroundIssue);
					}
					if (isset($mgrContributionsum) && isset($mgrIssuesum)){
						
						$availableAmountFund=$mgrContributionsum-$mgrIssuesum;
						if ($availableAmountFund>0) // there is money in the fund
						{
							$beforemgr['availableAmountFund']=$availableAmountFund;
							$beforemgr['trans_dir']=2;
							$beforemgr['cycle']=$cycledata->id;
							$beforemgr['round']=$rounddata->id;
							
							return $beforemgr;
						}
						elseif ($availableAmountFund<=0) // there is no money in the fund
						{
							$this->redirect(array('//setting/mgrround/create','mgr_cycle'=>$cycledata->id,'sguid'=>$this->getSpace()->guid));						
						}
					}
				}			
		}
		elseif ($mgr_depo_count!==count($space->memberships)&&$mgr_depo_count<count($space->memberships))
		{
			// create new deposit contribution
			
			if (isset($availableAmountFund)) {
				$beforemgr['expectedAmount']=$availableAmountFund;
			}
			$mgrset=MerriGoRoundSettings::model()->findByattributes(array('id'=>$cycledata->setting_id));
			$beforemgr['trans_dir']=1;
			$beforemgr['cycle']=$cycledata->id;
			$beforemgr['round']=$rounddata->id;
			$beforemgr['depositamount']=$mgrset['amount'];
			$beforemgr['cash_gate']=$mgrset['cash_gate'];
			
			return $beforemgr;
			
		}
	}
	}
	
	public function withdrawshare($member=null,$setting=null)
	{//show total available shares and income(interest, penalties and profits) 
		// return : member number of shares, income from interests and penalties- expences 
		//Withdraw : if excess is withdrawn -> raise a redflag.
		//there should be one default share for the savings and then there should be project share
		$shareoption=ContributionSettings::model()->findAllByAttributes(array('space_id'=>Yii::app()->getController()->getSpace()->id));
		$userdata=User::model()->findByAttributes(array('guid'=>$member));
		
		$shareoptionno=count($shareoption);
		//@todo incorporate loans, interests/penalties and and income
		//select share available that the member has: 
				//if a single-> go directly to withdrawal page.
				//if multiple shares: find if there are multiple balances
					//if no share balance say there is no balance  
					//if only one single share with balance: redirect to withdrwal with share.
					//if multiple balances available: list of available then link the withdrawal page.
		//withdraw with limits
		
		if (isset($setting)){
			$data['membersharebought']=TransactionDetail::model()->findAllByAttributes(array('space_id'=>Yii::app()->getController()->getSpace()->id,'related_user_id'=>$userdata['id'],'trans_type_id'=>$setting,'account_id'=>23,'type'=>'Cr'));
			$data['membersharesold']=TransactionDetail::model()->findAllByAttributes(array('space_id'=>Yii::app()->getController()->getSpace()->id,'related_user_id'=>$userdata['id'],'trans_type_id'=>$setting,'account_id'=>23,'type'=>'Dr'));
			$sharesetting=ContributionSettings::model()->findByAttributes(array('space_id'=>Yii::app()->getController()->getSpace()->id,'id'=>$setting));
			
			$data['sumsharebought']=$this->addtransactions($data['membersharebought']);
			$data['sumsharesold']=$this->addtransactions($data['membersharesold']);
			
			$data['shareboughtNo']=$this->addshares($data['membersharebought']);
			$data['sharesoldNo']=$this->addshares($data['membersharesold']);
			$data['sharenetNo']=$data['shareboughtNo']-$data['sharesoldNo'];
			
			$data['sumsharenet']=$data['sumsharebought']-$data['sumsharesold'];
			$data['memberid']=$userdata['id'];
			$data['setting']=$setting;
			$data['trans_dir']=2;
			$data['username']=$userdata['username'];
			$data['cash_gate']=$sharesetting['cash_gate'];
			$data['share_price']=$sharesetting['amount'];
			
			return $data;
		}
		if($shareoptionno==1){
			$this->redirect(array('//accounting/transactiondetail/contribution','sguid'=>Yii::app()->getController()->getSpace()->guid,'trans_dir'=>2,'transid'=>1,'member'=>$member,'setting'=>$shareoption['0']['id']));
		}
		elseif ($shareoptionno>1){
			//$sharebal;
			for ($i=0;$i<$shareoptionno;$i++){
				
				$membersharebought[$i]=TransactionDetail::model()->findAllByAttributes(array('space_id'=>Yii::app()->getController()->getSpace()->id,'related_user_id'=>$userdata['id'],'trans_type_id'=>$shareoption[$i]['id'],'account_id'=>23,'type'=>'Cr'));
				$membersharesold[$i]=TransactionDetail::model()->findAllByAttributes(array('space_id'=>Yii::app()->getController()->getSpace()->id,'related_user_id'=>$userdata['id'],'trans_type_id'=>$shareoption[$i]['id'],'account_id'=>23,'type'=>'Dr'));
				
				$data[$i]['sumsharebought']=$this->addtransactions($membersharebought[$i]);
				$data[$i]['sumsharesold']=$this->addtransactions($membersharesold[$i]);
				$data[$i]['sumsharenet']=$data[$i]['sumsharebought']-$data[$i]['sumsharesold'];
				
				$data[$i]['sharename']=$shareoption[$i]['name'];
				$data[$i]['shareid']=$shareoption[$i]['id'];
				
				if (!isset($sharebal)) {
					$sharebal=0;
				}
				if (isset($data[$i]['sumsharenet'])) {
					$sharebal++;
				}
			}
			if ($sharebal==0) {
				$data['memberid']=$userdata['id'];
				$data['username']=$userdata['username']; 
				$data['trans_dir']=3;
				$data['shareoptionno']=$shareoptionno;
				
				return $data;
			}
			elseif ($sharebal==1||$sharebal>1){
				$data['memberid']=$userdata['id'];
				$data['trans_dir']=4;
				$data['username']=$userdata['username'];
				$data['shareoptionno']=$shareoptionno;
				$data['guid']=$userdata['guid'];
				return $data;
			}
		}
		elseif ($shareoptionno==0){
				$this->redirect(array('//setting/contributionsettings/create','sguid'=>$this->getSpace()->sguid));
			}
		
		//sum of all shares balance
		// share setting 1 : bought shares-sold shares= available shares
		/***share income(setting 1) : income=(total interest earned and paid + total penalties earned and paid)
		*share expence(setting 1) : expense=(total due interest & not paid + total due penalties & not yet paid)
		*share profit and loss : (profit/loss)=income-expense **/
		
		
	}
	
	public function depositshare($setting=null){
		//on saving request
		//show share select list : if there are none -> redirect to create one.
		
			if (!isset($setting)) {
				$this->redirect(array('//setting/contributionsettings/shareoptions','guid'=>$this->getSpace()->guid));
			}
			elseif (isset($setting))
			{
				$sdata = ContributionSettings::model()->findByAttributes(array('space_id'=>$this->getSpace()->id,'id'=>$setting));
				$beforeshare['id']=$sdata['id'];
				$beforeshare['share_price']=$sdata['amount'];
				$beforeshare['share_no']=$sdata['share_no'];
				$beforeshare['transfer_method']=$sdata['cash_gate'];
				$beforeshare['trans_dir']=1;
				$beforeshare['setting']=$setting;
				
				return $beforeshare;
			}				
	}
	
	public function issueloan($setting=null){
		//on saving request
		//show share select list : if there are none -> redirect to create one.
	
		if (!isset($setting)) {
			$this->redirect(array('//setting/loansettings/loanoptions','guid'=>$this->getSpace()->guid));
		}
		elseif (isset($setting))
		{			
			
			$sdata = LoanSettings::model()->findByAttributes(array('space_id'=>$this->getSpace()->id,'id'=>$setting));
			
			$data['amount']= $sdata['amount'];
			$data['interest']=$sdata['interest_rate'];
			$data['trans_dir']=1;
			$data['setting']=$setting;
	
			return $data;
		}
	}
	
	public function loanbal($loanbal,$member)
	{
		$space=Yii::app()->getController()->getSpace();
		//$userdata=User::model()->findByAttributes(array('guid'=>$member));
		//return outstanding loans retails -> total debt= (principle+interest+penalties)-Repayments
		//principle sum
		$principal=TransactionDetail::model()->findAllByAttributes(array('space_id'=>$space->id,'related_user_id'=>$member,'type_unit'=>$loanbal['id'],'type_subunit'=>1,'account_id'=>28,'type'=>'Dr'));
		$principalSum=$this->addtransactions($principal);
		//+interest sum
		$interest=TransactionDetail::model()->findAllByAttributes(array('space_id'=>$space->id,'related_user_id'=>$member,'type_unit'=>$loanbal['id'],'type_subunit'=>2,'account_id'=>28,'type'=>'Dr'));
		$interestSum=$this->addtransactions($interest);
		//+penalties sum
		$penalty=TransactionDetail::model()->findAllByAttributes(array('space_id'=>$space->id,'related_user_id'=>$member,'type_unit'=>$loanbal['id'],'type_subunit'=>3,'account_id'=>28,'type'=>'Dr'));
		$penaltySum=$this->addtransactions($penalty);
		//-Repayments sum
		$repayment=TransactionDetail::model()->findAllByAttributes(array('space_id'=>$space->id,'related_user_id'=>$member,'type_unit'=>$loanbal['id'],'account_id'=>28,'type'=>'Cr'));
		$repaymentSum=$this->addtransactions($repayment);
		
		$data['totalDebt']=($principalSum+$interestSum+$penaltySum)-$repaymentSum;
		//$data['memberid']=$userdata['id'];
		//$data['installment'];
		$settingLoan=LoanSettings::model()->findByPk($loanbal['setting_id']);
		$data['loanname']=$settingLoan['name'];
		$data['cash_gate']=$settingLoan['cash_gate'];
		$data['type_unit']=$loanbal['id'];
		//loan setting name
		//outstanding balance
		
		return $data;
	}
	
	public function payloan($member=null,$setting=null){
		$space=Yii::app()->getController()->getSpace();
		
		//select member
		if (!isset($member)) {
			$this->redirect(array('//space/mlist/payloan','sguid'=>$space->guid));
		}		
		if (!isset($setting)) {
			//Are there active loans for this member:
			$rUser=User::model()->findByAttributes(array('guid'=>$member));
			$activeloan=ActiveLoan::model()->findAllByAttributes(array('space'=>$space->id,'related_user_id'=>$rUser['id'],'status'=>1));
			$activeloanNo=count($activeloan);
			if ($activeloanNo>0) {
				//yes there are active loans -> list them here; 
				$data['trans_dir']=3;
				$data['username']=$rUser['username'];
				$data['activeloanNo']=$activeloanNo;
				$data['guid']=$rUser['guid'];
				
				for ($i=0;$activeloanNo>$i;$i++)
				{
					$data['activeloans'][$i]=$this->loanbal($activeloan[$i],$rUser['id']);
				}
			}
			elseif ($activeloanNo==0){
				//No active loan -> inform there are  no active loans and suggest to issue loan.
				$data['trans_dir']=4;
				$data['username']=$rUser['username'];
			}
		}
		elseif (isset($setting)){
		//repay loan
		//setting is the loan on the type_unit 
		$rUser=User::model()->findByAttributes(array('guid'=>$member));
		$numb=ActiveLoan::model()->findByPk($setting);
		$data['activeloans']=$this->loanbal($numb,$rUser['id']);
		$data['trans_dir']=2;
		$data['username']=$rUser['username'];
		$data['userid']=$rUser['id'];
		}
		
		return $data;
	}
	
	public function chargeInterest($loanInterest){
		//get interest rate
		//get if: flat rate/ reducing bal
		//get amount to be charged
		$activeLoan=ActiveLoan::model()->findByAttributes(array('id'=>$loanInterest['active_loan'],'status'=>1));
		if (!isset($activeLoan)) {
			//disable this loan interest;
		}
		$loanSettings=LoanSettings::model()->findByPk($activeLoan['setting_id']);
		//if reducing bal-> amount=bal*interest/100 
		//if flat rate -> amount=principal*interest/100
		if ($loanSettings['interest_policy']==1) {
			$amount=$this->loanbal($activeLoan, $activeLoan['related_user_id']);
			$amountInterest=$amount*$loanSettings['interest_rate']/100;
		}
		elseif ($loanSettings['interest_policy']==2){
			$amount=TransactionDetail::model()->findByAttributes(array('type_unit'=>$activeLoan,'account_id'=>28));
			$amountInterest=$amount['amount']*$loanSettings['interest_rate']/100;
		}
		
		//cr loan account
		//dr loan issued interest
		$TransactionDetail['Detail']= 'Savings deposit '.$TransactionDetail['Detail'];
		$TransactionDetail['amount']=$amountInterest;
		$TransactionDetail['trans_setting_type']= 5;
		$TransactionDetail['trans_type_id']=$activeLoan['setting_id'];
		$TransactionDetail['status']=1;
		$TransactionDetail['type_subunit']=$loanInterest['id'];
		$TransactionDetail['type_unit']=$activeLoan['id'];
		$TransactionDetail['creator_id']=1;
		$TransactionDetail['space_id']=$activeLoan['space'];
		$TransactionDetail['related_user_id']=$activeLoan['related_user_id'];		
		
		$displayId=$this->doubleentry(28,'Cr',$TransactionDetail, true,0); //Cr loan account
		$this->doubleentry(29,'Dr',$TransactionDetail,false ,$displayId); //Dr interest account		
		
		//type_unit=activeloan
		//type_subunit=interest
		$newInterest['status']=1;
		$newInterest['active_loan']=$activeLoan['id'];
		$idTime= time()+$this->timestampSeconds($loanSettings['interest_period']);
		//calculate date
		$newInterest['charge_date']=time()+$idTime;
		LoanInterestController::actionCreate($newInterest);
		//create next interest date to charge
		//if loan is inactive, deactivate
		
		//send notification to relevant user
	}
	
	public function actionTypeunit($id,$typeunit){
		
		$model=$this->loadModel($id);
		$model->type_unit=$typeunit;
		
		if ($model->save()) {
			$this->redirect(array('//accounting/transactiondetail/view','id'=>$id, 'sguid'=>Yii::app()->getController()->getSpace()->guid));
		}		
	}
		
	public function timestampSeconds($idTime){
		//1=>'Monthly'
		if ($idTime==1) {
			$data=60*60*24*30;
		}
		//2=>'Weekly'
		elseif ($idTime==2) {
			$data=60*60*24*7;
		}
		//3=>'Once every two weeks'
		elseif ($idTime==3) {
			$data=60*60*24*14;
		}
		//4=>'Once every two months'
		elseif ($idTime==4) {
			$data=60*60*24*60;
		}
		//5=>'Once every three months'
		elseif ($idTime==5) {
			$data=60*60*24*90;
		}
		//6=>'Bi-annual'
		elseif ($idTime==6) {
			$data=60*60*24*182.5;
		}
		//7=>'Annual'
		elseif ($idTime==7) {
			$data=60*60*24*365;
		}
		//8=>'Single Installment'
		elseif ($idTime==8) {
			$data=0;
		}
		
		return $data;
				
	}
	
	public function actionContribution($transid=1, $trans_dir=1,$setting=null,$member=null)
	{
		$this->adminOnly();
		$model=new TransactionDetail;
		$cashrecipient=new Cash;
		$space = Yii::app()->getController()->getSpace();
		if(isset($_POST['TransactionDetail']))
		{			
			//$model->created_by=Yii::app()->user->id;
			//$model->space_id=$space->id;
			
			$TransactionDetail=$_POST['TransactionDetail'];
			// @todo create notification to inform: individual on transaction, whole chama on chosen events
			// @todo Are members allowed to contribute more than the required amount?
			if($TransactionDetail['trans_setting_type']==TransactionDetail::SAVINGS_TRAN) // --------------------------------------SAVINGS transaction type
			{
				if($TransactionDetail['transaction_direction']==1) // deposit
					{
						$TransactionDetail['Detail']= 'Savings Deposit - '.$TransactionDetail['Detail'];
						$accoID=$this->cashgate($TransactionDetail); //// if cash acc=20 elseif  mobile acc=elseif bank acc=22
						
						$displayID = $this->doubleentry(23,'Cr',$accoID,$TransactionDetail, true); //Cr shares account
						//$cashrecipient->id=1; //$displayID;
						//$cashrecipient->cash_recipient=1; //$_POST['Cash']['cash_recipient'];
						
						//$this->doubleentry($accoID,'Dr',$TransactionDetail, false,$displayID); //Dr money  account
						
						//---------Notification---------------------------------------
						
						$userData['userId'] = $TransactionDetail['related_user_id'];			
						$userData['spaceId'] = $space->id;						
						$userData['sObject_id']=$displayID;
						$userData['tObject_id']=$displayID;
						$userData['space_id']=$space->id;
						
						$shareBuyNotification= new shareBuyNotification;
						
						$shareBuyNotification->fire($userData);
						
						$transactiongroupNotification= new transactiongroupNotification;
						
						$transactiongroupNotification->fire($userData);
					}
				elseif($TransactionDetail['transaction_direction']==2) //withdrawal
					{
						//@todo if they withdraw more than they have in there account: throw error
												
						$TransactionDetail['Detail']= 'Savings Withdrawal - '.$TransactionDetail['Detail'];	
						$accoID=$this->cashgate($TransactionDetail); //// if cash acc=20 elseif  mobile acc=elseif bank acc=22
						
						$displayID = $this->doubleentry(23,'Dr',$accoID,$TransactionDetail, true); //Cr share account
						
						//$this->doubleentry($accoID,'Cr',$TransactionDetail, false,$displayID); //Dr money  account
						
						//---------Notification---------------------------------------
						
						$userData['userId'] = $TransactionDetail['related_user_id'];
						$userData['spaceId'] = $space->id;
						$userData['sObject_id']=$displayID;
						$userData['tObject_id']=$displayID;
						$userData['space_id']=$space->id;
						
						$shareSellNotification= new shareSellNotification;
						
						$shareSellNotification->fire($userData);
						//------------------------------------------------------
						
						$transactiongroupNotification= new transactiongroupNotification;
						
						$transactiongroupNotification->fire($userData);
					}
			}
				
			elseif($TransactionDetail['trans_setting_type']==TransactionDetail::MGR_TRAN)// -------------------------------------Merri-go-round contribution and issue
			{
				
				if($TransactionDetail['transaction_direction']==1) // contribute
					{//@todo  see if this user has contributed to the pool- if they have reject submission and point to the users' previous contribution update
						$depositTest=TransactionDetail::model()->findByAttributes(array('type'=>'Cr','account_id'=>25,'type_unit'=>$TransactionDetail['type_unit'],'type_subunit'=>$TransactionDetail['type_subunit'],'trans_setting_type'=>$TransactionDetail['trans_setting_type']));
						if (isset($depositTest)) {
							//throw error, highlight the memeber area and give an option to update and exit : error = a single member cannot deposit twice in a single round
						}
						$TransactionDetail['Detail']= 'Merry go round deposit - '.$TransactionDetail['Detail'];
						$accoID=$this->cashgate($TransactionDetail); //// if cash acc=20 elseif  mobile acc=elseif bank acc=22						
						$displayID = $this->doubleentry(25,'Cr',$accoID,$TransactionDetail, true,0); //Cr savings account
						
						//$this->doubleentry($accoID,'Dr',$TransactionDetail, false,$displayID); //Dr money  account
						
						//---------Notification---------------------------------------
						
						$userData['userId'] = $TransactionDetail['related_user_id'];
						$userData['spaceId'] = $space->id;
						$userData['sObject_id']=$displayID;
						$userData['tObject_id']=$displayID;
						$userData['space_id']=$space->id;
						
						$mgrDepositNotification= new mgrDepositNotification;
						
						$mgrDepositNotification->fire($userData);
						
						//---------------------------------------------------
						
						$transactiongroupNotification= new transactiongroupNotification;
						
						$transactiongroupNotification->fire($userData);
						
					}
				elseif($TransactionDetail['transaction_direction']==2) //issue
					{ //@todo see if the user has received in this cyle and disqualify and redirect to the specific transaction id 
						$depositTest=TransactionDetail::model()->findByAttributes(array('type'=>'Dr','account_id'=>25,'type_unit'=>$TransactionDetail['type_unit'],'trans_setting_type'=>$TransactionDetail['trans_setting_type']));
						if (isset($depositTest)) {
							//throw error, highlight the memeber area and give an option to update and exit : error = one user cannot receive money twice in a single cycle
						}
						$TransactionDetail['Detail']= 'Merry go round issue - '.$TransactionDetail['Detail'];
						$accoID=$this->cashgate($TransactionDetail); //// if cash acc=20 elseif  mobile acc=elseif bank acc=22
						$displayID = $this->doubleentry(25,'Dr',$accoID,$TransactionDetail, true,0); //Cr savings account
						
						//$accoID=$this->cashgate($TransactionDetail, $displayID,'Merry go round issue'); //// if cash acc=20 elseif  mobile acc=elseif bank acc=22 
						//$this->doubleentry($accoID,'Cr',$TransactionDetail, false,$displayID); //Dr money  account
						
						//---------Notification---------------------------------------
						
						$userData['userId'] = $TransactionDetail['related_user_id'];
						$userData['spaceId'] = $space->id;
						$userData['sObject_id']=$displayID;
						$userData['tObject_id']=$displayID;
						$userData['space_id']=$space->id;
						
						$mgrIssueNotification= new mgrIssueNotification;
						
						$mgrIssueNotification->fire($userData);
						
						//----------------------------------------------------
						
						$transactiongroupNotification= new transactiongroupNotification;
						
						$transactiongroupNotification->fire($userData);
					}
			
			}					
			elseif($TransactionDetail['trans_setting_type']==TransactionDetail::LOAN_TRAN) // -----------------------------Loan issue and repayment
			{
				$this->getSpace()->isSimba();				 
					 
				
				if($TransactionDetail['transaction_direction']==1) // issue
				{
						$TransactionDetail['Detail']= 'Loan issue - '.$TransactionDetail['Detail'];
						$accoID=$this->cashgate($TransactionDetail); //// if cash acc=20 elseif  mobile acc=elseif bank acc=22
						
						$displayID = $this->doubleentry(28,'Dr',$accoID,$TransactionDetail, true,0); //Dr loan account
						
						//$this->doubleentry($accoID,'Cr',$TransactionDetail, false,$displayID); //Cr money  account
						$this->redirect(array('//setting/activeloan/create','ruid'=>$TransactionDetail['related_user_id'],'setting'=>$TransactionDetail['trans_type_id'],'viewid'=>$displayID,'sguid'=>$space->guid));
						
						
						$userData['userId']=$TransactionDetail['related_user_id'];
						$userData['spaceId']=$space->id;
						$userData['sObject_id']=$displayID;
						$userData['tObject_id']=$displayID;
						$userData['space_id']=$space->id;
						
						$loanIssueNotification= new loanIssueNotification;
						
						$loanIssueNotification->fire($userData);
						
						//--------------------------------------------------
						
						$transactiongroupNotification= new transactiongroupNotification;
						
						$transactiongroupNotification->fire($userData);
					}
				elseif($TransactionDetail['transaction_direction']==2) //Loan payment ----interest is handled else where
					{
						$TransactionDetail['Detail']= 'Loan repayment - '.$TransactionDetail['Detail'];
						$accoID=$this->cashgate($TransactionDetail); // if cash acc=20 elseif  mobile acc=elseif bank acc=22
						$displayID = $this->doubleentry(28,'Cr',$accoID,$TransactionDetail, true,0); //Cr loan account
						
						//$this->doubleentry($accoID,'Dr',$TransactionDetail, false,$displayID); //Dr money  account 
						//@todo if the whole balance has been settled: disable the loan in question.
						$activeLoan=ActiveLoan::model()->findByPk($TransactionDetail['type_unit']);
						$loanbal = $this->loanbal($activeLoan,$TransactionDetail['related_user_id']);
						
						if ($TransactionDetail['amount']>=$loanbal['totalDebt']){
							//disable this loan
							$activeLoan->status = 0;
							$activeLoan->save();
						}
						$userData['userId'] = $TransactionDetail['related_user_id'];
						$userData['spaceId'] = $space->id;
						$userData['sObject_id']=$displayID;
						$userData['tObject_id']=$displayID;
						$userData['space_id']=$space->id;
						
						$loanRepaymentNotification= new loanRepaymentNotification;
						
						$loanRepaymentNotification->fire($userData);
						
						
						//---------------------------------------------------------
						
						$transactiongroupNotification= new transactiongroupNotification;
						
						$transactiongroupNotification->fire($userData);
					}
			
			}
			
		$this->redirect(array('view','id'=>$displayID,'sguid' => $space->guid));
		}
		
		$membership = SpaceMembership::model()->findAllByAttributes(array('space_id' => $this->getSpace()->id));
		if($transid==TransactionDetail::SAVINGS_TRAN)
		$transsetting = ContributionSettings::model()->findAllByAttributes(array('space_id' => $this->getSpace()->id));
		elseif($transid==TransactionDetail::MGR_TRAN)
		$transsetting = MerriGoRoundSettings::model()->findAllByAttributes(array('space_id' => $this->getSpace()->id));
		elseif($transid==TransactionDetail::LOAN_TRAN)
		$transsetting = LoanSettings::model()->findAllByAttributes(array('space_id' => $this->getSpace()->id));
		
		
	if($transid==TransactionDetail::SAVINGS_TRAN)
		{
			//deposit : price per share, money transfer method, contribution settings
			if ($trans_dir==1)
			{
				$shareData = $this->depositshare($setting);
				
				$model->type_unit=$shareData['id'];
				$model->type_subunit=$shareData['share_no'];
				$model->amount=$shareData['share_price']*$shareData['share_no'];
				$model->cash_gate=$shareData['transfer_method'];	
				
				//@todo create javasript to change amount on revision of  number of shares
			}
			//withdrawal : user shares' and income so you get available for withdrawal.
			elseif ($trans_dir==2)
			{
				//@todo add the member to to diplay on the function
				if (!isset($member)){
					$this->redirect(array('//space/mlist/sellshare','sguid'=>$space->guid));
				} 
				elseif (isset($member)) {
					$shareData = $this->withdrawshare($member,$setting);
					
					$model->related_user_id=$shareData['memberid'];
					if (isset($shareData['setting'])) {
						$model->trans_type_id=$shareData['setting'];
						$model->cash_gate=$shareData['cash_gate'];
						$model->type_subunit=$shareData['sharenetNo'];
						$model->amount=$shareData['sumsharenet'];
					}					
				}				
			}
			$this->render('contribution',array(
				'model'=>$model,
				'membership'=>$membership,
				'space' => $space,
				'transsetting'=>$transsetting,
				'cashrecipient'=>$cashrecipient,
				'shareData'=>$shareData,				
			)); 
		}
	
	elseif($transid==TransactionDetail::MGR_TRAN)
		{
			if (isset($setting)){
				$mgrIdRoundCycle=$this->mgrIdRoundCycle($setting);	
				if ($mgrIdRoundCycle['trans_dir']==1) {
					$model->amount=$mgrIdRoundCycle['depositamount'];
					$model->cash_gate=$mgrIdRoundCycle['cash_gate'];
				}
			}
			elseif (!isset($setting)) {
				$mgrIdSetting=$this->mgrIdSetting();				
				$this->mgrIdRoundCycle($mgrIdSetting);				
			} 
				
		$this->render('merrygoround',array(
			'model'=>$model,
			'membership'=>$membership,
			'space' => $space,
			'mgrIdRoundCycle'=>$mgrIdRoundCycle,
			'transsetting'=>$transsetting,
			'setting'=>$setting,
		)); }
	elseif($transid==TransactionDetail::LOAN_TRAN)
		{
			$this->getSpace()->isSimba();
			
			if ($trans_dir==1) {
				$loanData=$this->issueloan($setting);
				$model->amount=$loanData['amount'];
			}
			elseif ($trans_dir=2){
				$loanData=$this->payloan($member,$setting);
				if ($loanData['trans_dir']==2) {
					$model->amount=$loanData['activeloans']['totalDebt'];
					$model->cash_gate=$loanData['activeloans']['cash_gate'];
				}		
				
			}
			
		$this->render('loan',array(
			'model'=>$model,
			'membership'=>$membership,
			'space' => $space,
			'transsetting'=>$transsetting,
			'loanData'=>$loanData,
		)); }
	}
	
	public function loadtransactions($accid,$type,$type_unit=null, $type_subunit=null){
		
		if (!isset($type_unit) && !isset($type_subunit)) {
			$TransactionDetails = TransactionDetail::model()->findAllByAttributes(array('account_id'=>$accid, 'type'=>$type, 'space_id'=>Yii::app()->getController()->getSpace()->id));
		}
		else{
			$TransactionDetails = TransactionDetail::model()->findAllByAttributes(array('type_unit'=>$type_unit,'type_subunit'=>$type_subunit,'account_id'=>$accid,'type'=>$type,'space_id'=>Yii::app()->getController()->getSpace()->id));
		}
		
		//$transaction= 2 ;
		return $TransactionDetails;
	}
	
	public function loadmoney($accid,$type,$type_unit=null, $type_subunit=null){
	
		if (!isset($type_unit) && !isset($type_subunit)) {
			$TransactionDetails = TransactionDetail::model()->findAllByAttributes(array('primary_catchup'=>$accid, 'type'=>$type, 'space_id'=>Yii::app()->getController()->getSpace()->id));
		}
		else{
			$TransactionDetails = TransactionDetail::model()->findAllByAttributes(array('type_unit'=>$type_unit,'type_subunit'=>$type_subunit,'primary_catchup'=>$accid,'type'=>$type,'space_id'=>Yii::app()->getController()->getSpace()->id));
		}
	
		//$transaction= 2 ;
		return $TransactionDetails;
	}
	
	
	public function individualLoadTransactions($accid,$type,$userId,$type_unit=null, $type_subunit=null){
	
		if (!isset($type_unit) && !isset($type_subunit)) {
			$TransactionDetails = TransactionDetail::model()->findAllByAttributes(array('account_id'=>$accid, 'type'=>$type,'related_user_id'=>$userId,'space_id'=>Yii::app()->getController()->getSpace()->id));
		}
		else{
			$TransactionDetails = TransactionDetail::model()->findAllByAttributes(array('type_unit'=>$type_unit,'related_user_id'=>$userId,'type_subunit'=>$type_subunit,'account_id'=>$accid,'type'=>$type,'space_id'=>Yii::app()->getController()->getSpace()->id));
		}
	
		//$transaction= 2 ;
		return $TransactionDetails;
	}
	
	public function addshares($transarray){
		if (isset($transarray))
		{
			$index=count($transarray);
			$transactionssum=0;
			for ($i = 0; $i < $index; $i++) {
				$transactionssum+=$transarray[$i]->type_subunit;
			}
			return $transactionssum;
		}
	}
	
	public function addtransactions($transarray){
	if (isset($transarray)) 
		{
		$index=count($transarray);
		$transactionssum=0;
		for ($i = 0; $i < $index; $i++) {
			$transactionssum+=$transarray[$i]->amount;
		}
		return $transactionssum;
		}			
	}
	
	public function actionReport($userId=0)
	{		
		$space = Yii::app()->getController()->getSpace();
		if ($userId!=0) {
			if ($userId==0 || !$space->isAdmin())
				$userId = Yii::app()->user->id;
			//savings report : deposits - withdrawals = net savings
			//@done savings deposits management
			//@todo interest, pealties, income & expences: monthly graph on previous period
			$data['savingDeposit']= $this->individualLoadTransactions(23,'Cr',$userId);
			$data['savingDepositsum']=$this->addtransactions($data['savingDeposit']);
			$data['savingWithdrawal']= $this->individualLoadTransactions(23,'Dr',$userId);
			$data['savingWithdrawalsum']=$this->addtransactions($data['savingWithdrawal']);
			
			//Loan report : (loans issue + interests attracted) - loan repayments = outstanding loans
			//@todo interest managment: loan interest increase->account26(Loan), Dr; accountInterest, Cr
			$data['loanIssue']= $this->individualLoadTransactions(28,'Dr',$userId);
			$data['loanIssuesum']=$this->addtransactions($data['loanIssue']);
			//@todo $loanInterest= loadtransactions($accid,$type);
			$data['loanRepayment']= $this->individualLoadTransactions(28,'Cr',$userId);
			$data['loanRepaymentsum']=$this->addtransactions($data['loanRepayment']);
			
			//Merry go round : contributions-issues = remaining
			//@todo bal of previous round and cycle with graph
			$data['merygoroundContribution']= $this->individualLoadTransactions(25,'Cr',$userId);
			$data['mgrContributionsum']=$this->addtransactions($data['merygoroundContribution']);
			$data['merygoroundIssue']= $this->individualLoadTransactions(25,'Dr',$userId);
			$data['mgrIssuesum']=$this->addtransactions($data['merygoroundIssue']);
			
			//merry go round - (total transactions: No of cycles and rounds)(current cycles & round, balance on current pool);
			
			//count total cycles and rounds
			//$data['mgrTotalCycles']=MgrCycle::model()->countByAttributes(array('space'=>$space->id));
			//$data['mgrTotalRounds']=MgrRound::model()->countByAttributes(array('space_id'=>$space->id));
			
			//calculate balances of current cycle & round
			//No. of rounds done in current cycle,
			//$MgrCycledata=MgrCycle::model()->findByAttributes(array('space'=>$space->id,'cycle_status'=>1));
			//MgrCycle::model()->
			//total cycle deposits
			//total issues
			//total rounds in current cycle
			//No. remaining rounds.
			
			//total deposits on current active round
			//remaining deposits to close round
			
			//money - cash
			//@todo money periodic graphs
			
			$cashDeposit= $this->individualLoadTransactions(20,'Dr',$userId);
			$cashDepositsum=$this->addtransactions($cashDeposit);
			$cashWithdrawal= $this->individualLoadTransactions(20,'Cr',$userId);
			$cashWithdrawalsum=$this->addtransactions($cashWithdrawal);
			$data['cash']=$cashDepositsum-$cashWithdrawalsum;
			
			//money - bank
			$bankDeposit= $this->individualLoadTransactions(22,'Dr',$userId);
			$bankDepositsum=$this->addtransactions($bankDeposit);
			$bankWithdrawal= $this->individualLoadTransactions(22,'Cr',$userId);
			$bankWithdrawalsum=$this->addtransactions($bankWithdrawal);
			$data['bank']=$bankDepositsum-$bankWithdrawalsum;
			
			//money - mobile
			$mobileDeposit= $this->individualLoadTransactions(21,'Dr',$userId);
			$mobileDepositsum=$this->addtransactions($mobileDeposit);
			$mobileWithdrawal= $this->individualLoadTransactions(21,'Cr',$userId);
			$mobileWithdrawalsum=$this->addtransactions($mobileWithdrawal);
			$data['mobile']=$mobileDepositsum-$mobileWithdrawalsum;
			
			
			//$this->redirect(array('view','id'=>$model->id,'sguid' => $space->guid));
			
			$rUser=User::model()->findByAttributes(array('id'=>$userId));
			$data['username'] = $rUser['username'];
			
			
			$this->render('individualReport',array(
					'data'=>$data,
					'space'=>$space,
			));
		}	
	else
		{
			//savings report : deposits - withdrawals = net savings
			//@done savings deposits management
			//@todo interest, pealties, income & expences: monthly graph on previous period
			$data['savingDeposit']= $this->loadtransactions(23,'Cr');
			$data['savingDepositsum']=$this->addtransactions($data['savingDeposit']);
			$data['savingWithdrawal']= $this->loadtransactions(23,'Dr');
			$data['savingWithdrawalsum']=$this->addtransactions($data['savingWithdrawal']);
			
			//Loan report : (loans issue + interests attracted) - loan repayments = outstanding loans
			//@todo interest managment: loan interest increase->account26(Loan), Dr; accountInterest, Cr
			$data['loanIssue']= $this->loadtransactions(28,'Dr');
			$data['loanIssuesum']=$this->addtransactions($data['loanIssue']);
			//@todo $loanInterest= loadtransactions($accid,$type);
			$data['loanRepayment']= $this->loadtransactions(28,'Cr');
			$data['loanRepaymentsum']=$this->addtransactions($data['loanRepayment']);
			
			//Merry go round : contributions-issues = remaining
			//@todo bal of previous round and cycle with graph
			$data['merygoroundContribution']= $this->loadtransactions(25,'Cr');
			$data['mgrContributionsum']=$this->addtransactions($data['merygoroundContribution']);
			$data['merygoroundIssue']= $this->loadtransactions(25,'Dr');
			$data['mgrIssuesum']=$this->addtransactions($data['merygoroundIssue']);
			
			//merry go round - (total transactions: No of cycles and rounds)(current cycles & round, balance on current pool);
			
			//count total cycles and rounds
			$data['mgrTotalCycles']=MgrCycle::model()->countByAttributes(array('space'=>$space->id));
			$data['mgrTotalRounds']=MgrRound::model()->countByAttributes(array('space_id'=>$space->id));
			
			//calculate balances of current cycle & round
			//No. of rounds done in current cycle,
			$MgrCycledata=MgrCycle::model()->findByAttributes(array('space'=>$space->id,'cycle_status'=>1));
			//MgrCycle::model()->
			//total cycle deposits
			//total issues
			//total rounds in current cycle
			//No. remaining rounds.
			
			//total deposits on current active round
			//remaining deposits to close round
			
			//money - cash
			//@todo money periodic graphs
			
			$cashDeposit= $this->loadmoney(20,'Cr');
			$cashDepositsum=$this->addtransactions($cashDeposit);
			$cashWithdrawal= $this->loadmoney(20,'Dr');
			$cashWithdrawalsum=$this->addtransactions($cashWithdrawal);
			$data['cash']=$cashDepositsum-$cashWithdrawalsum;
			
			//money - bank
			$bankDeposit= $this->loadmoney(22,'Cr');
			$bankDepositsum=$this->addtransactions($bankDeposit);
			$bankWithdrawal= $this->loadtransactions(22,'Dr');
			$bankWithdrawalsum=$this->addtransactions($bankWithdrawal);
			$data['bank']=$bankDepositsum-$bankWithdrawalsum;
			
			//money - mobile
			$mobileDeposit= $this->loadmoney(21,'Cr');
			$mobileDepositsum=$this->addtransactions($mobileDeposit);
			$mobileWithdrawal= $this->loadmoney(21,'Dr');
			$mobileWithdrawalsum=$this->addtransactions($mobileWithdrawal);
			$data['mobile']=$mobileDepositsum-$mobileWithdrawalsum;
			
			
			//$this->redirect(array('view','id'=>$model->id,'sguid' => $space->guid));
			
			
			$this->render('report',array(
				'data'=>$data,
				'space'=>$space,
			));
		}	
	}
	
	public function adminOnly()
	{
		if (!$this->getSpace()->isAdmin())
			throw new CHttpException(403, 'Access denied - Contact your  SACCO admin.');
	}	
		
}