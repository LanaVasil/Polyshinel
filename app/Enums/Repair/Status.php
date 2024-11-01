<?php

namespace App\Enums\Repair;

enum Status: int
{
    // REJECTED - відхилено
  case DRAFT = 0;
  case APPROVED = 5;
  case POSTPONED = 6;
  case ARCHIVED = 9;

  // POSTPONE - [постпон] відкладати
  public function text()
  {
    return match ($this->value) {
      0 => 'чорнетка',
      5 => 'ухвалено',
      6 => 'відкладено',
      9 => 'архів'
    };
  }

  public function nextStatus()
  {
    return match ($this->value) {
      0 => 'Ухвалити',
      5 => 'Відкласти',
      6 => 'До архіву',
      9 => 'Чорнетка'
    };
  }
}
