<?php

namespace Ipsum\Admin\app\View\Components;

use Illuminate\View\Component;

class Custom extends Component
{
    public $name;
    public $label;
    public $description;
    public $options;
    public $value;
    public $type;
    public $field;


    /**
     * Create a new component instance.
     *
     * @return void
     */

    public function __construct(array $field, string $name, $value)
    {
        $options = $this->setOptions($field);

        $this->label = $field['label'];
        $this->description = $field['description'] ?? null;
        $this->options = $options;
        $this->name = $name;
        $this->value = $value;
        $this->type = $field['type'];
        $this->field = $field;
    }



    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        return view('IpsumAdmin::components.custom', [
            'name' => $this->name,
            'label' => $this->label,
            'description' => $this->description,
            'options' => $this->options,
            'value' => $this->value,
            'type' => $this->type,
            'field' => $this->field,
        ]);
    }

    protected function setOptions($field)
    {
        $options = $field['options'] ?? [];

        if ($field['type'] === 'relation') {
            $query = $field['model']::query();
            if (isset($field['filtre'])) {
                foreach ($field['filtre'] as $filter) {
                    if ($filter['method']) {
                        $method = $filter['method'];
                        if (count($filter['args']) > 0) {
                            $args = $filter['args'];
                            $query = $query->$method(...$args);
                        } else {
                            $query = $query->$method();
                        }
                    }
                }
            }
            $options = $query->get()->pluck('nom', 'id');
        }
        return collect(['' => '---- ' . $field['label'] . ' -----'])->union($options);
    }
}
