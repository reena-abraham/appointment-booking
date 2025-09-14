<?php

class AdminController extends Controller
{

    public $layout = '//layouts/admin';
    public function filters()
    {
        return array('accessControl');
    }

    public function accessRules()
    {
        return array(
            array(
                'allow',
                'expression' => 'Yii::app()->user->getState("role") === "admin"',
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionDashboard()
    {
        $totalEmployees = User::model()->count('role = :role', array(':role' => 'employee'));

        // Get total number of customers
        $totalCustomers = User::model()->count('role = :role', array(':role' => 'customer'));

        // Calculate total user count (employees + customers)
        $totalUsers = $totalEmployees + $totalCustomers;

        $totalAppointments = Appointment::model()->count();
        //cancelled appointments
        $cancelledAppointments = Appointment::model()->countByAttributes(['status' => 'cancelled']);

        $today = date('Y-m-d');

        // Get the start of the current week (assuming the week starts on Monday)
        $weekStart = date('Y-m-d', strtotime('monday this week'));

        // Get the end of the current week (Sunday)
        $weekEnd = date('Y-m-d', strtotime('sunday this week'));

        // Get total number of appointments today
        $totalAppointmentsToday = Appointment::model()->count('DATE(appointment_date) = :today', array(':today' => $today));

        // Get total number of appointments this week
        $totalAppointmentsThisWeek = Appointment::model()->count('DATE(appointment_date) BETWEEN :weekStart AND :weekEnd', array(':weekStart' => $weekStart, ':weekEnd' => $weekEnd));

        // Pass data to the view
        $this->render('dashboard', array(
            'totalUsers' => $totalUsers,
            'totalEmployees' => $totalEmployees,
            'totalCustomers' => $totalCustomers,
            'totalAppointments' => $totalAppointments,
            'totalAppointmentsToday' => $totalAppointmentsToday,
            'totalAppointmentsThisWeek' => $totalAppointmentsThisWeek,
            'totalCancelledAppointments' => $cancelledAppointments
        ));
        // $this->render('dashboard');
    }
    public function actionAppointments()
    {
        $criteria = new CDbCriteria();
        $criteria->with = ['user', 'staff', 'category', 'service']; // preload relations
        $criteria->together = true; // ensure JOIN is used for filtering

        // Search filter: by customer name
        $customerName = Yii::app()->request->getParam('customer');
        if (!empty($customerName)) {
            $criteria->addSearchCondition('user.name', $customerName);
        }

        $dataProvider = new CActiveDataProvider('Appointment', [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => 't.appointment_date DESC',
            ],
        ]);

        $this->render('appointment', [
            'dataProvider' => $dataProvider,
        ]);
    }

    // public function actionAppointments()
    // {
    //     $dataProvider = new CActiveDataProvider('Appointment', [
    //         'criteria' => [
    //             'with' => ['user', 'staff', 'category'],
    //             'order' => 'appointment_date DESC',
    //         ],
    //         'pagination' => [
    //             'pageSize' => 10,
    //         ],
    //     ]);

    //     $this->render('appointment', [
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }
}
