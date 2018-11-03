<?php

namespace Ktpl\Topmenu\Model\Category\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * Class FeaturedBrand
 * @package Ktpl\Topmenu\Model\Category\Attribute\Source
 */
class FeaturedBrand extends AbstractSource
{

    /**
     * @return array
     */
    public function getAllOptions()
    {
        return $this->_options = [
            'option1' => [
                'label' => 'Option 1',
                'value' => 'option1'
            ],
            'option2' => [
                'label' => 'Option 2',
                'value' => 'option2'
            ],
            'option3' => [
                'label' => 'Option 3',
                'value' => 'option3'
            ],
            'option4' => [
                'label' => 'Option 4',
                'value' => 'option4'
            ]
        ];
    }
}
