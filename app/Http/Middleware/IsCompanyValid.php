<?php

namespace App\Http\Middleware;

use App\Models\Company;
use App\Models\LocketCall;
use App\Models\LocketQueue;
use App\Models\Room;
use App\Models\RoomQeueueCall;
use App\Models\RoomQueue;
use App\Models\StatConsole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use starekrow\Lockbox\CryptoKey;

class IsCompanyValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $key = CryptoKey::Import(file_get_contents("key.txt"));
            $ciphertext = file_get_contents("cipher.txt");
            $message = $key->Unlock($ciphertext);
            $registered = json_decode($message, true);
            if (empty($registered['company_name']) || empty($registered['company_code'])) return $this->out();

            $validated = true;
        } catch (\Throwable | \Exception | \ErrorException  $th) {
            $validated = false;
        }
        if (!$validated) return $this->out();

        if (!$this->validatCompany($registered)) return $this->out();

        if ($data = StatConsole::first()) {
            $today = now();
            if ($data->tanggal != $today->format('Ymd')) {
                $this->initiateTable();
            }
        } else {
            $this->initiateTable();
        }

        $this->fillTodayStat($data);
        Config::set('mysite.company_name', $registered['company_name']);
        Config::set('mysite.company_adress', $registered['company_code']);
        return $next($request);
    }

    private function initiateTable()
    {
        // empty queue
        RoomQueue::truncate();
        RoomQeueueCall::truncate();
        LocketQueue::truncate();
        LocketCall::truncate();

        // Reset to 0 again
        Room::query()->update(['current_queue' => null, 'last_call_queue' => null, 'last_call_time' => null]);
    }

    private function fillTodayStat($stat)
    {
        $today = now();
        $newData = [
            'tanggal' => $today->format('Ymd'),
            'Status' => 'active',
            'ActiveDate' => $today->format('Ymd'),
        ];

        if (empty($stat)) {
            StatConsole::create($newData);
        } else {
            $stat->update($newData);
        }
    }

    private function validatCompany($registered)
    {
        $name = $registered['company_name'];
        $address = $registered['company_code'];

        if ($current = Company::first()) {
            if ($current->name !== $name) {
                $current->active = false;
                $current->save();
                return false;
            }
        } else {
            Company::create([
                'name' => $name,
                'address' => $address,
                'active' => true
            ]);
        }

        return true;
    }

    private function out()
    {
        return response()->view('errors.subscribe');
    }
}
