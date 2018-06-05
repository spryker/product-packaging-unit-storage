<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductPackagingUnitStorage\Storage;

use Generated\Shared\Transfer\PriceProductStorageTransfer;
use Spryker\Client\ProductPackagingUnitStorage\Dependency\Client\PriceProductStorageToStorageInterface;
use Spryker\Shared\ProductPackagingUnitStorage\ProductPackagingUnitStorageConstants;

class PriceAbstractStorageReader implements PriceAbstractStorageReaderInterface
{
    /**
     * @var \Spryker\Client\ProductPackagingUnitStorage\Dependency\Client\PriceProductStorageToStorageInterface
     */
    protected $storageClient;

    /**
     * @var \Spryker\Client\ProductPackagingUnitStorage\Storage\PriceProductStorageKeyGeneratorInterface
     */
    protected $priceStorageKeyGenerator;

    /**
     * @param \Spryker\Client\ProductPackagingUnitStorage\Dependency\Client\PriceProductStorageToStorageInterface $storageClient
     * @param \Spryker\Client\ProductPackagingUnitStorage\Storage\PriceProductStorageKeyGeneratorInterface $priceStorageKeyGenerator
     */
    public function __construct(PriceProductStorageToStorageInterface $storageClient, PriceProductStorageKeyGeneratorInterface $priceStorageKeyGenerator)
    {
        $this->storageClient = $storageClient;
        $this->priceStorageKeyGenerator = $priceStorageKeyGenerator;
    }

    /**
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\PriceProductStorageTransfer|null
     */
    public function findPriceAbstractStorageTransfer($idProductAbstract)
    {
        $key = $this->priceStorageKeyGenerator->generateKey(ProductPackagingUnitStorageConstants::PRICE_ABSTRACT_RESOURCE_NAME, $idProductAbstract);

        return $this->findPriceProductStorageTransfer($key);
    }

    /**
     * @param string $key
     *
     * @return \Generated\Shared\Transfer\PriceProductStorageTransfer|null
     */
    protected function findPriceProductStorageTransfer($key)
    {
        $priceData = $this->storageClient->get($key);

        if (!$priceData) {
            return null;
        }

        $priceProductStorageTransfer = new PriceProductStorageTransfer();
        $priceProductStorageTransfer->fromArray($priceData, true);

        return $priceProductStorageTransfer;
    }
}
