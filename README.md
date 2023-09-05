# info-flow_development

Описание, с примером, моего пути разработки, с использованием:
 - Контроллера
 - Шаблона
 - ресурсов
 - сервисов
 - API

В абстрактном примере, c использованием фреймворка(к примеру yii2), на некой странице надо вывести в таблицу данные полученные по API.

_____

### Контроллер.  
Обрадатывает запросы. Используя сервисы собирает в экшене ресурс, который передаёт в шаблон.
```php
<?php

namespace app\controllers;

/**
  * Контроллер обрабатывающий запросы связанные с клиентами
  */
class CustomerController extrends app\components\base\BaseController {

  private CustomerService $service;



  /**
    * @return void
    */
  public function init():void
  {
    parent::init();

    $this->setupService();
  }

  /**
    * @return void
    */
  private fuinction setupService():void
  {
     $this->service = new CustomerService();
  }

  /**
    * @return string
    */
  public function actionViewCustomer(): string
  {
    $R = new CustomerViewResources();
    $R->searchCustomerForm = new SearchCustomerForm();
    $R->customerRowList = $this->service->getCustomerList( $R->searchCustomerForm );

    return $this->render( CustomerViewResources::TEMPLATE, [ 'R' => $R ] );
  }
}
```

### Сервис.  
Отдаёт подготовленные данные для шаблона которые **не нуждаются в форматировании/изменении и т.п.**
```php
namespace app\services;

/**
  * Сервис для работы с клиентами
  */
class CustomerService extends app\components\base\BaseService
{
  /** @var OutSideServiceApi $api */
  private OutSideServiceApi $api;



  /**
    * @return void
    */
  public function __construct(OutSideServiceApi $api): void
  {
    $this->api = $api;
  }

  /**
   * @return CustomerRow[]
   */
  public function getCustomerList( SearchCustomerForm $searchCustomerForm ): array
  {
   $resp = [];

   $customerListByPeriod = $this->api->getCustomerListByPeriod($searchCustomerForm->from, $searchCustomerForm->to);

   foreach( $customerListByPeriod as $customer )
   {
      $fio = "{$customer['last_name']} {$customer['name']}";

      $birthday = new DateTime($customer['birthday']);
      $interval = $birthday->diff(new DateTime);
      $age = $interval->y;

      $resp[] = new CustomerRow( $fio, $age )
    }

    return $resp;
  }
}
```

### API.  
Только передаёт данные от стороннего сервиса в текущую систему _(не занимается форматированием данных)._
```php

namespace app\components\api;

/**
  * API взаимодействия со сторонним сервисом
  */
class OutSideServiceApi
{
  /** @var string Токен авторизации и т.п. **/
  private string $token;



  // ....

  /**
    * @return array
    */
  public function getCustomerListByPeriod(string $from, string $to, array $filtrer): array
  {
    // ...

    return $this->query( ... );
  }

  // ...
}

```

### Ресурс.  
Содержет пул данных для конкретного шаблона.
```php

namespace app\resources\customer;

class CustomerViewResources extenda app\components\base\BaseResources
{
  /** @var string мя шаблона */
  public const TEMPLATE = 'customer-view';


  /** @var SearchCustomerForm $searchCustomerForm */
  public SearchCustomerForm $searchCustomerForm;

  /** @var CustomerRow[] */
  public array $customerRowList;
}
```

### Модель.  
Cодержет данные одного конкретногог объекта.  
_Либо используется в шаблоне либо для вычисления каких либо знаений/формирования связных списков/коллекций._
```php

namespace app\models\component\customer;

/**
  * Модель/DTO
  */
class CustomerRow {

  /** @var string $fio*/
  public string $fio;

  /** @var int $fio*/
  public int $age;



  /**
    * @return void
    */
  public function __construct(string $fio, int $age): void
  {
    $this->fio = $fio;

    $this->age = $age;
  }
}
```

### Шаблон.  
Выводит данные из объекта `Resource`
```php
<?php

/**
  * @var CustomerViewResources $R
  */

?>

Форма...
 <?= $form->field($R->searchCustomerForm,'from')-> ... ?>
 // ...

<?php if (count($R->customerRowList)) : ?>
  <UL>
    <?php foreach($R->customerRowList as $customer ) : ?>
      <LI><?= $customer->fio ?>(<?= $customer->age ?>)<LI>
    <?php endforeach; ?>
  <UL>
<?php endif; ?>
```


## Преимущества.

Вся бизнес логика заключена в "сервисы":  
1. может быть переиспользована влюбом месте приложения  
2. можно написать Unit тесты на методы сервисов  

При работе в шаблоне:  
1. используя autocomplete отсутствует возможность опечататься  
2. используя навигацию IDE можно быстро "прыгнуть" к месту где назначается или используется какое либо свойство  


Очевидное преимукщество, то что всё по полочкам, на своих местах.  
Удобство переиспользования и использование отдельных компонентов системы.  
Контроллеры немее жирные, за счёт тогог что всю бизнес логику "всосали" сервисы.  
При необходимости переписать метод сервиса/контроллера/API не затрагивается и не отвлекает "соседний код".  
