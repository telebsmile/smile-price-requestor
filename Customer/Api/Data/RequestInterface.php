<?php
/**
 * Smile Customer Request Interface
 *
 * @category  Smile
 * @package   Smile\Customer
 * @author    Tetiana Lebed <teleb@smile.fr>
 * @copyright 2019 Smile
 */
namespace Smile\Customer\Api\Data;

/**
 * Interface RequestInterface
 *
 * @package Smile\Customer\Api\Data
 */
interface RequestInterface
{
    /**
     * Table name
     */
    const TABLE_NAME = 'lebed_price_request';

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
     * Get product sku
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
     * Get email
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
     * Get status
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
     * Set product sku
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
     * Set email
     *
     * @param string $email
     *
     * @return RequestInterface
     */
    public function setEmail($email);

    /**
     * Set request comment
     *
     * @param string $comment
     *
     * @return RequestInterface
     */
    public function setComment($comment);

    /**
     * Set request answer
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
