<?php

/**
 * This is the model class for table "sp1_transaction_detail".
 *
 * The followings are the available columns in table 'sp1_transaction_detail':
 * @property string $id
 * @property integer $transaction_id
 * @property integer $account_id
 * @property string $type
 * @property integer $amount
 * @property integer trans_setting_type
 * @property integer trans_type_id
 *
 * The followings are the available model relations:
 * @property Account $account
 * @property Transaction $transaction
 */
class TransactionDetail extends HActiveRecordContent
{
	/**
	 * @return string the associated database table name
	 */
	const SAVINGS_TRAN=1;
	const MGR_TRAN=2;
	const LOAN_TRAN=3;
	public $transaction_direction='';
	public $cash_gate='';
	public $share_price='';
	public $created_by;
	public $title="Accounting"; 
	const SAVINGS_AC_ID=23;
	const SAVINGS_DEPOSITS='Cr';
	const SAVINGS_WITHDRAWAL='Dr';
	
	const MGR_AC_ID=25;
	const MGR_CONTRIBUTION='Cr';
	const MGR_ISSUE='Dr';
	
	const LOAN_AC_ID=28;
	const LOAN_ISSUE='Cr';
	const LOAN_PAYMENT='Dr';
		
	public function tableName()
	{
		return 'sp1_transaction_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cash_gate,account_id, type, amount,trans_setting_type,trans_type_id,related_user_id,type_unit,type_subunit', 'required'),
			array(' account_id, related_user_id, amount', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>6),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, transaction_id, account_id, type, amount', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
			//'transaction' => array(self::BELONGS_TO, 'Transaction', 'transaction_id'),
			'ContributionSettings' => array(self::BELONGS_TO, 'ContributionSettings', 'trans_type_id'),
			'space'=>array(self::BELONGS_TO,'space','space_id'),
			'creator'=>array(self::BELONGS_TO, 'user','user_id'),
			'relatedUser'=>array(self::BELONGS_TO, 'user', 'related_user_id'),
			//'Cash' => array(self::BELONGS_TO, 'Cash', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'transaction_id' => 'Transaction',
			'account_id' => 'Account',
			'type' => 'Type',
			'amount' => 'Amount',
			'trans_setting_type'=>'Transaction type',
	        'trans_type_id'=>'Select transaction',
			'related_user_id'=>'Member',
			//'gate_cash'=>'Money transfer method',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('transaction_id',$this->transaction_id);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('cash_gate',$this->amount);
		//$criteria->compare('transaction.relatedUser.username',$this->transaction->relatedUser->username,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TransactionDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function afterSave()
	{		
		if ($this->isNewRecord) {
			
			$activity = Activity::CreateForContent($this);
		    $activity->type = "TransactiondetailCreated";
		    $activity->module = "accounting";
		    $activity->save();
		    $activity->fire();
			
		}
		$this->walltransactionpostNotification();
	
		return parent::afterSave();
	}
	public function getContentTitle()
	{
		return "Transaction";
	}
	public function beforeValidate()
	{		
		
		if (!isset($this->content->space_id)) {
			$this->content->space_id=$this->space_id;
		}
		return true;		
	}
	public function getWallOut()
	{
		return Yii::app()->getController()->renderPartial('application.modules.accounting.views.activities.TransactiondetailCreate',array('Transactiondetail'=>$this),true);
	}
			
	public function walltransactionpostNotification(){
		
	}
	
	public function beforeSave(){
		if ($this->isNewRecord){
			$this->created_at= new CDbExpression('NOW()');
			$this->updated_at= new CDbExpression('NOW()');
		}
		else
			$this->updated_at= new CDbExpression('NOW()');
			
		
		return parent::beforeSave();
	}
	
}
