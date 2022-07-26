<?php

namespace app\controllers;

use Yii;
use app\models\Transaction;
use app\models\TransactionSearch;
use app\models\Client;
use app\models\Account;
use app\controllers\behaviors\AccessBehavior;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TransactionController implements the CRUD actions for Transaction model.
 */
class TransactionController extends Controller
{
	/**
	 * @inheritDoc
	 */
	public function behaviors()
	{
		return array_merge(
			parent::behaviors(),
			[
				'verbs' => [
					'class' => VerbFilter::class,
					'actions' => [
						'delete' => ['POST'],
					],
				],
				AccessBehavior::class,
			]
		);
	}

	/**
	 * Lists all Transaction models.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		$searchModel = new TransactionSearch();
		$dataProvider = $searchModel->search($this->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Transaction model.
	 * @param int $id ID
	 * @return string
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new Transaction model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return string|\yii\web\Response
	 */
	public function actionCreate()
	{
		$model = new Transaction();

		$accounts = Account::find()->indexBy('id')->asArray()->all();
		$clients = Client::find()->indexBy('id')->asArray()->all();
		$array = [];

		foreach ($accounts as $key => $account) {
			$array += [$key => "{$clients[$account['client_id']]['surname']} {$clients[$account['client_id']]['name']} {$clients[$account['client_id']]['patronymic']} - {$account['currency']} - {$key}"];
		}

		if ($this->request->isPost) {
			if ($model->load($this->request->post()) && $model->save()) {
				$acc = Account::findOne($model->account_id);
				if (($acc->balance + $model->sum) >= 0) {
					$acc->balance += $model->sum;
					$acc->save();
					return $this->redirect(['view', 'id' => $model->id]);
				}
			}
		} else {
			$model->loadDefaultValues();
		}

		return $this->render('create', [
			'model' => $model,
			'array' => $array,
		]);
	}

	/**
	 * Updates an existing Transaction model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param int $id ID
	 * @return string|\yii\web\Response
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing Transaction model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param int $id ID
	 * @return \yii\web\Response
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the Transaction model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param int $id ID
	 * @return Transaction the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Transaction::findOne(['id' => $id])) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
