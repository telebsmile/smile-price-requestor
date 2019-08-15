<?php
/**
 * Smile Customer Edit Request
 *
 * @category  Smile
 * @package   Smile\Customer
 * @author    Tetiana Lebed <teleb@smile.fr>
 * @copyright 2019 Smile
 */
namespace Smile\Customer\Controller\Adminhtml\Request;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Smile\Customer\Api\RequestRepositoryInterface;

/**
 * Class Edit
 *
 * @package Smile\Customer\Controller\Adminhtml\Request
 */
class Edit extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Smile_Customer::price_request_save';

    /**
     * Core registry
     *
     * @var Registry
     */
    private $coreRegistry;

    /**
     * Page factory
     *
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * Request repository interface
     *
     * @var RequestRepositoryInterface
     */
    private $requestRepository;

    /**
     * Edit constructor
     *
     * @param Action\Context             $context
     * @param PageFactory                $resultPageFactory
     * @param Registry                   $registry
     * @param RequestRepositoryInterface $requestRepository
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        RequestRepositoryInterface $requestRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $registry;
        $this->requestRepository = $requestRepository;
        parent::__construct($context);
    }

    /**
     * Edit Post page
     *
     * @return \Magento\Backend\Model\View\Result\Page | \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $id = $this->getRequest()->getParam('id');
        $resultPage->getConfig()->getTitle()->prepend(__('Price Request Information'));

        try {
            $model = $this->requestRepository->getById($id);
            $resultPage->getConfig()->getTitle()->prepend(__('Edit Price Request from user %1', $model->getName()));

        } catch (NoSuchEntityException $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while editing the price request.'));
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();

            return $resultRedirect->setPath('*/*/');
        }
        $this->coreRegistry->register('lebed_price_request', $model);

        $resultPage->addBreadcrumb(__('Edit Price Request'), __('Edit Price Request'));

        return $resultPage;
    }
}
