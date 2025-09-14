<?php
class EmployeeAvailabilitySlot extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'employee_availability_slots';
    }

    public function rules()
    {
        return [
            ['availability_id, from_time, to_time', 'required'],
            ['availability_id', 'numerical', 'integerOnly'=>true],
            ['from_time, to_time', 'safe'], // format validation can be added if needed
        ];
    }

    public function relations()
    {
        return [
            'availability' => [self::BELONGS_TO, 'EmployeeAvailability', 'availability_id'],
        ];
    }
}
