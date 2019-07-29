# NewsFeed

### 1. Установка ###

Перед запуском приложения создайте файл <code>.env</code> со всеми настройками приложения

Установите зависимости:

<code>$ php composer.phar install</code>

<code>$ npm i</code>

Выполните все миграции, команда:

<code>$ php artisan migrate</code>

Затем необходимо заполнить базу данных стандартными категориями и пользователями, для этого выполните команду:

<code>$ php artisan db:seed</code>

Для входа в панель управления:
- email: admin@admin.com
- пароль: password

### 2. Принятые решения ###

#### 1. Входные данные для новостей отличаются в зависимости от типа: ####
Изначально планировалось создать одну таблицу с разными колонками всех типов новостей, данный метод имеет некоторые недостатки. 
Так как при создании нового типа приходится создавать новые колонки что несколько неудобно. 

Поэтому было принято решение создать Polymorphic Relationships (OneToOne) от единой сущности FeedEntity к ее дочерним сущностям: 
WeatherForecast (Погода), NewsItem (Новости и Главные новости), DaySummary (Итог дня) и обратно. 
Данный подход позволяет создавать независимые друг от друга и от типа сущности, которые могут быть затем отображены в 
одной новостной ленте, что позволяет отображать в ленте все что угодно (любой тип).

Картинка с class diagram всех связей базы данных для наглядного представления:
https://drive.google.com/file/d/1ASxgmIOXnrsu9q-05LX3DOAQqUMJHSH2/view?usp=sharing

#### 2. Автоматическая запись погоды и главных новостей дня ####

Планировалось сделать с помощью taskscheduling, но не все хостинги его поддерживают, а грузить этот проектик на платный vps
не вижу смысла.

Поэтому реализовал все с помощью events.

Когда пользователь заходит на любую страницу с новостью то автоматически 
генерируются прогнозы погоды начиная от последнесозданного прогноза, что решает проблему если пользователь не заходит каждый день, 
то все равно прогнозы будут созданы на каждый день (не пропуская ни одного дня до последнего посещения).

Главные новости дня тем временем генерируются только при создании "главных новостей" (checkbox при создании обычных новостей). 
Созданные до 20:00 главные новости помещаются в текущий список, созданные после 20:00 помещаются в список на следующий день, 
который станет текущим после 0:00 и будет виден пользователю только после 20:00 следующего дня.

Таким образом можно обойтись без cronjob или taskscheduling, функционал можно найти в events и listers.


### 3. Дополнительно ###

Запись в log при ошибке (CREATE/UPDATE/READ), логи находятся: <code>/storage/logs</code>.

Запись не совершается, реализовано с помощью TRANSACTIONs, что позволяет избежать неправильных связей и нарушения целостности базы данных.

Валитации форм хранятся в: <code>app/Http/Requests/</code>.

Приложение немного покрыто тестами, но не полностью, из-за нехватки времени.

Комментарии писал на английском.

Код получился местами громоздкий, поскольку не было достаточно времени на рефакторинг.

