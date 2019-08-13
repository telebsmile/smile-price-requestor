<?php
/**
 *  Smile PriceRequestor InstallSchema
 *
 * @category  Smile
 * @package   Smile\PriceRequestor
 * @author    Tetiana Lebed <teleb@smile.fr>
 * @copyright 2019 Smile
 */
namespace Smile\PriceRequestor\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * Class InstallSchema
 *
 * @package Smile\PriceRequestor\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * Constant price requests table name
     */
    const LEBED_PRICE_REQUESTS = 'lebed_price_requests';

    /**
     * Install table lebed_price_requests
     *
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $table = $setup->getConnection()->newTable(
            $setup->getTable(self::LEBED_PRICE_REQUESTS)
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ],
            'Request id'
        )->addColumn(
            'product_sku',
            Table::TYPE_TEXT,
            255,
            [],
            'Product SKU'
        )->addColumn(
            'name',
            Table::TYPE_TEXT,
            255,
            [],
            'User name'
        )->addColumn(
            'email',
            Table::TYPE_TEXT,
            255,
            [],
            'User e-mail'
        )->addColumn(
            'comment',
            Table::TYPE_TEXT,
            '64k',
            [],
            'Comment'
        )->addColumn(
            'answer',
            Table::TYPE_TEXT,
            '64k',
            [],
            'Request Answer'
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            [
                'nullable' => false,
                'default' => Table::TIMESTAMP_INIT
            ],
            'Request created at'
        )->addColumn(
            'status',
            Table::TYPE_TEXT,
            32,
            [
                'nullable' => false,
                'default' => 'new'
            ],
            'Request Status'
        )->setComment(
            'Price Requests Table'
        );

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}
