<?php
//src/SD/AppserverloginBundle/User
namespace User;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;

   
    /**
     * User constructor.
     * @param $id
     */
    public function __construct()
    {
        echo("Customer constructor");
        $this->id = $this->id ? $this->id : uniqid();
        parent::__construct();
    }
    
    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

}