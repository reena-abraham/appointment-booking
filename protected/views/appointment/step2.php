
<?php
$currentStep = 2;
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
    <h2 class="text-3xl font-semibold text-gray-800 mb-8 text-center">Select a Service</h2>

    <!-- Service Form -->
    <form id="service-form" method="POST" action="<?php echo $this->createUrl('appointment/step3'); ?>">
        <input type="hidden" name="service" id="selectedServiceId" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <?php foreach ($services as $service): ?>
                <div class="cursor-pointer border p-6 rounded-lg hover:bg-blue-100 transition-all text-center font-bold text-gray-800 shadow-md hover:shadow-lg service-option" data-id="<?php echo $service->id; ?>">
                    <h3 class="text-xl font-semibold mb-2"><?php echo CHtml::encode($service->name); ?></h3>
                    <p class="text-gray-600 font-normal text-sm"><?php echo CHtml::encode($service->description); ?></p>
                    <p class="text-blue-600 font-semibold mt-3 text-lg">AED <?php echo number_format($service->price, 2); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Navigation Buttons -->
        <div class="text-center">
            <button type="submit" id="nextBtn" class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md disabled:opacity-50 hover:bg-blue-700 focus:outline-none transition-all" disabled>
                Next →
            </button>
        </div>
    </form>
</div>

<!-- jQuery (if not already included) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- JS to handle service selection -->
<script>
    $(document).ready(function () {
        $('.service-option').on('click', function () {
            // Remove selection highlight from all
            // $('.service-option').removeClass('bg-blue-200 border-blue-600');
$('.service-option').removeClass('bg-teal-200');

            // Highlight selected
            // $(this).addClass('bg-blue-200 border-blue-600');
 $(this).addClass('bg-teal-200');
            // Set hidden input
            $('#selectedServiceId').val($(this).data('id'));

            // Enable the Next button
            $('#nextBtn').prop('disabled', false);
        });
    });
</script>

<div class="max-w-4xl mx-auto my-8 p-6 bg-white shadow rounded" style="display: none;">
    <h2 class="text-xl font-semibold mb-4">Select a Service</h2>

    <form id="service-form" method="POST" action="<?php echo $this->createUrl('appointment/step3'); ?>">
        <input type="hidden" name="service" id="selectedServiceId" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <?php foreach ($services as $service): ?>
                <div class="service-option border p-4 rounded cursor-pointer hover:bg-blue-100 transition" data-id="<?php echo $service->id; ?>">
                    <h3 class="font-bold"><?php echo CHtml::encode($service->name); ?></h3>
                    <p class="text-gray-600"><?php echo CHtml::encode($service->description); ?></p>
                    <p class="text-blue-600 font-semibold mt-2">AED <?php echo number_format($service->price, 2); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between">
            <!-- <a href="<?php echo $this->createUrl('appointment/step1'); ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">
                ← Previous
            </a> -->

            <button type="submit" id="nextBtn" class="bg-blue-600 text-white px-4 py-2 rounded disabled:opacity-50" disabled>
                Next →
            </button>
        </div>
    </form>
</div>
<script>

    // document.querySelectorAll('.service-option').forEach(option => {
    //     option.addEventListener('click', function () {
    //         // Remove selection highlight from all
    //         document.querySelectorAll('.service-option').forEach(el => el.classList.remove('bg-blue-200', 'border-blue-600'));

    //         // Highlight selected
    //         this.classList.add('bg-blue-200', 'border-blue-600');

    //         // Set hidden input
    //         document.getElementById('selectedServiceId').value = this.getAttribute('data-id');

    //         // Enable the Next button
    //         document.getElementById('nextBtn').disabled = false;
    //     });
    // });
</script>

