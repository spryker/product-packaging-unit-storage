<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductPackagingUnitStorage\Storage;

use Generated\Shared\Transfer\ProductPackagingUnitStorageCollectionTransfer;
use Generated\Shared\Transfer\ProductPackagingUnitStorageCriteriaTransfer;
use Generated\Shared\Transfer\ProductPackagingUnitStorageTransfer;
use Spryker\Client\ProductPackagingUnitStorage\Dependency\Client\ProductPackagingUnitStorageToStorageClientInterface;
use Spryker\Service\UtilEncoding\UtilEncodingServiceInterface;
use Spryker\Shared\ProductPackagingUnitStorage\ProductPackagingUnitStorageConfig;

class ProductPackagingUnitStorageReader implements ProductPackagingUnitStorageReaderInterface
{
    /**
     * @var \Spryker\Client\ProductPackagingUnitStorage\Dependency\Client\ProductPackagingUnitStorageToStorageClientInterface
     */
    protected $storageClient;

    /**
     * @var \Spryker\Client\ProductPackagingUnitStorage\Storage\ProductPackagingUnitStorageKeyGeneratorInterface
     */
    protected $productPackagingUnitStorageKeyGenerator;

    public function __construct(
        ProductPackagingUnitStorageToStorageClientInterface $storageClient,
        ProductPackagingUnitStorageKeyGeneratorInterface $productPackagingUnitStorageKeyGenerator,
        protected UtilEncodingServiceInterface $utilEncodingService
    ) {
        $this->storageClient = $storageClient;
        $this->productPackagingUnitStorageKeyGenerator = $productPackagingUnitStorageKeyGenerator;
    }

    public function findProductPackagingUnitById(int $idProductConcrete): ?ProductPackagingUnitStorageTransfer
    {
        $key = $this->productPackagingUnitStorageKeyGenerator->generateKey(
            ProductPackagingUnitStorageConfig::PRODUCT_PACKAGING_UNIT_RESOURCE_NAME,
            $idProductConcrete,
        );

        return $this->findProductPackagingUnitStorageTransfer($key);
    }

    public function getProductPackagingUnitStorageCollection(
        ProductPackagingUnitStorageCriteriaTransfer $productPackagingUnitStorageCriteriaTransfer
    ): ProductPackagingUnitStorageCollectionTransfer {
        $productPackagingUnitStorageCollectionTransfer = new ProductPackagingUnitStorageCollectionTransfer();

        $productIds = $productPackagingUnitStorageCriteriaTransfer
            ->getProductPackagingUnitStorageConditionsOrFail()
            ->getProductIds();

        if (!$productIds) {
            return $productPackagingUnitStorageCollectionTransfer;
        }

        $storageKeys = $this->productPackagingUnitStorageKeyGenerator->generateKeys(
            ProductPackagingUnitStorageConfig::PRODUCT_PACKAGING_UNIT_RESOURCE_NAME,
            $productIds,
        );

        $productPackagingUnitStorageData = array_filter($this->storageClient->getMulti($storageKeys));

        foreach ($productPackagingUnitStorageData as $productPackagingUnitStorageItem) {
            // Unlike `get()`, `getMulti()` returns the raw stored JSON.
            $decodedProductPackagingUnitStorageItem = $this->utilEncodingService->decodeJson($productPackagingUnitStorageItem, true);

            if (!$decodedProductPackagingUnitStorageItem) {
                continue;
            }

            $productPackagingUnitStorageCollectionTransfer->addProductPackagingUnitStorage(
                $this->mapProductPackagingUnitStorageData((array)$decodedProductPackagingUnitStorageItem),
            );
        }

        return $productPackagingUnitStorageCollectionTransfer;
    }

    protected function findProductPackagingUnitStorageTransfer(string $key): ?ProductPackagingUnitStorageTransfer
    {
        $data = $this->storageClient->get($key);

        if (!$data) {
            return null;
        }

        return $this->mapProductPackagingUnitStorageData((array)$data);
    }

    /**
     * @param array<string, mixed> $productPackagingUnitStorageData
     */
    protected function mapProductPackagingUnitStorageData(array $productPackagingUnitStorageData): ProductPackagingUnitStorageTransfer
    {
        return (new ProductPackagingUnitStorageTransfer())
            ->fromArray($productPackagingUnitStorageData, true);
    }
}
