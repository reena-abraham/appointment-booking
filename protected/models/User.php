<?php
class User extends CActiveRecord
{

    public $category;        // for provider role


    public $current_password;
    public $new_password;
    public $confirm_password;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return array(
            array('name, email, password,role', 'required'),
            array('email', 'email'),
            array('email', 'unique'),
            array('password', 'length', 'min' => 6),
            array('category, ', 'safe'), // for provider fields

            array('current_password, new_password, confirm_password', 'required', 'on' => 'changePassword'),
			array('new_password', 'length', 'min' => 6, 'on' => 'changePassword'),
			array('confirm_password', 'compare', 'compareAttribute' => 'new_password', 'message' => 'Passwords do not match.', 'on' => 'changePassword'),
        );        
    }
    public function relations()
    {
        return array(
            'employee' => array(self::HAS_ONE, 'Employee', 'user_id'),
            'appointments' => array(self::HAS_MANY, 'Appointment', 'user_id'),
        );
    }
    public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);

		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    public function getAllUsers()
    {
        // Create a CDbCriteria instance
        $criteria = new CDbCriteria;
         $criteria->condition = "role != 'admin'";

        // Optionally, add any conditions here (e.g., ordering by name)
        $criteria->order = 'created_at DESC';  // Example: Order by name

        // Return CActiveDataProvider with pagination and criteria
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria, // Apply criteria for sorting or filtering (if any)
            'pagination' => array(
                'pageSize' => 20, // Number of records per page
            ),
        ));
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->created_at = new CDbExpression('NOW()');
        }

        $this->updated_at = new CDbExpression('NOW()');
        return parent::beforeSave();
    }
}
