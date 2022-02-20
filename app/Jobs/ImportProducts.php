<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ImportProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $tmp_file;

    public function __construct($f)
    {
        $this->tmp_file = $f;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $file = fopen(Storage::path($this->tmp_file), 'r');
        $i = 0;
        $insert = [];
        while ($row = fgetcsv($file, 1000, ';')) {
            if ($i++ == 0) {
                $bom = pack('H*', 'EFBBBF');
                $row = preg_replace("/^$bom/", '', $row);
                $columns = $row;
                continue;
            }

            $data = array_combine($columns, $row);

            if ($data['id']) {
                Product::where('id', $data['id'])->update($data);
                continue;
            }

            unset($data['id']);

            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $insert[] = $data;
        }

        Product::insert($insert);

        unlink(Storage::path($this->tmp_file));
    }
}
