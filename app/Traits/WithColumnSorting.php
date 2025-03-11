<?php

namespace App\Traits;

trait WithColumnSorting
{
    public $sort;
    public $direction;
    public $cantidad;

    public function order($sort)
    {
        if ($this->sort === $sort) {
            $this->direction = $this->toggleDirection($this->direction);
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function updatingCantidad()
    {
        if (isset($this->pageName)) {
            $this->resetPage(pageName: $this->pageName);
        } else {
            $this->resetPage();
        }
    }

    private function toggleDirection($direction)
    {
        if ($direction === 'desc') {
            return 'asc';
        }

        if ($direction === 'asc') {
            return 'desc';
        }
    }
}
