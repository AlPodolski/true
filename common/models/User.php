<?php
namespace common\models;

use common\components\events\UserRegister;
use frontend\models\Files;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\Review;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $city_id
 * @property integer $role
 * @property integer $cash
 * @property integer $age
 * @property integer $male
 * @property integer $notify
 * @property integer $open_message
 * @property integer $fake
 * @property string $password write-only password
 * @property string $partner_id
 * @property Review $review
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    const USER_ROLE = 0;
    const ADMIN_ROLE = 1;

    const MEN_MALE = 1;
    const WOOMEN_MALE = 0;

    const NOTIFY_ALLOWED = 1;
    const NOTIFY_DISALLOWED = 0;

    const MESSAGE_ALLOWED = 1;
    const MESSAGE_DISALLOWED = 0;

    const REAL_USER = 1;
    const FAKE_USER = 0;

    public function __construct()
    {
        $this->on(self::EVENT_AFTER_INSERT, [UserRegister::class, 'handle']);

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['city_id', 'integer'],
            ['role', 'integer'],
            ['cash', 'integer'],
            ['partner_id', 'string'],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['fake', 'default', 'value' => self::REAL_USER],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    public function getReview()
    {
        return $this->hasMany(Review::class, ['author' => 'id'])->with('article', 'author');
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Finds user by username
     *
     * @param $email
     * @return static|null
     */
    public static function findAdmin(string $email) : User
    {
        return static::findOne(['email' => $email, 'role' => User::ADMIN_ROLE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getAvatar()
    {
        return $this->hasOne(Files::class, ['related_id' => 'id'])->andWhere(['related_class' => self::class]);
    }

    public function getTelegram()
    {
        return $this->hasOne(TelegramToken::class, ['user_id' => 'id'])
            ->andWhere(['token_status' => TelegramToken::TOKEN_STATUS_ACTIVE]);
    }

    public function getPostCount()
    {
        return $this->hasMany(Posts::class, ['user_id' => 'id'])->count();
    }
}
