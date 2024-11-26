<?php

namespace App\Jobs;

use App\Models\Employee;
use App\Mail\EmployeeCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmployeeCreatedEmail implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $employee;

    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    public function handle()
    {
        $company = $this->employee->company;
        Mail::to($company->email)->send(new EmployeeCreated($this->employee));
    }
}
