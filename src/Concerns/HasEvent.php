<?php

namespace Dipesh\Calendar\Concerns;

trait HasEvent
{
    /**
     * Set an event for a specific date in the calendar.
     *
     * This method allows you to assign an event to a particular date. The date can be provided
     * either as a day number (1-31) or as a date string. The event can be a string or an array
     * containing event details.
     *
     * @param string|int $date The date for which the event should be set, either as a day number (1-31) or a date string.
     * @param array|string $event The event details to associate with the specified date.
     * @return void
     * @throws Exception If the date is invalid or if the event cannot be set.
     */
    public function setEvent(string|int $date, array|string $event): void
    {
        if (is_numeric($date)) {
            $this->days[$date] = $event;
        } else {
            $this->days[$this->current->make($date)->day] = $event;
        }
    }

    /**
     * Set multiple events for the calendar.
     *
     * This method allows for setting multiple events in the calendar, either through a callable function
     * or an associative array. The callable function can dynamically set events, such as fetching
     * them from a database, while the associative array can be used to set events directly.
     *
     * @param callable|array $events The events to set, either as a callable function or an associative array.
     * @return static The current instance for method chaining.
     * @throws Exception If an error occurs while setting the events.
     */
    public function setEvents(callable|array $events): static
    {
        if (is_callable($events)) {
            $events($this, $this->days);
        } else {
            foreach ($events as $key => $event) {
                $this->setEvent($key, $event);
            }
        }

        return $this;
    }
}
