<?php

namespace App\Observers;

use App\Models\Record;
use Illuminate\Support\Facades\Log;

class RecordObserver
{
    public function saving(Record $record)
    {
        $record->content = clean($record->content, 'user_common_body');
    }
}
