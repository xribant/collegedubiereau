<?php
namespace App\Service;

use App\Entity\InfoRegistration;
use Jsvrcek\ICS\Utility\Formatter;
use Jsvrcek\ICS\CalendarExport;
use Jsvrcek\ICS\CalendarStream;
use Jsvrcek\ICS\Model\CalendarEvent;
use Jsvrcek\ICS\Model\Relationship\Attendee;
use Jsvrcek\ICS\Model\Calendar;
use DateTimeZone;
use DateInterval;
use DateTime;

class CalendarFileGenerator {

    private $formatter;
    private $calendarExport;

    public function __construct(Formatter $formatter, CalendarExport $calendarExport) {

        $this->formatter = $formatter;
        $this->calendarExport = $calendarExport;
    }
    
    public function createIcs(InfoRegistration $registration){

        $timeZone = new DateTimeZone('Europe/Brussels');

        $startTime = new \DateTime();
        $startTime->setTimestamp($registration->getInfoSessionDay()->getSessionDate()->getTimestamp());

        $endTime = new DateTime();
        $endTime->setTimestamp($registration->getInfoSessionDay()->getSessionDate()->getTimestamp());
        $endTime->add(new DateInterval('PT2H')); 

        $event = new CalendarEvent();
        $event->setStart($startTime)
            ->setEnd($endTime)
            ->setSummary('Réunion d\'information et d\'inscription au Collège du Biéreau')
            ->setUid(uniqid());
        
        //add an Attendee
        $attendee = new Attendee($this->formatter); // or $formatter

        $attendee->setValue($registration->getEmail())
            ->setName($registration->getFirstName().' '.$registration->getLastName());

        $event->addAttendee($attendee);

        $calendar = new Calendar();
        $calendar->addEvent($event)
            ->setTimezone($timeZone);

        $calendarExport = new CalendarExport(new CalendarStream, new Formatter());
        $calendarExport->addCalendar($calendar);
        
        $file = 'temp/'.uniqid().'.ics';
        file_put_contents($file,$calendarExport->getStream());

        return $file;

    }
    
}