<?php

namespace Ktpl\Topmenu\Observer;

class MenuCategoryData
{
    /**
     * Catalog category
     *
     * @var \Magento\Catalog\Helper\Category
     */
    protected $catalogCategory;

    /**
     * Catalog layer
     *
     * @var \Magento\Catalog\Model\Layer
     */
    private $catalogLayer = null;

    /**
     * Catalog layer resolver
     *
     * @var \Magento\Catalog\Model\Layer\Resolver
     */
    protected $layerResolver;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    protected $categoryFactory;

    /**
     * @param \Magento\Catalog\Helper\Category $catalogCategory
     * @param \Magento\Catalog\Model\Layer\Resolver $layerResolver
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Magento\Catalog\Helper\Category $catalogCategory,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory
    ) {

        $this->catalogCategory = $catalogCategory;
        $this->layerResolver = $layerResolver;
        $this->registry = $registry;
        $this->categoryFactory = $categoryFactory;
    }

    /**
     * Get category data to be added to the Menu
     *
     * @param \Magento\Framework\Data\Tree\Node $category
     * @return array
     */
    public function getMenuCategoryData($category)
    {
        $nodeId = 'category-node-' . $category->getId();

        $isActiveCategory = false;
        /** @var \Magento\Catalog\Model\Category $currentCategory */
        $currentCategory = $this->registry->registry('current_category');
        if ($currentCategory && $currentCategory->getId() == $category->getId()) {
            $isActiveCategory = true;
        }
        
        $categoryData = [
            'name' => $category->getName(),
            'id' => $nodeId,
            'url' => $this->catalogCategory->getCategoryUrl($category),
            'has_active' => $this->hasActive($category),
            'is_active' => $isActiveCategory,
            'image' => $this->categoryFactory->create()->load($category->getId())->getImage(),
            'megamenu_enabled' => $this->categoryFactory->create()->load($category->getId())->getMegamenuEnabled(),
            'featured_category_product_skus' => $this->categoryFactory->create()->load($category->getId())->getFeaturedCategoryProductSkus(),
            'featured_brand' => $this->categoryFactory->create()->load($category->getId())->getFeaturedBrand(),
            'left_static_block' => $this->categoryFactory->create()->load($category->getId())->getLeftStaticBlock(),
            'right_static_block' => $this->categoryFactory->create()->load($category->getId())->getRightStaticBlock(),

        ];

        return $categoryData;
    }

    /**
     * Checks whether category belongs to active category's path
     *
     * @param \Magento\Framework\Data\Tree\Node $category
     * @return bool
     */
    protected function hasActive($category)
    {
        $catalogLayer = $this->getCatalogLayer();
        if (!$catalogLayer) {
            return false;
        }

        $currentCategory = $catalogLayer->getCurrentCategory();
        if (!$currentCategory) {
            return false;
        }

        $categoryPathIds = explode(',', $currentCategory->getPathInStore());
        return in_array($category->getId(), $categoryPathIds);
    }

    /**
     * Get catalog layer
     * @return \Magento\Catalog\Model\Layer
     */
    private function getCatalogLayer()
    {
        if ($this->catalogLayer === null) {
            $this->catalogLayer = $this->layerResolver->get();
        }
        return $this->catalogLayer;
    }
}