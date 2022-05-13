<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property int $id
 * @property string $name
 * @property int $parent_id
 *
 * @property BookCategory[] $bookCategories
 * @property Book[] $bookIsbns
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent_id' => 'Parent ID',
        ];
    }

    /**
     * Gets query for [[BookCategories]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\BookCategoryQuery
     */
    public function getBookCategories()
    {
        return $this->hasMany(BookCategory::className(), ['category_id' => 'id']);
    }

    /**
     * Gets query for [[BookIsbns]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\BookQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['isbn' => 'book_isbn'])->viaTable('{{%book_category}}', ['category_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CategoryQuery(get_called_class());
    }

    public static function getByName($name) {
        $category = self::find()->where(['name' => $name])->one();
        if ($category) {
            return $category;
        }
        return false;
    }

   
    public static function createByName($name) {   
        if (!self::getByName($name)) {
            $category = new self;
            $category->name = $name;
            $category->save();
        }
        
    }

    public static function getAllCategories() {
        $categories = self::find()->all();
        foreach ($categories as $category) {
            $tempArray['id'] = $category->id;
            $tempArray['name'] = $category->name;        
            $allCategories[] = $tempArray;
        }
        return $allCategories;
    }

    public static function getCategoryName($id) {
        return self::findOne($id)->name;
    }

}
