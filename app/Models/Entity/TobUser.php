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
 * 用户表

 * @Entity()
 * @Table(name="tob_user")
 * @uses      TobUser
 */
class TobUser extends Model
{
    /**
     * @var int $id 
     * @Id()
     * @Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string $userName 姓名
     * @Column(name="user_name", type="string", length=20)
     * @Required()
     */
    private $userName;

    /**
     * @var string $userPassword 密码
     * @Column(name="user_password", type="string", length=25, default="123456")
     */
    private $userPassword;

    /**
     * @var string $userPhone 手机号
     * @Column(name="user_phone", type="string", length=50)
     * @Required()
     */
    private $userPhone;

    /**
     * @var string $userEmail 邮箱
     * @Column(name="user_email", type="string", length=30)
     */
    private $userEmail;

    /**
     * @var int $userDeparId 部门Id
     * @Column(name="user_depar_id", type="integer")
     * @Required()
     */
    private $userDeparId;

    /**
     * @var int $userGroupId 分组Id
     * @Column(name="user_group_id", type="integer")
     */
    private $userGroupId;

    /**
     * @var int $userRoleId 角色Id
     * @Column(name="user_role_id", type="integer")
     */
    private $userRoleId;

    /**
     * @var string $createdAt 创建时间
     * @Column(name="created_at", type="timestamp", default="CURRENT_TIMESTAMP")
     */
    private $createdAt;

    /**
     * @var string $updatedAt 修改时间
     * @Column(name="updated_at", type="timestamp", default="CURRENT_TIMESTAMP")
     */
    private $updatedAt;

    /**
     * @var string $deletedAt 删除时间
     * @Column(name="deleted_at", type="timestamp")
     */
    private $deletedAt;

    /**
     * @var string $operatorName 操作人
     * @Column(name="operator_name", type="string", length=30)
     */
    private $operatorName;

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
     * 姓名
     * @param string $value
     * @return $this
     */
    public function setUserName(string $value): self
    {
        $this->userName = $value;

        return $this;
    }

    /**
     * 密码
     * @param string $value
     * @return $this
     */
    public function setUserPassword(string $value): self
    {
        $this->userPassword = $value;

        return $this;
    }

    /**
     * 手机号
     * @param string $value
     * @return $this
     */
    public function setUserPhone(string $value): self
    {
        $this->userPhone = $value;

        return $this;
    }

    /**
     * 邮箱
     * @param string $value
     * @return $this
     */
    public function setUserEmail(string $value): self
    {
        $this->userEmail = $value;

        return $this;
    }

    /**
     * 部门Id
     * @param int $value
     * @return $this
     */
    public function setUserDeparId(int $value): self
    {
        $this->userDeparId = $value;

        return $this;
    }

    /**
     * 分组Id
     * @param int $value
     * @return $this
     */
    public function setUserGroupId(int $value): self
    {
        $this->userGroupId = $value;

        return $this;
    }

    /**
     * 角色Id
     * @param int $value
     * @return $this
     */
    public function setUserRoleId(int $value): self
    {
        $this->userRoleId = $value;

        return $this;
    }

    /**
     * 创建时间
     * @param string $value
     * @return $this
     */
    public function setCreatedAt(string $value): self
    {
        $this->createdAt = $value;

        return $this;
    }

    /**
     * 修改时间
     * @param string $value
     * @return $this
     */
    public function setUpdatedAt(string $value): self
    {
        $this->updatedAt = $value;

        return $this;
    }

    /**
     * 删除时间
     * @param string $value
     * @return $this
     */
    public function setDeletedAt(string $value): self
    {
        $this->deletedAt = $value;

        return $this;
    }

    /**
     * 操作人
     * @param string $value
     * @return $this
     */
    public function setOperatorName(string $value): self
    {
        $this->operatorName = $value;

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
     * 姓名
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * 密码
     * @return mixed
     */
    public function getUserPassword()
    {
        return $this->userPassword;
    }

    /**
     * 手机号
     * @return string
     */
    public function getUserPhone()
    {
        return $this->userPhone;
    }

    /**
     * 邮箱
     * @return string
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * 部门Id
     * @return int
     */
    public function getUserDeparId()
    {
        return $this->userDeparId;
    }

    /**
     * 分组Id
     * @return int
     */
    public function getUserGroupId()
    {
        return $this->userGroupId;
    }

    /**
     * 角色Id
     * @return int
     */
    public function getUserRoleId()
    {
        return $this->userRoleId;
    }

    /**
     * 创建时间
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * 修改时间
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * 删除时间
     * @return string
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * 操作人
     * @return string
     */
    public function getOperatorName()
    {
        return $this->operatorName;
    }

}
