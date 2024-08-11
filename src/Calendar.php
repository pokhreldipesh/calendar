<?php

namespace Dipesh\Calendar;

use Exception;

/**
 * Class Calendar
 *
 * The Calendar class provides functionality to manage and manipulate a Nepali calendar.
 * It allows setting and retrieving events for specific dates, navigating through months and years,
 * and initializing the calendar with a specified date.
 */
class Calendar
{
    /**
     * The current date instance.
     *
     * @var Date
     */
    public Date $current;

    /**
     * The year of the current date.
     *
     * @var int
     */
    public int $year;

    /**
     * The month of the current date.
     *
     * @var int
     */
    public int $month;

    /**
     * The day of the current date.
     *
     * @var int
     */
    public int $day;

    /**
     * The total number of days in the current month.
     *
     * @var int
     */
    public int $monthDay;

    /**
     * An array containing day numbers as keys and their corresponding Date objects as values.
     *
     * @var array
     */
    public array $days;

    /**
     * Calendar constructor.
     * Initializes a new Calendar instance with the specified date or defaults to the current date.
     *
     * @param mixed|null $date The date to initialize the calendar. If null, the current date is used.
     * @throws Exception Thrown if the provided date is invalid or cannot be processed.
     */
    public function __construct(mixed $date = null)
    {
        $this->setUp($date);
    }

    /**
     * Configures the calendar based on the provided date.
     * Sets the current date and calculates the number of days in the current month.
     *
     * @param mixed $date The date to set up the calendar.
     * @return void
     * @throws Exception Thrown if the provided date is invalid or cannot be processed.
     */
    protected function setUp(mixed $date): void
    {
        $this->current = (new Date($date))->setLang("np");
        $this->year = $this->current->year;
        $this->month = $this->current->month;
        $this->day = $this->current->day;

        $this->monthDay = $this->current::$bs[$this->current->year][$this->current->month - 1];

        $this->setDaysInMonth();
    }

    /**
     * Updates the current date of the calendar and refreshes the days accordingly.
     *
     * @param mixed $date The new date to set as the current date.
     * @return static Returns the current Calendar instance for method chaining.
     * @throws Exception Thrown if the provided date is invalid or cannot be processed.
     */
    public function setCurrent(mixed $date): static
    {
        $this->setUp($date);
        return $this;
    }

    /**
     * Initializes the days of the current month in the calendar.
     * Populates the $days array with Date objects representing each day in the month.
     *
     * @return void
     * @throws Exception Thrown if the current date cannot be processed.
     */
    public function setDaysInMonth(): void
    {
        for ($i = 1; $i <= $this->monthDay; $i++) {
            $this->days[$i] = $this->current->create(sprintf("%d/%d/%d", $this->year, $this->month, $i));
        }
    }

    /**
     * Sets an event for a specific date in the calendar.
     *
     * @param string|int $date The date for which to set the event, either as a day number (1-31) or a date string.
     * @param array|string $event The details of the event to associate with the specified date.
     * @return void
     * @throws Exception Thrown if the date is invalid or if the event cannot be set.
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
     * Sets multiple events for the calendar using a callable function or an associative array.
     * This allows for dynamic event setting, such as fetching events from a database.
     *
     * @param callable|array $events The events to set, either as a callable function or an associative array.
     * @return static Returns the current Calendar instance for method chaining.
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

    /**
     * Moves the calendar to the next month, updating the current date and the days accordingly.
     *
     * @return static Returns the current Calendar instance for method chaining.
     * @throws Exception Thrown if the new date cannot be processed.
     */
    public function nextMonth(): static
    {
        $this->setUp($this->current->make($this->year.'/'.$this->month."/1")->addDays($this->monthDay));
        return $this;
    }

    /**
     * Moves the calendar to the previous month, updating the current date and the days accordingly.
     *
     * @return static Returns the current Calendar instance for method chaining.
     * @throws Exception Thrown if the new date cannot be processed.
     */
    public function prevMonth(): static
    {
        $this->setUp($this->current->make($this->year.'/'.$this->month."/1")->subDays($this->monthDay));
        return $this;
    }

    /**
     * Advances the calendar to the next year, resetting the current date to January 1st of the following year.
     *
     * @return static Returns the current Calendar instance for method chaining.
     * @throws Exception Thrown if the new date cannot be processed.
     */
    public function nextYear(): static
    {
        $this->setUp(sprintf("%d/1/1", $this->year + 1));
        return $this;
    }

    /**
     * Rewinds the calendar to the previous year, resetting the current date to January 1st of the previous year.
     *
     * @return static Returns the current Calendar instance for method chaining.
     * @throws Exception Thrown if the new date cannot be processed.
     */
    public function prevYear(): static
    {
        $this->setUp(sprintf("%d/1/1", $this->year - 1));
        return $this;
    }
}
