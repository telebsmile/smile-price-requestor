<?php
/**
 * Smile Customer Send
 *
 * @category  Smile
 * @package   Smile\Customer
 * @author    Tetiana Lebed <teleb@smile.fr>
 * @copyright 2019 Smile
 */
namespace Smile\Customer\Controller\Adminhtml\Request;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect as ResultRedirect;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\Store;
use Magento\Framework\Mail\Template\TransportBuilder;
use Smile\Customer\Api\Data\RequestInterface;
use Smile\Customer\Api\RequestRepositoryInterface;
use Smile\Customer\Model\Request;

/**
 * Class Send
 *
 * @package Smile\Customer\Controller\Adminhtml\Request
 */
class Send extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Smile_Customer::price_request_answer';

    /**
     * #@+
     * Config path const
     */
    const SEND_ANSWER_BY_REQUEST_EMAIL_TEMPLATE = 'smile_customer/email_template/send_price_by_request';
    const SEND_ANSWER_BY_REQUEST_SENDER_EMAIL = 'smile_customer/sender_info/sender_email';
    const SEND_ANSWER_BY_REQUEST_SENDER_NAME = 'smile_customer/sender_info/sender_name';
    /**#@-*/

    /**
     * Scope config interface
     *
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Request Repository
     *
     * @var RequestRepositoryInterface
     */
    private $requestRepository;

    /**
     * Transport Builder
     *
     * @var TransportBuilder
     */
    private $transportBuilder;

    /**
     * Product Repository
     *
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * Send constructor.
     *
     * @param Action\Context             $context
     * @param RequestRepositoryInterface $requestRepository
     * @param TransportBuilder           $transportBuilder
     * @param ScopeConfigInterface       $scopeConfig
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        Action\Context $context,
        RequestRepositoryInterface $requestRepository,
        TransportBuilder $transportBuilder,
        ScopeConfigInterface $scopeConfig,
        ProductRepositoryInterface $productRepository
    ) {
        $this->requestRepository = $requestRepository;
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->productRepository = $productRepository;
        parent::__construct($context);
    }

    /**
     * Send Action
     *
     * @return ResultRedirect
     */
    public function execute()
    {
        /** @var ResultRedirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            $id = $this->getRequest()->getParam('id');
            /** @var RequestInterface $priceRequest */
            $priceRequest = $this->requestRepository->getById($id);
        } catch (NoSuchEntityException $error) {
            $this->messageManager->addErrorMessage($error->getMessage());

            return $resultRedirect->setPath('*/*/');
        }

        $answer = $priceRequest->getAnswer();

        if ($answer) {
            try {
                $customerEmail = $priceRequest->getEmail();
                $customerName = $priceRequest->getName();
                $adminEmail = $this->getAdminEmail();
                $adminName = $this->getAdminName();
                $product = $this->productRepository->get($priceRequest->getProductSku());
                $emailData = [
                    'userName'   => $priceRequest->getName(),
                    'answer' => $answer,
                    'productTitle' => $product->getName(),
                    'productPrice' => $product->getFormatedPrice()
                ];

                $transport = $this->transportBuilder
                    ->setTemplateIdentifier($this->getEmailTemplate())
                    ->setTemplateOptions([
                        'area' => Area::AREA_FRONTEND,
                        'store' => Store::DEFAULT_STORE_ID
                    ])->setTemplateVars($emailData)
                    ->setFrom(['name' => $adminName,'email' => $adminEmail])
                    ->addTo($customerEmail, $customerName)
                    ->getTransport();
                $transport->sendMessage();

                $this->messageManager->addSuccessMessage(__('Email has been sent successfully.'));
                $priceRequest->setStatus(Request::STATUS_CLOSED);
                $this->requestRepository->save($priceRequest);

                return $resultRedirect->setPath('*/*/');
            } catch(\Exception $e){
                $this->messageManager->addErrorMessage($e->getMessage());
                $resultRedirect->setUrl($this->_redirect->getRefererUrl());

                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }

        $this->messageManager->addErrorMessage(__('Save answer before send email.'));

        return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
    }

    /**
     * Get Email Template
     *
     * @return string
     */
    public function getEmailTemplate()
    {
        return $this->scopeConfig->getValue(static::SEND_ANSWER_BY_REQUEST_EMAIL_TEMPLATE);
    }

    /**
     * Get Admin Email
     *
     * @return string
     */
    public function getAdminEmail()
    {
        return $this->scopeConfig->getValue(static::SEND_ANSWER_BY_REQUEST_SENDER_EMAIL);
    }

    /**
     * Get Admin Name
     *
     * @return string
     */
    public function getAdminName()
    {
        return $this->scopeConfig->getValue(static::SEND_ANSWER_BY_REQUEST_SENDER_NAME);
    }
}
