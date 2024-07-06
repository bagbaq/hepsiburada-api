# ⚡ Hepsiburada API yardımcı kütüphane
Minimum 7.4 PHP sürüm öneririm. 

<h3>Kullanım</h3>

`composer require bagbaq/hepsiburada-api`

```php
require 'vendor/autoload.php';

$hb = new Hepsiburada("username", "password", "merchantId");

// Verilen satıcı stok kodu ile ürün bilgilerini getir
$productEx = $hb->getProductInfo("MERCHANTSKU112");

// Hepsiburada sisteminde kayıtlı tüm kategorilerini getir
$categories = $hb->getAllCategories();

```
