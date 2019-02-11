<?php

namespace app\models;

use Yii;
use yii\web\ServerErrorHttpException;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property text $password
 * @property text $access_token
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property datetime $created
 * @property datetime $updated
 * @property datetime $deleted
 * @property boolean $is_deleted
 * */
class User extends Base implements \yii\web\IdentityInterface
{

    protected $cookieTime = 2592000;

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['username', 'password', 'first_name', 'last_name', 'email'], 'required'],
                [['username', 'first_name', 'last_name', 'password', 'email'], 'string', 'max' => 255],
                [['username', 'password', 'first_name', 'last_name', 'email'], 'trim'],
                ['email', 'email'],
                ['email', 'unique'],
                ['username', 'unique'],
                [['password'], 'string', 'min' => 8]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function fields()
    {
        $fields = parent::fields();

        unset($fields['password']);
        unset($fields['access_token']);

        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        $result = parent::beforeSave($insert);

        $userArray = User::find()->where(['username' => $this->username])->asArray()->one();

        if (!empty($this->password) && $this->password != $userArray['password']) {
            $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        }

        if ($this->isNewRecord) {
            $this->access_token = Yii::$app->getSecurity()->generatePasswordHash(rand(0, 1000));
        }

        return $result;
    }

    public function login()
    {
        $result = \Yii::$app->user->login($this, $this->cookieTime);

        if (empty($result)) {
            return $result;
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token, 'is_deleted' => false]);
    }

    public function markDeleted()
    {
        $this->username .= $this->getHash();
        $this->email .= $this->getHash();
        
        $result = parent::markDeleted();

        return $result;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'is_deleted' => false]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'is_deleted' => false]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public function getMyBooks($params = null)
    {
        $query = $this->getMyBooksQuery($params);
        $book = new Book();
        return $book->getList($params, $query);
    }
    
    public function getMyBooksIds($params = null)
    {
        $query = $this->getMyBooksQuery($params);
        $query->select('id');
        
        $books = $query->asArray()->all();
        $booksIds = [];
        
        if (empty($books)) {
            return $booksIds;
        }
        
        $booksIds = $this->getIdsList($books);
        
        return $booksIds;
    }

    public function getMyBooksQuery($params = [])
    {
        if (empty($this->id)) {
            return;
        }
        
        $book = new Book();
        $query = $book->getListQuery($params);

        $userToBook = new UserToBook();
        $userToBookQuery = $userToBook->getListQuery()->
                select('book_id')->
                andWhere(['user_id' => $this->id]);

        $query->andWhere(['in', 'id', $userToBookQuery]);
        
        return $query;
    }

    public function addBookToMy($bookId)
    {
        if (empty($bookId) || empty($this->id)) {
            return;
        }
        
        $userToBook = UserToBook::findByUserAndBook($this->id, $bookId, true);
        
        if (empty($userToBook->user_id)) {
            $userToBook = new UserToBook();
        }

        $userToBook->user_id = $this->id;
        $userToBook->book_id = $bookId;
        $userToBook->is_deleted = false;
        
        return $userToBook->save();
    }

    public function removeBookFromMy($bookId)
    {
        if (empty($bookId) || empty($this->id)) {
            return;
        }
        
        $userToBook = UserToBook::findByUserAndBook($this->id, $bookId);
        
        if (empty($userToBook->user_id)) {
            throw new ServerErrorHttpException('Book is not in your collection');
        }
        
        $userToBook->is_deleted = true;
        
        return $userToBook->save();
    }
}
