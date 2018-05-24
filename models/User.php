<?php

namespace models;

use app\AccessControl;
use app\db\Model;
use helpers\Url;

/**
 * @property integer $id
 * @property string $username
 * @property integer $password
 */
class User extends Model
{
    public $errors;
    public static $isGuest = true;

    public static function tableName()
    {
        return 'user';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'username',
            'password' => 'password',
        ];
    }

    public function login()
    {
        $user = User::find()->where(['username' => $this->username, 'password' => md5($this->password)])->one();
        if ($user) {
            AccessControl::$isGuest = false;
            $_SESSION['user'] = true;
            Url::redirect('task/index');
        }
        $this->errors = 'Неверный логин или пароль';
        return false;
    }

    public function logout()
    {
        if (!AccessControl::$isGuest) {
            unset($_SESSION['user']);
        }
    }
}