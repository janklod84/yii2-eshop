<?php
namespace app\models;


use yii\db\ActiveRecord;

/**
 * Class Product
 *
 * @package app\models
 */
class Product extends ActiveRecord
{

    /**
     * Get table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'product';
    }


    /**
     * Table relation
     *
     * связанные таблицы
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}