<?php
namespace App\Http\Traits;

use App\AttendanceLeave;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasLeave
{
    public function leaveOnDate(): MorphOne
    {
        return $this->morphOne(AttendanceLeave::class, 'person');
    }
}