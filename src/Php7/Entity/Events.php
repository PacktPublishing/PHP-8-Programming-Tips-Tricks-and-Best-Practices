<?php
namespace Php7\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Events
 *
 * @ORM\Table(name="events")
 * @ORM\Entity("Application\Entity\Events")
 */
class Events
{
    const DATE_FORMAT = 'l, d M Y';
    const TIME_FORMAT = 'H:i:s';
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="event_key", type="string", length=16, nullable=true, options={"fixed"=true})
     */
    private $eventKey;

    /**
     * @var string|null
     *
     * @ORM\Column(name="event_name", type="string", length=128, nullable=true)
     */
    private $eventName;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="event_date", type="datetime", nullable=true)
     */
    private $eventDate;

    /**
     * @var \Hotels
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Hotels")
     */
    private $hotel;

    // getters
    public function getId()        { return $this->id; }
    public function getEventKey()  { return $this->eventKey; }
    public function getEventName() { return $this->eventName; }
    public function getEventDate() { return $this->eventDate->format(self::DATE_FORMAT); }
    public function getEventTime() { return $this->eventDate->format(self::TIME_FORMAT); }
    public function getHotel()     { return $this->hotel; }

    // setters
    public function setEventKey(string $key)
    {
        $this->eventKey = $key;
    }
    public function setEventName(string $name)
    {
        $this->eventName = $name;
    }
    public function setEventDate(DateTime $date)
    {
        $this->eventDate = $date;
    }
    public function setHotel(Hotels $hotel)
    {
        $this->hotel = $hotel;
    }
    // output
    public function display()
    {
        $output = '';
        $output .= "ID: \t"    . $this->getId()        . PHP_EOL;
        $output .= "Key: \t"   . $this->getEventKey()  . PHP_EOL;
        $output .= "Name: \t"  . $this->getEventName() . PHP_EOL;
        $output .= "Date: \t"  . $this->getEventDate() . PHP_EOL;
        $output .= "Time: \t"  . $this->getEventTime() . PHP_EOL;
        $output .= "Hotel: \t" . $this->getHotel()->getHotelName() . PHP_EOL;
        return $output;
    }
}
