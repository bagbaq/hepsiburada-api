<?php

namespace Hepsiburada;

class Hepsiburada
{
    public $username;
    public $password;
    public $merchantId;

    function __construct($username, $password, $merchantId)
    {
        $this->username = $username;
        $this->password = $password;
        $this->merchantId = $merchantId;
    }

    protected function api_request($method, $url, $body = null, $file = null)
    {
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
            curl_setopt($ch, CURLOPT_POSTFIELDS, ['file' => new \CURLFile($tmpf, 'application/octet-strem', $file)]);

            $response = curl_exec($ch);
            curl_close($ch);
        } else {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
            if ($method == "POST") {
                if ($body != null) {
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
                    $response = curl_exec($ch);
                    curl_close($ch);
                } else {
                    $response = curl_exec($ch);
                    curl_close($ch);
                }
            } else {
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

    public function createProduct($data)
    {
        $data = array($data);

        return $this->api_request("POST", "https://mpop-sit.hepsiburada.com/product/api/products/import", $data, "integrator.json");
    }

    public function updateProduct($data)
    {
        $data = array($data);

        $newData = [
            'merchantId' => $this->merchantId,
            'items' => $data
        ];

        return $this->api_request("POST", "https://mpop-sit.hepsiburada.com/ticket-api/api/integrator/import?version=1", $newData, "integrator-ticket-upload.json");
    }

    public function updateProductCheck($trackingId)
    {
        $url = "https://mpop-sit.hepsiburada.com/ticket-api/api/integrator/status/" . $trackingId;

        return $this->api_request("GET", $url);
    }

    public function getAllProducts()
    {
        $url = "https://mpop-sit.hepsiburada.com/product/api/products/all-products-of-merchant/" . $this->merchantId . "?page=0&size=1000";

        return $this->api_request("GET", $url);
    }

    public function getAllCategories()
    {
        $url = "https://mpop-sit.hepsiburada.com/product/api/categories/get-all-categories?leaf=true&status=ACTIVE&available=true&version=1&page=0&size=1000";

        return $this->api_request("GET", $url);
    }

    public function getAllCategoryAttributeValues($categoryId, $attrId)
    {
        $url = "https://mpop-sit.hepsiburada.com/product/api/categories/" . $categoryId . "/attribute/" . $attrId . "/values?version=5&page=0&size=1000";

        return $this->api_request("GET", $url);
    }

    public function getProductInfo($sku)
    {
        $url = "https://listing-external-sit.hepsiburada.com/listings/merchantid/" . $this->merchantId . "?offset=0&limit=1&merchantSkuList=" . $sku;

        $result = json_decode($this->api_request("GET", $url));

        if (property_exists($result, "listings")) {
            $result = $result->listings;
            $result = $result[0];
        } else {
            $result = null;
        }

        return $result;
    }
}