<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/products', name: 'product_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $product = new Product();
        $product->setCode($data['code']);
        $product->setName($data['name']);
        $product->setDescription($data['description']);
        $product->setImage($data['image']);
        $product->setCategory($data['category']);
        $product->setPrice($data['price']);
        $product->setQuantity($data['quantity']);
        $product->setInternalReference($data['internalReference']);
        $product->setShellId($data['shellId']);
        $product->setInventoryStatus($data['inventoryStatus']);
        $product->setRating($data['rating']);
        $product->setCreatedAt(time());
        $product->setUpdatedAt(time());

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Product created!'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/products', name: 'product_get_all', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();
        $data = [];

        foreach ($products as $product) {
            $data[] = [
                'id' => $product->getId(),
                'code' => $product->getCode(),
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'image' => $product->getImage(),
                'category' => $product->getCategory(),
                'price' => $product->getPrice(),
                'quantity' => $product->getQuantity(),
                'internalReference' => $product->getInternalReference(),
                'shellId' => $product->getShellId(),
                'inventoryStatus' => $product->getInventoryStatus(),
                'rating' => $product->getRating(),
                'createdAt' => $product->getCreatedAt(),
                'updatedAt' => $product->getUpdatedAt(),
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/products/{id}', name: 'product_get', methods: ['GET'])]
    public function get(int $id): JsonResponse
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            return new JsonResponse(['status' => 'Product not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'id' => $product->getId(),
            'code' => $product->getCode(),
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'image' => $product->getImage(),
            'category' => $product->getCategory(),
            'price' => $product->getPrice(),
            'quantity' => $product->getQuantity(),
            'internalReference' => $product->getInternalReference(),
            'shellId' => $product->getShellId(),
            'inventoryStatus' => $product->getInventoryStatus(),
            'rating' => $product->getRating(),
            'createdAt' => $product->getCreatedAt(),
            'updatedAt' => $product->getUpdatedAt(),
        ]);
    }

    #[Route('/products/{id}', name: 'product_update', methods: ['PATCH'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            return new JsonResponse(['status' => 'Product not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        // Update properties if provided
        if (isset($data['code'])) $product->setCode($data['code']);
        if (isset($data['name'])) $product->setName($data['name']);
        if (isset($data['description'])) $product->setDescription($data['description']);
        if (isset($data['image'])) $product->setImage($data['image']);
        if (isset($data['category'])) $product->setCategory($data['category']);
        if (isset($data['price'])) $product->setPrice($data['price']);
        if (isset($data['quantity'])) $product->setQuantity($data['quantity']);
        if (isset($data['internalReference'])) $product->setInternalReference($data['internalReference']);
        if (isset($data['shellId'])) $product->setShellId($data['shellId']);
        if (isset($data['inventoryStatus'])) $product->setInventoryStatus($data['inventoryStatus']);
        if (isset($data['rating'])) $product->setRating($data['rating']);

        $product->setUpdatedAt(time());

        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Product updated!']);
    }

    #[Route('/products/{id}', name: 'product_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            return new JsonResponse(['status' => 'Product not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($product);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Product deleted!'], JsonResponse::HTTP_NO_CONTENT);
    }
}
