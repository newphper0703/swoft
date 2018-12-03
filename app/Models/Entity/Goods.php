<?php
namespace App\Models\Entity;

use Swoft\Db\Model;
use Swoft\Db\Bean\Annotation\Column;
use Swoft\Db\Bean\Annotation\Entity;
use Swoft\Db\Bean\Annotation\Id;
use Swoft\Db\Bean\Annotation\Required;
use Swoft\Db\Bean\Annotation\Table;
use Swoft\Db\Types;

/**
 * @Entity()
 * @Table(name="goods")
 * @uses      Goods
 */
class Goods extends Model
{
    /**
     * @var int $id 
     * @Id()
     * @Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string $goods 
     * @Column(name="goods", type="string", length=255)
     */
    private $goods;

    /**
     * @var float $sprice 
     * @Column(name="sprice", type="decimal")
     */
    private $sprice;

    /**
     * @var int $num 
     * @Column(name="num", type="integer")
     */
    private $num;

    /**
     * @param int $value
     * @return $this
     */
    public function setId(int $value)
    {
        $this->id = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setGoods(string $value): self
    {
        $this->goods = $value;

        return $this;
    }

    /**
     * @param float $value
     * @return $this
     */
    public function setSprice(float $value): self
    {
        $this->sprice = $value;

        return $this;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setNum(int $value): self
    {
        $this->num = $value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getGoods()
    {
        return $this->goods;
    }

    /**
     * @return float
     */
    public function getSprice()
    {
        return $this->sprice;
    }

    /**
     * @return int
     */
    public function getNum()
    {
        return $this->num;
    }

}
