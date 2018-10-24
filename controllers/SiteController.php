<?php

namespace app\controllers;

use Yii;
use app\models\SignupForm;
use app\models\User;
use app\models\SomeDataModel;

class SiteController extends \app\components\BaseController
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->signup()) {
                Yii::$app->session->setFlash('success', "User created successfully.");
                return $this->goHome();
            }
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Tests caching.
     *
     * @return mixed
     */
    public function actionCaching()
    {
        Yii::$app->user->login(User::findOne(['username' => 'test_user']));
        $date = '2018-10-18';
        $type = 1;
        $dataBeforeUpdate = $this->selectSomeData($date, $type);
        $cachedDataBeforeUpdate = $this->selectSomeDataCached($date, $type);
        $model = SomeDataModel::findOne(['user_id' => Yii::$app->user->id, 'date' => $date, 'type' => $type]);
        if ($model->a + 1 <= 100) {
            $model->a++;
            $model->b = 'test_data_' . $model->a;
        } else {
            $model->a = 1;
            $model->b = 'test_data_1';
        }
        $model->save();
        $dataAfterUpdate = $this->selectSomeData($date, $type);
        $cachedDataAfterUpdate = $this->selectSomeDataCached($date, $type);
        Yii::$app->user->logout();
        return $this->render('caching', [
            'dataBeforeUpdate' => $dataBeforeUpdate[$model->id],
            'cachedDataBeforeUpdate' => $cachedDataBeforeUpdate[$model->id],
            'dataAfterUpdate' => $dataAfterUpdate[$model->id],
            'cachedDataAfterUpdate' => $cachedDataAfterUpdate[$model->id],
        ]);
    }

    protected function selectSomeDataCached($date, $type) {
        return Yii::$app->cache->getOrSet(('selectSomeData_'.Yii::$app->user->id.'_'.$date.'_'.$type),
            function () use ($date, $type) { return $this->selectSomeData($date, $type); },
            60
        );
    }

    protected function selectSomeData($date, $type) {
        $userId = Yii::$app->user->id;
        $dataList = SomeDataModel::find()->where(['date' => $date, 'type' => $type, 'user_id' => $userId])->all();
        $result = [];
        if (!empty($dataList)) {
            foreach ($dataList as $dataItem) {
                $result[$dataItem->id] = ['a' => $dataItem->a, 'b' => $dataItem->b];
            }
        }
        return $result;
    }
}
