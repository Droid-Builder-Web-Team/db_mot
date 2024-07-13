<?php

/**
 * ICal Controller
 * php version 7.4
 *
 * @category Controller
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\Date;
use Eluceo\iCal\Domain\ValueObject\SingleDay;
use Eluceo\iCal\Presentation\Factory\CalendarFactory;
use Illuminate\Support\Carbon;
use Eluceo\iCal\Domain\ValueObject\Location;
use App\Event as Events;
use App\User;

/**
 * ICal
 *
 * @category Class
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class ICalController extends Controller
{
    /**
     * Get all users registered events and generate an Ical
     *
     * @param string $calId the calendar ID to retrieve
     *
     * @return void
     */
    public function __invoke($calId, $scope = "user")
    {
        $user = User::where('calendar_id', $calId)->first();

        if ($scope == "user") {
            $events = $user->events;
        } elseif ($scope == "all") {
            $events = Events::all();
        }

        $calendar = new Calendar();

        foreach ($events as $event) {

            $date = new Date(Carbon::createFromFormat('Y-m-d', $event->date));
            $occurrence = new SingleDay($date);

            $location = new Location($event->location->name . ", " . $event->location->postcode . ", " . $event->location->country);

            $entry = (new Event())
                ->setSummary($event->name)
                ->setDescription($event->description)
                ->setOccurrence($occurrence)
                ->setLocation($location);

            $calendar->addEvent($entry);
        }


        /*
        define('ICAL_FORMAT', 'Ymd\T\0\0\0\0\0\0\Z');

        $icalObject = "BEGIN:VCALENDAR\r\n";
        $icalObject .= "VERSION:2.0\r\n";
        $icalObject .= "METHOD:PUBLISH\r\n";
        $icalObject .= "PRODID:-//Droid Builders//Events//EN\r\n";

        // loop over events
        foreach ($events as $event) {
            $icalObject .= "BEGIN:VEVENT\r\n";
            $icalObject .= "DTSTART:" .
                date(ICAL_FORMAT, strtotime($event->date)) . "\r\n";
            $icalObject .= "DTEND:" .
                date(ICAL_FORMAT, strtotime($event->date)) . "\r\n";
            $icalObject .= "DTSTAMP:" .
                date(ICAL_FORMAT, strtotime($event->created_at)) . "\r\n";
            $icalObject .= "SUMMARY:" . $event->name . "\r\n";
            $icalObject .= "DESCRIPTION:" .
                addslashes(htmlspecialchars(strip_tags($event->description))) . "\r\n";
            $icalObject .= "UID:" . $event->id . "\r\n";
            $icalObject .= "LAST-MODIFIED:" .
                date(ICAL_FORMAT, strtotime($event->updated_at)) . "\r\n";
            $icalObject .= "LOCATION:" . $event->location->name . "\r\n";
            $icalObject .= "END:VEVENT\r\n";
        }

        // close calendar
        $icalObject .= "END:VCALENDAR\r\n";

        // Set the headers
        header('Content-type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="cal.ics"');

        echo $icalObject;

        */
        $componentFactory = new CalendarFactory();
        $calendarComponent = $componentFactory->createCalendar($calendar);

        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="cal.ics"');

        echo $calendarComponent;


    }

}
