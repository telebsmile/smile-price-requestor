<?php
/**
 * Smile Customer request search results interface
 *
 * @category  Smile
 * @package   Smile\Customer
 * @author    Tetiana Lebed <teleb@smile.fr>
 * @copyright 2019 Smile
 */
namespace Smile\Customer\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface RequestSearchResultsInterface
 *
 * @package Smile\Customer\Api\Data
 */
interface RequestSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get requests list
     *
     * @return \Smile\Customer\Api\Data\RequestInterface[]
     */
    public function getItems();

    /**
     * Set requests list
     *
     * @param \Smile\Customer\Api\Data\RequestInterface[] $items
     *
     * @return RequestSearchResultsInterface
     */
    public function setItems(array $items);
}
