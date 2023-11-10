<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case ON_GOING = 'on-going';

    case DONE = 'done';

    case CANCELED = 'canceled';

    public function labels(): string
    {
        return match ($this) {
            self::ON_GOING => "On Going ⏳",
            self::DONE => "Done ✅",
            self::CANCELED => "Canceled ❎"
        };
    }

    public function labelPowergridFilter(): string
    {
        return $this->labels();
    }
}
