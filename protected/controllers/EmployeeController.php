<?php

class EmployeeController extends Controller
{

    public $layout = '//layouts/employee';
    public function filters()
    {
        return array('accessControl');
    }

    public function accessRules()
    {
        return array(
            array(
                'allow',
                'expression' => 'Yii::app()->user->getState("role") === "employee"',
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }
    public function actionServices()
    {
        $employeeUserId = Yii::app()->user->id;
        // print_r($employeeUserId);exit;
        //     $schema = Yii::app()->db->getSchema()->getTable('employee_services');
        // var_dump($schema->primaryKey);
        // var_dump($schema->foreignKeys);
        // exit;

        // Load employee
        $employee = Employee::model()->with(['services' => ['joinType' => 'LEFT JOIN']])
            ->findByAttributes(['user_id' => $employeeUserId]);
        //  print_r($employee);exit;
        if (!$employee) {
            throw new CHttpException(404, 'Employee not found.');
        }
        // print_r($employee);exit;
        // Fetch all services by the employee's category
        $services = ServiceType::model()->findAllByAttributes([
            'category_id' => $employee->category_id
        ]);
        // print_r($services);exit;
        // Get selected services IDs safely (fallback if relation broken)
        $selectedServices = [];

        if (isset($employee->services) && (is_array($employee->services) || $employee->services instanceof Traversable)) {
            // print_r('ff');exit;
            // Relation works
            $selectedServices = CHtml::listData($employee->services, 'id', 'id');
        } else {
            // print_r('vvv');exit;
            // Fallback: fetch manually from pivot table
            $serviceIds = Yii::app()->db->createCommand()
                ->select('service_id')
                ->from('employee_services')
                ->where('employee_id = :eid', [':eid' => $employee->id])
                ->queryColumn();
            //  print_r($serviceIds);exit;
            if (!empty($serviceIds)) {
                $selectedServices = array_combine($serviceIds, $serviceIds);
            }
        }
        if (isset($_POST['services']) && is_array($_POST['services'])) {
            $employeeId = $employee->user_id;

            foreach ($_POST['services'] as $sid) {
                $sid = (int)$sid;

                // Check if this employee-service pair already exists
                $exists = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('employee_services')
                    ->where('employee_id = :eid AND service_id = :sid', [
                        ':eid' => $employeeId,
                        ':sid' => $sid
                    ])
                    ->queryScalar();

                if (!$exists) {
                    // Insert only if it doesn't exist
                    Yii::app()->db->createCommand()->insert('employee_services', [
                        'employee_id' => $employeeId,
                        'service_id' => $sid
                    ]);
                }
            }

            Yii::app()->user->setFlash('success', 'Services updated.');
            $this->refresh();
        }

        // print_r($selectedServices);exit;
        // Handle form submission
        // if (isset($_POST['services']) && is_array($_POST['services'])) {
        //     // Delete previous
        //     Yii::app()->db->createCommand()->delete('employee_services', 'employee_id = :eid', [
        //         ':eid' => $employee->id
        //     ]);
        //     // Insert new ones
        //     foreach ($_POST['services'] as $sid) {
        //         Yii::app()->db->createCommand()->insert('employee_services', [
        //             'employee_id' => $employee->user_id,
        //             'service_id' => (int)$sid
        //         ]);
        //     }
        //     Yii::app()->user->setFlash('success', 'Services updated.');
        //     $this->refresh();
        // }
        // print_r($selectedServices);exit;
        // Render
        $this->render('services', [
            'employee' => $employee,
            'services' => $services,
            'selectedServices' => $selectedServices,
        ]);
    }
    public function actionDashboard()
    {
        $staffId = Yii::app()->user->id;

        $appointments = Appointment::model()->findAll([
            'condition' => 'staff_id = :staffId AND status != :cancelled',
            'params' => [':staffId' => $staffId, ':cancelled' => 'cancelled',],
            'order' => 'appointment_date ASC', // Optional: Order by date
        ]);

        $events = [];
        foreach ($appointments as $appointment) {
            $events[] = [
                'title' => CHtml::encode($appointment->service->name),
                'start' => $appointment->appointment_date . 'T' . $appointment->appointment_time,
                'end' => $appointment->appointment_date . 'T' . $this->getEndTime($appointment),  // Add end time based on the duration
                'description' => CHtml::encode($appointment->notes),
            ];
        }
        // print_r($events);exit;
        $this->render('dashboard', array('events' => $events));
    }


    // Helper function to get the end time based on duration (in minutes)
    private function getEndTime($appointment)
    {
        $start = new DateTime($appointment->appointment_time);
        $end = clone $start;
        $end->modify('+' . (int)$appointment->duration_minutes . ' minutes');
        return $end->format('H:i');
    }

    // public function actionAvailability()
    // {
    //     $this->render('availability');
    // }
    //     public function actionAvailability()
    //     {

    //     $employeeId = Yii::app()->user->id;

    //     $availabilityData = [];
    //     $serviceDuration = 30;

    //     // Load service duration
    //     $settings = EmployeeSettings::model()->findByAttributes(['employee_id' => $employeeId]);
    //     if ($settings) {
    //         $serviceDuration = $settings->service_duration;
    //     }

    //     // Load availability and slots
    //     $availabilities = EmployeeAvailability::model()->findAllByAttributes(['employee_id' => $employeeId]);
    //     foreach ($availabilities as $availability) {
    //         $day = $availability->day;
    //         $availabilityData[$day]['enabled'] = $availability->enabled;

    //         $slots = EmployeeAvailabilitySlots::model()->findAllByAttributes(['availability_id' => $availability->id]);
    //         $availabilityData[$day]['slots'] = [];
    //         foreach ($slots as $slot) {
    //             $availabilityData[$day]['slots'][] = [
    //                 'from' => $slot->from_time,
    //                 'to' => $slot->to_time,
    //             ];
    //         }
    //     }

    //     $this->render('availability', [
    //         'availabilityData' => $availabilityData,
    //         'serviceDuration' => $serviceDuration,
    //     ]);
    // }
    //     public function actionAvailability()
    //     {
    //         $employeeId = Yii::app()->user->id;  // or however you get the employee ID

    //         $employeeSetting = EmployeeSettings::model()->findByAttributes(['employee_id' => $employeeId]);

    //         if (isset($employeeSetting->service_duration) && $employeeSetting->service_duration !== null) {
    //             $savedServiceDuration = $employeeSetting->service_duration;
    //         } else {
    //             $savedServiceDuration = '15';
    //         }


    //         $availabilities = EmployeeAvailability::model()->with('slots')->findAllByAttributes(['employee_id' => $employeeId]);

    //         $employeeDays = [];
    //         $enabledDays = [];
    //         foreach ($availabilities as $availability) {
    //             $day = $availability->day;        
    //             $enabledDays[$day] = $availability->enabled;
    //             $employeeDays[$day] = [];
    //             //print_r('dwwe');exit;
    //             // print_r($availability['EmployeeAvailabilitySlots'] );exit;
    //             var_dump($availability->slots); 
    // exit;
    //             foreach ($availability->slots  as $slot) {
    //                 print_r($slot);exit;
    //                 $employeeDays[$day][] = [
    //                     'from' => substr($slot->from_time, 0, 5), // format HH:mm
    //                     'to' => substr($slot->to_time, 0, 5),
    //                 ];
    //             }
    //             // print_r($employeeDays);exit;
    //             // If no slots, add one empty slot for form display
    //             if (empty($employeeDays[$day])) {
    //                 $employeeDays[$day][] = ['from' => '', 'to' => ''];
    //             }
    //         }
    //         print_r('d');exit;
    //         // For days without availability, add empty slots (optional)
    //         $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    //         foreach ($days as $day) {
    //             if (!isset($employeeDays[$day])) {
    //                 $employeeDays[$day] = [['from' => '', 'to' => '']];
    //                 $enabledDays[$day] = false;
    //             }
    //         }
    //         print_r($employeeDays);exit;
    //         $this->render('availability', [
    //             'employeeDays' => $employeeDays,
    //             'enabledDays' => $enabledDays,
    //             'savedServiceDuration' => $savedServiceDuration,
    //         ]);
    //     }
    public function actionAvailability()
    {
        $employeeId = Yii::app()->user->id;  // or however you get the employee ID

        $employeeSetting = EmployeeSettings::model()->findByAttributes(['employee_id' => $employeeId]);

        $savedServiceDuration = isset($employeeSetting->service_duration) && $employeeSetting->service_duration !== null
            ? $employeeSetting->service_duration
            : '15';

        // Fetch all availability records with related slots
        $availabilities = EmployeeAvailability::model()->with('slots')->findAllByAttributes(['employee_id' => $employeeId]);

        $employeeDays = [];
        $enabledDays = [];
        foreach ($availabilities as $availability) {
            $day = $availability->day;
            $enabledDays[$day] = $availability->enabled;
            $employeeDays[$day] = [];

            foreach ($availability->slots as $slot) {
                $employeeDays[$day][] = [
                    'from' => substr($slot->from_time, 0, 5), // HH:mm format
                    'to' => substr($slot->to_time, 0, 5),
                ];
            }

            // If no slots, add an empty slot for form display
            if (empty($employeeDays[$day])) {
                $employeeDays[$day][] = ['from' => '', 'to' => ''];
            }
        }

        // For days without availability, add empty slots and mark as disabled
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        foreach ($days as $day) {
            if (!isset($employeeDays[$day])) {
                $employeeDays[$day] = [['from' => '', 'to' => '']];
                $enabledDays[$day] = false;
            }
        }

        $this->render('availability', [
            'employeeDays' => $employeeDays,
            'enabledDays' => $enabledDays,
            'savedServiceDuration' => $savedServiceDuration,
        ]);
    }

    public function actionSaveAvailability()
{
    if (!Yii::app()->request->isPostRequest) {
        throw new CHttpException(400, 'Invalid request');
    }

    $employeeId = Yii::app()->user->id;

    $days = isset($_POST['days']) ? $_POST['days'] : [];
    $serviceDuration = isset($_POST['service_duration']) ? intval($_POST['service_duration']) : 30;

    $transaction = Yii::app()->db->beginTransaction();
    try {
        // Save or update employee_settings
        $settings = EmployeeSettings::model()->findByAttributes(['employee_id' => $employeeId]);

        if (!$settings) {
            $settings = new EmployeeSettings();
            $settings->employee_id = $employeeId;
        }
        $settings->service_duration = $serviceDuration;
        if (!$settings->save()) {
            throw new Exception('Failed to save service duration.');
        }

        // Fetch old availabilities for this employee
        $availabilities = EmployeeAvailability::model()->findAllByAttributes(['employee_id' => $employeeId]);

        // Get the IDs of those availabilities
        $availabilityIds = array_map(function ($availability) {
            return $availability->id;
        }, $availabilities);

        // Delete only slots that belong to this employee's availability records
        if (!empty($availabilityIds)) {
            EmployeeAvailabilitySlot::model()->deleteAll([
                'condition' => 'availability_id IN (' . implode(',', $availabilityIds) . ')'
            ]);
        }

        // Now delete the availability rows themselves
        foreach ($availabilities as $availability) {
            $availability->delete();
        }

        // Insert new availability & slots
        foreach ($days as $day => $data) {
            $enabled = isset($data['enabled']) && $data['enabled'] ? 1 : 0;
            $availability = new EmployeeAvailability();
            $availability->employee_id = $employeeId;
            $availability->day = $day;
            $availability->enabled = $enabled;

            if (!$availability->save()) {
                throw new Exception("Failed to save availability for {$day}.");
            }

            if ($enabled && !empty($data['slots']) && is_array($data['slots'])) {
                foreach ($data['slots'] as $slot) {
                    if (!empty($slot['from']) && !empty($slot['to'])) {
                        $slotModel = new EmployeeAvailabilitySlot();
                        $slotModel->availability_id = $availability->id;
                        $slotModel->from_time = $slot['from'];
                        $slotModel->to_time = $slot['to'];

                        if (!$slotModel->save()) {
                            throw new Exception("Failed to save slot for {$day}.");
                        }
                    }
                }
            }
        }

        $transaction->commit();
        Yii::app()->user->setFlash('success', 'Availability saved successfully.');
        $this->redirect(['availability']);

    } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', $ex->getMessage());
        $this->redirect(['availability']);
    }
}



    // public function actionSaveAvailability()
    // {
    //     if (!Yii::app()->request->isPostRequest) {
    //         throw new CHttpException(400, 'Invalid request');
    //     }

    //     $employeeId = Yii::app()->user->id;

    //     $days = isset($_POST['days']) ? $_POST['days'] : [];
    //     $serviceDuration = isset($_POST['service_duration']) ? intval($_POST['service_duration']) : 30;

    //     $transaction = Yii::app()->db->beginTransaction();
    //     try {
    //         // Save or update employee_settings
    //         $settings = EmployeeSettings::model()->findByAttributes(['employee_id' => $employeeId]);

    //         if (!$settings) {
    //             $settings = new EmployeeSettings();
    //             $settings->employee_id = $employeeId;
    //         }
    //         $settings->service_duration = $serviceDuration;
    //         if (!$settings->save()) {
    //             throw new Exception('Failed to save service duration.');
    //         }

    //         // Delete old availabilities & slots
    //         $availabilities = EmployeeAvailability::model()->findAllByAttributes(['employee_id' => $employeeId]);
    //         foreach ($availabilities as $availability) {
    //             $availability->delete();
    //         }

    //         // Insert new availability & slots
    //         foreach ($days as $day => $data) {
    //             $enabled = isset($data['enabled']) && $data['enabled'] ? 1 : 0;
    //             $availability = new EmployeeAvailability();
    //             $availability->employee_id = $employeeId;
    //             $availability->day = $day;
    //             $availability->enabled = $enabled;

    //             if (!$availability->save()) {
    //                 throw new Exception("Failed to save availability for {$day}.");
    //             }

    //             if ($enabled && !empty($data['slots']) && is_array($data['slots'])) {
    //                 foreach ($data['slots'] as $slot) {
    //                     if (!empty($slot['from']) && !empty($slot['to'])) {
    //                         $slotModel = new EmployeeAvailabilitySlot();
    //                         $slotModel->availability_id = $availability->id;
    //                         $slotModel->from_time = $slot['from'];
    //                         $slotModel->to_time = $slot['to'];

    //                         if (!$slotModel->save()) {
    //                             throw new Exception("Failed to save slot for {$day}.");
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //         $transaction->commit();
    //         Yii::app()->user->setFlash('success', 'Availability saved successfully.');
    //         $this->redirect(['availability']); // redirect back to form

    //     } catch (Exception $ex) {
    //         $transaction->rollback();
    //         Yii::app()->user->setFlash('error', $ex->getMessage());
    //         $this->redirect(['availability']);
    //     }
    // }
    public function actionAppointments()
    {
        $userId = Yii::app()->user->id;

        // Optionally, you can fetch the user to confirm role or other details:
        $user = User::model()->findByPk($userId);
        if (!$user || $user->role !== 'employee') {
            throw new CHttpException(403, 'Access denied.');
        }

        $criteria = new CDbCriteria();
        $criteria->with = ['user', 'staff', 'category', 'service'];
        $criteria->together = true;
        $criteria->condition = 't.staff_id = :staff_id';
        $criteria->params = [':staff_id' => $userId];
        $criteria->order = 't.appointment_date DESC';

        $dataProvider = new CActiveDataProvider('Appointment', [
            'criteria' => $criteria,
            'pagination' => ['pageSize' => 10],
        ]);

        $this->render('appointments', [
            'dataProvider' => $dataProvider,
        ]);
    }


    // public function actionAppointments()
    // {
    //     $userId = Yii::app()->user->id;
    //     $dataProvider = new CActiveDataProvider('Appointment', [
    //         'criteria' => [
    //             'with' => ['user', 'staff', 'category'],
    //             'condition' => 't.staff_id = :staff_id', // 👈 Apply the filter here
    //             'params' => [':staff_id' => $userId],
    //             'order' => 't.appointment_date DESC',
    //         ],
    //         'pagination' => [
    //             'pageSize' => 10,
    //         ],
    //     ]);

    //     $this->render('appointments', [
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }
    public function actionUpdateStatus($id)
    {

        $model = Appointment::model()->findByPk($id);
        if (!$model) throw new CHttpException(404, 'Appointment not found.');

        if (isset($_POST['status'])) {
            $model->status = $_POST['status'];

            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Status updated successfully.');
            } else {
                Yii::app()->user->setFlash('error', 'Failed to update status.');
            }
        }

        $this->redirect(['appointments']); // redirect back to list
    }
}
