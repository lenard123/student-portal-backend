<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $casts = ['meta' => 'array'];

    public function mediable()
    {
        return $this->morphTo();
    }

    public static function upload($model, $file, $folder, $disk = 'public')
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $media = new self();
        $media->mediable()->associate($model);
        $media->source = $file->storeAs($folder, $filename, $disk);
        $media->disk = $disk;
        $media->meta = [
            'filename' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'mimetype' => $file->getMimetype(),
        ];
        $media->save();

        return $media;
    }
}
