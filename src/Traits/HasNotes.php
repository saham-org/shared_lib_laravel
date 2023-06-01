<?php

namespace Saham\SharedLibs\Traits;

use Illuminate\Support\Facades\Auth;
use Saham\SharedLibs\Mongodb\Eloquent\Model;

trait HasNotes
{
    public function createNotes(
        $notes
    ): ?bool {

        return   $this->push('notes_history', [
            'user_id'    => Auth::user()?->id,
            'full_name'  => Auth::user()?->full_name,
            'guard'      => Auth::getDefaultDriver(),
            'notes'     => $notes,
            'created_at' => date('Y-m-d h:i:s'),
            'type' => 'normal',
        ], false);
    }
}