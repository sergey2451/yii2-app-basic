<?php

namespace app\controllers;

use app\models\Account;
use app\models\Client;
use app\models\AccountSearch;
use app\models\TransactionSearch;
use app\controllers\behaviors\AccessBehavior;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AccountController implements the CRUD actions for Account model.
 */
class AccountController extends Controller
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
	 * Lists all Account models.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		$searchModel = new AccountSearch();
		$dataProvider = $searchModel->search($this->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Account model.
	 * @param int $id ID
	 * @return string
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		$searchModel = new TransactionSearch();
		$searchModel->account_id = $id;
		$dataProvider = $searchModel->search($this->request->queryParams);

		return $this->render('view', [
			'model' => $this->findModel($id),
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Creates a new Account model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return string|\yii\web\Response
	 */
	public function actionCreate($id)
	{
		$model = new Account();
		$model->client_id = $this->findModel($id)->id;

		$clients = Client::find()->indexBy('id')->asArray()->all();
		$str = "{$clients[$model->client_id]['name']} {$clients[$model->client_id]['surname']} Accounts";

		if ($this->request->isPost) {
			if ($model->load($this->request->post()) && $model->save()) {
				return $this->redirect(['view', 'id' => $model->id]);
			}
		} else {
			$model->loadDefaultValues();
		}

		return $this->render('create', [
			'model' => $model,
			'str' => $str,
		]);
	}

	/**
	 * Updates an existing Account model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param int $id ID
	 * @return string|\yii\web\Response
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
			return $this->redirect(['client/view', 'id' => $model->client_id]);
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing Account model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param int $id ID
	 * @return \yii\web\Response
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$model->delete();

		return $this->redirect(["client/view", 'id' => $model->client_id]);
	}

	/**
	 * Finds the Account model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param int $id ID
	 * @return Account the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Account::findOne(['id' => $id])) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
