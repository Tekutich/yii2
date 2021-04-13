<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Модель формы входа.
 *
 * @property-read User|null $user только чтение.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array правил валидации.
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Email',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить'
        ];
    }

    /**
     * Проверяет пароль.
     * Этот метод служит встроенной проверкой пароля.
     *
     * @param string $attribute атрибут, который в настоящее время проверяется
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неправильный email или пароль.');
            }
        } else {
            $this->addError($attribute, 'Ошибки.');
        }
    }

    /**
     * Выполняет вход пользователя, используя предоставленные имя пользователя и пароль.
     * @return bool успешно ли вошел пользователь в систему
     */
    public function login()
    {
        if ($this->validate()) {
            if ($this->rememberMe) {
                $u = $this->getUser();
                $u->generateAuthKey();
                $u->save();
            }
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    /**
     * Поиск пользователя по [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
