<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Класс модели таблицы "users".
 *
 * @property int $id
 * @property string $surname фамилия
 * @property string $name имя
 * @property string $patronymic отчество
 * @property string $email
 * @property string $password пароль
 * @property int $role роль
 * @property string|null $auth_key
 *
 * @property Orders[] $orders модель Orders
 * @property string $new_password атрибут для нового пароля
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public $new_password = null;
    const roleAdmin = 1;
    const roleUser = 0;

    public function rules()
    {
        return [
            [['surname', 'name', 'patronymic', 'email', 'password', 'role'], 'required', 'message' => 'Пожалуйста, заполните поле {attribute}'],
            [['role'], 'integer'],
            [['surname', 'name', 'patronymic'], 'string', 'max' => 100],
            [['email', 'password', 'auth_key', 'new_password'], 'string', 'max' => 255],
            [['email'], 'unique'],
            ['role', 'in', 'range' => [self::roleUser, self::roleAdmin]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'surname' => 'Фамилия',
            'name' => 'Имя',
            'patronymic' => 'Отчество',
            'email' => 'Email',
            'password' => 'Пароль',
            'role' => 'Роль',
            'auth_key' => 'Auth Key',
        ];
    }

    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    /**
     * Поииск пользователя по email
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['email' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Проверка пароля
     *
     * @param string $password пароль для проверки
     * @return bool если предоставленный пароль действителен для текущего пользователя
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Создание токена для "запоминания пользователя"
     */
    public function generateAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    /**
     * Проверка администратор или пользователь
     */
    public static function isUserAdmin($username)
    {
        if (static::findOne(['email' => $username, 'role' => self::roleAdmin])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Связь с [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['user_id' => 'id']);
    }
}
