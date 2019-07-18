<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 03.04.2016
 * Time: 11:35
 */

namespace app\models;

use yii\db\ActiveRecord;

class Category extends ActiveRecord{

    public static function tableName(){
        return 'categories';
    }

    public function getProducts(){
        return $this->hasMany(Product::className(), ['parent' => 'id']);
    }

}