<?php

namespace App;

use Stancl\Tenancy\Database\Models\Domain as BaseDomain;


class Domain extends BaseDomain
{
    protected $connection = 'mysql_landlord';

}
