<?php

namespace App\Http\View\Composers\SdmPayroll;

use Illuminate\View\View;
use App\Models\UserMenu;

class MasterPayrollChannel 
{
    public function compose(View $view)
    {
        $usermenu = UserMenu::where('menuid', 625)
                            ->where('userid', auth()->user()->userid)
                            ->first();

        if(!$usermenu){
            $usermenu == null;
        }

        $view->with('usermenu', $usermenu);
    }
}