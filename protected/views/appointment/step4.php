<?php
Yii::app()->clientScript->registerCoreScript('jquery');

$currentStep = 4;
$steps = [
    1 => 'Step1',
    2 => 'Step2',
    3 => 'Step3',
    4 => 'Step4',
    5 => 'Step5',
];
?>

<div class="max-w-4xl mx-auto my-8 p-6 bg-white shadow rounded">

    <!-- Step Indicator -->
    <div class="flex items-center justify-center mb-10">
        <ol class="flex items-center w-full max-w-4xl space-x-4 text-sm text-gray-500 sm:space-x-6">
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
    <h2 class="text-3xl font-semibold text-gray-800 mb-8 text-center">Select Date & Time</h2>

    <!-- Selected Staff Info -->
    <div class="mb-6 text-center text-lg font-medium">
        Selected Staff: <?php echo CHtml::encode($employee->user->name); ?>
    </div>

    <form method="POST" action="<?php echo $this->createUrl('appointment/step5'); ?>" id="dateTimeForm">
        <input type="hidden" name="staff_id" value="<?php echo $employee->user_id; ?>">
        <input type="hidden" name="selected_date" id="selectedDate">
        <input type="hidden" name="selected_slot" id="selectedSlot">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Date Picker -->
            <div>
                <label for="dateInput" class="block mb-2 font-medium">Select a Date</label>
                <input type="date" id="dateInput" name="date" class="border rounded px-4 py-2 w-full"
                       min="<?php echo date('Y-m-d'); ?>" />
            </div>

            <!-- Time Slots -->
            <div>
                <h3 class="text-xl font-semibold mb-4 text-gray-800 text-center">Available Time Slots</h3>
                <!-- <div id="slotContainer" class="grid grid-cols-2 gap-4"> -->
                    <div id="slotContainer" class="grid grid-cols-3 gap-4">
                    <!-- Time slots will be appended here -->
                </div>
            </div>

        </div>

        <!-- Navigation -->
        <div class="text-center mt-8">
            <button type="submit" id="nextBtn" class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md disabled:opacity-50 hover:bg-blue-700 focus:outline-none transition-all" disabled>
                Next →
            </button>
        </div>
    </form>
</div>

<script>
$(function() {
    const $dateInput = $('#dateInput');
    const $slotContainer = $('#slotContainer');
    const $selectedDateInput = $('#selectedDate');
    const $selectedSlotInput = $('#selectedSlot');
    const staffId = <?php echo json_encode($employee->user_id); ?>;

    function renderSlots(slots) {
        $slotContainer.empty();

        if (slots.length === 0) {
            $slotContainer.html('<p class="col-span-2 text-center text-gray-600">No available slots for the selected date.</p>');
            return;
        }

        slots.forEach(slot => {
            const $slot = $('<div>')
                .addClass('time-slot cursor-pointer border rounded py-3 text-center font-semibold select-none')
                .text(slot.time)
                .attr('data-slot', slot.time)
                .css('border-color', '#ccc');

            if (slot.isBooked) {
                $slot.addClass('bg-red-500 text-white cursor-not-allowed')
                    .attr('title', 'This slot is already booked')
                    .off('click');
            } else {
                $slot.on('click', function() {
                    // Remove selection from all
                
                   // $('.time-slot').removeClass('bg-teal-200 text-white border-blue-600');
                    $('.time-slot').removeClass('bg-blue-600 text-white border-blue-600');
                    // Mark this selected
                   // $(this).addClass('bg-teal-200 text-white border-blue-600');
                     $(this).addClass('bg-blue-600 text-white border-blue-600');
                    // Store selected slot
                    $selectedSlotInput.val(slot.time);
                });
            }

            $slotContainer.append($slot);
        });
    }

    $dateInput.on('change', function() {
        const selectedDate = $(this).val();
        $selectedDateInput.val(selectedDate);
        $selectedSlotInput.val('');
        $('#nextBtn').prop('disabled', true);  // disable next until slot chosen

        if (!selectedDate) {
            $slotContainer.empty();
            return;
        }

        $.ajax({
            url: '<?php echo Yii::app()->createAbsoluteUrl("appointment/getAvailabilitySlots"); ?>',
            method: 'GET',
            data: {
                staff_id: staffId,
                date: selectedDate
            },
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                    $slotContainer.empty();
                    return;
                }
                renderSlots(response.slots);
            },
            error: function() {
                $slotContainer.html('<p class="col-span-2 text-center text-red-600">Error loading slots. Please try again later.</p>');
            }
        });
    });

    // Enable Next button only if date and slot selected
    $('#slotContainer').on('click', '.time-slot:not(.bg-red-500)', function() {
        if ($dateInput.val() && $selectedSlotInput.val()) {
            $('#nextBtn').prop('disabled', false);
        }
    });

    $('#dateTimeForm').on('submit', function(e) {
        if (!$dateInput.val() || !$selectedSlotInput.val()) {
            e.preventDefault();
            alert('Please select both a date and time slot.');
        }
    });
});
</script>






