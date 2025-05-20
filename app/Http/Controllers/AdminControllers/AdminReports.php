<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\User;

class AdminReports extends Controller
{
    public function AdminReportsView() {
        $message = "Choose Role type";
        return view('AdminViews/AdminReportsView', compact('message'));
    }

    public function AdminReportsViewDrop($roleName)
    {


            if($roleName == "user" || $roleName == "admin") {
                $users = User::with(['roles', 'deliveriesReceived' => function ($q) {
                    $q->whereHas('request', function ($q) {
                        $q->where('requestStatus', 'accepted');
                    })->whereHas('statuses', function ($q) {
                        $q->where('deliveryStatus', 'completed');
                    });
                }])
                    ->whereHas('roles', function ($q) use ($roleName) {
                        $q->where('roleName', $roleName);
                    })
                    ->whereHas('deliveriesReceived', function ($q) {
                        $q->whereHas('request', function ($q) {
                            $q->where('requestStatus', 'accepted');
                        })->whereHas('statuses', function ($q) {
                            $q->where('deliveryStatus', 'completed');
                        });

                    })
                    ->get();
            } elseif($roleName == "driver") {
                $users = User::with(['roles','reviews', 'deliveriesMade' => function ($q) {
                    $q->whereHas('request', function ($q) {
                        $q->where('requestStatus', 'accepted');
                    })->whereHas('statuses', function ($q) {
                        $q->where('deliveryStatus', 'completed');
                    });
                }])
                    ->whereHas('roles', function ($q) use ($roleName) {
                        $q->where('roleName', $roleName)->where('gotRegistered', "accepted");
                    })
                    ->whereHas('deliveriesMade', function ($q) {
                        $q->whereHas('request', function ($q) {
                            $q->where('requestStatus', 'accepted');
                        })->whereHas('statuses', function ($q) {
                            $q->where('deliveryStatus', 'completed');
                        });

                    })
                    ->get();
            }




        $status = $roleName;
        if($users->isEmpty()) {
            $emptyMessage = "no users to be listed";
            return view('AdminViews/AdminReportsView', compact('users', 'status', 'emptyMessage'));
        }

        return view('AdminViews/AdminReportsView', compact('users', 'status'));

    }

    public function userDetailedReport($id) {

        $deliveries = Delivery::with('request', 'deliveredToUser', 'deliveredByUser','statuses')
            ->whereHas('request', function ($q) {
                $q->where('requestStatus', 'accepted');
            })->WhereHas('statuses', function ($q)  {
                $q->where('deliveryStatus', 'completed');
            })->WhereHas('deliveredToUser', function ($q) use ($id) {
                $q->where('id', $id);
            })
            ->get();

        return view('AdminViews/AdminUserReport', compact('deliveries'));
    }

    public function driverDetailedReport($id) {

        $deliveries = Delivery::with('request', 'deliveredToUser', 'deliveredByUser','statuses')
            ->whereHas('request', function ($q) {
                $q->where('requestStatus', 'accepted');
            })->WhereHas('statuses', function ($q)  {
                $q->where('deliveryStatus', 'completed');
            })->WhereHas('deliveredByUser', function ($q) use ($id) {
                $q->where('id', $id);
            })
            ->get();

        return view('AdminViews/AdminDriverReport', compact('deliveries'));
    }
}
