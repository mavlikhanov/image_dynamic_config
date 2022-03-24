<?php
declare(strict_types=1);

namespace Mr\ImageDynamicConfig\Model;

class ArrayFileModifier
{
    private $request;
    private $requestName;

    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        string $requestName = 'groups'
    ) {
        $this->request = $request;
        $this->requestName = $requestName;
    }

    public function modify(): array
    {
        $requestFiles = $this->parseRequest();
        $files = [];
        foreach ($requestFiles as $id => $file) {
            $data = array_shift($file);
            if (!$data['tmp_name']) {
                continue;
            }
            $files[$id] = $data;
        }
        $_FILES = $files;
        return $files;
    }

    private function parseRequest(): array
    {
        $requestFiles = $this->request->getFiles($this->requestName);
        if (isset($requestFiles['value'])) {
            return $requestFiles['value'];
        }
        if (is_array($requestFiles)) {
            $requestFiles = array_shift($requestFiles);
            return $this->parseRequest($requestFiles);
        }
        return $requestFiles;
    }
}