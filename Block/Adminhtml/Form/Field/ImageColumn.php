<?php
declare(strict_types=1);

namespace Mr\ImageDynamicConfig\Block\Adminhtml\Form\Field;

use Mr\ImageDynamicConfig\Block\Adminhtml\ImageButton;

class ImageColumn extends \Magento\Framework\View\Element\AbstractBlock
{
    public function setInputName(string $value)
    {
        return $this->setName($value);
    }

    public function setInputId(string $value)
    {
        return $this->setId($value);
    }

    protected function _toHtml(): string
    {
        $imageButton = $this->getLayout()
            ->createBlock(ImageButton::class)
            ->setData('id', $this->getId())
            ->setData('name', $this->getName());
        return $imageButton->toHtml();
    }
}
