<?php
declare(strict_types=1);

namespace Mrmodule\ImageDynamicConfig\Model;

use Magento\MediaStorage\Model\File\Uploader;

class ImageUploader
{
    private $arrayFileModifier;
    private $uploaderFactory;
    private $uploadDir;
    private $allowExtensions;

    public function __construct(
        \Mrmodule\ImageDynamicConfig\Model\ArrayFileModifier $arrayFileModifier,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        string $uploadDir,
        array $allowExtensions
    ) {
        $this->arrayFileModifier = $arrayFileModifier;
        $this->uploaderFactory = $uploaderFactory;
        $this->uploadDir = $uploadDir;
        $this->allowExtensions = $allowExtensions;
    }

    public function upload(): array
    {
        $result = [];
        $files = $this->arrayFileModifier->modify();
        if (!$files) {
            return $result;
        }

        foreach ($files as $id => $file) {
            try {
                $uploader = $this->uploaderFactory->create(['fileId' => $id]);
                $uploader->setAllowedExtensions($this->allowExtensions);
                $uploader->setAllowRenameFiles(true);
                $uploader->addValidateCallback('size', $this, 'validateMaxSize');
                $newFileName = $this->getNewFileName($uploader);
                $uploader->save($this->uploadDir, $newFileName);
                $result[$id] = $this->getFullFilPath($newFileName);
            } catch (\Exception $e) {
                throw new \Magento\Framework\Exception\LocalizedException(__('%1', $e->getMessage()));
            }
        }
        return $result;
    }

    private function getNewFileName(Uploader $uploader): string
    {
        return sprintf(
            '%s.%s',
            uniqid(),
            $uploader->getFileExtension()
        );
    }

    private function getFullFilPath(string $filename): string
    {
        return sprintf(
            '/%s/%s',
            $this->uploadDir,
            $filename
        );
    }
}