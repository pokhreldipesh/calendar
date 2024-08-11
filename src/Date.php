<?php
namespace Dipesh\Calendar;

use Dipesh\NepaliDate\NepaliDate;

class Date extends NepaliDate
{
    public string|array $event;
    
    /**
     * @return static
     */
    public function setEvent(string|array $event): static 
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return string|array
     */
    public function getEvent(): string|array 
    {
        return $this->event;
    }
} 