<?php
$currentStep = 1;
$steps = [
    1 => 'Step1',
    2 => 'Step2',
    3 => 'Step3',
    4 => 'Step4',
    5 => 'Stp5',
];


?>

<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-lg">

    <!-- Step Indicator -->
    <div class="flex items-center justify-center mb-10">
        <ol class="flex items-center w-full max-w-3xl space-x-4 text-sm text-gray-500 sm:space-x-6">
            <?php foreach ($steps as $stepNumber => $stepLabel): ?>
                <!-- Step Item -->
                <li class="flex items-center <?php echo $stepNumber === $currentStep ? 'text-blue-600 font-medium' : ($stepNumber < $currentStep ? 'text-green-600 line-through' : 'text-gray-400'); ?>">
                    <span class="flex items-center justify-center w-8 h-8 border <?php echo $stepNumber <= $currentStep ? 'border-blue-600 bg-blue-600 text-white' : 'border-gray-300'; ?> rounded-full mr-2">
                        <?php echo $stepNumber; ?>
                    </span>
                    <?php echo CHtml::encode($stepLabel); ?>
                </li>

                <!-- Divider except after last -->
                <?php if ($stepNumber < count($steps)): ?>
                    <li class="flex-1 border-t-2 <?php echo $stepNumber < $currentStep ? 'border-green-600' : ($stepNumber === $currentStep ? 'border-blue-600' : 'border-gray-300'); ?>"></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ol>
    </div>

    <!-- Step Title -->
    <h2 class="text-3xl font-semibold text-gray-800 mb-8 text-center">Select a Category</h2>

    <!-- Category Form -->
    <form id="category-form" method="POST" action="<?php echo Yii::app()->createUrl('appointment/step2'); ?>">
        <!-- Hidden input to store selected category ID -->
        <input type="hidden" name="category" id="selectedCategoryId" />

        <div class="grid grid-cols-2 gap-6 mb-8">
            <?php foreach ($categories as $category): ?>
                <?php
                $categoryImage = !empty($category->image)
                    ? Yii::app()->baseUrl . '/uploads/categories/' . CHtml::encode($category->image)
                    : Yii::app()->baseUrl . '/images/default.png'; // <-- Default image path

                ?>
                <div
                    class="cursor-pointer border p-6 rounded-lg hover:bg-teal-100 transition-all text-center font-bold text-lg text-gray-800 shadow-md hover:shadow-lg category-option"
                    data-id="<?php echo $category->id; ?>">

                    <!-- Category Image -->
                    <img src="<?php echo $categoryImage; ?>" alt="<?php echo CHtml::encode($category->name); ?>" class="w-16 h-16 mx-auto mb-4 rounded-full">

                    <!-- Category Name -->
                    <span class="block text-xl"><?php echo CHtml::encode($category->name); ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Next Button -->
        <button type="submit" id="nextBtn" class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md disabled:opacity-50 hover:bg-blue-700 focus:outline-none transition-all" disabled>
            Next →
        </button>
    </form>
</div>

<!-- JS to select category and enable next -->
<script>
    $(document).ready(function() {
        $('.category-option').on('click', function() {
            // Remove highlight from all
            $('.category-option').removeClass('bg-teal-200');

            // Highlight the selected one
            $(this).addClass('bg-teal-200');

            // Set value in hidden input
            const categoryId = $(this).data('id');
            $('#selectedCategoryId').val(categoryId);

            // Enable the Next button
            $('#nextBtn').prop('disabled', false);
        });
    });
</script>