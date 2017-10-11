<?php

/**
 * This is the model class for table "sp1_account".
 *
 * The followings are the available columns in table 'sp1_account':
 * @property integer $id
 * @property string $name
 * @property string $parent_id
 * @property string $Type
 * @property integer $space_individualtype
 * @property integer $system_user
 * @property integer $space_id
 * @property integer $related_user_id
 *
 * The followings are the available model relations:
 * @property Space $space
 * @property User $relatedUser
 * @property Bank[] $banks
 * @property MobileMoney[] $mobileMoneys
 * @property TransactionDetail[] $transactionDetails
 */
class Account extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sp1_account';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, Type, space_individualtype', 'required'),
			array('space_individualtype, system_user, space_id, related_user_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>32),
			array('parent_id', 'length', 'max'=>20),
			array('Type', 'length', 'max'=>9),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, parent_id, Type, space_individualtype, system_user, space_id, related_user_id', 'safe', 'on'=>'search'),
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
			'space' => array(self::BELONGS_TO, 'Space', 'space_id'),
			'relatedUser' => array(self::BELONGS_TO, 'User', 'related_user_id'),
			'banks' => array(self::HAS_MANY, 'Bank', 'gl_account'),
			'mobileMoneys' => array(self::HAS_MANY, 'MobileMoney', 'gl_account'),
			'transactionDetails' => array(self::HAS_MANY, 'TransactionDetail', 'account_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Account name',
			'parent_id' => 'Parent Account id',
			'Type' => 'Account type on the GL',
			'space_individualtype' => 'what type of account is this for /1. space /2 individual in a space',
			'system_user' => 'access level 1. system only can modify, 2. user can modify',
			'space_id' => 'Space',
			'related_user_id' => 'if individual account whos does this belong to.',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('parent_id',$this->parent_id,true);
		$criteria->compare('Type',$this->Type,true);
		$criteria->compare('space_individualtype',$this->space_individualtype);
		$criteria->compare('system_user',$this->system_user);
		$criteria->compare('space_id',$this->space_id);
		$criteria->compare('related_user_id',$this->related_user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Account the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
