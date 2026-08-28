<?php

namespace App\Traits;

trait Searchable
{
    public function scopeSearch($query, $term, $columns = [])
    {
        if (empty($term)) {
            return $query;
        }

        $search = $term; // Capture the original term for use inside the closure as $search
        $term = '%' . $term . '%'; // This $term is now the wildcarded version

        return $query->where(function ($q) use ($search, $columns) {
            $term = "%{$search}%"; // Redefine $term inside the closure using $search
            foreach ($columns as $column) {
                $q->orWhere($column, 'like', $term);
            }
        });
    }
}
