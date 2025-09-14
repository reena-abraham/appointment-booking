<?php

/**
 * This is the model class for table "designation".
 *
 * The followings are the available columns in table 'designation':
 * @property integer $id
 * @property string $title
 * @property integer $department_id
 *
 * The followings are the available model relations:
 * @property Department $department
 * @property Employee[] $employees
 */
class ServiceType extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'service_type';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('category_id, name, price', 'required'),
            array('category_id','numerical', 'integerOnly' => true),
            array('price', 'numerical'),
            array('name', 'length', 'max' => 100),
            array('description', 'safe'),
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
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
            'employees' => array(self::MANY_MANY, 'Employee', 'employee_services(service_id, employee_id)'),

        );
    }
    

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
        	'id' => 'ID',
        	'name' => 'Service Name',
        	'category_id' => 'Category',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('category_id', $this->category_id);

        $criteria->order = 'name ASC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10, // Adjust as needed
            ),

        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Designation the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    // protected function beforeSave()
    // {
    //     if ($this->isNewRecord) {
    //         // Set created_at only when the record is being created
    //         $this->created_at = new CDbExpression('NOW()');
    //     }

    //     // Always update updated_at on save
    //     $this->updated_at = new CDbExpression('NOW()');

    //     return parent::beforeSave();
    // }
}
