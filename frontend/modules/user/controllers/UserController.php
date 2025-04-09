<?php


namespace frontend\modules\user\controllers;

use common\models\City;
use common\models\LoginForm;
use frontend\models\ContactForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\redis\Connection;
use yii\web\BadRequestHttpException;
use frontend\modules\user\controllers\CabinetBeforeController as Controller;

class UserController extends Controller
{

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('/cabinet');
        }

        if ( !$_POST['g-recaptcha-response'] ) {

            Yii::$app->session->setFlash('warning' , 'нужно заполнить капчу');

            Yii::$app->response->redirect(['/login'], 301, false);

            return true;
        }


        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $key = Yii::$app->params['recaptcha-key'];
        $query = $url.'?secret='.$key.'&response='.$_POST['g-recaptcha-response'].'&remoteip='.$_SERVER['REMOTE_ADDR'];

        $data = json_decode(file_get_contents($query));

        if ( $data->success == false) {

            Yii::$app->session->setFlash('warning' , 'Капча введена неверно');
            Yii::$app->response->redirect(['/login'], 301, false);
            return true;

        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('/cabinet');
        } else {
            $model->password = '';

            Yii::$app->session->setFlash('warning', 'Указана неверная почта или пароль');

            return $this->redirect('/login');
        }
    }

    public function actionLoginPage()
    {
        return $this->render('login-page');
    }

    public function actionSignupPage()
    {
        return $this->render('signup-page');
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('/login');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup($city)
    {

        if ( !$_POST['g-recaptcha-response'] ) {

            Yii::$app->session->setFlash('warning' , 'нужно заполнить капчу');

            Yii::$app->response->redirect(['/signup'], 301, false);

            return true;
        }


        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $key = Yii::$app->params['recaptcha-key'];
        $query = $url.'?secret='.$key.'&response='.$_POST['g-recaptcha-response'].'&remoteip='.$_SERVER['REMOTE_ADDR'];

        $data = json_decode(file_get_contents($query));

        if ( $data->success == false) {

            Yii::$app->session->setFlash('warning' , 'Капча введена неверно');
            Yii::$app->response->redirect(['/signup'], 301, false);
            return true;

        }

        /* @var $redis Connection */

        $ip = $_SERVER['REMOTE_ADDR'];

        $redis = Yii::$app->redis;

        $redis->INCR("register:$ip");

        $redis->expire("register:$ip", 3600 * 2);

        if ($redis->GET ("register:$ip") > 3) {

            return $this->goHome();

        }

        $model = new SignupForm();

        $cityInfo = City::getCity($city);

        $model->city_id = $cityInfo['id'];

        if ($model->load(Yii::$app->request->post()) && $user = $model->signup() and Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Благодарим за регистрацию, для активации пополните счет или напишите в поддержку ');
            return $this->redirect('/cabinet');
        }else{

            Yii::$app->session->setFlash('formErrors', $model->getErrors());

        }

        return $this->redirect('/signup');
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @return yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                $user->cash = Yii::$app->params['bonus_sum'];
                $user->save();
                Yii::$app->session->setFlash('success', 'Ваша почта подтверждена!');
                return $this->redirect('/cabinet');
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

}