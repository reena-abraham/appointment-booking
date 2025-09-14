<?php
class Appointment extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'appointment';
    }

    public function rules()
    {
        return array(
            array('user_id, category_id, service_id, staff_id, appointment_date, appointment_time, price', 'required'),
            array('duration_minutes', 'numerical', 'integerOnly' => true),
            array('price', 'numerical'),
            array('notes', 'safe'),
        );
    }

    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
            'service' => array(self::BELONGS_TO, 'ServiceType', 'service_id'),
            'staff' => array(self::BELONGS_TO, 'Employee', 'staff_id'),

        );
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
