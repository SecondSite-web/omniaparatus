<?php
/**
 * Created by PhpStorm.
 * User: grego
 * Date: 7/18/2019
 * Time: 2:31 PM
 */

/**
 * Регистрация пользователя
 * @param string $username <p>Имя пользователя</p>
 * @param string $email <p>E-mail</p>
 * @param string $password <p>Пароль</p>
 * @param string $confirm_password <p>Повторить пароль</p>
 * @return boolean <p>Результат выполнения метода</p>
 */
public function actionRegister()
{
    // Переменные для формы
    $email = false;
    $password = false;
    $confirm_password = false;
    $username = false;
    $registration = false;
    // Обработка формы
    if (isset($_POST['submit'])) {
        // Если форма отправлена
        // Получаем данные из формы
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $username = $_POST['user_name'];
        $dbh = Db::getConnection();
        $config = new PHPAuth\Config($dbh);
        $auth = new PHPAuth\Auth($dbh, $config, $language = "ru_RU");
        $registration = $auth->register($email, $password, $confirm_password, $username, $role = 'user', $params = array(), $captcha = NULL, $sendmail = TRUE);
    }
    require_once ROOT . '/views/user/register.php';
    return true;
}