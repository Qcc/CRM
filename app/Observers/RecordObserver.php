<?php

namespace App\Observers;

use App\Models\Record;
use Illuminate\Support\Facades\Log;

class RecordObserver
{
    public function saving(Record $record)
    {
        Log::info('过滤前 '.$record->content);
        $record->content = clean($record->content, 'user_common_body');
        Log::info('过滤后 '.$record->content);
    }
}
