<?php

namespace Ktpl\Topmenu\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Eav\Setup\EavSetup;

/**
 * Class InstallData
 * @package Ktpl\Topmenu\Setup
 */
class InstallData implements InstallDataInterface
{

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * Constructor
     *
     * @param \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'megamenu_enabled',
            [
                'type' => 'int',
                'label' => 'Enable megamenu',
                'input' => 'boolean',
                'sort_order' => 333,
                'source' => '',
                'global' => 0,
                'visible' => true,
                'required' => true,
                'user_defined' => false,
                'default' => null,
                'group' => 'General Information',
                'backend' => ''
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'featured_category_product_skus',
            [
                'type' => 'varchar',
                'label' => 'Featured products',
                'input' => 'text',
                'sort_order' => 333,
                'source' => '',
                'global' => 0,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => null,
                'group' => 'General Information',
                'backend' => ''
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'featured_brand',
            [
                'type' => 'varchar',
                'label' => 'Featured brand',
                'input' => 'multiselect',
                'sort_order' => 333,
                'source' => 'Ktpl\Topmenu\Model\Category\Attribute\Source\FeaturedBrand',
                'global' => 1,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => null,
                'group' => 'General Information',
                'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend'
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'left_static_block',
            [
                'type' => 'text',
                'label' => 'Left static block',
                'input' => 'textarea',
                'sort_order' => 333,
                'source' => '',
                'global' => 0,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => null,
                'wysiwyg_enabled' => true,
                'is_html_allowed_on_front' => true,
                'group' => 'General Information',
                'backend' => ''
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'right_static_block',
            [
                'type' => 'text',
                'label' => 'Right static block',
                'input' => 'textarea',
                'sort_order' => 333,
                'source' => '',
                'global' => 0,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => null,
                'wysiwyg_enabled' => true,
                'is_html_allowed_on_front' => true,
                'group' => 'General Information',
                'backend' => ''
            ]
        );
    }
}
