<?php

namespace App\Http\Controllers;

use App\Models\EditRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditRequestController extends Controller
{
    public function index()
    {
        $requests = EditRequest::with([
            'user',
            'lhp.auditee'
        ])
            ->latest()
            ->get();

        return view(
            'pages.edit-request.index',
            compact('requests')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lhp_id' => 'required|exists:lhp,id',
            'alasan' => 'required|string|max:1000',
        ]);

        // Cek apakah masih ada request pending
        $exists = EditRequest::where('lhp_id', $validated['lhp_id'])
            ->where('user_id', auth()->id())
            ->whereIn('status', [
                'pending',
                'approved'
            ])
            ->exists();



        if ($exists) {
            return back()->with('error', 'Permintaan edit masih menunggu persetujuan admin.');
        }

        EditRequest::create([
            'user_id' => auth()->id(),
            'lhp_id' => $validated['lhp_id'],
            'alasan' => $validated['alasan'],
            'status' => 'pending',
        ]);

        return back()->with('success', 'Permintaan edit berhasil dikirim.');
    }
    public function approve(EditRequest $editRequest)
    {
        $editRequest->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()
            ->with('success', 'Permintaan edit disetujui.');
    }


    public function reject(EditRequest $editRequest)
    {
        if ($editRequest->status !== 'pending') {
            return back()->with('error', 'Permintaan ini sudah diproses.');
        }

        $editRequest->update([
            'status'      => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Permintaan edit berhasil ditolak.');
    }

    public function complete(EditRequest $editRequest)
    {
        // Pastikan hanya pemilik request yang bisa menyelesaikan
        if ($editRequest->user_id !== auth()->id()) {

            abort(403);
        }


        // Pastikan status memang sedang approved
        if ($editRequest->status !== 'approved') {

            return back()
                ->with('error', 'Permintaan edit belum aktif.');
        }


        $editRequest->update([
            'status' => 'completed'
        ]);


        return redirect()
            ->route('lhp.show', $editRequest->lhp_id)
            ->with(
                'success',
                'Proses edit selesai. Akses edit telah ditutup.'
            );
    }
}
