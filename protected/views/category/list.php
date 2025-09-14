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
                               <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Category</span>
                           </div>
                       </li>
                   </ol>
               </nav>
               <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">All categories</h1>
           </div>
           <div class="block sm:flex items-center md:divide-x md:divide-gray-100">
               
               <div class="flex items-center sm:justify-end w-full">
                   
                   <a href="<?php echo $this->createUrl('category/create'); ?>"
                       class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                       <svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                           <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                       </svg>
                       Add Category
                   </a>


               </div>
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
                               <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Name</th>

                               <th scope="col" class="p-4"></th>
                           </tr>
                       </thead>
                       <tbody class="bg-white divide-y divide-gray-200">

                           <?php foreach ($dataProvider->getData() as $data): ?>
                               <tr class="hover:bg-gray-100">
                                   <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-500"><?= CHtml::encode($data->id) ?></td>
                                   <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-500"><?= CHtml::encode($data->name) ?></td>


                                   <td class="p-4 whitespace-nowrap space-x-2">

                                       <a href="<?php echo $this->createUrl('category/update', ['id' => $data->id]); ?>"
                                           class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                                           <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                               <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                                               <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                                           </svg>
                                           Edit
                                       </a>
                                       <!-- <a href="<?php echo $this->createUrl('category/delete', ['id' => $data->id]); ?>"
                                           class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                           <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                               <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                           </svg>
                                           Delete
                                       </a> -->
                                       <button type="button" data-modal-toggle="delete-product-modal-<?php echo $data->id; ?>" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                           <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                               <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                           </svg>
                                           Delete
                                       </button>
                                       <div class="hidden overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full" id="delete-product-modal-<?php echo $data->id; ?>">
                                           <div class="relative w-full max-w-md px-4 h-full md:h-auto">
                                               <!-- Modal content -->
                                               <div class="bg-white rounded-lg shadow relative">
                                                   <!-- Modal header -->
                                                   <div class="flex justify-end p-2">
                                                       <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="delete-product-modal">
                                                           <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                               <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                           </svg>
                                                       </button>
                                                   </div>
                                                   <!-- Modal body -->
                                                   <div class="p-6 pt-0 text-center">
                                                       <svg class="w-20 h-20 text-red-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                       </svg>
                                                       <h3 class="text-xl font-normal text-gray-500 mt-5 mb-6">Are you sure you want to delete?</h3>
                                                       <form method="POST" action="<?php echo Yii::app()->createUrl('category/delete', ['id' => $data->id]); ?>" style="display:inline;">
                                                           <input type="hidden" name="<?php echo Yii::app()->request->csrfTokenName; ?>"
                                                               value="<?php echo Yii::app()->request->csrfToken; ?>" />
                                                           <button type="submit"
                                                               class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-base inline-flex items-center px-3 py-2.5 text-center mr-2">
                                                               Yes, I'm sure
                                                           </button>
                                                       </form>
                                                       <a href="#" class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-cyan-200 border border-gray-200 font-medium inline-flex items-center rounded-lg text-base px-3 py-2.5 text-center" data-modal-toggle="delete-product-modal">
                                                           No, cancel
                                                       </a>
                                                   </div>
                                               </div>
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