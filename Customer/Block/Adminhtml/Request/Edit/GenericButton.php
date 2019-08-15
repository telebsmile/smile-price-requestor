<?php
/**
 * Smile Customer request generic button
 *
 * @category  Smile
 * @package   Smile\Customer
 * @author    Tetiana Lebed <teleb@smile.fr>
 * @copyright 2019 Smile
 */
namespace Smile\Customer\Block\Adminhtml\Request\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Smile\Customer\Api\RequestRepositoryInterface;

/**
 * Class GenericButton
 *
 * @package Smile\Customer\Block\Adminhtml\Request\Edit
 */
class GenericButton
{
    /**
     * Context
     *
     * @var Context
     */
    private $context;

    /**
     * Request repository interface
     *
     * @var RequestRepositoryInterface
     */
    private $requestRepository;

    /**
     * GenericButton constructor
     *
     * @param Context                    $context
     * @param RequestRepositoryInterface $requestRepository
     */
    public function __construct(
        Context $context,
        RequestRepositoryInterface $requestRepository
    ) {
        $this->context = $context;
        $this->requestRepository = $requestRepository;
    }

    /**
     * Get Post ID
     *
     * @return int
     */
    public function getRequestId()
    {
        try {
            $modelId = $this->context->getRequest()->getParam('id');

            return $this->requestRepository->getById($modelId)->getId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array  $params
     *
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
