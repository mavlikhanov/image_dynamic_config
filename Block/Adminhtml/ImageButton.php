<?php
declare(strict_types=1);

namespace Mr\ImageDynamicConfig\Block\Adminhtml;

class ImageButton extends \Magento\Backend\Block\Template
{
    protected $_template = 'Mr_ImageDynamicConfig::config/array_serialize/swatch_image.phtml';

    private $assetRepository;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\View\Asset\Repository $assetRepository,
        array $data = []
    ) {
        $this->assetRepository = $assetRepository;
        parent::__construct($context, $data);
    }

    public function getAssertRepository(): \Magento\Framework\View\Asset\Repository
    {
        return $this->assetRepository;
    }
}