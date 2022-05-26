<?php
declare(strict_types=1);

namespace Mrmodule\ImageDynamicConfig\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class ImageFields extends AbstractFieldArray
{
    const IMAGE_FIELD = 'image';
    const NAME_FIELD = 'name';

    private $imageRenderer;

    protected function _prepareToRender()
    {
        $this->addColumn(
            self::IMAGE_FIELD,
            [
                'label' => __('Image'),
                'renderer' => $this->getImageRenderer()
            ]
        );

        $this->addColumn(
            self::NAME_FIELD,
            [
                'label' => __('Name'),
            ]
        );

        $this->_addAfter       = false;
        $this->_addButtonLabel = __('Add');
    }

    private function getImageRenderer()
    {
        if (!$this->imageRenderer) {
            $this->imageRenderer = $this->getLayout()->createBlock(
                \Mrmodule\ImageDynamicConfig\Block\Adminhtml\Form\Field\ImageColumn::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->imageRenderer;
    }
}