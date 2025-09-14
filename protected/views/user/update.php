<?php
/* @var $this Categoryontroller */
/* @var $model Category */

$this->pageTitle = 'Update User';
$this->breadcrumbs = array(
    'User' => array('index'),
    'Update',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>