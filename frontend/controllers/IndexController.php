<?php

namespace frontend\controllers;

use Yii;
use common\models\Category;
use common\models\Book;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * IndexController implements the CRUD actions for Category model.
 */
class IndexController extends Controller
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
     * Lists all Category models.
     *
     * @return string
     */
    public function actionIndex()    {
       
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find()->where(['parent_id' => null]),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ] 
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
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
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



    public function actionCategory($id) {
        $model = $this->findModel($id);

        $subCategoriesDataProvider = new ActiveDataProvider([
            'query' => Category::find()->where(['parent_id' => $id]),           
        ]);

        $booksDataProvider = new ActiveDataProvider([
            'query' => Book::find()->joinWith('categories')->where(['category_id' => $id]),   
            'pagination' => [
                'pageSize' => Yii::$app->params['booksPerPage']
            ],
            /*
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ] 
            ],
            */
        ]);


        return $this->render('category', [
            'subCategoriesDataProvider' => $subCategoriesDataProvider ?? null,
            'booksDataProvider' => $booksDataProvider,
            'model' => $model
        ]);
    }


    public function actionBook($isbn) {


        $model = Book::findOne($isbn);

        return $this->render('book', [
            'model' => $model
        ]);


    }

    public function actionSearch() {
        $title = $this->request->get('search-title');
        $authors = $this->request->get('search-authors');
        $status = $this->request->get('search-status');

        $query = Book::find();        
       
        if (!empty($title)) {
            $query->andwhere(['like', 'title', $title]);
        }
        if (!empty($authors)) {
            $query->andwhere(['like', 'authors', $authors]);
        }
        if ($status != '') {          
            $query->andwhere('status = :status', [':status' => $status]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query         
        ]);

        return $this->render('found_books', [
            'dataProvider' => $dataProvider,
        ]);

    }
}
