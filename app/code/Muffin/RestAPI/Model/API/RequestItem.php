<?php
namespace Muffin\RestAPI\Model\API;

use Magento\Framework\DataObject;
use Muffin\RestAPI\API\RequestItemInterface;

/**
 * Class RequestItem
 */
class RequestItem extends DataObject implements RequestItemInterface
{
    public function getId() : int
    {
        return $this->_getData(self::DATA_ID);
    }
    public function getDescription() : string
    {
        return $this->_getData(self::DATA_DESCRIPTION);
    }
    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id) : mixed
    {
        return $this->setData(self::DATA_ID, $id);
    }
    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description) : mixed
    {
        return $this->setData(self::DATA_DESCRIPTION, $description);
    }
}
