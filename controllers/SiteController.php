<?php

namespace app\controllers;

use app\models\Account;
use app\models\Balance;
use app\models\Course;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class SiteController extends Controller
{
    public $defaultAction = 'account-index';

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionAccountIndex()
    {
        $account = new Account();

        if ($account->load(Yii::$app->request->post()) && $account->save()) {
            return $this->refresh();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Account::find(),
            'sort' => [
                'defaultOrder' => ['createdAt' => SORT_DESC],
            ],
            'pagination' => [
                'defaultPageSize' => 100,
            ],
        ]);

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
            'account' => $account,
        ]);
    }

    public function actionBalanceIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Balance::find(),
            'sort' => [
                'defaultOrder' => ['createdAt' => SORT_DESC],
            ],
            'pagination' => [
                'defaultPageSize' => 100,
            ],
        ]);

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCourseIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Course::find(),
            'sort' => [
                'defaultOrder' => ['createdAt' => SORT_DESC],
            ],
            'pagination' => [
                'defaultPageSize' => 100,
            ],
        ]);

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
        ]);
    }

}
