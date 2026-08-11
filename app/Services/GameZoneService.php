<?php

namespace App\Services;

use App\Models\GameZone;
use App\Repositories\GameZoneRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GameZoneService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected GameZoneRepository $gameZoneRepository
    ) {}

    public function all($perPage = 10)
    {
        return $this->gameZoneRepository->all($perPage);
    }

    public function create(array $data, ?UploadedFile $icon)
    {
        DB::beginTransaction();

        try {
            if ($icon) {

                $data['icon'] = $icon->store('games/icons', 'public');
            }

            $gameZone = $this->gameZoneRepository->create($data);

            DB::commit();

            return $gameZone;

        } catch (\Throwable $e) {
            DB::rollBack();

            if (!empty($data['icon'])) {
                Storage::disk('public')->delete($data['icon']);
            }

            throw $e;
        }
    }

    public function update(GameZone $gameZone, array $data, ?UploadedFile $icon)
    {
        DB::beginTransaction();

        try {
            $oldIcon = $gameZone->icon;

            if ($icon) {

                $data['icon'] = $icon->store('games/icons', 'public');
            }

            $gameZone = $this->gameZoneRepository->update($gameZone, $data);

            if ($icon && $oldIcon && Storage::disk('public')->exists($oldIcon)) {
                
                Storage::disk('public')->delete($oldIcon);
            }

            DB::commit();

            return $gameZone;

        } catch (\Throwable $e) {
            DB::rollBack();

            if (!empty($data['icon'])) {
                Storage::disk('public')->delete($data['icon']);
            }

            throw $e;
        }
    }

    public function delete(GameZone $gameZone)
    {
        if ($gameZone->icon && Storage::disk('public')->exists($gameZone->icon)) {

            Storage::disk('public')->delete($gameZone->icon);
        }
        
        return $this->gameZoneRepository->delete($gameZone);
    }
}
