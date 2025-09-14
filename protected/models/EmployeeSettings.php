<?php
class EmployeeSettings extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'employee_settings';
    }

    public function rules()
    {
        return [
            ['employee_id, service_duration', 'required'],
            ['employee_id, service_duration', 'numerical', 'integerOnly'=>true],
        ];
    }

    // Define relations if needed
    public function relations()
    {
        return [
            'employee' => [self::BELONGS_TO, 'Employee', 'employee_id'],
        ];
    }
}
