<?php

namespace App\Console\Commands;

use App\Mail\Timetable;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class TimetableNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:timetable-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // ?from=2024-09-02T00:00:00Z&lang=ET&studentGroups=7597&thru=2025-08-31T00:00:00Z
        $response = Http::get('https://tahvel.edu.ee/hois_back/timetableevents/timetableByGroup/38', [
            'from' => now()->startOfWeek()->toIsoString(),
            'lang' => 'ET',
            'studentGroups' => 7597,
            'thru' => now()->endOfYear()->toIsoString(),
        ]);
        
        $data = collect($response->json()['timetableEvents'])->map(function ($entry) {
            return [
                'name' => data_get($entry, 'nameEt', '-'),
                'room' => data_get($entry, 'rooms.0.roomCode', 'pole'),
                'teacher' => data_get($entry, 'teachers.0.name', 'pole'),
                'date' => Carbon::parse(data_get($entry, 'date')),
                'time_start' => data_get($entry, 'timeStart'),
                'time_end' => data_get($entry, 'timeEnd'),

            ];
        })->sortBy(['date', 'time_start'])
            ->groupBy(function ($event) {
                return $event['date']->format('m-d');
            });

        Mail::to('ruusmann@gmail.com')->send(new Timetable($data));
    }
}
