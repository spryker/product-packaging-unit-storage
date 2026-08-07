<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Client\ProductPackagingUnitStorage;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ProductPackagingUnitStorageCollectionTransfer;
use Generated\Shared\Transfer\ProductPackagingUnitStorageConditionsTransfer;
use Generated\Shared\Transfer\ProductPackagingUnitStorageCriteriaTransfer;
use Generated\Shared\Transfer\ProductPackagingUnitStorageTransfer;
use Generated\Shared\Transfer\SpyProductPackagingUnitEntityTransfer;
use Generated\Shared\Transfer\SpyProductPackagingUnitTypeEntityTransfer;
use Spryker\Client\ProductPackagingUnitStorage\Dependency\Client\ProductPackagingUnitStorageToStorageClientInterface;
use Spryker\Client\ProductPackagingUnitStorage\ProductPackagingUnitStorageClientInterface;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Client
 * @group ProductPackagingUnitStorage
 * @group ProductPackagingUnitStorageClientTest
 * Add your own group annotations below this line
 */
class ProductPackagingUnitStorageClientTest extends Unit
{
    /**
     * @var string
     */
    protected const PACKAGING_TYPE = 'box';

    /**
     * @var int
     */
    protected const ID_PRODUCT_PACKAGED = 11;

    /**
     * @var int
     */
    protected const ID_PRODUCT_PACKAGED_SECOND = 22;

    /**
     * @var \SprykerTest\Client\ProductPackagingUnitStorage\ProductPackagingUnitStorageClientTester
     */
    protected $tester;

    public function testFindProductPackagingUnitById(): void
    {
        // Arrange
        $itemProductConcreteTransfer = $this->tester->haveProduct();
        $boxProductConcreteTransfer = $this->tester->haveProduct();

        $boxProductPackagingUnitType = $this->tester->haveProductPackagingUnitType([SpyProductPackagingUnitTypeEntityTransfer::NAME => static::PACKAGING_TYPE]);

        $this->tester->haveProductPackagingUnit([
            SpyProductPackagingUnitEntityTransfer::FK_PRODUCT => $boxProductConcreteTransfer->getIdProductConcrete(),
            SpyProductPackagingUnitEntityTransfer::FK_PRODUCT_PACKAGING_UNIT_TYPE => $boxProductPackagingUnitType->getIdProductPackagingUnitType(),
            SpyProductPackagingUnitEntityTransfer::FK_LEAD_PRODUCT => $itemProductConcreteTransfer->getIdProductConcrete(),
        ]);

        $productPackagingUnitStorageToStorageClientBridge = $this->getMockBuilder(ProductPackagingUnitStorageToStorageClientInterface::class)->getMock();
        $this->tester->setStorageMock(
            $productPackagingUnitStorageToStorageClientBridge,
            (new ProductPackagingUnitStorageTransfer())->toArray(),
        );

        // Act
        $productPackagingUnitStorageTransfer = $this->getProductPackagingUnitStorageClient()
            ->findProductPackagingUnitById(
                $boxProductConcreteTransfer->getIdProductConcrete(),
            );

        // Assert
        $this->assertInstanceOf(ProductPackagingUnitStorageTransfer::class, $productPackagingUnitStorageTransfer);
    }

    public function testGetProductPackagingUnitStorageCollectionReturnsAllPackagingUnitsInOneStorageRequest(): void
    {
        // Arrange
        $productPackagingUnitStorageToStorageClientBridge = $this->getMockBuilder(ProductPackagingUnitStorageToStorageClientInterface::class)->getMock();

        $productPackagingUnitStorageToStorageClientBridge
            ->expects($this->once())
            ->method('getMulti')
            ->willReturn($this->encodeStorageContents([
                [ProductPackagingUnitStorageTransfer::ID_PRODUCT => static::ID_PRODUCT_PACKAGED],
                [ProductPackagingUnitStorageTransfer::ID_PRODUCT => static::ID_PRODUCT_PACKAGED_SECOND],
            ]));

        $this->tester->setStorageDependency($productPackagingUnitStorageToStorageClientBridge);

        // Act
        $productPackagingUnitStorageCollectionTransfer = $this->getProductPackagingUnitStorageClient()
            ->getProductPackagingUnitStorageCollection(
                $this->createCriteriaTransfer([static::ID_PRODUCT_PACKAGED, static::ID_PRODUCT_PACKAGED_SECOND]),
            );

        // Assert
        $this->assertCount(2, $productPackagingUnitStorageCollectionTransfer->getProductPackagingUnitStorages());
        $this->assertSame(
            [static::ID_PRODUCT_PACKAGED, static::ID_PRODUCT_PACKAGED_SECOND],
            $this->extractProductIds($productPackagingUnitStorageCollectionTransfer),
        );
    }

    public function testGetProductPackagingUnitStorageCollectionSkipsProductWithoutPackagingUnit(): void
    {
        // Arrange
        $productPackagingUnitStorageToStorageClientBridge = $this->getMockBuilder(ProductPackagingUnitStorageToStorageClientInterface::class)->getMock();
        $productPackagingUnitStorageToStorageClientBridge
            ->method('getMulti')
            ->willReturn($this->encodeStorageContents([
                [ProductPackagingUnitStorageTransfer::ID_PRODUCT => static::ID_PRODUCT_PACKAGED],
            ]));

        $this->tester->setStorageDependency($productPackagingUnitStorageToStorageClientBridge);

        // Act
        $productPackagingUnitStorageCollectionTransfer = $this->getProductPackagingUnitStorageClient()
            ->getProductPackagingUnitStorageCollection(
                $this->createCriteriaTransfer([static::ID_PRODUCT_PACKAGED, static::ID_PRODUCT_PACKAGED_SECOND]),
            );

        // Assert
        $this->assertSame([static::ID_PRODUCT_PACKAGED], $this->extractProductIds($productPackagingUnitStorageCollectionTransfer));
    }

    public function testGetProductPackagingUnitStorageCollectionSkipsStorageForEmptyProductIds(): void
    {
        // Arrange
        $productPackagingUnitStorageToStorageClientBridge = $this->getMockBuilder(ProductPackagingUnitStorageToStorageClientInterface::class)->getMock();

        $productPackagingUnitStorageToStorageClientBridge->expects($this->never())->method('getMulti');

        $this->tester->setStorageDependency($productPackagingUnitStorageToStorageClientBridge);

        // Act
        $productPackagingUnitStorageCollectionTransfer = $this->getProductPackagingUnitStorageClient()
            ->getProductPackagingUnitStorageCollection($this->createCriteriaTransfer([]));

        // Assert
        $this->assertCount(0, $productPackagingUnitStorageCollectionTransfer->getProductPackagingUnitStorages());
    }

    /**
     * @param array<array<string, mixed>> $contents
     *
     * @return array<string>
     */
    protected function encodeStorageContents(array $contents): array
    {
        $encodedContents = [];

        foreach ($contents as $content) {
            $encodedContents[] = (string)json_encode($content);
        }

        return $encodedContents;
    }

    /**
     * @param array<int> $productIds
     */
    protected function createCriteriaTransfer(array $productIds): ProductPackagingUnitStorageCriteriaTransfer
    {
        return (new ProductPackagingUnitStorageCriteriaTransfer())
            ->setProductPackagingUnitStorageConditions(
                (new ProductPackagingUnitStorageConditionsTransfer())->setProductIds($productIds),
            );
    }

    /**
     * @return array<int>
     */
    protected function extractProductIds(ProductPackagingUnitStorageCollectionTransfer $productPackagingUnitStorageCollectionTransfer): array
    {
        $productIds = [];

        foreach ($productPackagingUnitStorageCollectionTransfer->getProductPackagingUnitStorages() as $productPackagingUnitStorageTransfer) {
            $productIds[] = $productPackagingUnitStorageTransfer->getIdProduct();
        }

        return $productIds;
    }

    protected function getProductPackagingUnitStorageClient(): ProductPackagingUnitStorageClientInterface
    {
        return $this->tester->getLocator()->productPackagingUnitStorage()->client();
    }
}
