<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductPackagingUnitStorage\Business\Storage;

use Spryker\Zed\ProductPackagingUnitStorage\Persistence\ProductPackagingUnitStorageEntityManagerInterface;

class ProductPackagingStorageWriter implements ProductPackagingStorageWriterInterface
{
    /**
     * @var \Spryker\Zed\ProductPackagingUnitStorage\Persistence\ProductPackagingUnitStorageEntityManagerInterface
     */
    protected $productPackagingUnitStorageEntityManager;

    /**
     * @var \Spryker\Zed\ProductPackagingUnitStorage\Business\Storage\ProductPackagingStorageReaderInterface
     */
    protected $productAbstractPackagingUnitStorageReader;

    /**
     * @param \Spryker\Zed\ProductPackagingUnitStorage\Persistence\ProductPackagingUnitStorageEntityManagerInterface $productPackagingUnitStorageEntityManager
     * @param \Spryker\Zed\ProductPackagingUnitStorage\Business\Storage\ProductPackagingStorageReaderInterface $productAbstractPackagingStorageReader
     */
    public function __construct(
        ProductPackagingUnitStorageEntityManagerInterface $productPackagingUnitStorageEntityManager,
        ProductPackagingStorageReaderInterface $productAbstractPackagingStorageReader
    ) {
        $this->productPackagingUnitStorageEntityManager = $productPackagingUnitStorageEntityManager;
        $this->productAbstractPackagingUnitStorageReader = $productAbstractPackagingStorageReader;
    }

    /**
     * @param array $idProductAbstracts
     *
     * @return void
     */
    public function publish(array $idProductAbstracts): void
    {
        $productAbstractPackagingTransfers = $this->productAbstractPackagingUnitStorageReader
            ->getProductAbstractPackagingStorageTransfer($idProductAbstracts);

        $this->storeData($productAbstractPackagingTransfers);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractPackagingStorageTransfer[] $productAbstractPackagingTransfers
     *
     * @return void
     */
    protected function storeData(array $productAbstractPackagingTransfers): void
    {
        foreach ($productAbstractPackagingTransfers as $productAbstractPackagingTransfer) {
            $this->productPackagingUnitStorageEntityManager->saveProductAbstractPackagingStorageEntity($productAbstractPackagingTransfer);
        }
    }

    /**
     * @param int[] $idProductAbstracts
     *
     * @return void
     */
    public function unpublish(array $idProductAbstracts): void
    {
        $productAbstractPackagingStorageEntities = $this->productAbstractPackagingUnitStorageReader
            ->getProductAbstractPackagingUnitStorageEntities($idProductAbstracts);

        foreach ($productAbstractPackagingStorageEntities as $productAbstractPackagingStorageEntity) {
            $this->productPackagingUnitStorageEntityManager->deleteProductAbstractPackagingStorageEntity($productAbstractPackagingStorageEntity);
        }
    }
}