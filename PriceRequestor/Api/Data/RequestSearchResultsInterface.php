<?php
/**
 * Smile PriceRequestor request search results interface
 *
 * @category  Smile
 * @package   Smile\PriceRequestor
 * @author    Tetiana Lebed <teleb@smile.fr>
 * @copyright 2019 Smile
 */
namespace Smile\PriceRequestor\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface RequestSearchResultsInterface
 *
 * @package Smile\PriceRequestor\Api\Data
 */
interface RequestSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get request list
     *
     * @return \Smile\PriceRequestor\Api\Data\RequestInterface[]
     */
    public function getItems();

    /**
     * Set request list
     *
     * @param \Smile\PriceRequestor\Api\Data\RequestInterface[] $items
     *
     * @return RequestSearchResultsInterface
     */
    public function setItems(array $items);
}
