<?php
/**
 * Smile Customer request repository interface
 *
 * @category  Smile
 * @package   Smile\Customer
 * @author    Tetiana Lebed <teleb@smile.fr>
 * @copyright 2019 Smile
 */
namespace Smile\Customer\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Smile\Customer\Api\Data\RequestInterface;

/**
 * Interface RequestRepositoryInterface
 *
 * @package Smile\Customer\Api
 */
interface RequestRepositoryInterface
{
    /**
     * Retrieve a request by it's id
     *
     * @param int $objectId
     *
     * @return RequestRepositoryInterface
     */
    public function getById($objectId);

    /**
     * Retrieve request which match a specified criteria.
     *
     * @param SearchCriteriaInterface|null $searchCriteria
     *
     * @return \Magento\Framework\Api\SearchResults
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null);

    /**
     * Save request
     *
     * @param RequestInterface $object
     *
     * @return RequestRepositoryInterface
     */
    public function save(RequestInterface $object);

    /**
     * Delete a request by its id
     *
     * @param int $objectId
     *
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($objectId);
}
