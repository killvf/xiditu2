<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

    protected $guarded = [];

    public function parseOptions($options) {

        if (!empty($options['sort'])) {
            foreach ($options['sort'] as $sort) {
                foreach ($sort as $k => $v) {
                    $this->orderBy($k, $v);
                }
            }
        }

        if (!empty($options['field'])) {
            $this->select($options['field']);
        }

        return $this;
    }
}
