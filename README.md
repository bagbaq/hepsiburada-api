# hepsiburada-api
Hepsiburada API'si için yardımcı kütüphane. Kendinize göre düzenleyip kullanabilirsiniz.


<h3>⚡ Örnek Kullanım</h3>

```php
include "libraries/hepsiburada-class.php";

$hb = new Hepsiburada("username", "password", "merchantId");

// Belirtili satıcı stok koduyla ürün bilgilerini getir
$productEx = $hb->getProductInfo("MERCHANTSKU112");

echo json_encode($productEx);

// Hepsiburada sisteminde kayıtlı tüm kategorilerini getir
$categories = $hb->getAllCategories();

echo json_encode($categories);

```
