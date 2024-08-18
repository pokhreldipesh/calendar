<?php
namespace Dipesh\Calendar;

use Dipesh\NepaliDate\NepaliDate;

/**
 * Class Date
 *
 * This class extends the `NepaliDate` class to include additional functionality for managing events.
 * It allows setting and retrieving events associated with a specific date in the Nepali BS calendar.
 * Events can be stored as a string or an array, providing flexibility in managing multiple events.
 *
 * @property int $weekDay The day of the week for the date.
 */
class Date extends NepaliDate
{
    /**
     * @var string|array $event The event(s) associated with the date.
     */
    public string|array $event;

    /**
     * Sets the event or events for the date.
     *
     * This method allows you to assign an event or multiple events to a specific date. The event can
     * be provided as a string for a single event or an array for multiple events.
     *
     * @param string|array $event The event(s) to associate with the date.
     * @return static             Returns the current instance for method chaining.
     */
    public function setEvent(string|array $event): static
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Retrieves the event or events associated with the date.
     *
     * This method returns the event(s) assigned to the date. The return value can be either a string
     * for a single event or an array for multiple events.
     *
     * @return string|array The event(s) associated with the date.
     */
    public function getEvent(): string|array
    {
        return $this->event;
    }
}
