<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
	<div class="mb-1 w-full">
		<div class="mb-4">
			<nav class="flex mb-5" aria-label="Breadcrumb">
				<ol class="inline-flex items-center space-x-1 md:space-x-2">
					<li class="inline-flex items-center">
						<a href="<?php echo $this->createUrl('admin/dashboard'); ?>" class="text-gray-700 hover:text-gray-900 inline-flex items-center">
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
							<span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium" aria-current="page">Service Type</span>
						</div>
					</li>
				</ol>
			</nav>
			<h1 class="text-xl sm:text-2xl font-semibold text-gray-900">All Service Types</h1>
		</div>
		<div class="block sm:flex items-center md:divide-x md:divide-gray-100">
			
			<div class="flex items-center sm:justify-end w-full">
				
				<a href="<?php echo $this->createUrl('servicetype/create'); ?>"
					class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
					<svg class="-ml-1 mr-2 h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
					</svg>
					Add Service Type
				</a>


			</div>
		</div>
	</div>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'servicetype-grid',
	'dataProvider' => $model->search(),
	// 'filter'=>$model,
	'cssFile' => false, // Disable default Yii grid CSS
	'itemsCssClass' => 'min-w-full divide-y divide-gray-200 table-fixed', // Tailwind classes for table element
	'htmlOptions' => ['class' => 'shadow overflow-hidden border border-gray-200 sm:rounded-lg'], // Wrapper div classes
	'pagerCssClass' => 'mt-4', // add spacing to pager if needed
	'summaryText' => '',
	'summaryCssClass' => 'text-sm text-gray-700 my-2',
	'columns' => array(
		 array(
                'header' => 'No.',
                'value' => '$row + 1',
                'headerHtmlOptions' => ['class' => 'p-4 text-left text-xs font-medium text-gray-500 uppercase bg-gray-100'],
                'htmlOptions' => ['class' => 'p-4 whitespace-nowrap text-sm font-normal text-gray-500'],
            ),
		array(
			'name' => 'name',
			 'header' => 'Service Name',
			'headerHtmlOptions' => ['class' => 'p-4 text-left text-xs font-medium text-gray-500 uppercase bg-gray-100'],
			'htmlOptions' => ['class' => 'p-4 whitespace-nowrap text-base font-medium text-gray-900'],
		),
		array(
			'name' => 'category_id',
			'header' => 'category',
			'value' => '$data->category->name',
			'filter' => CHtml::listData(Category::model()->findAll(), 'id', 'name'),
			'headerHtmlOptions' => ['class' => 'p-4 text-left text-xs font-medium text-gray-500 uppercase bg-gray-100'],
			'htmlOptions' => ['class' => 'p-4 whitespace-nowrap text-base font-medium text-gray-900'],
		),
	
		array(
			'name' => 'price',
			 'header' => 'Price',
			'headerHtmlOptions' => ['class' => 'p-4 text-left text-xs font-medium text-gray-500 uppercase bg-gray-100'],
			'htmlOptions' => ['class' => 'p-4 whitespace-nowrap text-base font-medium text-gray-900'],
		),
		array(
			'class' => 'CButtonColumn',
			'htmlOptions' => ['class' => 'p-4 whitespace-nowrap'],
			'template' => '{update} {delete}', // Only show update and delete
			'buttons' => array(
				'update' => array(
					'label' => '<svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                         <path d="M17.414 2.586a2 2 0 00-2.828 0L7 9.172V13h3.828l7.586-7.586a2 2 0 000-2.828z"></path>
                         <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 110 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                     </svg>Edit',
					'imageUrl' => false,
					'options' => [
						'class' => 'text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-3 py-1 inline-flex items-center space-x-1',
						'title' => 'Edit',
						'escape' => false
					],
				),
				'delete' => array(
					'label' => '<svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                         <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                     </svg>Delete',
					'imageUrl' => false,
					'options' => [
						'class' => 'text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-1 inline-flex items-center space-x-1',
						'title' => 'Delete',
						'escape' => false
					],
				),
			),
		),

	),
));
?>