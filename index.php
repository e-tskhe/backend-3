<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  if (!empty($_GET['save'])) {
    // Если есть параметр save, то выводим сообщение пользователю.
    print('Спасибо, результаты сохранены.');
  }
  // Включаем содержимое файла form.php.
  include('form.php');
  // Завершаем работу скрипта.
  exit();
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в БД.

// Проверяем ошибки.
$errors = FALSE;
if (empty($_POST['name'])) {
  print('Заполните имя.<br/>');
  $errors = TRUE;
}

if (!preg_match("/[а-я]/i", $_POST['name']) && !preg_match("/[a-z]/i", $_POST['name'])) {
  print('Имя должно содержать только буквы.<br/>');
  $errors = TRUE;
}

if (empty($_POST['phone'])) {
  print('Заполните телефон.<br/>');
  $errors = TRUE;
}

if (!is_numeric($_POST['phone'])) {
  print('Телефон должен состоять только из цифр.<br/>');
  $errors = TRUE;
}

if (empty($_POST['birthdate'])) {
  print('Заполните дату рождения.<br/>');
  $errors = TRUE;
}

if (empty($_POST['gender'])) {
  print('Укажите пол.<br>');
  $errors = TRUE;
}

if (empty($_POST['languages'])) {
  print('Укажите любымие языки программирования.<br>');
  $errors = TRUE;
}

if (empty($_POST['bio'])) {
  print('Заполните биографию.<br>');
  $errors = TRUE;
}

if (empty($_POST['agreement'])) {
  print('Невозможно продолжить без вашего согласия на обработку персональных данных.<br>');
  $errors = TRUE;
}

if ($errors) {
  // При наличии ошибок завершаем работу скрипта.
  exit();
}
// Сохранение в базу данных.

$user = 'u68891'; // Заменить на ваш логин uXXXXX
$pass = '3849293'; // Заменить на пароль
$pdo = new PDO('mysql:host=localhost;dbname=u68891', $user, $pass,
 [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); // Заменить test на имя БД, совпадает с логином uXXXXX

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (empty($errors)) {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $birthdate = $_POST['birthdate'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $bio = $_POST['bio'] ?? '';
    $languages = $_POST['languages'] ?? []; // Массив ID языков программирования

    $pdo->beginTransaction();
    // Вставка основной информации в таблицу application
    $stmt = $pdo->prepare("INSERT INTO application (name, phone, email, birthdate, gender, bio) VALUES (:name, :phone, :email, :birthdate, :gender, :bio)");
    $stmt->execute([$name, $phone, $email, $birthdate, $gender, $bio]);
    $stmt->execute([
      ':name' => $name,
      ':phone' => $phone,
      ':email' => $email,
      ':birthdate' => $birthdate,
      ':gender' => $gender,
      ':bio' => $bio
    ]);
    $applicationId = $pdo->lastInsertId();

    // Вставка языков программирования в таблицу application_language
    $langStmt = $pdo->prepare("
                INSERT INTO programming_language (name)
                VALUES (:name)
                ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)
            ");
            
    $appLangStmt = $pdo->prepare("
        INSERT INTO application_language (application_id, language_id)
        VALUES (:app_id, :lang_id)
    ");
    foreach ($languages as $langName) {
      // Вставка языка, если его еще нет в базе
      $langStmt->execute([':name' => $langName]);
      $langId = $pdo->lastInsertId();
      
      // Связывание языка с заявкой
      $appLangStmt->execute([
          ':app_id' => $applicationId,
          ':lang_id' => $langId
      ]);
    }
    // Завершение транзакции
    $pdo->commit();

    echo "Данные успешно сохранены!";
  }
}