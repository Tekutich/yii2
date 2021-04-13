<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Модель формы регистрации
 *
 * @property-read User|null $user
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
     * @return array правил валидации.
     */
    public function rules()
    {
        return [
            [['username', 'password', 'surname', 'name', 'patronymic'], 'required', 'message' => 'Заполните поле'],
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

    /*
     * Проверяет email.
     * Этот метод служит проверкой совпадения email.
     *
     * @param string $attribute
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
                $newUser->role = 0;
                $newUser->save();
            }
        }
    }

    /**
     * Выполняет вход пользователя, используя предоставленные имя пользователя и пароль.
     * @return bool успешно ли вошел пользователь в систему
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());
        }
        return false;
    }

    /**
     * поиск пользователя по [[username]]
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
