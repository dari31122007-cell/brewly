<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Модель пользователя для работы с БД и аутентификации
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property string|null $avatar_path
 * @property string|null $bio
 * @property int $status 10=Active, 0=Inactive
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Favorite[] $favorites
 * @property Recipe[] $recipes
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user'; // ТЕПЕРЬ ЗДЕСЬ ПРАВИЛЬНОЕ ИМЯ ТАБЛИЦЫ!
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password_hash', 'auth_key'], 'required'],
            [['bio'], 'string'],
            [['status'], 'integer', 'min' => 0, 'max' => 10],
            [['created_at', 'updated_at'], 'safe'],
            [['username'], 'string', 'max' => 50],
            [['email', 'password_hash', 'avatar_path'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['email'], 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Имя пользователя',
            'email' => 'Email',
            'password_hash' => 'Пароль',
            'auth_key' => 'Ключ авторизации',
            'avatar_path' => 'Аватар',
            'bio' => 'О себе',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    // ==========================================
    // МЕТОДЫ ДЛЯ АВТОРИЗАЦИИ (LoginForm)
    // ==========================================

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    // ==========================================
    // МЕТОДЫ ИНТЕРФЕЙСА IdentityInterface
    // ==========================================

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => 10]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null; 
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    // ==========================================
    // СВЯЗИ С ДРУГИМИ ТАБЛИЦАМИ
    // ==========================================

    public function getFavorites()
    {
        return $this->hasMany(Favorite::className(), ['user_id' => 'id']);
    }

    public function getRecipes()
    {
        return $this->hasMany(Recipe::className(), ['author_id' => 'id']);
    }
}