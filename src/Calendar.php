<?php

namespace Dipesh\Calendar;

use Dipesh\Calendar\Concerns\HasLanguage;
use Dipesh\Calendar\Concerns\HasNavigation;
use Dipesh\Calendar\Concerns\HasEvent;
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
    use HasLanguage, HasNavigation, HasEvent;

    /**
     * The current date instance which will changes on calendar navigation eg: on next, prev etc
     *
     * @var Date
     */
    public Date $current;

    /**
     * Today's date object and this will remains constant on every calendar navigation
     *
     */
    public Date $today;

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
        $this->language = $this->getLanguage();

        $this->setUp($date);

        $this->today = $date
            ? new Date(language: $this->language)
            : $this->current; // This is reference for todays date
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
        $this->current = new Date(date: $date, language: $this->language);
        $this->year = $this->current->year;
        $this->month = $this->current->month;
        $this->day = $this->current->day;

        $this->monthDay =
            $this->current::$bs[$this->current->year][
                $this->current->month - 1
            ];

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
            $this->days[$i] = $this->current->create(
                sprintf("%d/%d/%d", $this->year, $this->month, $i)
            );
        }
    }

    /**
     * Get calendar days of current month. returns date object of each day in array and if you need furhter modification you can use callback function.
     *
     * @return array
     * @param callable(): array $callback
     */
    public function getDays(callable $callback = null): array
    {
        if (is_callable($callback)) {
            return $callback($this->days);
        }

        return $this->days;
    }

    /**
     * Get formatted current date
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->current->date;
    }
}
