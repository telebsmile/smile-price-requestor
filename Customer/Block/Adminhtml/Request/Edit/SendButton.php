<?php
/**
 * Smile Customer SendButton
 *
 * @category  Smile
 * @package   Smile\Customer
 * @author    Tetiana Lebed <teleb@smile.fr>
 * @copyright 2019 Smile
 */
namespace Smile\Customer\Block\Adminhtml\Request\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SendButton
 *
 * @package Smile\Customer\Block\Adminhtml\Request\Edit
 */
class SendButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Get button data
     *
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getRequestId()) {
            $data = [
                'label' => __('Send Answer'),
                'class' => 'delete',
                'on_click' => sprintf("location.href = '%s';", $this->getSendAnswerUrl()),
                'sort_order' => 50,
            ];
        }
        return $data;
    }

    /**
     * Get URL FOR send email button
     *
     * @return string
     */
    public function getSendAnswerUrl()
    {
        return $this->getUrl('*/*/send', ['id' => $this->getRequestId()]);
    }
}
