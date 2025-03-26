<!DOCTYPE html>

<html lang="ru">

    <head>
        <meta charset="utf-8">
        <title>Задание 3</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <div class="formular">
            <h2>Анкета</h2>
            
            <form action="" method="POST">

            <div class="container">
            <label for="fullname">ФИО:</label>
            <input type="text" id="fullname" name="fullname" maxlength="150">
            </div>

            <div class="container">
            <label for="phone">Телефон:</label>
            <input type="tel" id="phone" name="phone">
</div>
<div>
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email">
            </div class="container">
            <label for="dob">Дата рождения:</label>
            <input type="date" id="dob" name="dob">

            <label>Пол:</label>
            <div id="gender">
                <input type="radio" id="male" name="gender" value="male">
                <label for="male" style="font-weight: 500;">Мужской</label>
                <input type="radio" id="female" name="gender" value="female">
                <label for="female" style="font-weight: 500;">Женский</label>
            </div>

            <label for="languages">Любимый язык программирования:</label>
            <select id="languages" name="languages[]" multiple>
                <option value="Pascal">Pascal</option>
                <option value="C">C</option>
                <option value="C++">C++</option>
                <option value="JavaScript">JavaScript</option>
                <option value="PHP">PHP</option>
                <option value="Python">Python</option>
                <option value="Java">Java</option>
                <option value="Haskel">Haskel</option>
                <option value="Clojure">Clojure</option>
                <option value="Prolog">Prolog</option>
                <option value="Scala">Scala</option>
                <option value="Go">Go</option>
            </select>

            <label for="bio">Биография:</label>
            <textarea id="bio" name="bio" rows="4"></textarea>

            <label>
                <input type="checkbox" name="agreement"> С контрактом ознакомлен(а)
            </label>

            <button type="submit">Отправить</button>
            </form>
        </div>
    </body>

</html>