<?php

namespace app\controllers;

use app\models\RecipeTag;
use app\models\RecipeTagSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RecipeTagController implements the CRUD actions for RecipeTag model.
 */
class RecipeTagController extends Controller
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
     * Lists all RecipeTag models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RecipeTagSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RecipeTag model.
     * @param int $recipe_id Recipe ID
     * @param int $tag_id Tag ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($recipe_id, $tag_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($recipe_id, $tag_id),
        ]);
    }

    /**
     * Creates a new RecipeTag model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RecipeTag();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'recipe_id' => $model->recipe_id, 'tag_id' => $model->tag_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RecipeTag model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $recipe_id Recipe ID
     * @param int $tag_id Tag ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($recipe_id, $tag_id)
    {
        $model = $this->findModel($recipe_id, $tag_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'recipe_id' => $model->recipe_id, 'tag_id' => $model->tag_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RecipeTag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $recipe_id Recipe ID
     * @param int $tag_id Tag ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($recipe_id, $tag_id)
    {
        $this->findModel($recipe_id, $tag_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RecipeTag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $recipe_id Recipe ID
     * @param int $tag_id Tag ID
     * @return RecipeTag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($recipe_id, $tag_id)
    {
        if (($model = RecipeTag::findOne(['recipe_id' => $recipe_id, 'tag_id' => $tag_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
