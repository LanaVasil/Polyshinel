<?php

namespace App\View\Components\Controls;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public string $name;
    public string $label;
    public ?string $asterisk;
    public ?string $autofocus;
    public null|object|array $row; 
    public null|object|array $item; 
    public string $id; 

    public bool $hasRow;
    public bool $oldExists; 
    public ?string $old; 
    public ?string $selectValue; 
    
    public function __construct(
        string $name,
        string $label,
        ?string $asterisk = null,
        ?string $autofocus = null,
        null|object|array $row = null,
        null|object|array $item = null, 
        ?string $id = null,
    )
    {
        $this->name = $name;
        $this->label = $label;
        $this->asterisk = $asterisk;
        $this->autofocus = $autofocus;
        $this->row = $row;
        $this->item = $item;
        $this->hasRow = isset($this->row[$name]) !=null;

        if($id===null){
            $id = "field-$name";
        }
        $this->id = $id;

        $oldParams = old();
        $this->oldExists = array_key_exists($name, $oldParams);
        $this->old = $this->oldExists ? $oldParams[$name] : '';
        $this->selectValue = '';
        // $this->selectValue = $this->oldExists ? $old : ($this->hasRow ? $this->row[$name] : '');
        $this->selectValue = $this->oldExists ? $this->old : (isset($this->row[$name]) ? $this->row[$name] : '');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.controls.select');
    }
}
