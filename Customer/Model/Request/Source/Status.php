<?php
/**
 * Smile Customer Request Status
 *
 * @category  Smile
 * @package   Smile\Customer
 * @author    Tetiana Lebed <teleb@smile.fr>
 * @copyright 2019 Smile
 */
namespace Smile\Customer\Model\Request\Source;
use Magento\Framework\Data\OptionSourceInterface;
use Smile\Customer\Model\Request;
/**
 * Class Status
 *
 * @package Smile\Customer\Model\Request\Source
 */
class Status implements OptionSourceInterface
{
    /**
     * Request
     *
     * @var Request
     */
    private $request;
    /**
     * Status constructor
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->request->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
