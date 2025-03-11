<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CargarFlyway extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cargar-flyway';

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
        //Leer el directorio database/sql y ejecutar todos los scripts sql que se encuentren en el
        $files = scandir('database/sql');
        foreach ($files as $file) {
            if (is_file('database/sql/' . $file)) {
                DB::unprepared(file_get_contents('database/sql/' . $file));
            }
        }
    }
}
