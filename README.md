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

class CustomerController extrends Controller {

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

class CustomerService extends BaseService
{
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

class OutSideServiceApi
{
  private string $token;

   // ....

  public function getCustomerListByPeriod(string $from, string $to, array $filtrer)
  {
    // ...
  }

  // ...
}

```

### Ресурс.  
Содержет пул данных для конкретного шаблона.
```php

namespace app\resources\customer;

class CustomerViewResources extenda BaseResources
{
    public const TEMPLATE = 'customer-view';



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

class CustomerRow {
  public string $fio;
  public int $age;

  public function __construct($fio, $age)
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

<?php if (count($R->customerList)) : ?>
  <UL>
    <?php foreach($R->customerRowList as $customer ) : ?>
      <LI><?= $customer->fio ?>(<?= $customer->age ?>)<LI>
    <?php endforeach; ?>
  <UL>
<?php endif; ?>
```
