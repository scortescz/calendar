<?php

namespace Scortes\Calendar\Helpers;

use Scortes\Calendar\Month\Month;
use Scortes\Calendar\Events\EventsIterator;

class CalendarBoundary
{
    /** @var string */
    private $delimiter = '-';
    /** @var \Scortes\Calendar\Events\EventsIterator */
    private $events;

    public function setEvents(EventsIterator $events)
    {
        $this->events = $events;
    }

    public function setEventsDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
    }
    
    public function deleteBoundaryMonthsWithoutEvents(array $months)
    {
        $startIndex = $this->getIndexOfFirstMonth($months);
        $endIndex = $this->getIndexOfLastMonth($months);
        $length = $this->getLength($startIndex, $endIndex);
        return array_slice($months, $startIndex, $length);
    }

    private function getIndexOfFirstMonth($months)
    {
        return $this->getIndexOfFirstMonthWithEvent($months);
    }

    private function getIndexOfLastMonth($months)
    {
        $reversedMonths = array_reverse($months);
        $difference = $this->getIndexOfFirstMonthWithEvent($reversedMonths);
        return count($months) - $difference;
    }

    private function getIndexOfFirstMonthWithEvent($months)
    {
        $firstIndex = 0;
        foreach ($months as $month) {
            if (!$this->existsEventInMonth($month)) {
                $firstIndex++;
            } else {
                break;
            }
        }
        return $firstIndex;
    }

    private function existsEventInMonth(Month $month)
    {
        $date = "{$month->year}{$this->delimiter}{$month->monthNumber}";
        foreach ($this->events->iterate($date) as $event) {
            return true;
        }
        return false;
    }

    private function getLength($startIndex, $endIndex)
    {
        return $startIndex == $endIndex ? 1 : ($endIndex - $startIndex);
    }
}
