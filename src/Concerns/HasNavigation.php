<?php

namespace Dipesh\Calendar\Concerns;

trait HasNavigation
{
    /**
     * Moves the calendar to the next month, updating the current date and the days accordingly.
     *
     * @return static Returns the current Calendar instance for method chaining.
     * @throws Exception Thrown if the new date cannot be processed.
     */
    public function nextMonth(): static
    {
        $this->setUp(
            $this->current
                ->make($this->year . "/" . $this->month . "/1")
                ->addDays($this->monthDay)
        );
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
        $this->setUp(
            $this->current
                ->make($this->year . "/" . $this->month . "/1")
                ->subDays($this->monthDay)
        );
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
        $this->setUp(sprintf("%d/01/01", $this->year + 1));
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
        $this->setUp(sprintf("%d/01/01", $this->year - 1));
        return $this;
    }
}
