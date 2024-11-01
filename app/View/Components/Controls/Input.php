<?php

namespace App\View\Components\Controls;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public string $name;
    public string $label;
    public ?string $placeholder;
    public ?string $asterisk;
    public ?string $autofocus;
    public null|object|array $row; 
    public string $type; 
    public string $id; 

    public bool $hasRow;
    public bool $oldExists; 
    public ?string $old; 

    public function __construct(
        string $name,
        string $label,
        ?string $placeholder = null,
        ?string $asterisk = null,
        ?string $autofocus = null,
        null|object|array $row = null,
        string $type = 'text', 
        ?string $id = null,
    ) 
    {
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->asterisk = $asterisk;
        $this->autofocus = $autofocus;
        $this->row = $row;
        $this->hasRow = $this->row !=null;
        $this->type = $type;

        if($id===null){
            $id = "field-$name";
        }
        $this->id = $id;

        $oldParams = old();
        $this->oldExists = array_key_exists($name, $oldParams);
        $this->old = $this->oldExists ? $oldParams[$name] : '';
    }

    
    public function render(): View|Closure|string
    {
        return view('components.controls.input');
    }
}
