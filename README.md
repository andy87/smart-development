Привет! Если ты тут, то тебе, видимо интересно, как разрабатывать проекты правильно и грамотно.  
Безусловно путей множество и все они очень ситуативные, но есть общие моменты которые лучше всегда соблюдать.

Первое, что стоит упомянуть - это заветы "Чистого кода" и здравого смысла.  
> _Многие из этих вещей я осознал сам, а в дальнейшем получил подтверждение в книгах._

## 1. Всё должно быть на своих местах.
У всего должно быть своё место(своя директория/папка).  

Все файлы проекта группируются по типу, к примеру:
- компоненты
- контроллеры
- модели
- шаблоны
- сервисы
- ресурсы
- текстуры
- сцены
- и т.д.  

Все эти файлы обязаны быть в "своих папках", при этом если файлы в группе имеют общий тип / подтип, то  
они так же группируются в директории расположенной внутри корневой директории группы.

При этом большая библиотека или компонент, содержащий множество вспомогательных файлов разных групп и типов,  
обязан располагаться в своём собственном пространстве (в персональной директории), группируя свои файлы в подпапки по назначению.  
> _Смешивать файлы разных компонентов - код кобольдов и деяние сатаны!  
Становится невозможно переиспользовать компонент без геморроя, в виде вычленения файлов нужных для работы требуемого компонента_

## 2. У всех должно быть актуальное имя/название.
Имя обязано ясно и чётко донести:
- назначение компонента _(для класса / интерфейса / примеси)_
- содержание в хранилище _(переменные / свойства / константы)_
- действия для инструкций _(методы / функции)_ обязательно начинаются с глаголов: _get / set / construct / add / remove и т.д._

## 3. Не оставляйте закомментированный код.
Не на будущее, не на вечер, не на пока что...

1. Вы живёте здесь и сейчас, ваш код здесь и сейчас должен быть актуальным. 
2. Исправлю потом, когда-нибудь, скоро? - оно не настанет, будьте реалистами, вы живёте здесь и сейчас!
3. Большинство проектов используют CSV, там сохранится ваш код, на все потом, в будущем, когда-нибудь.  
> _Если вы ещё не используете систему контроля версий, пора взрослеть!_

## 4. Соблюдайте строгую типизацию.
Она поможет определить узкие места и ошибки ещё на этапе проектирования, а не во время исполнения кода.  
> _Согласитесь: лучше когда код работает, а не выдаёт ошибку за ошибкой_

## 5. Пишите тесты
Насколько это нудно и затратно по времени, на столько же это полезно!
> _Тесты - как биткоин ₿, крафтятся долго и со временем их ценность многократно возрастает._

### <i>Эти 5 шагов подходят практически для любого проекта и многократно упрощают жизнь разработчика...</i>

## Дополнительные рекомендации.

#### A) Используйте Паттерны проектирования, они помогут вам в решении многих задач.
Обязательно ознакомьтесь с такими паттернами как: 
- MVC
- ActiveRecord
- ORM
- Singleton
- Factory
- Command
- Service Object Architecture
- Observer
- и т.д.

Комбинируйте паттерны проектирования.

#### B) Лучше проектировать метод / функции проекта, что бы они всегда возвращали значение, а не изменяли состояние объекта.
Это позволит вам легко тестировать методы и функции, а так же избежать ошибок при использовании методов в разных частях проекта.

#### C) При передаче в метод / функцию большого кол-ва аргументов ( > 3), лучше использовать объекты _(приоритетнее)_ или массивы.
Это позволит вам легко расширять функционал метода, а так же упростит чтение и понимание кода.

#### D) Что бы код позволил вам легко расширять функционал, а так же упростил чтение и понимание кода.
 - Используйте PSR стандарты.
 - Используйте интерфейсы и абстрактные классы.
 - Используйте DI (Dependency Injection).

#### E) При проектировании проекта, старайтесь разделять бизнес логику, логику представления и логику обработки запроса.

#### F) Когда проектируете проект, старайтесь представить его как набор компонентов, которые могут быть пере использованы в других проектах.

#### G) Если вы используете фреймворк / библиотеку / компонент, старайтесь использовать их на 100%, а не писать свои решения.

#### H) Не закладывайте много логики в шаблоны, лучше всё это вынести в контроллеры или сервисы.






# Пример разработки проекта.

В директории `app` при ведён пример небольшого "модуля/страничка"

Которая использует следующие паттерны: 
- MVC
- Service Object Architecture
- ModelView
- Active Record
- ORM


## Преимущества.

Вся бизнес-логика заключена в "сервисы":  
1. может быть пере использована в любом месте приложения  
2. можно написать Unit тесты на методы сервисов  

При работе в шаблоне:  
1. используя autocomplete отсутствует возможность опечататься  
2. используя навигацию IDE можно быстро "прыгнуть" к месту где назначается или используется какое-либо свойство  


- Очевидное преимущество, то что всё по полочкам, на своих местах.  
- Удобство пере использования и использование отдельных компонентов системы.  
- Контроллеры немее жирные, за счёт того что всю бизнес-логику "всосали" сервисы.  
- При необходимости переписать метод сервиса/контроллера/API не затрагивается и не отвлекает "соседний код".  
