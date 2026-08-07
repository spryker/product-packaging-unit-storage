<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductPackagingUnitStorage\Storage;

use Generated\Shared\Transfer\SynchronizationDataTransfer;
use Spryker\Client\ProductPackagingUnitStorage\Dependency\Service\ProductPackagingUnitStorageToSynchronizationServiceInterface;

class ProductPackagingUnitStorageKeyGenerator implements ProductPackagingUnitStorageKeyGeneratorInterface
{
    /**
     * @var \Spryker\Client\ProductPackagingUnitStorage\Dependency\Service\ProductPackagingUnitStorageToSynchronizationServiceInterface
     */
    protected $synchronizationService;

    public function __construct(
        ProductPackagingUnitStorageToSynchronizationServiceInterface $synchronizationService
    ) {
        $this->synchronizationService = $synchronizationService;
    }

    /**
     * @param string $resourceName
     * @param int $resourceId
     *
     * @return string
     */
    public function generateKey($resourceName, $resourceId): string
    {
        $synchronizationDataTransfer = new SynchronizationDataTransfer();
        $synchronizationDataTransfer
            ->setReference((string)$resourceId);

        return $this->synchronizationService
            ->getStorageKeyBuilder($resourceName)
            ->generateKey($synchronizationDataTransfer);
    }

    /**
     * @param array<int> $resourceIds
     *
     * @return array<string>
     */
    public function generateKeys(string $resourceName, array $resourceIds): array
    {
        $storageKeys = [];

        foreach ($resourceIds as $idResource) {
            $storageKeys[] = $this->generateKey($resourceName, $idResource);
        }

        return $storageKeys;
    }
}
