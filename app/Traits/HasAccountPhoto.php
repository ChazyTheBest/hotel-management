<?php

namespace App\Traits;

use App\Features\AccountFeatures;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasAccountPhoto
{
    /**
     * Update the user's account photo.
     *
     * @param \Illuminate\Http\UploadedFile $photo
     * @param string $storagePath
     * @return void
     */
    public function updatePhoto(UploadedFile $photo, string $storagePath = 'account-photos'): void
    {
        if (! AccountFeatures::managesAccountPhotos()) {
            return;
        }

        tap($this->photo_path, function ($previous) use ($photo, $storagePath) {
            $this->forceFill([
                'photo_path' => $photo->storePublicly(
                    $storagePath, ['disk' => $this->photoDisk()]
                )
            ])->save();

            if ($previous) {
                Storage::disk($this->photoDisk())->delete($previous);
            }
        });
    }

    /**
     * Delete the user's account photo.
     *
     * @return void
     */
    public function deleteAccountPhoto(): void
    {
        if (! AccountFeatures::managesAccountPhotos() || is_null($this->photo_path)) {
            return;
        }

        Storage::disk($this->photoDisk())->delete($this->photo_path);

        $this->forceFill([
            'photo_path' => null
        ])->save();
    }

    /**
     * Get the URL to the user's account photo.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function photoUrl(): Attribute
    {
        return Attribute::get(fn (): string =>
            $this->photo_path
                ? Storage::disk($this->photoDisk())->url($this->photo_path)
                : $this->defaultPhotoUrl()
        );
    }

    /**
     * Get the default account photo URL if no account photo has been uploaded.
     *
     * @return string
     */
    protected function defaultPhotoUrl(): string
    {
        $name = trim(collect(explode(' ', $this->name))
            ->map(fn ($segment) => mb_substr($segment, 0, 1))
            ->join(' '));

        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the disk that account photos should be stored on.
     *
     * @return string
     */
    protected function photoDisk(): string
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME'])
            ? 's3'
            : config('features-options.account-photos.disk', 'public');
    }
}
