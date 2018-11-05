<?php

namespace Sengera\DreiNullEins\Controller;

use Magento\Framework\App\Action\Context as Context;
use Magento\Framework\View\Result\PageFactory as PageFactory;
use Magento\Store\Model\StoreManagerInterface as StoreManagerInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

class NoRoute extends \Magento\Framework\App\Action\Action
{
    protected $resultPageFactory;
    protected $storeManager;
    protected $productRepository;

    /**
     * NoRoute constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        StoreManagerInterface $storeManager,
        ProductRepositoryInterface $productRepository)
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $rewrites = $this->_importCSV2Array('var/urlsDreiNullEins.csv', NULL, ';', "'");

        foreach ($rewrites as $rewrite) {
            $requestedUrl = strtolower($this->storeManager->getStore()->getCurrentUrl());

            if(substr($requestedUrl, 0, strpos($requestedUrl, '?')) == strtolower($rewrite['url'])) {
                header("HTTP/1.1 301 Moved Permanently");
                header('Location: '. $rewrite['new_url']); exit;
            }
        }

        return $this->_redirectNormal();
    }

    private function _redirectNormal() {
        $resultLayout = $this->resultPageFactory->create();
        $resultLayout->setStatusHeader(404, '1.1', 'Not Found');
        $resultLayout->setHeader('Status', '404 File not found');
        return $resultLayout;
    }

    /*
    * Import a CSV file into a php array
    */
    private function _importCSV2Array($filename, $k_delimiter = NULL, $delimiter = ';', $enclosure = '"') {
        $row = 0;
        $col = 0;

        $results = array();

        $handle = @fopen($filename, "r");
        if ($handle) {
            while (($row = fgetcsv($handle, 4096, $delimiter, $enclosure)) !== false) {
                if (empty($fields)) {
                    $fields = $row;
                    continue;
                }

                foreach ($row as $k => $value) {
                    if($k_delimiter != NULL && $k >= $k_delimiter) {
                        break;
                    }

                    $results[$col][$fields[$k]] = $value;
                }

                $col++;
                unset($row);
            }

            if (!feof($handle)) {
                echo "Error: unexpected fgets() failn";
            }

            fclose($handle);
        }

        return $results;
    }
}