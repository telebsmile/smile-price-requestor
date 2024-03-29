<?php
/**
 * Smile Customer request actions
 *
 * @category  Smile
 * @package   Smile\Customer
 * @author    Tetiana Lebed <teleb@smile.fr>
 * @copyright 2019 Smile
 */
namespace Smile\Customer\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Smile\Customer\Model\Request;

/**
 * Class RequestActions
 *
 * @package Smile\Customer\Ui\Component\Listing\Colum\RequestActions
 */
class RequestActions extends Column
{
    /**
     * Url path
     */
    const URL_PATH_EDIT = 'smile_price_requestor/request/edit';
    const URL_PATH_SEND = 'smile_price_requestor/request/send';

    /**
     * Url builder
     *
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct(
            $context,
            $uiComponentFactory,
            $components,
            $data
        );
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['id'])) {
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href'  => $this->urlBuilder->getUrl(
                                static::URL_PATH_EDIT,
                                [
                                    'id' => $item['id'],
                                ]
                            ),
                            'label' => __('Edit'),
                        ]
                    ];
                }
                if ($item['answer'] && $item['status'] != Request::STATUS_CLOSED) {
                    $item[$this->getData('name')]['send'] = [
                            'href'  => $this->urlBuilder->getUrl(
                                static::URL_PATH_SEND,
                                [
                                    'id' => $item['id'],
                                ]
                            ),
                            'label' => __('Send'),
                    ];
                }
            }
        }

        return $dataSource;
    }
}
