PHP CommerceML 2
==============

### О библиотеке
Данная библиотека предназначена для поточного разбора выгруженных из 1с файлов по стандарту Commerce ML 2.

Сам парсер представляет собой диспетчер событий, т.е. при нахождении в структуре Commerce ML 2 объекта нужной структуры, диспетчером вызывается определенной событие и в него передается уже сформированные по модельной структуре объект.

На данный момент существует 7 основных событий:

* получение Владельца;
* получение Категории;
* получение Предложения;
* получение Категории Цен;
* получение Склада;
* получение Товара;
* получение Свойства товара.

### Простое использование парсера:

```php
$parser = \CommerceMLParser\Parser::getInstance(); // парсер
// Парсер с кастомной фабрикой
// $parser = \CommerceMLParser\Parser::getInstance(new CustomFactory());

// Слушаем событие получения Категории
$parser->addListener("CategoryEvent", function (\CommerceMLParser\Event\CategoryEvent $categoryEvent) {
    $categories = $categoryEvent->getCategory()->fetch(); // array of Category
}); // добавление функции обработки события CategoryEvent

// Парсим файл XML
$parser->parse($pathToImportXmlFile); // полный путь до файла import.xml (Commerce ML 2) выгрузки из 1с
```
