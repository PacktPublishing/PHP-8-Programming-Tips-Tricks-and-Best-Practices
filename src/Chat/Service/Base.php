<?php
declare(strict_types=1);
namespace Chat\Service;

#[Chat\Service\Base]
class Base
{
    public $pdo = NULL;
    #[description("Sets the PDO instance")]
    public function __construct()
    {
        $this->pdo = Connection::getInstance();
    }
}
