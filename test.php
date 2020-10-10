<?php
// core_cool_attr_new.php
namespace Application\Entity;
use Doctrine\ORM\Mapping as ORM;
#[ORM\UniqueConstraint(
    name : "users_user_key", 
    columns : ["userKey"]
)]
#[ORM\Table(
    name : "users", 
    uniqueConstraints : ORM\UniqueConstraint
)]
#[ORM\Entity("Application\Entity\Users")]
class Users
{
	#[int("id")]
	#[ORM\Column(name : "id", type : "integer", nullable : false)]
	#[ORM\Id]
	#[ORM\GeneratedValue(strategy : "IDENTITY")]
    private $id;

	#[string("name"),null("name")]
	#[ORM\Column(name : "name", type : "string", length : 24, nullable : true)]
    private $name;
}
