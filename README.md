## Объект

Сущность, _одновременно_ содержащая данные и поведения. 
Благодаря этому обеспечивается высокая степень целостности данных.

Можно управлять доступом к атрибутам и методам.

Скрытие данных - ограничение доступа к определенным атрибутам/методам

### Разница со структурным проектированием

При процедурном/структурном проектировании атрибуты и поведения разделяются

### Минусы структурного проектирования, которых нет в ОО-проектировании

Данные отделяются от процедур и являются глобальными, благодаря чему их легко модифицировать 
вне области видимости. Доступ к данным неконтролируемый и непредсказуемый. 
Тестирование и отладка усложняются.

## Методы в объектах

Представляют то, что может сделать объект.

Применяются для выполнения операций с данными. 

## Данные/атрибуты

Представляют состояние объекта.

Объект, содержащий атрибут, должен управлять доступом к нему. Если объект контролирует доступ к 
данным, то при возникновении проблемы, не придется беспокоиться об отслеживании каждого фрагмента 
кода, который мог бы изменить значение атрибута - оно может быть изменено только с помощью сеттера.

## Инкапсуляция

Объединение атрибутов (данных) и методов (поведений) в одной сущности (классе).

Скрытие данных является основной частью инкапсуляции.

Объявление атрибута как public нарушает концепцию скрытия данных

## Геттеры и сеттеры

Обеспечивают управляемый доступ к данным объекта и целостность данных

## Класс

Шаблон / чертеж, на основе которого создаются объекты.

При создании объектов создаются экземпляры этих объектов.

## Интерфейс

Услуги, предоставляемые конечным пользователям.

Определяет основные средства коммуникации между объектами.

Любое поведение, которое обеспечивается объектом, должно вызываться через сообщение, 
отправляемое с использованием одного из предоставленных интерфейсов.

## Наследование

Позволяет классу наследовать и использовать преимущества атрибутов и методов другого 
класса (суперкласса).

Позволяет определять отношение между классами.

## Суперкласс и подклассы

Суперкласс / родительский / базовый - содержит все атрибуты и поведения, общие для классов, 
которые наследуют от него.

Подкласс / дочерний / производный - расширение суперкласса.

## Простое и множественное наследование

Простое - когда у класса может быть только один родительский класс.

Множественное - когда у одного класса может быть несколько родительских классов.

## Переопределение

Замена реализации родительского класса на реализацию из дочернего класса.

## Полиморфизм

Схожие объекты могут по-разному отвечать на одно и то же сообщение.

Позволяет использовать объекты с одинаковым интерфейсом без необходимости знать их конкретный тип.

Каждый класс способен реагировать на один и тот же метод по-разному.

Направлен на стандартизацию определенного интерфейса среди классов.

## Абстрактный метод

Когда метод объявляется абстрактным, подкласс должен обеспечить реализацию этого метода.

## Композиция

Объекты зачастую формируются или состоят из других объектов - это и есть композиция

## Глава 2. Как мыслить объектно

Первым пунктом должно быть определение и решение бизнес-проблем.

Важный момент при проектировании класса - определение его аудитории / пользователей

Объектно-ориентированное проектирование - это итеративный процесс.

Определить минимальный интерфейс - Никогда не предполагайте, что определенному пользователю 
что-то потребуется

### Объектно-ориентированные концепции

#### Разница между интерфейсом и реализацией

Розетка - интерфейс, как вырабатывается электричество - реализация

Руль, педали, зажигание - интерфейс, двигатель (то, чего мы не видим) - реализация. 
Стандартный руль - общий интерфейс

Изменения в реализации не должны требовать внесения изменений в пользовательский код

Все, что не является интерфейсом, можно считать реализацией.

Методы открытых интерфейсов имеют тенденцию быть очень абстрактными, а реализация склонна быть 
более конкретной.

#### Использование абстрактного мышления при проектировании классов

Одно из преимуществ ООП - повторное применение классов. 
Пригодные для повторного применения классы обычно располагают интерфейсами, которые больше 
абстрактны, нежели конкретны. 

Абстрактные - в высокой степени пригодные для повторного применения классы

Интерфейс "отвезите меня в аэропорт" более пригоден для повторного использования 
чем отдельные интерфейсы "поверните направо", "поверните налево" и т.д.

#### Обеспечение самого минимального интерфейса пользователя из возможных

Предоставляйте пользователям только то, что им обязательно потребуется. 

У каждого класса должно быть как можно меньше интерфейсов.

## Глава 3. Продвинутые объектно-ориентированные концепции

### Конструкторы

Конструктор не должен возвращать значение

Наиболее важная функция конструктора - инициализация выделенной памяти при обнаружении 
ключевого слова new.

Код, заключенный внутри конструктора, должен задать для нового объекта его начальное, стабильное, 
надежное состояние.

Единственное действие, предпринимаемое конструктором по умолчанию - вызов конструктора 
его суперкласса

### Перегрузка методов

Позволяет снова и снова использовать один и тот же метод, если его подпись (название метода 
и параметры) отличается

### Проектирование конструкторов

Правильная методика заключается в том, чтобы определить стабильное состояние для всех атрибутов, 
а затем инициализировать их с этим стабильным состоянием в конструкторе

### Поведенческое наследование и наследование реализации

Интерфейсы - механизм для поведенческого наследования (без реализации).

Абстрактные классы используются для наследования реализации.

## Глава 4. Анатомия класса.

В итоге все будет сводиться к тому, насколько полезным является определенный класс и как он 
взаимодействует с другими классами

Не создавать класс "в вакууме"

## Глава 5. Руководство по проектированию классов

### Определение открытых интерфейсов

Интерфейс хорошо спроектированного объекта описывает услуги, оказание которых требуется клиенту
(Объектно-ориентированное проектирование на Java - Гилберт и Маккарти)

Пользователи не должны ничего знать о его внутренней работе.  
Им нужно знать лишь то, как создавать экземпляры и использовать объекты.

### Проектирование с учетом сопровождаемости

Проектирование практичных и компактных классов обеспечивает высокий уровень сопровождаемости.

Один из наилучших способов обеспечить сопровождаемость - уменьшить количество 
взаимозависимого кода - изменения в одном классе не должны сказываться на других.

### Использование постоянства объектов

Постоянство - концепция сохранения состояния объектов

Сериализация - процесс деконструирования (сделать плоским) объекта для передачи по сети и 
реконструирование на другом конце сети

Маршаллинг - действие по передаче объекта по сети

## Глава 6. Проектирование с использованием объектов

UML (Unified Modeling Language) - унифицированный язык моделирования

## Глава 7. Наследование и композиция

Наследование и композиция представляют собой механизмы повторного использования.

Эти механизмы - единственный способ повторного использования созданных классов.

- Наследование - (собака) является экземпляром (млекопитающего)
- Композиция - (автомобиль) содержит как часть (двигатель) 

### Подробный пример полиморфизма

В хорошо спроектированной системе объект должен быть способен ответить на все важные вопросы 
о себе. Как правило, объект должен быть ответственным за себя.

Смысл полиморфизма заключается в том, что вы можете отправлять сообщения разным объектам, 
которые будут отвечать на них в соответствии со своими объектными типами.

Конкретные классы сами несут ответственность за реализацию.

## Глава 8. Фреймворки и повторное использование: проектирование с применением интерфейсов и 
абстрактных классов 

### Код: использовать повторно или нет?

Полезность кода, а также его пригодность к повторному использованию зависит от того, насколько 
хорошо он был спроектирован и реализован

### Что такое фреймворк

Идея фреймворка "вращается" вокруг принципа "включил и работай", а также принципа повторного 
использования.

### Что такое контракт

Любой механизм, требующий от разработчиков соблюдения спецификаций того или иного API-интерфейса

Контракты создаются с целью способствовать использованию правильных методик разработки

### Абстрактный способ

Один из способов реализации контракта

Абстрактный класс - это класс, содержащий один или несколько методов, которые не имеют какой-либо 
обеспеченной реализации

Абстрактный класс может содержать обычные методы, у которых присутствует реализация.

Единственными методами, которые подкласс должен реализовать, являются те, что объявлены в 
суперклассе абстрактными. Эти абстрактные методы представляют собой контракт.

### Интерфейс

Как и абстрактные классы, это инструмент приведения контрактов в исполнение

Интерфейс, в отличие от абстрактного класса не обеспечивает вообще никакой реализации

Любой класс, реализующий интерфейс, должен обеспечивать реализацию для всех методов

#### Разница между интерфейсом и абстрактным классом

Ключ здесь в том, что классы при строгом наследовании должны быть связаны (Dog находится в 
непосредственной связи в Mammal [млекопитающее]. Собака является млекопитающим. Собака и ящерица 
не связаны на уровне млекопитающих). 

Однако интерфейсы могут использоваться для классов, которые не являются связанными (Nameable). 

- Абстрактный класс представляет некоторую реализацию. 
- Интерфейс моделирует только поведение (никогда не обеспечивает реализацию).

### Заключение контракта

Простое правило при определении контракта заключается в обеспечении нереализованного метода 
с помощью либо абстрактного класса, либо интерфейса.

Одно из преимуществ контракта - стандартизация соглашений по программированию.


