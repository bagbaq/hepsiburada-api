# ⚡ Hepsiburada API yardımcı kütüphane
Minimum PHP 7.4 öneririm. 

<h3>Kurulum</h3>

Composer kullanarak kütüphaneyi projenize ekleyin. 
`composer require bagbaq/hepsiburada-api`

<h3>Tüm Fonksiyonlar</h3>

| Fonksiyon                                       | Açıklama                                                                                                                                   |
| ----------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------ |
| updateProductStock(array)                       | **Ürün fiyatını günceller.** -- *Aşağıdan örnek kullanımı inceleyebilirsiniz*                                                              |
| updateProductStockCheck(string)                 | **Güncellenen ürünün durumunu döndürür. (başarılı veya başarısız)** -- *Parametre olarak Tracking ID giriniz*                              |
| updateProductPrice(array)                       | **Ürün fiyatını günceller.** -- *Aşağıdan örnek kullanımı inceleyebilirsiniz*                                                              |
| updateProductPriceCheck(string)                 | **Güncellenen ürünün durumunu döndürür. (başarılı veya başarısız)** -- *Parametre olarak Tracking ID giriniz*                              |
| createProduct(array)                            | **Ürün oluşturur.** -- *Aşağıdan örnek kullanımı inceleyebilirsiniz*                                                                       |
| updateProduct(array)                            | **Ürün günceller.** -- *Aşağıdan örnek kullanımı inceleyebilirsiniz*                                                                       |
| updateProductCheck(string)                      | **Güncellenecek ürünün durumunu döndürür. (başarılı veya başarısız)** -- *Parametre olarak Tracking ID giriniz*                            |
| getAllProducts()                                | **Tüm ürünlerinizi döndürür.**                                                                                                             |
| getAllCategories()                              | **Tüm kategorileri döndürür.**                                                                                                             |
| getAllCategoryAttributeValues(integer, integer) | **Kategori özelliğe atanabilen değerleri döndürür.** -- *1. Parametre olarak kategori ID, 2. parametre olarak kategori özellik ID giriniz* |
| getProductInfo(string)                          | **Ürün bilgilerini döndürür.** -- *Parametre olarak ürün stok kodunu giriniz*                                                              |

<h3>Örnek Kullanım</h3>


```php
$hb = new Hepsiburada("username", "password", "merchantId");

// Ürün Güncelleme
$items = [
    [
        "hbSku"              => "STOK-KOD-1",
        "productName"        => "Ürün 1",
        "productDescription" => "Ürün açıklaması",
        "image1"             => "https://productimages.hepsiburada.net/s/27/552/10194862145586.jpg",
        "image2"             => "https://productimages.hepsiburada.net/s/27/552/10194862145586.jpg",
        "image3"             => "https://productimages.hepsiburada.net/s/27/552/10194862145586.jpg",
        "image4"             => "https://productimages.hepsiburada.net/s/27/552/10194862145586.jpg",
        "image5"             => "https://productimages.hepsiburada.net/s/27/552/10194862145586.jpg",
        "video"              => "https://images.hepsiburada.net/assets/videos/ProductVideos/iPhone_14_Pro_PDP_Video_16x9__TR.mp4",
        "attributes"         => [
            "renk_variant_property"=> "Siyah",
            "numara_variant_property"=> "44",
            "malzeme"=> "Rugan"
        ]
    ]
];

$hb->updateProduct($items);

// Ürün Fiyat Güncelleme
$items = [
    [
        "hepsiburadaSku" => "SKU-456866",
        "merchantSku"    => "SKU12",
        "price"          => 120.50
    ]
];

$hb->updateProductPrice($items);

// Ürün Stok Güncelleme
$items = [
    [
        "hepsiburadaSku"             => "SKU-456866",
        "merchantSku"                => "SKU12",
        "availableStock"             => 30,
        "maximumPurchasableQuantity" => 1
    ]
];

$hb->updateProductStock($items);

```