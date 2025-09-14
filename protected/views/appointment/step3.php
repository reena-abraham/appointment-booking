<?php
$currentStep = 3;
$steps = [
    1 => 'Step1',
    2 => 'Step2',
    3 => 'Step3',
    4 => 'Step4',
    5 => 'Step5',
];
?>

<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-lg">

    <!-- Step Indicator -->
    <div class="flex items-center justify-center mb-10">
        <ol class="flex items-center w-full max-w-3xl space-x-4 text-sm text-gray-500 sm:space-x-6">
            <?php foreach ($steps as $stepNumber => $stepLabel): ?>
                <li class="flex items-center <?php echo $stepNumber === $currentStep ? 'text-blue-600 font-medium' : ($stepNumber < $currentStep ? 'text-green-600 line-through' : 'text-gray-400'); ?>">
                    <span class="flex items-center justify-center w-8 h-8 border <?php echo $stepNumber <= $currentStep ? 'border-blue-600 bg-blue-600 text-white' : 'border-gray-300'; ?> rounded-full mr-2">
                        <?php echo $stepNumber; ?>
                    </span>
                    <?php echo CHtml::encode($stepLabel); ?>
                </li>

                <?php if ($stepNumber < count($steps)): ?>
                    <li class="flex-1 border-t-2 <?php echo $stepNumber < $currentStep ? 'border-green-600' : ($stepNumber === $currentStep ? 'border-blue-600' : 'border-gray-300'); ?>"></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ol>
    </div>

    <!-- Page Title -->
    <h2 class="text-3xl font-semibold text-gray-800 mb-8 text-center">Select a Staff Member</h2>

    <!-- Staff Selection Form -->
    <form method="POST" action="<?php echo $this->createUrl('appointment/step4'); ?>" id="staffForm">
        <!-- Hidden input to store selected staff ID -->
        <input type="hidden" name="staff" id="selectedStaffId" value="">

        <!-- Staff Options -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <?php foreach ($staff as $member): ?>
                <div class="staff-option cursor-pointer border p-6 rounded-lg hover:bg-blue-100 transition-all text-center font-bold text-gray-800 shadow-md hover:shadow-lg"
                    data-id="<?php echo $member->user_id; ?>">
                    <div class="flex items-center justify-center mb-3">
                        <img src="<?php echo CHtml::encode(Yii::app()->baseUrl . '/images/user.png'); ?>"
                            alt="<?php echo CHtml::encode($member->user->name); ?>"
                            class="w-16 h-16 rounded-full object-cover border border-gray-300 shadow-sm" />
                    </div>
                    <h3 class="text-xl font-semibold"><?php echo CHtml::encode($member->user->name); ?></h3>
                    <!-- <p class="text-sm text-gray-500">Position / Title if needed</p> -->
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Navigation Buttons -->
        <div class="text-center">
            <button type="submit"
                id="nextBtn"
                class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md disabled:opacity-50 hover:bg-blue-700 focus:outline-none transition-all"
                disabled>
                Next →
            </button>
        </div>
    </form>
</div>

<!-- JS to handle selection -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.staff-option').on('click', function() {
            // Remove selection from all

            $('.service-option').removeClass('bg-teal-200');

            // Highlight selected
            // $(this).addClass('bg-blue-200 border-blue-600');
            $(this).addClass('bg-teal-200');

            // Set hidden input
            $('#selectedStaffId').val($(this).data('id'));

            // Enable the Next button
            $('#nextBtn').prop('disabled', false);
        });
    });
</script>