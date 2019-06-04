<?php

namespace App\Observers;

use App\Models\Record;

class RecordObserver
{
    public function saving(Record $record)
    {
        $record->content = clean($record->content, 'user_common_body');
    }
}
