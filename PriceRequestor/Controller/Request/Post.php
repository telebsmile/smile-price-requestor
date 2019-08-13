<?php
/**
 * Lebed Blog Post
 *
 * @category  Lebed
 * @package   Lebed\PriceRequestor
 * @author    Tetiana Lebed <teleb@smile.fr>
 * @copyright 2019 Smile
 */
namespace Smile\PriceRequestor\Controller\Request;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\View\LayoutInterface as Layout;
use Smile\PriceRequestor\Model\RequestFactory;
use Smile\PriceRequestor\Model\RequestRepository;

/**
 * Class Post
 *
 * @package Smile\PriceRequestor\Controller\Request
 */
class Post extends Action
{
    /**
     * Product Repository
     *
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * Request Factory
     *
     * @var \Smile\PriceRequestor\Model\RequestFactory
     */
    protected $requestFactory;

    /**
     * Request Repository
     *
     * @var \Smile\PriceRequestor\Model\RequestRepository
     */
    protected $requestRepository;

    /**
     * Layout Interface
     *
     * @var \Magento\Framework\View\LayoutInterface
     */
    protected $layout;

    /**
     * Post constructor.
     *
     * @param Context                    $context
     * @param ProductRepositoryInterface $productRepository
     * @param RequestFactory             $requestFactory
     * @param RequestRepository          $requestRepository
     * @param Layout                     $layout
     */
    public function __construct(
        Context                    $context,
        ProductRepositoryInterface $productRepository,
        RequestFactory             $requestFactory,
        RequestRepository          $requestRepository,
        Layout                     $layout
    ) {
        $this->productRepository = $productRepository;
        $this->requestFactory = $requestFactory;
        $this->requestRepository = $requestRepository;
        $this->layout = $layout;
        parent::__construct($context);
    }

    /**
     * Post action
     *
     * @return \Magento\Framework\Controller\Result\Raw
     */
    public function execute()
    {
        /** @var Template $message */
        $message = $this->layout->createBlock(Template::class)
                                ->setTemplate('Smile_PriceRequestor::response_popup.phtml');

        $postData = $this->getRequest()->getPostValue();
        $message->setIsSuccess(false);
        $message->setResponseText(__('Something went wrong. Your request has not been sent.'));

        if (!empty($postData) && isset($postData['product_sku'])) {
            $product = $this->getProductBySku($postData['product_sku']);

            if ($product) {
                $priceRequest = $this->requestFactory->create();
                $priceRequest->setData($postData);

                try {
                    $this->requestRepository->save($priceRequest);
                    $message->setResponseText(__('Your request for "%1" price has been sent', $product->getName()));
                    $message->setIsSuccess(true);
                } catch (CouldNotSaveException $e) {
                    $message->setResponseText(__('We can\'t send your price request right now.'));
                }
            }
        }

        /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
        $resultRaw = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        return $resultRaw->setContents($message->toHtml());
    }

    /**
     * Get product by SKU
     *
     * @param $productSku
     *
     * @return bool|\Magento\Catalog\Api\Data\ProductInterface
     */
    public function getProductBySku($productSku)
    {
        try {
            $product = $this->productRepository->get($productSku);
        } catch (NoSuchEntityException $e) {
            return false;
        }

        return $product;
    }
}
