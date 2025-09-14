<?php
class Employee extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'employees';
    }

    public function rules()
    {
        return array(
            array('user_id, category_id', 'required'),
            array('user_id, category_id', 'numerical', 'integerOnly' => true),
        );
    }

    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),  // Added relation for category
             'services' => array(self::MANY_MANY, 'ServiceType', 'employee_services(employee_id, service_id)', 'joinType' => 'LEFT JOIN'),

        );
    }
}
