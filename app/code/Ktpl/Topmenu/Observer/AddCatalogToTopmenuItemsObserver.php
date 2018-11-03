<?php

namespace Ktpl\Topmenu\Observer;

use Ktpl\Topmenu\Observer\MenuCategoryData;
use Magento\Catalog\Helper\Category;
use Magento\Catalog\Model\Indexer\Category\Flat\State;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class AddCatalogToTopmenuItemsObserver
 * @package Ktpl\Topmenu\Observer
 */
class AddCatalogToTopmenuItemsObserver implements ObserverInterface
{
    /**
     * Catalog category
     *
     * @var Category
     */
    protected $catalogCategory;

    /**
     * @var State
     */
    protected $categoryFlatState;

    /**
     * @var MenuCategoryData
     */
    protected $menuCategoryData;

    /**
     * AddCatalogToTopmenuItemsObserver constructor.
     * @param Category $catalogCategory
     * @param State $categoryFlatState
     * @param \Ktpl\Topmenu\Observer\MenuCategoryData $menuCategoryData
     */
    public function __construct(
        Category $catalogCategory,
        State $categoryFlatState,
        MenuCategoryData $menuCategoryData
    ) {
        $this->catalogCategory = $catalogCategory;
        $this->categoryFlatState = $categoryFlatState;
        $this->menuCategoryData = $menuCategoryData;
    }

    /**
     * Checking whether the using static urls in WYSIWYG allowed event
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();
        $block->addIdentity(\Magento\Catalog\Model\Category::CACHE_TAG);
        $this->_addCategoriesToMenu($this->catalogCategory->getStoreCategories(), $observer->getMenu(), $block);
    }

    /**
     * Recursively adds categories to top menu
     *
     * @param \Magento\Framework\Data\Tree\Node\Collection|array $categories
     * @param \Magento\Framework\Data\Tree\Node $parentCategoryNode
     * @param \Magento\Theme\Block\Html\Topmenu $block
     * @return void
     */
    protected function _addCategoriesToMenu($categories, $parentCategoryNode, $block)
    {
        foreach ($categories as $category) {
            if (!$category->getIsActive()) {
                continue;
            }
            $block->addIdentity(\Magento\Catalog\Model\Category::CACHE_TAG . '_' . $category->getId());

            $tree = $parentCategoryNode->getTree();
            $categoryData = $this->menuCategoryData->getMenuCategoryData($category);
            $categoryNode = new \Magento\Framework\Data\Tree\Node($categoryData, 'id', $tree, $parentCategoryNode);
            $parentCategoryNode->addChild($categoryNode);

            if ($this->categoryFlatState->isFlatEnabled() && $category->getUseFlatResource()) {
                $subcategories = (array)$category->getChildrenNodes();
            } else {
                $subcategories = $category->getChildren();
            }

            $this->_addCategoriesToMenu($subcategories, $categoryNode, $block);
        }
    }
}
