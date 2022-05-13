<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Json;
use common\models\Book;
use common\models\Category;

class ImportController extends Controller
{
    

    public function actionTest() {
        var_dump(Yii::$app->params);
    }
    
    public function actionStart()
    {   
        $count = 1;

        // парсим список книг
        $url = Yii::$app->params['bookParseUrl'];
        $json = file_get_contents($url);
        $books = Json::decode($json);           

        // в цикле перебираем книги
        foreach ($books as $book) {

             // если у книги отсутствует isbn - не импортируем эту книгу
            if (!array_key_exists('isbn', $book)) { 
                echo "Skip: book '{$book['title']}' is skipped because of missing ISBN ".PHP_EOL;
                continue;
            }

            $count++;

            // Создаем категории. Если категории не указаны - создаем категорию "Новинки"
            if (empty($book['categories'])) {                   
                    Category::createByName('New Books');
            }
           
            foreach ($book['categories'] as $category) {
                Category::createByName($category);
            }

            // создаем книгу
            if (!Book::isExist($book['isbn'])) {

                $newBook = Book::create($book);                

                if ($newBook) {
                    // назначаем категорию
                    $newBook->setCategoriesByName($book['categories']);
                    echo "Success: book '{$book['title']}' is imported ".PHP_EOL;
                }
                else {
                    echo "Fail: failed importing book '{$book['title']}'".PHP_EOL;
                }                
            }
            else {
                echo "Skip: book '{$book['title']}' is already exist".PHP_EOL;
            }

          //  if($count > 150) break;
        }   
       
    }

}
