<?php

namespace App\Services;

use App\Models\Avatar;
use App\Repositories\AvatarReapository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AvatarService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private AvatarReapository $avatarRepository,
    ) {}

    public function index() {

        return $this->avatarRepository->index();
    }

    public function store(array $data, ?UploadedFile $image) {

      DB::beginTransaction();

        try {
            if ($image) {

                $data['image'] = $image->store('avatars', 'public');
            }

            $avatar = $this->avatarRepository->store($data);

            DB::commit();

            return $avatar;

        } catch (\Throwable $e) {
            DB::rollBack();

            if (!empty($data['image'])) {
                Storage::disk('public')->delete($data['image']);
            }

            throw $e;
        }
    }

    public function update(Avatar $avatar, array $data, ?UploadedFile $image) {

        DB::beginTransaction();

        try {
            $oldImage = $avatar->image;

            if ($image) {

                $data['image'] = $image->store('avatars', 'public');
            }

            $avatar = $this->avatarRepository->update($avatar, $data);

            if ($image && $oldImage && Storage::disk('public')->exists($oldImage)) {
                
                Storage::disk('public')->delete($oldImage);
            }

            DB::commit();

            return $avatar;
            
        } catch (\Throwable $e) {
            DB::rollBack();

            // Delete newly uploaded image if database update failed
            if (!empty($data['image'])) {
                Storage::disk('public')->delete($data['image']);
            }

            throw $e;
        }
    }

    public function destroy(Avatar $avatar) {

        if ($avatar->image && Storage::disk('public')->exists($avatar->image)) {
            Storage::disk('public')->delete($avatar->image);
        }

        return $this->avatarRepository->destroy($avatar);
    }   
}
