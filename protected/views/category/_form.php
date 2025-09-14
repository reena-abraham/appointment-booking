<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow mt-2">
    <div class="flex justify-between items-center mb-6">
        <nav class="text-sm text-gray-500">
            <a href="<?php echo $this->createUrl('admin/dashboard'); ?>" class="hover:underline">Home</a> &gt;
            <a href="<?php echo $this->createUrl('category/list'); ?>" class="hover:underline">Category</a> &gt;
            <span><?php echo $model->isNewRecord ? 'Add Category' : 'Edit Category'; ?></span>
        </nav>
    </div>

    <h2 class="text-2xl font-bold mb-10">
        <?php echo $model->isNewRecord ? 'Add Category' : 'Edit Category'; ?>
    </h2>

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'category-form',
        'enableAjaxValidation' => false,
        'action' => $model->isNewRecord
            ? $this->createUrl('Category/create')
            : $this->createUrl('Category/update', ['id' => $model->id]),
            'htmlOptions' => array('enctype' => 'multipart/form-data')
    )); ?>

    <?php
    // echo $form->errorSummary($model, null, null, [
    //     'class' => 'p-4 mb-6 text-sm text-red-800 bg-red-50 border border-red-300 rounded-lg'
    // ]);
    ?>





    <?php
    // echo $form->errorSummary($model); 
    ?>

    <div class="grid grid-cols-1 gap-6">
        <!-- Department Name Field -->
        <div class="mb-4">
            <?php echo $form->labelEx($model, 'name', ['class' => 'text-sm font-medium text-gray-900 block mb-2']); ?>
            <?php echo $form->textField($model, 'name', [
                'class' => 'form-input w-full border border-gray-300 rounded-lg p-2.5',
                'placeholder' => 'Enter category name',
            ]); ?>
            <?php echo $form->error($model, 'name', ['class' => 'text-red-600 text-sm mt-1']); ?>
        </div>
    </div>
    <div class="mb-4">
    <?php echo $form->labelEx($model, 'description', array('class' => 'block text-sm font-medium text-gray-700')); ?>
    <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50, 'class' => 'mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm')); ?>
    <?php echo $form->error($model, 'description', array('class' => 'text-red-500 text-xs italic')); ?>
</div>

<div class="mb-4">
    <?php echo $form->labelEx($model, 'image', array('class' => 'block text-sm font-medium text-gray-700')); ?>
    <?php echo $form->fileField($model, 'image', array('class' => 'mt-1 block w-full text-sm text-gray-500 file:border file:border-gray-300 file:rounded-md file:px-6 file:py-3 file:text-sm file:cursor-pointer focus:outline-none focus:ring-indigo-500 focus:border-indigo-500')); ?>
    <?php echo $form->error($model, 'image', array('class' => 'text-red-500 text-xs italic')); ?>
</div>

    <!-- Submit Button -->
    <div class="mt-4 flex justify-start">
        <?php echo CHtml::submitButton(
            $model->isNewRecord ? 'Create' : 'Save',
            ['class' => 'bg-cyan-600 hover:bg-cyan-700 text-white font-semibold py-2 px-6 rounded']
        ); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>