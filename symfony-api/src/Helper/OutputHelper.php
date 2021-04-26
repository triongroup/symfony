<?php


namespace App\Helper;


use App\Entity\Product;
use App\Entity\ProductProperties;
use Doctrine\ORM\Query;

class OutputHelper
{
    public function prepareOutput(Query $data)
    {
        $result = [
            'success' => true,
            'products' => [],
            'filters' => [
                'properties' => [],
                'price' => [],
                'manufacturer' => [],
                'region' => [],
            ],
        ];

        /** @var Product $product */
        foreach ($data->getResult() as $product) {
            $result['products'][] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'basePrice' => $product->getBasePrice(),
            ];

            //setting properties
            /** @var ProductProperties $prop */
            foreach ($product->getProperties() as $prop) {
                if (!isset($result['filters']['properties'][$prop->getProperty()->getName()])) {
                    $result['filters']['properties'][$prop->getProperty()->getName()] = 1;
                } else {
                    $result['filters']['properties'][$prop->getProperty()->getName()]++;
                }
            }

            // setting prices
            //TODO: need optimize
            if ($product->getPrice() < 10) {
                if (!isset($result['filters']['price']['0-10'])) {
                    $result['filters']['price']['0-10'] = 1;
                } else {
                    $result['filters']['price']['0-10']++;
                }
            }
            if ($product->getPrice() >= 10 && $product->getPrice() < 20) {
                if (!isset($result['filters']['price']['10-20'])) {
                    $result['filters']['price']['10-20'] = 1;
                } else {
                    $result['filters']['price']['10-20']++;
                }
            }
            if ($product->getPrice() >= 20 && $product->getPrice() < 50) {
                if (!isset($result['filters']['price']['20-50'])) {
                    $result['filters']['price']['20-50'] = 1;
                } else {
                    $result['filters']['price']['20-50']++;
                }
            }
            if ($product->getPrice() >= 50) {
                if (!isset($result['filters']['price']['50-'])) {
                    $result['filters']['price']['50-'] = 1;
                } else {
                    $result['filters']['price']['50-']++;
                }
            }

            // setting manufacturers
            if ($product->getManufacturer()) {
                if (!isset($result['filters']['manufacturer'][$product->getManufacturer()->getName()])) {
                    $result['filters']['manufacturer'][$product->getManufacturer()->getName()] = 1;
                } else {
                    $result['filters']['manufacturer'][$product->getManufacturer()->getName()]++;
                }
            }

            // setting regions
            if ($product->getRegion()) {
                if (!isset($result['filters']['region'][$product->getRegion()->getName()])) {
                    $result['filters']['region'][$product->getRegion()->getName()] = 1;
                } else {
                    $result['filters']['region'][$product->getRegion()->getName()]++;
                }
            }
        }

        return $result;
    }
}
