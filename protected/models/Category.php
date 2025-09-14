<?php
class Category extends CActiveRecord
{
    public function tableName()
    {
        return 'categories';
    }
    public function rules()
    {
        return array(
            // Other validation rules for category_name, etc.
            array('name', 'required'),
            array('image', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),  // Validate image upload
            // Additional validation rules...
            array('description', 'safe'),
        );
    }

    // The attribute labels method to label your fields
    public function attributeLabels()
    {
        return array(
            'name' => 'Category Name',
            'description' => 'Category Description',
            'image' => 'Category Image',  // Add a label for the image field
        );
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    public function getAllCategory()
    {
        // Create a CDbCriteria instance
        $criteria = new CDbCriteria;

        // Optionally, add any conditions here (e.g., ordering by name)
        $criteria->order = 'id ASC';  // Example: Order by name

        // Return CActiveDataProvider with pagination and criteria
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria, // Apply criteria for sorting or filtering (if any)
            'pagination' => array(
                'pageSize' => 20, // Number of records per page
            ),
        ));
    }
    public function saveCategoryImage()
    {
        if ($this->image && $this->validate()) {
            // Directory where you want to store the image
            $directory = Yii::getPathOfAlias('webroot.images.categories') . '/';

            // Ensure the directory exists
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            // Define the file path and save the image
            $imageName = time() . '.' . $this->image->extensionName;  // Use timestamp to avoid name conflicts
            $imagePath = $directory . $imageName;

            if ($this->image->saveAs($imagePath)) {
                $this->image_path = '/images/categories/' . $imageName;  // Save the relative path in the database
            }
        }
    }
}
