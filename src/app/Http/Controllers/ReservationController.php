<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use App\Services\ReservationService;
use App\Http\Requests\ReservationRequest;

class ReservationController extends Controller
{
    private $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }



    public function reserve(ReservationRequest $request): RedirectResponse
    {
        $userId = Auth::id();
        $shopId = $request->shopId;
        $date = $request->date;
        $time = $request->time;
        $numPeople = $request->numPeople;
        if (is_null($shopId)) {
            return redirect('/reservation/failed');
        }
        $this->reservationService->reserve($userId, $shopId, $date, $time, $numPeople);
        return redirect('/reservation/completed');
    }

    public function reserveCompleted(): View
    {
        return view('reservation.completed');
    }

    public function reserveFailed(): View
    {
        return view('reservation.failed');
    }

    public function deleteReservation(Request $request): RedirectResponse
    {
        $userId = Auth::id();
        $reservationId = $request->reservationId;
        $this->reservationService->deleteReservation($userId, $reservationId);
        return redirect('/reservation/delete/completed');
    }

    public function deleteReservationCompleted(): View
    {
        return view('reservation.deleted');
    }

    public function showModifyReservationPage(Request $request): View
    {
        $userId  = Auth::id();
        $reservationId = $request->reservationId;
        [$reservation, $shop, $image] = $this->reservationService->getModifyReservationInfo($userId, $reservationId);

        if (is_null($reservation)) {
            return view('reservation.notFound');
        }
        $referrer = '/modify-reservation/' . $reservationId;
        return view('shop.detail', compact('reservation', 'shop', 'image', 'referrer'));
    }



    public function modifyReservation(ReservationRequest $request): RedirectResponse
    {
        $userId = Auth::id();
        $reservationId = $request->reservationId;
        $date = $request->date;
        $time = $request->time;
        $numPeople = $request->numPeople;
        if (is_null($reservationId)) {
            return redirect('/reservation/modify/failed');
        }
        if ($this->reservationService->modifyReservation($userId, $reservationId, $date, $time, $numPeople)) {
            return redirect('/reservation/modify/completed');
        };
        return redirect('/reservation/modify/failed');
    }

    public function reservationModifyCompleted(): View
    {
        return view('reservation.modify.completed');
    }

    public function reservationModifyFailed(): View
    {
        return view('reservation.modify.failed');
    }
}
