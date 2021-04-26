<?php

namespace App\Controller;

use App\Entity\Manufacturer;
use App\Entity\Product;
use App\Entity\ProductProperties;
use App\Entity\Properties;
use App\Entity\Region;
use App\Helper\OutputHelper;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    /**
     * @Route("/upload", name="upload_file", methods={"POST"})
     */
    public function upload(Request $request, ValidatorInterface $validator): JsonResponse
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('file');

        $violations = $validator->validate(
            $uploadedFile,
            [
                new NotBlank([
                    'message' => 'Please select a file to upload'
                ]),
                new File([
                    'maxSize' => '5M',
                ])
            ]
        );
        if ($violations->count() > 0) {
            $result = [
                'success' => false,
                'errors' => [],
            ];
            foreach ($violations as $violation) {
                $result['errors'][] = $violation->getMessage();
            }
            return new JsonResponse($result, 400);
        }
        $uploadedFile->move($this->getParameter('upload_directory'), $uploadedFile->getClientOriginalName());

        $entityManager = $this->getDoctrine()->getManager();

        if (($handle = fopen($this->getParameter('upload_directory') . '/' .$uploadedFile->getClientOriginalName(), "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!$data || !$data[0] || !(int)$data[0]) {
                    continue;
                }

                $region = null;
                if (!empty($data[2])) {
                    $region = $entityManager->getRepository(Region::class)->findOneBy(['name' => $data[2]]);
                    if (null === $region) {
                        $region = new Region();
                        $region->setName($data[2]);
                        $entityManager->persist($region);
                    }
                }

                $manufacturer = $entityManager->getRepository(Manufacturer::class)
                    ->findOneBy(['name' => $data[5]]);
                if (null === $manufacturer) {
                    $manufacturer = new Manufacturer();
                    $manufacturer->setName($data[5]);
                    $entityManager->persist($manufacturer);
                }

                $product = $entityManager->getRepository(Product::class)
                    ->findOneBy(['id' => $data[0]]);
                if (null === $product) {
                    $product = new Product();
                    $product->setId($data[0]);
                }
                $product->setName($data[1]);
                $product->setPrice($data[3]);
                $product->setBasePrice($data[4]);
                if ($region !== null) {
                    $product->setRegion($region);
                }
                $product->setManufacturer($manufacturer);
                $entityManager->persist($product);

                if (!empty($data[6])) {
                    foreach (explode(',', $data[6]) as $prop) {
                        $property = $entityManager->getRepository(Properties::class)
                            ->findOneBy(['name' => $prop]);
                        if (null === $property) {
                            $property = new Properties();
                            $property->setName($prop);
                            $entityManager->persist($property);
                        }

                        $productProp = $entityManager->getRepository(ProductProperties::class)
                            ->findOneBy(['product' => $product, 'property' => $property]);
                        if (null === $productProp) {
                            $productProp = new ProductProperties();
                            $productProp->setProduct($product);
                            $productProp->setProperty($property);
                            $entityManager->persist($productProp);
                        }
                    }
                }

                $entityManager->flush();
            }
            fclose($handle);
        }

        return new JsonResponse(['success' => true], 200);
    }

    /**
     * @Route("/products", name="products", methods={"GET"})
     */
    public function getProducts(Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $productsQuery = $entityManager->getRepository(Product::class)->initProducts();

        $products = $productsQuery->applyFilters($request->get('filter'))->getQuery();

        $result = (new OutputHelper())->prepareOutput($products);

        return new JsonResponse($result, 200);
    }
}
