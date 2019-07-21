<?php
namespace app\models;


use yii\db\ActiveRecord;
use Yii;


/**
 * Class User
 *
 * @package app\models
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{

    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'user';
    }


    /**
     * Find User by id
     *
     * @param int|string $id
     * @return User|\yii\web\IdentityInterface|null
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // return static::findOne(['access_token' => $token]);
    }


    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Get Auth Key [ auth_key permet d'authentifier l'utilisateur automatiquement par cookie ]
     *
     * @return mixed|string
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }


    /**
     * Validate Auth Key
     *
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        // return $this->password === $password;

        return Yii::$app->security->validatePassword($password, $this->password);
    }


    /**
     * Создано метод для генерации auth key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString(); // 0 - 32 symbols
    }
}
