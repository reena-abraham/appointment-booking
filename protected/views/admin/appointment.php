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

                   <form method="GET" class="flex items-center gap-x-3 mb-4">
                       <input
                           type="text"
                           name="customer"
                           value="<?= CHtml::encode(Yii::app()->request->getParam('customer')) ?>"
                           placeholder="Search by customer name..."
                           class="w-full sm:w-64 px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                       <button
                           type="submit"
                           class="bg-cyan-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                           Search
                       </button>
                   </form>

                   <!-- Table -->

                   <table class="table-fixed min-w-full divide-y divide-gray-200">
                       <thead class="bg-gray-100">
                           <tr>
                               <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                               <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Customer Name</th>
                               <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Customer Email</th>
                               <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Staff</th>
                               <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
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
                                   <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-500"><?= CHtml::encode($data->staff->user->name) ?></td>
                                   <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-500"><?= CHtml::encode($data->category->name) ?></td>
                                   <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-500">
                                       <?= CHtml::encode($data->service->name) ?> <!-- Displaying service name -->
                                   </td>
                                   <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-500"><?= CHtml::encode($data->appointment_date) ?></td>
                                   <?php
                                    $start = new DateTime($data->appointment_time);
                                    $end = new DateTime($data->appointment_time);
                                    // $end->modify('+' . (int)$data->duration_minutes . ' minutes');
                                    $duration = !empty($data->duration_minutes) ? (int)$data->duration_minutes : 15;
                                    $end->modify("+{$duration} minutes");

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
                                            $badgeClass = 'bg-green-400 text-red-800';
                                            $label = 'Completed';
                                        }

                                        echo '<span class="px-2 py-1 text-xs font-medium rounded-full ' . $badgeClass . '">' . CHtml::encode($label) . '</span>';
                                        ?>
                                   </td>


                               </tr>
                           <?php endforeach; ?>
                       </tbody>
                   </table>
               </div>
           </div>
       </div>
   </div>