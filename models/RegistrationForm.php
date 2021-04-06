<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class RegistrationForm extends Model
{
    public $username;
    public $password;
    public $surname;
    public $name;
    public $patronymic;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password', 'surname', 'name', 'patronymic'], 'required', 'message' => 'Заполните поле'],

            // rememberMe must be a boolean value

            // password is validated by validatePassword()
            ['username', 'validateUsername'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Email',
            'password' => 'Пароль',
            'surname' => 'Фамилия',
            'name' => 'Имя',
            'patronymic' => 'Отчество',
            'rememberMe' => 'Запомнить'
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateUsername($attribute, $params)
    {

        if (!$this->hasErrors()) {
            $isExists = User::find()->where(['email' => $this->username])->exists();
            if ($isExists == true) {
                $this->addError($attribute, 'Данная почта уже зарегистрирована');
            } else {
                $newUser = new User();
                $newUser->email = $this->username;
                $newUser->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
                $newUser->surname = $this->surname;
                $newUser->name = $this->name;
                $newUser->patronymic = $this->patronymic;
                $newUser->save();
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());
        }
        return false;
    }

    /**
     * Finds user by [[username]]
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
