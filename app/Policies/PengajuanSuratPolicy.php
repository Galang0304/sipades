<?php

namespace App\Policies;

use App\Models\PengajuanSurat;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PengajuanSuratPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['admin', 'lurah', 'petugas', 'member']);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PengajuanSurat  $pengajuanSurat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, PengajuanSurat $pengajuanSurat)
    {
        if ($user->hasAnyRole(['admin', 'lurah', 'petugas'])) {
            return true;
        }

        return $user->id === $pengajuanSurat->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasAnyRole(['admin', 'member']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PengajuanSurat  $pengajuanSurat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, PengajuanSurat $pengajuanSurat)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->id === $pengajuanSurat->user_id && $pengajuanSurat->status === 'Proses';
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PengajuanSurat  $pengajuanSurat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, PengajuanSurat $pengajuanSurat)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PengajuanSurat  $pengajuanSurat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, PengajuanSurat $pengajuanSurat)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PengajuanSurat  $pengajuanSurat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, PengajuanSurat $pengajuanSurat)
    {
        return $user->hasRole('admin');
    }
}
