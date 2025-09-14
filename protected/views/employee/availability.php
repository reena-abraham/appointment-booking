<?php
Yii::app()->clientScript->registerCoreScript('jquery');
?>
<form method="POST" action="<?php echo $this->createUrl('employee/saveAvailability'); ?>" class="space-y-6">
    <div class="max-w-4xl mx-auto p-6 space-y-8 bg-white rounded shadow">

        <!-- Service Duration -->
        <div>
            <label for="service_duration" class="block text-sm font-medium text-gray-700">🕒 Service Duration</label>
            <?php echo CHtml::dropDownList('service_duration', $savedServiceDuration, [
                '15' => '15 minutes',
                '30' => '30 minutes',
                '45' => '45 minutes',
                '60' => '1 hour',
            ], ['class' => 'mt-1 block  border border-gray-300 rounded p-2']); ?>
        </div>

        <!-- Set Availability -->
        <?php
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        ?>

        <div class="mb-6">
            <h4 class="text-lg font-semibold mb-1">Set Availability - For Employee</h4>
        </div>

        <?php foreach ($days as $day): ?>
            <?php $slots = isset($employeeDays[$day]) ? $employeeDays[$day] : [[]]; ?>

            <?php foreach ($slots as $i => $slot): ?>
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border border-gray-200 rounded-lg shadow-sm p-4 bg-white mb-4 slot-row slot-<?php echo $day; ?>">

                    <!-- Toggle + Day Label -->
                    <?php if ($i === 0): ?>
                        <div class="flex items-center space-x-3 w-full sm:w-1/4">
                            <input
                                type="checkbox"
                                id="<?php echo $day; ?>-checkbox"
                                name="days[<?php echo $day; ?>][enabled]"
                                class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                <?php echo !empty($enabledDays[$day]) ? 'checked' : ''; ?> />
                            <label for="<?php echo $day; ?>-checkbox" class="text-sm font-medium text-gray-900 capitalize">
                                <?php echo ucfirst($day); ?>
                            </label>

                        </div>




                    <?php else: ?>
                        <div class="w-full sm:w-1/4"></div>
                    <?php endif; ?>

                    <!-- From + To Inline -->
                    <div class="flex items-center gap-4 w-full sm:w-2/4">
                        <div class="w-1/2">
                            <label class="block text-sm text-gray-700 mb-1">From:</label>
                            <input type="time"
                                name="days[<?php echo $day; ?>][slots][<?php echo $i; ?>][from]"
                                value="<?php echo $slot['from'] ?? ''; ?>"
                                class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" />
                        </div>
                        <div class="w-1/2">
                            <label class="block text-sm text-gray-700 mb-1">To:</label>
                            <input type="time"
                                name="days[<?php echo $day; ?>][slots][<?php echo $i; ?>][to]"
                                value="<?php echo $slot['to'] ?? ''; ?>"
                                class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" />
                        </div>
                    </div>

                    <!-- Add/Remove -->
                    <div class="w-full sm:w-1/4 text-right">
                        <?php if ($i === 0): ?>
                            <a href="#" class="text-blue-600 text-sm font-medium hover:underline add-more" data-day="<?php echo $day; ?>">Add More</a>
                        <?php else: ?>
                            <a href="#" class="text-red-600 text-sm font-medium hover:underline remove-slot" data-day="<?php echo $day; ?>">Remove</a>
                        <?php endif; ?>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php endforeach; ?>

        <div class="row buttons">
            <?php echo CHtml::submitButton('Update Availability', ['class' => 'bg-cyan-600 hover:bg-cyan-700 text-white font-semibold py-2 px-6 rounded']); ?>
        </div>


    </div>
</form>
<!-- JavaScript -->
<script>
    // document.addEventListener('DOMContentLoaded', function () {
    //     const slotCounters = {};

    //     document.querySelectorAll('.add-more').forEach(button => {
    //         button.addEventListener('click', function (e) {
    //             e.preventDefault();

    //             const day = this.dataset.day;

    //             if (!slotCounters[day]) {
    //                 // Count existing slots initially
    //                 slotCounters[day] = document.querySelectorAll(`.slot-${day} .extra-slot`).length + 1;
    //             } else {
    //                 slotCounters[day]++;
    //             }

    //             // Create a container div for new slot
    //             const container = document.createElement('div');
    //             container.classList.add('flex', 'flex-col', 'sm:flex-row', 'items-center', 'gap-4', 'w-full', 'sm:w-3/5', 'mb-4', 'extra-slot');

    //            container.innerHTML = `
    //   <div class="flex items-center gap-4 w-full">
    //     <input type="time" name="days[${day}][slots][${slotCounters[day]}][from]" class="flex-1 bg-gray-50 border border-gray-300 rounded p-2.5 text-sm" />
    //     <input type="time" name="days[${day}][slots][${slotCounters[day]}][to]" class="flex-1 bg-gray-50 border border-gray-300 rounded p-2.5 text-sm" />
    //     <a href="#" class="text-red-600 text-sm font-medium hover:underline remove-slot" data-day="${day}">Remove</a>
    //   </div>
    // `;


    //             // Append the new slot before the Add More link container
    //             this.parentElement.insertAdjacentElement('beforebegin', container);
    //         });
    //     });

    //     // Remove slot functionality
    //     document.addEventListener('click', function (e) {
    //         if (e.target.classList.contains('remove-slot')) {
    //             e.preventDefault();
    //             e.target.closest('.extra-slot').remove();
    //         }
    //     });
    // });
    $(document).ready(function() {
        var slotCounters = {};

        $('.add-more').on('click', function(e) {
            e.preventDefault();

            var day = $(this).data('day');

            if (!slotCounters[day]) {
                // Count existing slots initially
                slotCounters[day] = $(`.slot-${day} .extra-slot`).length + 1;
            } else {
                slotCounters[day]++;
            }

            var container = $(`
          <div class="flex flex-col sm:flex-row items-center gap-4 w-full sm:w-3/5 mb-4 extra-slot">
            <div class="flex items-center gap-4 w-full">
              <input type="time" name="days[${day}][slots][${slotCounters[day]}][from]" class="flex-1 bg-gray-50 border border-gray-300 rounded p-2.5 text-sm" />
              <input type="time" name="days[${day}][slots][${slotCounters[day]}][to]" class="flex-1 bg-gray-50 border border-gray-300 rounded p-2.5 text-sm" />
              <a href="#" class="text-red-600 text-sm font-medium hover:underline remove-slot" data-day="${day}">Remove</a>
            </div>
          </div>
        `);

            // Insert before the Add More link container
            $(this).parent().before(container);
        });

        // Remove slot functionality using event delegation
        $(document).on('click', '.remove-slot', function(e) {
            e.preventDefault();
            $(this).closest('.extra-slot').remove();
        });
    });
</script>