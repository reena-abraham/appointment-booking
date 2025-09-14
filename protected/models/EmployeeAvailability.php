<?php

class EmployeeAvailability extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     */
    // public $slots = [];
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'employee_availability';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['employee_id, day', 'required'],
            ['employee_id', 'numerical', 'integerOnly'=>true],
            ['day', 'in', 'range'=>['monday','tuesday','wednesday','thursday','friday','saturday','sunday']],
            ['enabled', 'boolean'],
            ['enabled,created_at, updated_at', 'safe'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'slots' => [self::HAS_MANY, 'EmployeeAvailabilitySlot', 'availability_id'],
            'employee' => [self::BELONGS_TO, 'Employee', 'employee_id'],
        ];
    }
    public function getByStaffAndDay($staffId, $day)
    {
        return self::model()->with('slots')->findByAttributes([
            'employee_id' => $staffId,
            'day' => strtolower($day),
            'enabled' => 1,
        ]);
    }
}
