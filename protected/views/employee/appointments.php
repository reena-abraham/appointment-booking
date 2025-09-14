   <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
       <div class="mb-1 w-full">
           <div class="mb-4">
               <nav class="flex mb-5" aria-label="Breadcrumb">
                   <ol class="inline-flex items-center space-x-1 md:space-x-2">
                       <li class="inline-flex items-center">
                           <a href="#" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
                               <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                   <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                               </svg>
                               Home
                           </a>
                       </li>

                       <li>
                           <div class="flex items-center">
                               <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                   <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                               </svg>
                               <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Appointments</span>
                           </div>
                       </li>
                   </ol>
               </nav>
               <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">All Appointments</h1>
           </div>

       </div>
   </div>
   <div class="flex flex-col">
       <div class="overflow-x-auto">
           <div class="align-middle inline-block min-w-full">
               <div class="shadow overflow-hidden sm:rounded-lg">


                   <!-- Table -->

                   <table class="table-fixed min-w-full divide-y divide-gray-200">
                       <thead class="bg-gray-100">
                           <tr>
                               <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                               <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Customer Name</th>
                               <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Customer Email</th>

                               <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Service</th>

                               <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Appointment Date</th>
                               <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Appointment time</th>
                               <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                               <th scope="col" class="p-4"></th>
                           </tr>
                       </thead>
                       <tbody class="bg-white divide-y divide-gray-200">
                           <?php $counter = 1; ?>
                           <?php foreach ($dataProvider->getData() as $data): ?>
                               <tr class="hover:bg-gray-100">
                                   <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-500"><?= $counter++ ?></td>
                                   <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-500"><?= CHtml::encode($data->user->name) ?></td>
                                   <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-500"><?= CHtml::encode($data->user->email) ?></td>
                                   <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-500">
                                       <?= CHtml::encode($data->service->name) ?> <!-- Displaying service name -->
                                   </td>
                                   <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-500"><?= CHtml::encode($data->appointment_date) ?></td>
                                   <?php
                                    $start = new DateTime($data->appointment_time);
                                    $end = new DateTime($data->appointment_time);
                                    $duration = !empty($data->duration_minutes) ? (int)$data->duration_minutes : 15;
                                    $end->modify("+{$duration} minutes");
                                    // $end->modify('+' . (int)$data->duration_minutes . ' minutes');

                                    $time = $start->format('H:i') . ' - ' . $end->format('H:i');
                                    ?>
                                   <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-500"><?= CHtml::encode($time) ?></td>
                                   <td class="p-4 whitespace-nowrap text-sm">
                                       <?php
                                        $status = $data->status;
                                        $badgeClass = 'bg-yellow-400 text-yellow-800';
                                        $label = 'Pending';

                                        if ($status === 'confirmed') {
                                            $badgeClass = 'bg-green-600 text-green-800';
                                            $label = 'Confirmed';
                                        } elseif ($status === 'cancelled') {
                                            $badgeClass = 'bg-red-600 text-red-800';
                                            $label = 'Cancelled';
                                        } elseif ($status === 'completed') {
                                            $badgeClass = 'bg-green-400 text-green-800';
                                            $label = 'Completed';
                                        }

                                        echo '<span class="px-2 py-1 text-xs font-medium rounded-full ' . $badgeClass . '">' . CHtml::encode($label) . '</span>';
                                        ?>
                                   </td>

                                   <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-500">
                                       <!-- View Button -->
                                       <button
                                           onclick="document.getElementById('modal-<?= $data->id ?>').classList.remove('hidden');"
                                           class="bg-cyan-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                           View
                                       </button>

                                       <!-- Modal -->
                                       <!-- Modal -->
                                       <div id="modal-<?= $data->id ?>" class="fixed inset-0 bg-gray-800 bg-opacity-50 z-50 flex justify-center items-center hidden">
                                           <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg relative">

                                               <div class="flex items-center justify-between mb-4">
                                                   <h2 class="text-xl font-semibold text-gray-800">Appointment Details</h2>
                                                   <button
                                                       onclick="document.getElementById('modal-<?= $data->id ?>').classList.add('hidden')"
                                                       class="text-gray-500 hover:text-gray-800 text-2xl font-bold focus:outline-none"
                                                       aria-label="Close modal">
                                                       &times;
                                                   </button>
                                               </div>

                                               <div class="space-y-2 text-sm text-gray-700">
                                                   <p><strong>Customer Name:</strong> <?= CHtml::encode($data->user->name) ?></p>
                                                   <p><strong>Customer Email:</strong> <?= CHtml::encode($data->user->email) ?></p>
                                                   <p><strong>Service:</strong> <?= CHtml::encode($data->service->name) ?></p>
                                                   <p><strong>Appointment Date:</strong> <?= CHtml::encode($data->appointment_date) ?></p>
                                                   <p><strong>Appointment Time:</strong> <?= CHtml::encode($time) ?></p>
                                                   <?php if (!empty($data->notes)): ?>
                                                       <p><strong>Notes:</strong> <?= CHtml::encode($data->notes) ?></p>
                                                   <?php endif; ?>
                                               </div>

                                               <!-- Status Form -->
                                               <form method="POST" action="<?= Yii::app()->createUrl('employee/updateStatus', ['id' => $data->id]) ?>" class="mt-4">
                                                   <label for="status" class="block mb-1 text-sm font-medium text-gray-700">Status</label>
                                                   <select
                                                       id="status"
                                                       name="status"
                                                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                                                       <?php
                                                        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
                                                        foreach ($statuses as $status) {
                                                            $selected = ($data->status === $status) ? 'selected' : '';
                                                            echo "<option value=\"$status\" $selected>" . ucfirst($status) . "</option>";
                                                        }
                                                        ?>
                                                   </select>

                                                   <div class="mt-4 flex justify-end space-x-2">
                                                       <button
                                                           type="submit"
                                                           class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm">
                                                           Update Status
                                                       </button>
                                                       <button
                                                           type="button"
                                                           onclick="document.getElementById('modal-<?= $data->id ?>').classList.add('hidden')"
                                                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded text-sm">
                                                           Close
                                                       </button>
                                                   </div>
                                               </form>
                                           </div>
                                       </div>

                                   </td>


                               </tr>
                           <?php endforeach; ?>
                       </tbody>
                   </table>
               </div>
           </div>
       </div>
   </div>