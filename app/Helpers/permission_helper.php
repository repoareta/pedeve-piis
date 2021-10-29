<?php

use App\Models\UserMenu;

function permission(int $menuId)
{
    return UserMenu::where('userid', auth()->user()->userid)->where('menuid', $menuId)->first();
}
