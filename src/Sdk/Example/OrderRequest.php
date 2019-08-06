<?php
/**                                                             ";
 * date: 2019/8/6
 * author: four-li
 */

namespace FourLi\Tools\Sdk\Example;


use FourLi\Tools\Sdk\ClientInterface;

class OrderRequest implements ClientInterface
{
    private $id;

    /**
     * @param mixed $id
     * @return OrderRequest
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    public function check()
    {
        // TODO: Implement check() method.
        if (true) {

        } else {
            throw new \Exception('参数错误');
        }
        return true;
    }

    public function getApiParameters()
    {
        return [
            'id' => $this->id
        ];
    }

    public function getMethod()
    {
        return 'post';
    }

    public function getRoute()
    {
        return 'api-rest/applet/order.create';
    }

}
