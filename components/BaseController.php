<?php

namespace app\components;

use yii\web\Controller;
use yii\web\HttpException;
use app\models\Config;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        
        if ((bool)Config::find()->select('value')->where(['name' => 'is_online'])->scalar() === false) {
            throw new HttpException(403, "The server is under maintenance.");
        }
        
        return true;
    }
}
