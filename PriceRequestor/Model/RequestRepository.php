<?php
/**
 * Smile PriceRequestor Request Repository
 *
 * @category  Smile
 * @package   Smile\PriceRequestor
 * @author    Tetiana Lebed <teleb@smile.fr>
 * @copyright 2019 Smile
 */
namespace Smile\PriceRequestor\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Smile\PriceRequestor\Api\Data;
use Smile\PriceRequestor\Api\RequestRepositoryInterface;
use Smile\PriceRequestor\Model\ResourceModel\Request as ResourceRequest;
use Smile\PriceRequestor\Model\ResourceModel\Request\CollectionFactory as RequestCollectionFactory;

/**
 * Class RequestRepository
 *
 * @package Smile\PriceRequestor\Model
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class RequestRepository implements RequestRepositoryInterface
{
    /**
     * Resource request
     *
     * @var ResourceRequest
     */
    private $resource;

    /**
     * Request factory
     *
     * @var RequestFactory
     */
    private $requestFactory;

    /**
     * Request collection factory
     *
     * @var RequestCollectionFactory
     */
    private $requestCollectionFactory;

    /**
     * Request search results interface factory
     *
     * @var RequestSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * RequestRepository constructor.
     *
     * @param ResourceRequest                           $resource
     * @param RequestFactory                            $requestFactory
     * @param RequestCollectionFactory                  $requestCollectionFactory
     * @param Data\RequestSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        ResourceRequest $resource,
        RequestFactory $requestFactory,
        RequestCollectionFactory $requestCollectionFactory,
        Data\RequestSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->resource = $resource;
        $this->requestFactory = $requestFactory;
        $this->requestCollectionFactory = $requestCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * Save Request Data
     *
     * @param Data\RequestInterface $requst
     *
     * @return Request
     * @throws CouldNotSaveException
     */
    public function save(Data\RequestInterface $request)
    {
        try {
            $this->resource->save($request);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $request;
    }

    /**
     * Load Price Request data by given Request Identity
     *
     * @param int $requestId
     *
     * @return Request
     * @throws NoSuchEntityException
     */
    public function getById($requestId)
    {
        $request = $this->requestFactory->create();
        $this->resource->load($request, $requestId);
        if (!$request->getId()) {
            throw new NoSuchEntityException(__('Price Request with id "%1" does not exist.', $requestId));
        }

        return $request;
    }

    /**
     * Load Price Request data collection by given search criteria
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     *
     * @return \Smile\PriceRequestor\Model\ResourceModel\Request\Collection
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function getList(SearchCriteriaInterface $criteria = null)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->requestCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $request = [];
        /** @var Data\RequestInterface $requestModel */
        foreach ($collection as $requestModel) {
            $request[] = $requestModel;
        }
        $searchResults->setItems($request);

        return $searchResults;
    }

    /**
     * Delete Price Request
     *
     * @param \Smile\PriceRequestor\Api\Data\RequestInterface $request
     *
     * @return bool
     *
     * @throws CouldNotDeleteException
     */
    public function delete(Data\RequestInterface $request)
    {
        try {
            $this->resource->delete($request);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * Delete Price Request by given Request Identity
     *
     * @param int $requestId
     *
     * @return bool
     *
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($requestId)
    {
        return $this->delete($this->getById($requestId));
    }
}
