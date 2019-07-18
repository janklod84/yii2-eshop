<?php
namespace app\models;


use yii\db\ActiveRecord;

/**
 * Class Category
 *
 * @package app\models
 */
class Category extends ActiveRecord
{

     /**
      * Get table name
      *
      * @return string
     */
     public static function tableName()
     {
         return 'category';
     }


     /**
      * Table relation
      *
      * связанные таблицы
     */
     public function getProducts()
     {
         return $this->hasMany(Product::className(), ['category_id' => 'id']);
     }
}