<?php
/**
 * Smile PriceRequestor request interface
 *
 * @category  Smile
 * @package   Smile\PriceRequestor
 * @author    Tetiana Lebed <teleb@smile.fr>
 * @copyright 2019 Smile
 */
namespace Smile\PriceRequestor\Api\Data;

/**
 * Interface Request
 *
 * @package Smile\PriceRequestor\Api\Data
 */
interface RequestInterface
{
    /**
     * Table name
     */
    const TABLE_NAME = 'lebed_price_requests';

    /**#@+
     * Constants defined for keys of data array.
     */
    const ID          = 'id';
    const PRODUCT_SKU = 'product_sku';
    const NAME        = 'name';
    const EMAIL       = 'email';
    const COMMENT     = 'comment';
    const ANSWER      = 'answer';
    const CREATED_AT  = 'created_at';
    const STATUS      = 'status';
    /**#@-*/

    /**
     * Get ID
     *
     * @return int
     */
    public function getId();

    /**
     * Get product Sku
     *
     * @return string
     */
    public function getProductSku();

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Get e-mail
     *
     * @return string
     */
    public function getEmail();

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment();

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer();

    /**
     * Get creation time
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * Get request status
     *
     * @return string
     */
    public function getStatus();

    /**
     * Set ID
     *
     * @param int $id
     *
     * @return RequestInterface
     */
    public function setId($id);

    /**
     * Set product SKU
     *
     * @param string $productSku
     *
     * @return RequestInterface
     */
    public function setProductSku($productSku);

    /**
     * Set name
     *
     * @param string $name
     *
     * @return RequestInterface
     */
    public function setName($name);

    /**
     * Set e-mail
     *
     * @param string $email
     *
     * @return RequestInterface
     */
    public function setEmail($email);

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return RequestInterface
     */
    public function setComment($comment);

    /**
     * Set answer
     *
     * @param string $answer
     *
     * @return RequestInterface
     */
    public function setAnswer($answer);

    /**
     * Set creation time
     *
     * @param string $creationTime
     *
     * @return RequestInterface
     */
    public function setCreatedAt($creationTime);

    /**
     * Set request status
     *
     * @param string $status
     *
     * @return RequestInterface
     */
    public function setStatus($status);
}
