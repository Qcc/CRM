<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Customer $customer)
    {
        return $user->isAuthorOf($customer);
    }

    public function destroy(User $user, Customer $customer)
    {
        return $user->isAuthorOf($customer);
    }
    public function manager(User $user, Customer $customer)
    {   
        return $user->can('manager');
    }
}
