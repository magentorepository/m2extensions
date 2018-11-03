<?php

namespace Ktpl\Topmenu\Block\Html;

use Magento\Catalog\Block\Product\Context;
use Magento\Eav\Model\Config;
use Magento\Framework\View\Element\Template;

class FeaturedBrands extends Template
{
    /**
     * @var Config
     */
    protected $eavConfig;

    /**
     * FeaturedBrands constructor.
     * @param Context $context
     * @param Config $eavConfig
     * @param array $data
     */
    public function __construct(
        Context $context,
        Config $eavConfig,
        array $data = []
    ) {
        $this->eavConfig = $eavConfig;
        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * @param string $attributeCode
     * @return array
     */
    public function getFeaturedAttributeCollection($attributeCode)
    {
        $attribute = $this->eavConfig->getAttribute('catalog_product', $attributeCode);
        $options = $attribute->getSource()->getAllOptions();

        return $options;
    }

    /**
     * @return bool
     */
    protected function getDisplayOptionImage()
    {
        return false;
    }
}