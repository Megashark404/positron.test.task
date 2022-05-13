<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use common\models\Category;
use common\models\BookCategory;
use yii\web\NotFoundHttpException;
use yii\base\ErrorException;


/**
 * This is the model class for table "{{%book}}".
 *
 * @property string $isbn
 * @property string $title
 * @property string|null $thumbnail_url
 * @property string|null $short_description
 * @property string|null $long_description
 * @property int|null $status
 * @property string $authors
 * @property int $page_count
 *
 * @property BookCategory[] $bookCategories
 * @property Category[] $categories
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const STATUS_UNPUBLISHED = 0;
    const STATUS_PUBLISHED = 1;

    public $thumbnailFile;
    public $has_thumbnail;

    public static function tableName()
    {
        return '{{%book}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['isbn', 'title', 'authors', 'page_count'], 'required'],
            [['short_description', 'long_description'], 'string'],
            [['status', 'page_count'], 'integer'],
            [['isbn'], 'string', 'max' => 16],
            [['title', 'thumbnail_url'], 'string', 'max' => 256],
            [['authors'], 'string', 'max' => 255],
            [['isbn'], 'unique'],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'isbn' => 'Isbn',
            'title' => 'Title',
            'thumbnail_url' => 'Thumbnail Url',
            'short_description' => 'Short Description',
            'long_description' => 'Long Description',
            'status' => 'Status',
            'authors' => 'Authors',
            'page_count' => 'Page Count',
        ];
    }

    /**
     * Gets query for [[BookCategories]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\BookCategoryQuery
     */
    public function getBookCategories()
    {
        return $this->hasMany(BookCategory::className(), ['book_isbn' => 'isbn']);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\CategoryQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable('{{%book_category}}', ['book_isbn' => 'isbn']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\BookQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\BookQuery(get_called_class());
    }

    public function getStatusLabels() {
        return [
            self::STATUS_UNPUBLISHED => 'Unpublished',
            self::STATUS_PUBLISHED => 'Published',
        ];
    }


    public function save($runValidation = true, $attributeNames = null) {
        
        // Пишем имя файла картинки в базу
        if($this->thumbnailFile) {
            $this->thumbnail_url = '/storage/thumbs/'.$this->thumbnailFile->name;
        }

        $saved = parent::save($runValidation, $attributeNames);
        if(!$saved) {
            return false;
        }

        // если сохранение прошло успешно, сохраняем файл картинки в файловую систему
        if($this->thumbnailFile) {
            $thumbnailPath = Yii::getAlias('@backend/web/storage/thumbs/'.$this->thumbnailFile->name);
            if (!is_dir(dirname($thumbnailPath))) {
                FileHelper::createDirectory(dirname($thumbnailPath));
            }
            $this->thumbnailFile->saveAs($thumbnailPath);
        }

        return true;
    }

    public function setCategoriesById(array $categoriesId) {

        // удаляем все текущие категорий
        $currentCategories = $this->categories;
        foreach ($currentCategories as $currentCategory) {
            $this->unlink('categories', $currentCategory, $delete = true);
        }

        // назначаем новые категории
        foreach ($categoriesId as $categoryId) {
            $this->link('categories', Category::findOne($categoryId));
        }       

        //$this->link('categories', Category::findOne($id)); 
       // $this->link('categories', $category); 
    }

    public function setCategoryByName($categoryName) {
        $category = Category::find()->where(['name' => $categoryName])->one();
        $this->link('categories', $category); 
    }

    public function setCategoriesByName(array $categories) {
        if (empty($categories)) {
            $this->setCategoryByName('New Books');
        }
        foreach ($categories as $category) {
             $this->setCategoryByName($category);
        }

    }

    // возвращает книги из этих категорий
    public function getOtherBooks($isbn) {
        $books = [];

        $book = Book::findOne($isbn);
        foreach ($book->categories as $category) {
            foreach ($category->books as $fellowBook) {
                $books[] = $fellowBook;
            }
        }

        return $books;
    }

    public static function isExist($isbn) {
        $book = Book::findOne($isbn);
        if ($book) {
            return true;
        }
        return false;
    }

    public function downloadImage($url) {
        $thumbnailPath = Yii::getAlias('@backend/web/storage/thumbs/');
        if (!is_dir(dirname($thumbnailPath))) {
                FileHelper::createDirectory(dirname($thumbnailPath));
        }

        $fileName = basename($url);
        $thumbnailUrl = $thumbnailPath.$fileName;  

         // Скачиваем удаленную обложку в блоке try-catch  
        try {
            $remoteThumbnail = file_get_contents($url);  
            file_put_contents($thumbnailUrl, $remoteThumbnail);
            return '/storage/thumbs/'.$fileName;
        }   
        catch (ErrorException $e) {
            echo $e->getMessage();
            return '';
        }
        

    }

    public static function create (array $data) {        



        $newBook = new self();

        $newBook->isbn = $data['isbn'];
        $newBook->title = $data['title'];
        $newBook->authors = $newBook->getAuthors($data['authors']);
        $newBook->short_description = $data['shortDescription'] ?? '';
        $newBook->long_description = $data['longDescription'] ?? '';
        $newBook->status = $newBook->getStatus($data['status']);
        $newBook->page_count = $data['pageCount'] ?? 0;

        // Если у книги нет картинки - ставим пустую строку
        if (array_key_exists('thumbnailUrl', $data)) {  
            $newBook->thumbnail_url = $newBook->downloadImage($data['thumbnailUrl']);
        }
        else {
            $newBook->thumbnail_url = '';
        }

        $result = $newBook->save(false);

        return $newBook;
    }

    public function getStatus($status = null) {
        if ($status == 'PUBLISH') {
            return 1;
        }
        else {
            return 0;
        }
    }

    public function getAuthors($authors = null) {        
        if ($authors != null) {
            return implode(', ', $authors);
        }
        else {
            return '';
        }
    }
}
