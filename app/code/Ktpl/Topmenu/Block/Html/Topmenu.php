<?php

namespace Ktpl\Topmenu\Block\Html;

use Magento\Catalog\Helper\Output;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Framework\Data\Tree\NodeFactory;
use Magento\Framework\Data\TreeFactory;
use Magento\Framework\View\Element\Template\Context;
use Magento\Theme\Block\Html\Topmenu as MtbhTopmenu;

class Topmenu extends MtbhTopmenu
{
    /**
     * @var Output
     */
    protected $catalogHelper;

    /**
     * Topmenu constructor.
     * @param Context $context
     * @param NodeFactory $nodeFactory
     * @param TreeFactory $treeFactory
     * @param CategoryFactory $categoryFactory
     * @param Output $catalogHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        NodeFactory $nodeFactory,
        TreeFactory $treeFactory,
        CategoryFactory $categoryFactory,
        Output $catalogHelper,
        array $data = []
    )
    {
        $this->catalogHelper = $catalogHelper;
        parent::__construct($context, $nodeFactory, $treeFactory, $data);
    }

    /**
     * @param string [name]
     * @return string [name in lower case and replace space by underscore]
     */
    public function getStringSmallWithoutSpace($name)
    {
        return str_replace(array(' ', '/'), array('-', '-'), strtolower($name));
    }

    /**
     * Add category image in submenu
     *
     * @param \Magento\Framework\Data\Tree\Node $child
     * @param string $childLevel
     * @param string $childrenWrapClass
     * @param int $limit
     * @return string HTML code
     */
    protected function _addSubMenu($child, $childLevel, $childrenWrapClass, $limit)
    {
        $html = '';

        if (!$child->hasChildren()) {
            $html .= $this->getCategoryResizedImage($child, $childLevel);
            return $html;
        }

        $colStops = null;
        if ($childLevel == 0 && $limit) {
            $colStops = $this->_columnBrake($child->getChildren(), $limit);
        }
        /*if ($childLevel == 0) {
            $html .= '<div class="ktpl-custom ui-menu">';
            $html .= '<div class="top_submenu">';
        }*/

        $html .= $this->getCategoryResizedImage($child, $childLevel);

        $html .= '<ul class="level' . $childLevel . ' submenu">';

        if ($child->getMegamenuEnabled()) {
            $html .= '<div class="megamenu-left-elements">';
            if ($child->getLeftStaticBlock()) {
                $html .= $this->catalogHelper->categoryAttribute($child, $child->getLeftStaticBlock(), 'left_static_block');
            }
            $html .= '</div>';
        }

        $html .= $this->_getHtml($child, $childrenWrapClass, $limit, $colStops);

        if ($child->getMegamenuEnabled()) {
            $html .= '<div class="megamenu-featured-elements">';
            $html .= $this->getMegamenuFeaturedElements($child);
            $html .= '</div>';
        }

        if ($child->getMegamenuEnabled()) {
            $html .= '<div class="megamenu-right-elements">';
            if ($child->getRightStaticBlock()) {
                $html .= $this->catalogHelper->categoryAttribute($child, $child->getRightStaticBlock(), 'right_static_block');
            }
            $html .= '</div>';
        }

        $html .= '</ul>';

        /*if ($childLevel == 0) {
            $html .= '</div>';
            $html .= '</div>';
        }*/


        return $html;
    }

    /**
     * @param $category
     * @return string
     */
    protected function getMegamenuFeaturedElements($category)
    {
        $html = '';
        if ($category->getFeaturedCategoryProductSkus()) {
            $html .= $this->getFeaturedProductsHtml(explode(',', $category->getFeaturedCategoryProductSkus()));
        }
        if ($category->getFeaturedBrand()) {
            $html .= $this->getFeaturedBrandHtml(explode(',', $category->getFeaturedBrand()));
        }
        return $html;
    }

    /**
     * @param array $productSkus
     * @return mixed
     */
    protected function getFeaturedProductsHtml(array $productSkus)
    {
        if ($productSkus != null) {
            return $this->getLayout()->createBlock("\Ktpl\Topmenu\Block\Html\FeaturedProducts")
                ->setTemplate("Ktpl_Topmenu::featuredproducts.phtml")
                ->setProductSkus($productSkus)
                ->toHtml();
        }
    }

    /**
     * @param array $brands
     * @return mixed
     */
    protected function getFeaturedBrandHtml(array $brands)
    {
        if ($brands != null) {
            return $this->getLayout()->createBlock("Ktpl\Topmenu\Block\Html\FeaturedBrands")
                ->setTemplate("Ktpl_Topmenu::featuredbrands.phtml")
                ->setSelectedBrandValues($brands)
                ->toHtml();
        }
    }

    /**
     * Returns array of menu item's classes
     *
     * @param \Magento\Framework\Data\Tree\Node $item
     * @return array
     */
    protected function _getMenuItemClasses(\Magento\Framework\Data\Tree\Node $item)
    {
        $classes = [];

        $classes[] = 'level' . $item->getLevel();
        $classes[] = ($item->getMegamenuEnabled()) ? ' megamenu' : '';
        $classes[] = $item->getPositionClass();

        if ($item->getIsFirst()) {
            $classes[] = 'first';
        }

        if ($item->getIsActive()) {
            $classes[] = 'active';
        } elseif ($item->getHasActive()) {
            $classes[] = 'has-active';
        }

        if ($item->getIsLast()) {
            $classes[] = 'last';
        }

        if ($item->getClass()) {
            $classes[] = $item->getClass();
        }

        //if ($item->hasChildren()) {
        $classes[] = 'parent';
        //}

        return $classes;
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        $this->setModuleName($this->extractModuleName('Magento\Theme\Block\Html\Topmenu'));
        return parent::_toHtml();
    }
}

