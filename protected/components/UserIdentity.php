<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	// public function authenticate()
	// {
	// 	$users=array(
	// 		// username => password
	// 		'demo'=>'demo',
	// 		'admin'=>'admin',
	// 	);
	// 	if(!isset($users[$this->username]))
	// 		$this->errorCode=self::ERROR_USERNAME_INVALID;
	// 	elseif($users[$this->username]!==$this->password)
	// 		$this->errorCode=self::ERROR_PASSWORD_INVALID;
	// 	else
	// 		$this->errorCode=self::ERROR_NONE;
	// 	return !$this->errorCode;
	// }
	public function authenticate()
	{
		$user = User::model()->with('employee')->findByAttributes(['email' => $this->username]);

		if ($user === null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} elseif (!CPasswordHelper::verifyPassword($this->password, $user->password)) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		} else {
			// Login success
			$this->_id = $user->id;

			Yii::app()->user->setState('user_id', $user->id);
			Yii::app()->user->setState('role', $user->role); // 'admin', 'employee', 'customer'

			// If employee, save category_id to session
			if ($user->role === 'employee' && $user->employee !== null) {
				Yii::app()->user->setState('category_id', $user->employee->category_id);
			}

			$this->errorCode = self::ERROR_NONE;
		}

		return !$this->errorCode;
	}


	public function getId()
	{
		return $this->_id;
	}
}
