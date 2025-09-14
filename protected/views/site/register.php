<?php
/* @var $this SiteController */
/* @var $model UserSignupForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - Signup';
?>





<main class="bg-gray-50 ">
    <div class="mx-auto md:h-screen flex flex-col justify-center items-center px-6 pt-8 pt:mt-0">
        <!-- Logo + Title -->


        <!-- Card -->
        <div class="bg-white shadow rounded-lg md:mt-0 w-full sm:max-w-screen-sm xl:p-0">
            <div class="p-6 sm:p-8 lg:p-16 space-y-8">
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 text-center">
                    Sign in
                </h2>

                <?php $form = $this->beginWidget('CActiveForm', [
                    'id' => 'register-form',
                    'enableClientValidation' => true,
                    'clientOptions' => ['validateOnSubmit' => true],
                    'htmlOptions' => ['class' => 'mt-8 space-y-6'],
                ]); ?>

                <div>
                    <?php echo $form->labelEx($user, 'name', ['class' => 'text-sm font-medium text-gray-900 block mb-2']); ?>
                    <?php echo $form->textField($user, 'name', [
                        'class' => 'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5',
                        'placeholder' => 'Enter name',
                    ]); ?>
                    <?php echo $form->error($user, 'name', ['class' => 'text-red-600 text-sm mt-1']); ?>
                </div>

                <div>
                    <?php echo $form->labelEx($user, 'email', ['class' => 'text-sm font-medium text-gray-900 block mb-2']); ?>
                    <?php echo $form->textField($user, 'email', [
                        'class' => 'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5',
                        'placeholder' => 'Enter email',
                    ]); ?>
                    <?php echo $form->error($user, 'email', ['class' => 'text-red-600 text-sm mt-1']); ?>
                </div>



                <div>
                    <?php echo $form->labelEx($user, 'password', ['class' => 'text-sm font-medium text-gray-900 block mb-2']); ?>
                    <?php echo $form->passwordField($user, 'password', [
                        'class' => 'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5',
                        'placeholder' => '••••••••',
                    ]); ?>
                    <?php echo $form->error($user, 'password', ['class' => 'text-red-600 text-sm mt-1']); ?>
                </div>
                <div class="mb-4">
                    <?php echo $form->labelEx($user, 'role', ['class' => 'block text-sm font-medium text-gray-700 mb-1']); ?>
                    <?php echo $form->dropDownList($user, 'role', [
                        'customer' => 'Customer',
                        'employee' => 'Employee'
                    ], [
                        'prompt' => 'Select Role',
                        'class' => 'w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300'
                    ]); ?>
                </div>

                <div id="employee-fields" class="mb-4 hidden">
                    <?php echo $form->labelEx($employee, 'category_id', ['class' => 'block text-sm font-medium text-gray-700 mb-1']); ?>
                    <?php echo $form->dropDownList(
                        $employee,
                        'category_id',
                        CHtml::listData(Category::model()->findAll(), 'id', 'name'),
                        [
                            'prompt' => 'Select Category',
                            'class' => 'w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300'
                        ]
                    ); ?>
                </div>





                <button type="submit" class="w-full sm:w-auto text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-base px-5 py-3 text-center">
                    Register
                </button>

                <div class="text-sm font-medium text-gray-500 text-center">
                    Already have an account? <a href="<?php echo Yii::app()->createUrl('site/login'); ?>" class="text-teal-500 hover:underline">Login Here</a>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleDropdown = document.getElementById('<?php echo CHtml::activeId($user, "role"); ?>');
        const providerFields = document.getElementById('employee-fields');

        function toggleProviderFields() {
            if (roleDropdown.value === 'employee') {
                providerFields.classList.remove('hidden');
            } else {
                providerFields.classList.add('hidden');
            }
        }

        // Initial toggle on page load
        toggleProviderFields();

        // Listen for changes on role dropdown
        roleDropdown.addEventListener('change', toggleProviderFields);
    });
</script>