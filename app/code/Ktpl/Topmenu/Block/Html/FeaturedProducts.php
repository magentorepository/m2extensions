<?php

namespace Ktpl\Topmenu\Block\Html;


use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Block\Product\ListProduct;

/**
 * Class FeaturedProducts
 * @package Ktpl\Topmenu\Block\Html
 */
class FeaturedProducts extends \Magento\Catalog\Block\Product\AbstractProduct
{
    /**
     * @var CollectionFactory
     */
    protected $_productCollectionFactory;

    /**
     * @var Visibility
     */
    protected $catalogProductVisibility;

    /**
     * Featured constructor.
     * @param Context $context
     * @param CollectionFactory $productCollectionFactory
     * @param Visibility $catalogProductVisibility
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        Visibility $catalogProductVisibility,
        array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->catalogProductVisibility = $catalogProductVisibility;
        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * @return $this
     */
    public function getFeaturedProductCollection()
    {
        $collection = $this->_productCollectionFactory->create();
        $collection = $this->_addProductAttributesAndPrices($collection)
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('status', '1')
            ->addAttributeToFilter('sku', array('in' => $this->getProductSkus()));
        $collection->setVisibility($this->catalogProductVisibility->getVisibleInCatalogIds());

        return $collection;
    }

}