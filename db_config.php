<?php
$host = 'localhost';
$dbname = 'university';
$user = 'root';
$password = '1326';

function getPDO()
{
    global $host, $dbname, $user, $password;
    try {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit;
    }
}

function clearAndInitDB()
{
    $pdo = getPDO();
    try {
        $pdo->exec("DROP DATABASE IF EXISTS `university`");
        $pdo->exec("CREATE DATABASE `university`");
        $pdo->exec("USE university");

        $pdo->exec("CREATE TABLE students (
            id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(255) NOT NULL,
            last_name VARCHAR(255) NOT NULL,
            patronymic VARCHAR(255),
            birth_day DATE,
            birth_place VARCHAR(255),
            email VARCHAR(255),
            phone_number VARCHAR(20),
            gpa FLOAT,
            group_id INT
        )");
        $pdo->exec("INSERT INTO students (first_name, last_name, patronymic, birth_day, birth_place, email, phone_number, gpa, group_id) VALUES  
                                                                                                                         ('Иван', 'Солженицын', 'Иванович', '2001-05-15', 'Москва', 'ivan.ivanov@example.com', '+79261234567', 3.5, 1),  
                                                                                                                         ('Петр', 'Петров', 'Сергеевич', '2000-08-20', 'Санкт-Петербург', 'petr.petrov@example.com', '+79267654321', 4.0, 1),  
                                                                                                                         ('Александр', 'Петров', 'Сергеевич', '2002-03-10', 'Новосибирск', 'sergey.sergeev@example.com', '+79261239999', 3.8, 2),  
                                                                                                                         ('Александр', 'Пушкин', 'Сергеевич', '2001-06-25', 'Екатеринбург', 'alexandr.alexandrov@example.com', '+79381234567', 4.2, 1),  
                                                                                                                         ('Анастасия', 'Прекрасная', 'Антоновна', '2000-09-30', 'Казань', 'anastasia.anastasieva@example.com', '+79561234567', 4.5, 2),  
                                                                                                                         ('Ольга', 'Параболина', 'Анатольевна', '2002-12-07', 'Самара', 'olga.olgina@example.com', '+79261234501', 3.9, 3),  
                                                                                                                         ('Дмитрий', 'Апельсинов', 'Владимирович', '2001-01-14', 'Тюмень', 'dmitry.dmitriev@example.com', '+79601234567', 3.7, 3),  
                                                                                                                         ('Елена', 'Сибирская', 'Максимовна', '2000-12-01', 'Калуга', 'elena.yelenina@example.com', '+79261234578', 4.4, 4),  
                                                                                                                         ('Максим', 'Артемов', 'Андреевич', '2001-02-11', 'Нижний Новгород', 'maxim.maximov@example.com', '+79661234567', 4.1, 2),  
                                                                                                                         ('Ирина', 'Земная', 'Платоновна', '2002-07-22', 'Уфа', 'irina.irina@example.com', '+79561234508', 3.6, 3),  
                                                                                                                         ('Егор', 'Егориков', 'Анатольевич', '2000-10-10', 'Челябинск', 'egor.egoryev@example.com', '+79261234599', 4.3, 4),  
                                                                                                                         ('Ксения', 'Звездная', 'Антоновна', '2001-04-05', 'Тверь', 'ksenia.ksenieva@example.com', '+79591234567', 3.2, 1),  
                                                                                                                         ('Антон', 'Андреев', 'Алексеевич', '2000-02-14', 'Ростов-на-Дону', 'anton.antonov@example.com', '+79061234567', 4.6, 1),  
                                                                                                                         ('Наталья', 'Красилова', 'Александровна', '2001-05-19', 'Владивосток', 'natalya.natalyeva@example.com', '+79761234567', 3.5, 2),  
                                                                                                                         ('Виктор', 'Атомный', 'Викторович', '2000-11-30', 'Хабаровск', 'victor.viktorov@example.com', '+79861234567', 4.0, 3);");

        $pdo->exec("CREATE TABLE classes (
                id         INT AUTO_INCREMENT PRIMARY KEY,  
                group_name VARCHAR(255) NOT NULL,  
                faculty_id INT          not null check (faculty_id > 0),  
                head_id    INT          NOT NULL CHECK ( head_id > 0 )  
        )");
        $pdo->exec("INSERT INTO classes (group_name, faculty_id, head_id) VALUES 
                                                              ('22203', 1, 2),
                                                              ('23107', 2, 3),
                                                              ('21907', 3, 15),
                                                              ('20126', 1, 8);       
        ");

        $pdo->exec("CREATE TABLE faculties (  
            id           INT AUTO_INCREMENT PRIMARY KEY,  
            faculty_name VARCHAR(255) NOT NULL  
        )");

        $pdo->exec("INSERT INTO faculties (faculty_name) VALUES
            ('Факультет информационных технологий'),  
            ('Механико-математический факультет'),  
            ('Физический факультет'); 
        ");

        $pdo->exec("CREATE TABLE electives (
                id                  INT AUTO_INCREMENT PRIMARY KEY,  
                elective_name       VARCHAR(255) NOT NULL,  
                description         VARCHAR(512) NOT NULL,  
                capacity            INT NOT NULL CHECK ( electives.capacity > 0 )  
        )");

        $pdo->exec("INSERT INTO electives (elective_name, description, capacity) VALUES 
                                                                 ('Продвинутый курс C++', 'Этот курс предназначен для тех, кто уже имеет базовые знания C++ и хочет углубить свои навыки. Участники изучат сложные аспекты языка, такие как умные указатели, шаблоны, обработка исключений и многопоточность. Будут рассмотрены практические примеры и задачи, что поможет развить умение проектировать эффективные и устойчивые программные решения.', 10),
                                                                 ('Алгоритмы и структуры данных', 'Курс охватывает основные алгоритмы и структуры данных, которые являются фундаментальными для программирования. Участники узнают о различных типах данных (массивы, списки, деревья, графы) и алгоритмах (поиск, сортировка, жадные алгоритмы), а также научатся анализировать их производительность и выбирать оптимальные решения для различных задач.', 13),
                                                                 ('Электротехника на практике', 'Курс предлагает практическое введение в основы электротехники. Учащиеся узнают о законах электричества, принципах работы электронных компонентов, схемотехнике и основам проектирования электрических систем. Занятия включают как теоретические лекции, так и практические лабораторные работы, позволяющие применять полученные знания в реальных условиях.', 5),
                                                                 ('Вычислительные методы линейной алгебры', 'На курсе исследуются численные методы решения задач линейной алгебры. Учащиеся познакомятся с методами, такими как метод Гаусса, матричные разложения и итерационные алгоритмы. Курс акцентирует внимание на применении этих методов в различных областях, таких как компьютерная графика, машиное обучение и численное моделирование.', 7), 
                                                                 ('Литература 19 века', 'Данный курс погружает студентов в богатый мир литературы 19 века, исследуя ключевых авторов и произведения, формировавшие культурный контекст эпохи. Участники изучат произведения таких писателей, как Лев Толстой, Фёдор Достоевский, Эмили Бронте и других, анализируя их стиль, тематику и влияние на последующую литературу и общество.', 10);
        ");

        $pdo->exec("CREATE TABLE student_elective (
            student_id INT NOT NULL,
            elective_id INT NOT NULL,
            enrollment_date DATE NOT NULL,
            PRIMARY KEY (student_id, elective_id),
            FOREIGN KEY (student_id) REFERENCES students(id),
            FOREIGN KEY (elective_id) REFERENCES electives(id)
        )");

        $pdo->exec("INSERT INTO student_elective (student_id, elective_id, enrollment_date) VALUES 
            (1, 1, '2024-01-10'), 
            (2, 2, '2024-01-15');");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
