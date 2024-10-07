# databases_labs
My databases labs from 3 course nsu

##### Сущности

| Структура студента | Тип данных      |
| ------------------ | --------------- |
| id                 | int             |
| `first_name`       | varchar != null |
| `last_name`        | varchar != null |
| `patronymic`       | varchar         |
| `birth_day`        | float           |
| `birth_place`      | varchar         |
| `email`            | varchar         |
| `phone_number`     | varchar         |
| `gpa`              | date            |
| `group_id`         | int > 0         |

| Структура группы | Тип данных |
| ---------------- | ---------- |
| id               | int        |
| `group_name`     | varchar    |
| `faculty_id`     | int        |
| `head_id`        | int        |

| Факультет      | Datatype |
| -------------- | -------- |
| `faculty_id`   | int      |
| `faculty_name` | varchar  |

| Факультатив     | Datatype |
| --------------- | -------- |
| id              | int      |
| `elective_name` | varchar  |
| `description`   | varchar  |
| `capacity`      | int      |

| запись на факультатив **Enrollments** | datatype |
| ------------------------------------- | -------- |
| id                                    | int      |
| `student_id`                          | int      |
| `elective_id`                         | int      |
| `registation_date`                    | date     |
| `grade`                               | float    |
### Ограничения целостности
- Уникальность на полях`email`и`student_id`
- Непустые значения для обязательных полей, таких как`name`,`group_name`

### Связи между таблицами
- **Students**связан с**Groups**через`group_id`.
- **Groups**связан с**Faculties**через`faculty_id`и с**Students**через`head_id`.
- **Enrollments**связан с**Students**и**Electives**.
### Основные требования:
1. **Регистрация студентов**и групп, а также их связь с факультетами.
2. **Создание и управление факультативами**.
3. **Запись студентов на факультативы**.
4. **Просмотр и редактирование успеваемости**студентов по факультативам.
5. **Генерация отчетов**по успеваемости и популярности факультативов.

## Основные запросы к данным

1. Получить список всех студентов:
```sql
SELECT * FROM Students;
```
2. Получить список факультативов:
```sql
SELECT * FROM Electives;
```
3. Записать студента на факультатив:
```sql
INSERT INTO Enrollments (student_id, elective_id, registration_date) 
VALUES (1, 1, CURDATE());
```
4. Получить успеваемость студента:
```sql
SELECT E.elective_id, E.grade 
FROM Enrollments E 
WHERE E.student_id = 1;
```    
5. Получить количество студентов, записанных на факультатив:
```sql
SELECT elective_id, COUNT(*) as enrollment_count 
FROM Enrollments 
GROUP BY elective_id;
```

## Проектирование форм и отчетов

### Формы для ввода и редактирования данных
1. **Форма регистрации студента**: поля для ввода ФИО, даты рождения, телефона, email, группы.
2. **Форма регистрации факультатива**: поля для названия, описания, количества мест.
3. **Форма записи на факультатив**: выбор студента и факультатива.

### Отчеты
1. **Отчет по успеваемости**: показывает оценки студентов по факультативам.
2. **Отчет по популярности факультативов**: показывает, сколько студентов записано на каждый факультатив.

## Расширение приложения БД

### Дополнительные бизнес-процессы

1. **Создание расписания факультативов**:
    - Таблица`Schedules`с полями`schedule_id`,`elective_id`,`day_of_week`,`start_time`,`end_time`.
2. **Интеграция с системой уведомлений**:
    - Использование веб-приложений или email-рассылок для уведомления студентов о новых факультативах.
3. **Функция обратной связи**:
    - Таблица`Feedback`, в которой студенты могут оставлять отзывы о факультативах.


```mysql
use university;  
  
CREATE TABLE students (  
                          id INT AUTO_INCREMENT PRIMARY KEY,  
                          first_name VARCHAR(255) NOT NULL,  
                          last_name VARCHAR(255) NOT NULL,  
                          patronymic VARCHAR(255),  
                          birth_day DATE,  
                          birth_place VARCHAR(255),  
                          email VARCHAR(255),  
                          phone_number VARCHAR(20),  
                          gpa FLOAT,  
                          group_id INT CHECK (group_id > 0)  
);  
  
  
INSERT INTO students (first_name, last_name, patronymic, birth_day, birth_place, email, phone_number, gpa, group_id) VALUES  
                                                                                                                         ('Иван', 'Иванов', 'Иванович', '2001-05-15', 'Москва', 'ivan.ivanov@example.com', '+79261234567', 3.5, 1),  
                                                                                                                         ('Петр', 'Петров', 'Петрович', '2000-08-20', 'Санкт-Петербург', 'petr.petrov@example.com', '+79267654321', 4.0, 1),  
                                                                                                                         ('Сергей', 'Сергеев', 'Сергеевич', '2002-03-10', 'Новосибирск', 'sergey.sergeev@example.com', '+79261239999', 3.8, 2),  
                                                                                                                         ('Александр', 'Александров', 'Александрович', '2001-06-25', 'Екатеринбург', 'alexandr.alexandrov@example.com', '+79381234567', 4.2, 1),  
                                                                                                                         ('Анастасия', 'Анастасиева', 'Анастасиевна', '2000-09-30', 'Казань', 'anastasia.anastasieva@example.com', '+79561234567', 4.5, 2),  
                                                                                                                         ('Ольга', 'Ольгина', 'Ольгиевна', '2002-12-07', 'Самара', 'olga.olgina@example.com', '+79261234501', 3.9, 3),  
                                                                                                                         ('Дмитрий', 'Дмитриев', 'Дмитриевич', '2001-01-14', 'Тюмень', 'dmitry.dmitriev@example.com', '+79601234567', 3.7, 3),  
                                                                                                                         ('Елена', 'Еленина', 'Еленовна', '2000-12-01', 'Калуга', 'elena.yelenina@example.com', '+79261234578', 4.4, 4),  
                                                                                                                         ('Максим', 'Максимов', 'Максимович', '2001-02-11', 'Нижний Новгород', 'maxim.maximov@example.com', '+79661234567', 4.1, 2),  
                                                                                                                         ('Ирина', 'Ириной', 'Ириновна', '2002-07-22', 'Уфа', 'irina.irina@example.com', '+79561234508', 3.6, 3),  
                                                                                                                         ('Егор', 'Егорьев', 'Егорьевич', '2000-10-10', 'Челябинск', 'egor.egoryev@example.com', '+79261234599', 4.3, 4),  
                                                                                                                         ('Ксения', 'Ксениева', 'Ксениевна', '2001-04-05', 'Тверь', 'ksenia.ksenieva@example.com', '+79591234567', 3.2, 1),  
                                                                                                                         ('Антон', 'Антонов', 'Антонович', '2000-02-14', 'Ростов-на-Дону', 'anton.antonov@example.com', '+79061234567', 4.6, 1),  
                                                                                                                         ('Наталья', 'Натальева', 'Натальевна', '2001-05-19', 'Владивосток', 'natalya.natalyeva@example.com', '+79761234567', 3.5, 2),  
                                                                                                                         ('Виктор', 'Викторов', 'Викторович', '2000-11-30', 'Хабаровск', 'victor.viktorov@example.com', '+79861234567', 4.0, 3);
```

```mysql
CREATE TABLE faculties  
(  
    id           INT AUTO_INCREMENT PRIMARY KEY,  
    faculty_name VARCHAR(255) NOT NULL  
);  
  
INSERT INTO faculties (faculty_name)  
VALUES ('Факультет Информациооных технологий'),  
       ('Механико-математический факультет'),  
       ('Физический факультет');  
  
  
CREATE TABLE bunch  
(  
    id         INT AUTO_INCREMENT PRIMARY KEY,  
    group_name VARCHAR(255) NOT NULL,  
    faculty_id INT          not null check (faculty_id > 0),  
    head_id    INT          NOT NULL CHECK ( head_id > 0 )  
  
);  
  
  
INSERT into bunch(group_name, faculty_id, head_id)  
VALUES ( '22203', 1, 2),  
       ('23107', 2, 3 ),  
       ('21907', 3, 15),  
		('23209', 1, 8);
```
