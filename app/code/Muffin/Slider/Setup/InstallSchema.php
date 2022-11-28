<?php

namespace Muffin\Slider\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Zend_Db_Exception;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Function install
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @throws Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('muffin_bannerslider_banner')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('muffin_bannerslider_banner'))
                ->addColumn(
                    'banner_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true,
                        'unsigned' => true
                    ],
                    'Banner ID'
                )
                ->addColumn('name', Table::TYPE_TEXT, 255, ['nullable => false'], 'Banner Name')
                ->addColumn('status', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => '1'], 'Status')
                ->addColumn('image', Table::TYPE_TEXT, 255, [], 'Banner Image')
                ->addColumn('url_banner', Table::TYPE_TEXT, 255, [], 'Banner Url')
                ->addColumn('created_at', Table::TYPE_TIMESTAMP, null, [], 'Banner Created At')
                ->addColumn('updated_at', Table::TYPE_TIMESTAMP, null, [], 'Banner Updated At')
                ->setComment('Banner Table');
            $installer->getConnection()->createTable($table);
            $installer->getConnection()->addIndex(
                $installer->getTable('muffin_bannerslider_banner'),
                $setup->getIdxName(
                    $installer->getTable('muffin_bannerslider_banner'),
                    ['name', 'image', 'url_banner'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['name', 'image', 'url_banner'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }
        if (!$installer->tableExists('muffin_bannerslider_slider')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('muffin_bannerslider_slider'))
                ->addColumn(
                    'slider_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true,
                        'unsigned' => true
                    ],
                    'Slider ID'
                )
                ->addColumn('name', Table::TYPE_TEXT, 255, ['nullable' => false], 'Slider Name')
                ->addColumn('status', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => '1'], 'Status')
                ->addColumn('location', Table::TYPE_TEXT, 1000, [], 'Location')
                ->addColumn('design', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => '0'], 'Design')
                ->addColumn('loop', Table::TYPE_SMALLINT, null, [], 'Loop slider')
                ->addColumn('autoplay', Table::TYPE_SMALLINT, null, [], 'Autoplay')
                ->addColumn('autoplaySpeed', Table::TYPE_TEXT, 255, ['default' => '3000'], 'autoplay speed in milliseconds')
                ->addColumn('pauseOnHover', Table::TYPE_SMALLINT, null, [], 'Pause on hover')
                ->addColumn('responsive', Table::TYPE_SMALLINT, null, [], 'Responsive')
                ->addColumn('responsive_items', Table::TYPE_TEXT, 255, [], 'Max Items Slider')
                ->addColumn('created_at', Table::TYPE_TIMESTAMP, null, [], 'Slider Created At')
                ->addColumn('updated_at', Table::TYPE_TIMESTAMP, null, [], 'Slider Updated At')
                ->setComment('Slider Table');
            $installer->getConnection()->createTable($table);
        }
        if (!$installer->tableExists('muffin_bannerslider_banner_slider')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('muffin_bannerslider_banner_slider'))
                ->addColumn(
                    'slider_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => false, 'primary' => true],
                    'Slider ID'
                )
                ->addColumn(
                    'banner_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => false, 'primary' => true],
                    'Banner ID'
                )
                ->addColumn('position', Table::TYPE_INTEGER, null, ['nullable' => false, 'default' => '0'], 'Position')
                ->addForeignKey(
                    $installer->getFkName(
                        'muffin_bannerslider_banner_slider',
                        'slider_id',
                        'muffin_bannerslider_slider',
                        'slider_id'
                    ),
                    'slider_id',
                    $installer->getTable('muffin_bannerslider_slider'),
                    'slider_id',
                    Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'muffin_bannerslider_banner_slider',
                        'banner_id',
                        'muffin_bannerslider_banner',
                        'banner_id'
                    ),
                    'banner_id',
                    $installer->getTable('muffin_bannerslider_banner'),
                    'banner_id',
                    Table::ACTION_CASCADE
                )
                ->addIndex(
                    $installer->getIdxName(
                        'muffin_bannerslider_banner_slider',
                        [
                            'slider_id',
                            'banner_id'
                        ],
                        AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    [
                        'slider_id',
                        'banner_id'
                    ],
                    [
                        'type' => AdapterInterface::INDEX_TYPE_UNIQUE
                    ]
                )
                ->setComment('Slider To Banner Link Table');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}
