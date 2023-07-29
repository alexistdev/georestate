<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Traits\UUIDRandomGenerator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AgentSeeder extends Seeder
{
    use UUIDRandomGenerator;

    public function run(): void
    {
        $date = Carbon::now()->format('Y-m-d H:i:s');
        $agent = [
            array('id' =>$this->newUniqueId(),'user_id'=>'3','member_identifier' => $this->newUniqueIdbyUlid(),'phone' => '08212345678','created_at' => $date,'updated_at' => $date),
        ];
        Agent::insert($agent);
    }
}
