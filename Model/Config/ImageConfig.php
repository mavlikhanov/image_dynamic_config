<?php
declare(strict_types=1);

namespace Mr\ImageDynamicConfig\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;

class ImageConfig
{
    const XML_PATH_IMAGE_SERIALIZER = 'swatch/image_serializer/';

    private $scopeConfig;
    private $serializer;

    public function __construct(
        SerializerInterface $serializer,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->serializer = $serializer;
    }
    
    public function getSwatches(): array
    {
        $data = $this->scopeConfig->getValue(self::XML_PATH_IMAGE_SERIALIZER . 'image');
        if (!$data) {
            return [];
        }
        return $this->serializer->unserialize($data);
    }
}