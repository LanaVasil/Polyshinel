<?php

namespace App\View\Components\Controls;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Str;

class Check extends Component
{
  public string $name;
  public string $label;
  public ?string $asterisk;
  public null|object|array $row; 
  public string $id; 

  public bool $hasRow;
  public bool $oldExists; 
  public ?string $old; 
  public ?string $checkValue; 

    public function __construct(
      string $name,
      string $label,
      ?string $asterisk = null,
      null|object|array $row = null,
      ?string $id = null,
    )
    {
      $this->name = $name;
      $this->label = $label;
      $this->asterisk = $asterisk;
      $this->row = $row;
      $this->hasRow = isset($this->row[$name]) !=null;

      if($id===null){
        // Str::uuid() - функція Helpers, в версії 11 в документації відсутня
          // $id = Str::uuid();
          $id = "field-$name";
      }
      $this->id = $id;

      $oldParams = old();
      $this->oldExists = array_key_exists($name, $oldParams);
      $this->old = $this->oldExists ? $oldParams[$name] : '';

      $this->checkValue = $this->oldExists ? $this->old : (isset($this->row[$name]) ? $this->row[$name] : '0');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.controls.check');
    }
}
