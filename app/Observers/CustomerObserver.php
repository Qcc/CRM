<?php

namespace App\Observers;

use App\Models\Customer;

class CustomerObserver
{
    public function saving(Customer $customer)
    {
        $customer->comment = clean($customer->comment, 'user_common_body');
    }
}
