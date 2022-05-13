<?php

namespace backend\controllers;

use common\models\Book;
use common\models\Category;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
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
     * Lists all Book models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Book::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'isbn' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param string $isbn Isbn
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($isbn)
    {
        $book = $this->findModel($isbn);
        $otherBooks = $book->getOtherBooks($isbn);

        //var_dump($otherBooks);

        return $this->render('view', [
            'model' => $this->findModel($isbn),
            'otherBooks' => $otherBooks
        ]);
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Book();

        $model->thumbnailFile = UploadedFile::getInstanceByName('thumbnail');

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'isbn' => $model->isbn]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $isbn Isbn
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($isbn)
    {
        $model = $this->findModel($isbn);

        $model->thumbnailFile = UploadedFile::getInstanceByName('thumbnail');



        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            //var_dump($model->thumbnail);die;
            return $this->redirect(['view', 'isbn' => $model->isbn]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionSetCategory($isbn) {
        $book = $this->findModel($isbn);

        // формируем список всех категорий для вывода в чекбоксах
        $allCategories = Category::getAllCategories();

        //формируем список нынешних категорий книги
        foreach ($book->categories as $category) {            
            $currentCategories[] = $category->id;
        }

        // при отправке формы устанавливаем категорию и редиректим на страницу книги
        if ($this->request->isPost) {
            $categoriesId = $this->request->post('category');
            $book->setCategoriesById($categoriesId);
           
            return $this->redirect(['view', 'isbn' => $book->isbn]);
        }

        return $this->render('set-category', [
            'book' => $book,
            'allCategories' => $allCategories,
            'currentCategories' => $currentCategories ?? []
        ]);
        
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $isbn Isbn
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($isbn)
    {
        $book = $this->findModel($isbn);
        foreach ($book->categories as $category) {
            $book->unlink('categories', $category, $delete = true);
        }
        $book->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $isbn Isbn
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($isbn)
    {
        if (($model = Book::findOne(['isbn' => $isbn])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
