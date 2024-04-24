# 🌟 Hepsiburada API'si için yardımcı kütüphane
Kendinize göre düzenleyip kullanabilirsiniz.

<h3>⚡ Örnek Kullanım</h3>

```php
include "hepsiburada-class.php";

$hb = new Hepsiburada("username", "password", "merchantId");

// Verilen satıcı stok kodu ile ürün bilgilerini getir
$productEx = $hb->getProductInfo("MERCHANTSKU112");

// Hepsiburada sisteminde kayıtlı tüm kategorilerini getir
$categories = $hb->getAllCategories();

```
