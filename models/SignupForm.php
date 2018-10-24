<?php
namespace app\models;

use yii\base\Model;
use app\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $type;
    public $is_entrepreneur;
    public $fullname;
    public $inn;
    public $org_name;
    public $org_inn;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            [['is_entrepreneur', 'type', 'fullname'], 'required'],
            [['is_entrepreneur'], 'boolean'],
            [['type', 'inn', 'org_inn'], 'integer'],
            ['type', 'in', 'range' => [1, 2]],
            ['inn', 'string', 'length' => 12],
            ['org_inn', 'string', 'length' => 10],
            [['fullname', 'org_name'], 'string', 'max' => 255],
            ['inn', 'required', 'when' => function ($model) { return (bool)$model->is_entrepreneur === true; },
                'whenClient' => 'function (attribute, value) { return $("#signupform-is_entrepreneur").is(":checked") === true; }'],
            [['org_name', 'org_inn'], 'required', 'when' => function ($model) { return (int)$model->type === 2; },
                'whenClient' => 'function (attribute, value) { return $("#signupform-type").val() === "2"; }'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->fullname = $this->fullname;
        if ($this->type === 1) {
            $user->is_entrepreneur = $this->is_entrepreneur;
            if ($user->is_entrepreneur === true) {
                $user->inn = $this->inn;
            }
        } else {
            $user->has_organization = true;
            $user->org_name = $this->org_name;
            $user->org_inn = $this->org_inn;
        }
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
