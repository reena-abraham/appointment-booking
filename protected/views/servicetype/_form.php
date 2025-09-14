<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow mt-2">
    <div class="flex justify-between items-center mb-6">
        <nav class="text-sm text-gray-500">
            <a href="<?php echo $this->createUrl('admin/dashboard'); ?>" class="hover:underline">Home</a> &gt; 
            <a href="<?php echo $this->createUrl('servicetype/admin'); ?>" class="hover:underline">Service Type</a> &gt; 
            <span><?php echo $model->isNewRecord ? 'Add Service Type' : 'Edit Service Type'; ?></span>
        </nav>
    </div>

    <h2 class="text-2xl font-bold mb-6">
        <?php echo $model->isNewRecord ? 'Add Service Type' : 'Edit Service Type'; ?>
    </h2>

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'servicetype-form',
        'enableAjaxValidation' => false,
    )); ?>

    <!-- <p class="note mb-4 text-gray-600">Fields with <span class="required">*</span> are required.</p> -->

    <?php 
    // echo $form->errorSummary($model, ['class' => 'mb-4 text-red-600']); 
    ?>

    <div class="mb-4">
        <?php echo $form->labelEx($model, 'category_id', ['class' => 'block text-sm font-medium text-gray-700']); ?>
        <?php echo $form->dropDownList(
            $model,
            'category_id',
            CHtml::listData(Category::model()->findAll(), 'id', 'name'),
            ['prompt' => 'Select Category', 'class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm']
        ); ?>
        <?php echo $form->error($model, 'category_id', ['class' => 'text-red-600 text-sm mt-1']); ?>
    </div>

    <div class="mb-4">
        <?php echo $form->labelEx($model, 'name', ['class' => 'block text-sm font-medium text-gray-700']); ?>
        <?php echo $form->textField($model, 'name', ['size' => 60, 'maxlength' => 255, 'class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm']); ?>
        <?php echo $form->error($model, 'name', ['class' => 'text-red-600 text-sm mt-1']); ?>
    </div>
    <div class="mb-4">
  <?php echo $form->labelEx($model, 'description', [
      'class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white',
  ]); ?>

  <?php echo $form->textArea($model, 'description', [
      'rows' => 4,
      'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                 focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 
                 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white',
      'placeholder' => 'Write a short description of the service...',
  ]); ?>

  <?php echo $form->error($model, 'description', [
      'class' => 'text-sm text-red-600 mt-1',
  ]); ?>
</div>



<!-- Price -->
<div class="mb-4">
  <?php echo $form->labelEx($model, 'price', [
      'class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white',
  ]); ?>

  <?php echo $form->numberField($model, 'price', [
      'step' => '0.01',
      'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                  focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5
                  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white',
      'placeholder' => 'e.g. 49.99',
  ]); ?>

  <?php echo $form->error($model, 'price', [
      'class' => 'text-sm text-red-600 mt-1',
  ]); ?>
</div>
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class' => 'bg-cyan-600 hover:bg-cyan-700 text-white font-semibold py-2 px-6 rounded']); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>
