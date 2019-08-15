<?php
/**
 * Controller Customer Request Post
 *
 * @category  Smile
 * @package   Smile\Catalog
 * @author    Tetiana Lebed <teleb@smile.fr>
 * @copyright 2019 Smile
 */
namespace Smile\Catalog\Controller\Request;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\LayoutInterface as Layout;
use Smile\Customer\Model\RequestFactory;
use Smile\Customer\Model\RequestRepository;

/**
 * Class Post
 *
 * @package Smile\Catalog\Controller\Request
 */
class Post extends Action
{
    /**
     * Request Factory
     *
     * @var \Smile\Customer\Model\RequestFactory
     */
    protected $requestFactory;

    /**
     * Request Repository
     *
     * @var \Smile\Customer\Model\RequestRepository
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
     * @param RequestFactory             $requestFactory
     * @param RequestRepository          $requestRepository
     * @param Layout                     $layout
     */
    public function __construct(
        Context                    $context,
        RequestFactory             $requestFactory,
        RequestRepository          $requestRepository,
        Layout                     $layout
    ) {
        $this->requestFactory = $requestFactory;
        $this->requestRepository = $requestRepository;
        $this->layout = $layout;
        parent::__construct($context);
    }

    /**
     * Post action
     *
     * @return \Magento\Framework\Controller\Result\Raw | \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        if ($this->getRequest()->isAjax()) {
            /** @var Template $message */
            $message = $this->layout->createBlock(Template::class)
                                    ->setTemplate('Smile_Catalog::response_popup.phtml');

            $postData = $this->getRequest()->getPostValue();

            $message->setIsSuccess(false);
            $message->setResponseText(__('Something went wrong. Your request has not been sent.'));

            if (!empty($postData) && isset($postData['product_sku'])) {
                $priceRequest = $this->requestFactory->create();
                $priceRequest->setData($postData);

                try {
                    $this->requestRepository->save($priceRequest);
                    $message->setResponseText(__('Your request for product price has been sent'));
                    $message->setIsSuccess(true);
                } catch (CouldNotSaveException $e) {
                    $message->setResponseText(__('We can\'t send your price request right now.'));
                }
            }

            /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
            $resultRaw = $this->resultFactory->create(ResultFactory::TYPE_RAW);

            return $resultRaw->setContents($message->toHtml());
        }

        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath($this->_redirect->getRefererUrl());
    }
}
