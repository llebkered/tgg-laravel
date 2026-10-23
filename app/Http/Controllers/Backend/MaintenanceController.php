<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Turns site maintenance on and off. See ShowMaintenancePage.
 */
class MaintenanceController extends Controller
{
    public function update(Request $request)
    {
        // Set rather than toggled, so a double click or a stale tab can't
        // switch it back
        $on = $request->boolean('on');

        option(['maintenance' => $on]);

        return back()->with('success_message', $on
            ? 'Maintenance is on. Visitors see the maintenance page; you can still use the site as an admin.'
            : 'Maintenance is off. The site is open to everyone.');
    }
}
