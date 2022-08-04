<?php

namespace app\controllers;

use Yii;
use app\models\Transaction;
use app\models\Transfer;
use app\models\TransferSearch;
use app\models\Client;
use app\models\Account;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TransferController implements the CRUD actions for Transfer model.
 */
class TransferController extends Controller
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
					'class' => VerbFilter::className(),
					'actions' => [
						'delete' => ['POST'],
					],
				],
			]
		);
	}

	/**
	 * Lists all Transfer models.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		$searchModel = new TransferSearch();
		$dataProvider = $searchModel->search($this->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Transfer model.
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
	 * Creates a new Transfer model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return string|\yii\web\Response
	 */
	public function actionCreate()
	{
		$model = new Transfer();
		$model1 = new Transaction();
		$model2 = new Transaction();
		$message = '';

		if ($this->request->isPost && $model->load($this->request->post())) {

			$accFrom = Account::findOne($model1->account_id = $model->from_account_id);
			$accTo = Account::findOne($model2->account_id = $model->to_account_id);
			$db = Yii::$app->db;
			$transaction = $db->beginTransaction();

			if ($accFrom->currency === 'BYN' && $accTo->currency === 'BYN' && (($accFrom->balance - $model->sum) >= 0) && ($accFrom->client_id !== $accTo->client_id)) {
				if ($model->sum > 0) {
					try {
						$accFrom->balance -= $model->sum;
						$accFrom->save();

						$accTo->balance += $model->sum;
						$accTo->save();

						$model1->sum = -$model->sum;
						$model2->sum = $model->sum;

						$model1->save();
						$model2->save();
						$model->save();

						$transaction->commit();
					} catch (\Exception $e) {
						$transaction->rollback();
					}

					return $this->redirect(['view', 'id' => $model->id]);
				} else {
					$model->from_account_id = '';
					$model->to_account_id = '';
					$model->sum = '';
					$message = 'You can not execute a transaction with the sum less than 0 or equal to 0.';
				}
			} elseif ($accFrom->currency === 'BYN' && $accTo->currency === 'EUR' && (($accFrom->balance - $model->sum) >= 0) && ($accFrom->client_id !== $accTo->client_id)) {
				$dataEur = file_get_contents(LINK_EUR);
				$courseEur = json_decode($dataEur, true);

				if ($model->sum > 0) {
					try {
						$accFrom->balance -= $model->sum;
						$accFrom->save();

						$accTo->balance += ($model->sum / $courseEur['Cur_OfficialRate']);
						$accTo->save();

						$model1->sum = -$model->sum;
						$model2->sum = ($model->sum / $courseEur['Cur_OfficialRate']);

						$model1->save();
						$model2->save();
						$model->save();

						$transaction->commit();
					} catch (\Exception $e) {
						$transaction->rollback();
					}

					return $this->redirect(['view', 'id' => $model->id]);
				} else {
					$model->from_account_id = '';
					$model->to_account_id = '';
					$model->sum = '';
					$message = 'You can not execute a transaction with the sum less than 0 or equal to 0.';
				}
			} elseif ($accFrom->currency === 'BYN' && $accTo->currency === 'USD' && (($accFrom->balance - $model->sum) >= 0) && ($accFrom->client_id !== $accTo->client_id)) {
				$dataUsd = file_get_contents(LINK_USD);
				$courseUsd = json_decode($dataUsd, true);

				if ($model->sum > 0) {
					try {
						$accFrom->balance -= $model->sum;
						$accFrom->save();

						$accTo->balance += ($model->sum / $courseUsd['Cur_OfficialRate']);
						$accTo->save();

						$model1->sum = -$model->sum;
						$model2->sum = ($model->sum / $courseUsd['Cur_OfficialRate']);

						$model1->save();
						$model2->save();
						$model->save();

						$transaction->commit();
					} catch (\Exception $e) {
						$transaction->rollback();
					}

					return $this->redirect(['view', 'id' => $model->id]);
				} else {
					$model->from_account_id = '';
					$model->to_account_id = '';
					$model->sum = '';
					$message = 'You can not execute a transaction with the sum less than 0 or equal to 0.';
				}
			} elseif ($accFrom->currency === 'EUR' && $accTo->currency === 'BYN' && (($accFrom->balance - $model->sum) >= 0) && ($accFrom->client_id !== $accTo->client_id)) {
				$dataEur = file_get_contents(LINK_EUR);
				$courseEur = json_decode($dataEur, true);

				if ($model->sum > 0) {
					try {
						$accFrom->balance -= $model->sum;
						$accFrom->save();

						$accTo->balance += ($model->sum * $courseEur['Cur_OfficialRate']);
						$accTo->save();

						$model1->sum = -$model->sum;
						$model2->sum = ($model->sum * $courseEur['Cur_OfficialRate']);

						$model1->save();
						$model2->save();
						$model->save();

						$transaction->commit();
					} catch (\Exception $e) {
						$transaction->rollback();
					}

					return $this->redirect(['view', 'id' => $model->id]);
				} else {
					$model->from_account_id = '';
					$model->to_account_id = '';
					$model->sum = '';
					$message = 'You can not execute a transaction with the sum less than 0 or equal to 0.';
				}
			} elseif ($accFrom->currency === 'EUR' && $accTo->currency === 'EUR' && (($accFrom->balance - $model->sum) >= 0) && ($accFrom->client_id !== $accTo->client_id)) {
				if ($model->sum > 0) {
					try {
						$accFrom->balance -= $model->sum;
						$accFrom->save();

						$accTo->balance += $model->sum;
						$accTo->save();

						$model1->sum = -$model->sum;
						$model2->sum = $model->sum;

						$model1->save();
						$model2->save();
						$model->save();

						$transaction->commit();
					} catch (\Exception $e) {
						$transaction->rollback();
					}

					return $this->redirect(['view', 'id' => $model->id]);
				} else {
					$model->from_account_id = '';
					$model->to_account_id = '';
					$model->sum = '';
					$message = 'You can not execute a transaction with the sum less than 0 or equal to 0.';
				}
			} elseif ($accFrom->currency === 'EUR' && $accTo->currency === 'USD' && (($accFrom->balance - $model->sum) >= 0) && ($accFrom->client_id !== $accTo->client_id)) {
				$dataUsd = file_get_contents(LINK_USD);
				$dataEur = file_get_contents(LINK_EUR);

				$courseUsd = json_decode($dataUsd, true);
				$courseEur = json_decode($dataEur, true);

				if ($model->sum > 0) {
					try {
						$accFrom->balance -= $model->sum;
						$accFrom->save();

						$accTo->balance += ($model->sum * $courseEur['Cur_OfficialRate'] / $courseUsd['Cur_OfficialRate']);
						$accTo->save();

						$model1->sum = -$model->sum;
						$model2->sum = ($model->sum * $courseEur['Cur_OfficialRate'] / $courseUsd['Cur_OfficialRate']);

						$model1->save();
						$model2->save();
						$model->save();

						$transaction->commit();
					} catch (\Exception $e) {
						$transaction->rollback();
					}

					return $this->redirect(['view', 'id' => $model->id]);
				} else {
					$model->from_account_id = '';
					$model->to_account_id = '';
					$model->sum = '';
					$message = 'You can not execute a transaction with the sum less than 0 or equal to 0.';
				}
			} elseif ($accFrom->currency === 'USD' && $accTo->currency === 'BYN' && (($accFrom->balance - $model->sum) >= 0) && ($accFrom->client_id !== $accTo->client_id)) {
				$dataUsd = file_get_contents(LINK_USD);
				$courseUsd = json_decode($dataUsd, true);

				if ($model->sum > 0) {
					try {
						$accFrom->balance -= $model->sum;
						$accFrom->save();

						$accTo->balance += ($model->sum * $courseUsd['Cur_OfficialRate']);
						$accTo->save();

						$model1->sum = -$model->sum;
						$model2->sum = ($model->sum * $courseUsd['Cur_OfficialRate']);

						$model1->save();
						$model2->save();
						$model->save();

						$transaction->commit();
					} catch (\Exception $e) {
						$transaction->rollback();
					}

					return $this->redirect(['view', 'id' => $model->id]);
				} else {
					$model->from_account_id = '';
					$model->to_account_id = '';
					$model->sum = '';
					$message = 'You can not execute a transaction with the sum less than 0 or equal to 0.';
				}
			} elseif ($accFrom->currency === 'USD' && $accTo->currency === 'EUR' && (($accFrom->balance - $model->sum) >= 0) && ($accFrom->client_id !== $accTo->client_id)) {
				$dataUsd = file_get_contents(LINK_USD);
				$dataEur = file_get_contents(LINK_EUR);

				$courseUsd = json_decode($dataUsd, true);
				$courseEur = json_decode($dataEur, true);

				if ($model->sum > 0) {
					try {
						$accFrom->balance -= $model->sum;
						$accFrom->save();

						$accTo->balance += ($model->sum * $courseUsd['Cur_OfficialRate'] / $courseEur['Cur_OfficialRate']);
						$accTo->save();

						$model1->sum = -$model->sum;
						$model2->sum = ($model->sum * $courseUsd['Cur_OfficialRate'] / $courseEur['Cur_OfficialRate']);

						$model1->save();
						$model2->save();
						$model->save();

						$transaction->commit();
					} catch (\Exception $e) {
						$transaction->rollback();
					}

					return $this->redirect(['view', 'id' => $model->id]);
				} else {
					$model->from_account_id = '';
					$model->to_account_id = '';
					$model->sum = '';
					$message = 'You can not execute a transaction with the sum less than 0 or equal to 0.';
				}
			} elseif ($accFrom->currency === 'USD' && $accTo->currency === 'USD' && (($accFrom->balance - $model->sum) >= 0) && ($accFrom->client_id !== $accTo->client_id)) {
				if ($model->sum > 0) {
					try {
						$accFrom->balance -= $model->sum;
						$accFrom->save();

						$accTo->balance += $model->sum;
						$accTo->save();

						$model1->sum = -$model->sum;
						$model2->sum = $model->sum;

						$model1->save();
						$model2->save();
						$model->save();

						$transaction->commit();
					} catch (\Exception $e) {
						$transaction->rollback();
					}

					return $this->redirect(['view', 'id' => $model->id]);
				} else {
					$model->from_account_id = '';
					$model->to_account_id = '';
					$model->sum = '';
					$message = 'You can not execute a transaction with the sum less than 0 or equal to 0.';
				}
			} else {
				$message = 'There are not enough funds to complete this transfer or you are trying to use the same accounts. Please select the sum less than balance and check the accounts you use.';
			}
		} else {
			$model->loadDefaultValues();
		}

		$accounts = Account::find()->indexBy('id')->asArray()->all();
		$clients = Client::find()->indexBy('id')->asArray()->all();
		$array = [];

		foreach ($accounts as $key => $account) {
			$array += [$key => "{$clients[$account['client_id']]['surname']} {$clients[$account['client_id']]['name']} {$clients[$account['client_id']]['patronymic']} - {$account['currency']} - {$key}"];
		}

		return $this->render('create', [
			'model' => $model,
			'array' => $array,
			'message' => $message,
		]);
	}

	/**
	 * Updates an existing Transfer model.
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
	 * Deletes an existing Transfer model.
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
	 * Finds the Transfer model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param int $id ID
	 * @return Transfer the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Transfer::findOne(['id' => $id])) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
