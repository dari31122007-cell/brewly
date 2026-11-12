<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['username', 'email', 'password', 'password_repeat'], 'required'],
            ['email', 'email'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Это имя пользователя уже занято.'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Этот Email уже зарегистрирован.'],
            ['password', 'string', 'min' => 6, 'message' => 'Пароль должен содержать минимум 6 символов.'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'email' => 'Email',
            'password' => 'Пароль',
            'password_repeat' => 'Повторите пароль',
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        // Генерируем безопасный хеш пароля
        $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        // Генерируем случайный ключ авторизации
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->status = 10; // 10 = Active

        if ($user->save()) {
            // Автоматически входим в систему после регистрации
            return Yii::$app->user->login($user, 3600 * 24 * 30); // 30 дней
        }

        return null;
    }
}