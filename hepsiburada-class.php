<?php

class Hepsiburada
{        
    public $username;
    public $password;
    public $merchantId;

    function __construct($username, $password, $merchantId) {
        $this->username = $username;
        $this->password = $password;
        $this->merchantId = $merchantId;
    }

    function api_request($method, $url, $body = null, $file = null) { 
		$ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERPWD, $this->username . ":" . $this->password);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        
            if ($file != null) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
				
                $file_content = json_encode($body);
                $tmph = tmpfile();
                fwrite($tmph, $file_content);
                $tmpf = stream_get_meta_data($tmph)['uri'];

				curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, ['file' => new CURLFile($tmpf, 'application/octet-strem', $file)]);
				
			    $response = curl_exec($ch);
                curl_close($ch);
            }
            else {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
                if ($method == "POST") {
                    if ($body != null) {
						curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
						$response = curl_exec($ch);
                        curl_close($ch);
                    }
                    else {
						$response = curl_exec($ch);
                        curl_close($ch);
                    }
                }
                else {
				     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
				     $response = curl_exec($ch);
                     curl_close($ch);
                }
            }

            return $response;
    }

    public function updateProductStock($data)
    {
        $url = "https://listing-external-sit.hepsiburada.com/listings/merchantid/" . $this->merchantId . "/stock-uploads";
        $data = array($data);

        return $this->api_request("POST", $url, $data);
    }

    public function updateProductStockCheck($trackingId)
    {
        $url = "https://listing-external-sit.hepsiburada.com/listings/merchantid/" . $this->merchantId . "/stock-uploads/id/" . $trackingId;

        return $this->api_request("GET", $url);
    }

    public function updateProductPrice($data)
    {
        $url = "https://listing-external-sit.hepsiburada.com/listings/merchantid/" . $this->merchantId . "/price-uploads";
        $data = array($data);

        return $this->api_request("POST", $url, $data);
    }

    public function updateProductPriceCheck($trackingId)
    {
        $url = "https://listing-external-sit.hepsiburada.com/listings/merchantid/" . $this->merchantId . "/price-uploads/id/" . $trackingId;

        return $this->api_request("GET", $url);
    }

    public function createProduct($data) {

        /*

    $createProductData = [
    'categoryId'         => $_POST['product-categoryId'],
    'merchant'           => $hepsiburada->merchantId,
    'attributes'         => [
        'merchantSku'         => $_POST['product-sku'],
        'VaryantGroupID'      => $_POST['product-variantGroupId'],
        'Barcode'             => $_POST['product-barcode'],
        'UrunAdi'             => $_POST['product-name'],
        'UrunAciklamasi'      => $_POST['product-description'],
        'Marka'               => $_POST['product-brand'],
        'GarantiSuresi'       => $_POST['product-warranty'],
        'kg'                  => $_POST['product-weight'],
        'tax_vat_rate'        => $_POST['product-taxRate'],
        'price'               => $_POST['product-price'],
        'stock'               => $_POST['product-stock'],
        'Image1'              => $_POST['product-image1'],
        'Image2'              => $_POST['product-image2'],
        'Image3'              => $_POST['product-image3'],
        'Image4'              => $_POST['product-image4'],
        'Image5'              => $_POST['product-image5'],
        'Video1'              => $_POST['product-video1'],
        'renk_variant_property' => $_POST['product-renkVariantProperty'],
        'ebatlar_variant_property' => $_POST['product-ebatlarVariantProperty'],
    ]
];

        https://developers.hepsiburada.com/hepsiburada/reference/uploadproductviafile
        */

        $data = array($data);

        return $this->api_request("POST", "https://mpop-sit.hepsiburada.com/product/api/products/import", $data, "integrator.json");
    }

    public function updateProduct($data) {
        /*

 {
    "merchantId": ,
    "items": [
       {
         "hbSku": "SAMPLE-SKU-INT-0",
         "productName": "Hizlimarket1",
         "productDescription": "Duis enim duis magna ex veniam elit id Lorem cillum minim nisi id aliquip. Laboris magna id est et deserunt adipisicing tempor eu ea officia ipsum deserunt. Irure occaecat sit aliquip elit ipsum sint dolore quis est amet aute pariatur cupidatat fugiat. Cillum pariatur pariatur occaecat sint. Aliqua qui in exercitation nulla aliquip id ipsum aliquip ad ut excepteur culpa consequat aliquip. Nisi ut ex tempor enim adipisicing anim irure pariatur.\r\n",
         "image1": "https://productimages.hepsiburada.net/s/27/552/10194862145586.jpg",
         "image2": "https://productimages.hepsiburada.net/s/27/552/10194862145586.jpg",
         "image3": "https://productimages.hepsiburada.net/s/27/552/10194862145586.jpg",
         "image4": "https://productimages.hepsiburada.net/s/27/552/10194862145586.jpg",
         "image5": "https://productimages.hepsiburada.net/s/27/552/10194862145586.jpg",
         "video": "https://images.hepsiburada.net/assets/videos/ProductVideos/iPhone_14_Pro_PDP_Video_16x9__TR.mp4",
       },
       {
         "hbSku": "SAMPLE-SKU-INT-1",
         "productName": "Hizlimarket2",
         "productDescription": "Duis enim duis magna ex veniam elit id Lorem cillum minim nisi id aliquip. Laboris magna id est et deserunt adipisicing tempor eu ea officia ipsum deserunt. Irure occaecat sit aliquip elit ipsum sint dolore quis est amet aute pariatur cupidatat fugiat. Cillum pariatur pariatur occaecat sint. Aliqua qui in exercitation nulla aliquip id ipsum aliquip ad ut excepteur culpa consequat aliquip. Nisi ut ex tempor enim adipisicing anim irure pariatur.\r\n",
         "image1": "https://productimages.hepsiburada.net/s/27/552/10194862145586.jpg",
         "image2": "https://productimages.hepsiburada.net/s/27/552/10194862145586.jpg",
         "image3": "https://productimages.hepsiburada.net/s/27/552/10194862145586.jpg",
         "image4": "https://productimages.hepsiburada.net/s/27/552/10194862145586.jpg",
         "image5": "https://productimages.hepsiburada.net/s/27/552/10194862145586.jpg",
         "video": "https://images.hepsiburada.net/assets/videos/ProductVideos/iPhone_14_Pro_PDP_Video_16x9__TR.mp4",
       }
    ]
  }
https://developers.hepsiburada.com/hepsiburada/reference/uploadticketviafile

        */

        $data = array($data);

        $newData = [
            'merchantId'                 => $this->merchantId,
            'items'                      => $data 
        ];
		
		echo json_encode($newData);

        return $this->api_request("POST","https://mpop-sit.hepsiburada.com/ticket-api/api/integrator/import?version=1", $newData, "integrator-ticket-upload.json");
    }

    public function updateProductCheck($trackingId) {
        $url = "https://mpop-sit.hepsiburada.com/ticket-api/api/integrator/status/" . $trackingId;

        return $this->api_request("GET", $url);
    }

    public function getAllProducts() {
        $url = "https://mpop-sit.hepsiburada.com/product/api/products/all-products-of-merchant/" . $this->merchantId . "?page=0&size=1000";

        return $this->api_request("GET", $url);
    }
	
	public function getAllCategories() {
		$url = "https://mpop-sit.hepsiburada.com/product/api/categories/get-all-categories?leaf=true&status=ACTIVE&available=true&version=1&page=0&size=1000";
		
		return $this->api_request("GET", $url);
	}	
	
	public function getAllCategoryAttributeValues($categoryId, $attrId) {
		$url = "https://mpop-sit.hepsiburada.com/product/api/categories/" . $categoryId . "/attribute/" . $attrId . "/values?version=5&page=0&size=1000";
		
		return $this->api_request("GET", $url);
	}
	
	public function getProductInfo($sku) {
		$url = "https://listing-external-sit.hepsiburada.com/listings/merchantid/" . $this->merchantId . "?offset=0&limit=1&merchantSkuList=" . $sku;
		
		$result = json_decode($this->api_request("GET", $url));
		
		if (property_exists($result, "listings")) {
            $result = $result->listings;
            $result = $result[0];
        }
        else {
            $result = null;
        }
		
		return $result;
	}
}

$hepsiburada = new Hepsiburada("username", "password", "merchantId");

?>