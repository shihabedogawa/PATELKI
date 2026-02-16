<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\DB;



class AdminController extends Controller
{
    // 1) Tampilkan daftar member pending
    public function pendingMembers()
    {
        $members = Member::where('status', 'pending')->get();

        return view('admin.members.index', compact('members'));
    }

    // 2) Approve member
    public function approveMember($id)
    {
        DB::transaction(function () use ($id) {

            $member = Member::findOrFail($id);

            // 1️⃣ update member
            if (!$member->nap) {
                $member->nap = 'PAT-' . str_pad($member->id, 6, '0', STR_PAD_LEFT);
            }

            $member->update([
                'status'    => 'approved',
                'joined_at' => now(),
            ]);

            // 2️⃣ update user (BUKAN create)
            $user = User::where('member_id', $member->id)->first();

            if ($user) {
                $user->update([
                    'role' => 'member',
                ]);
            }

        });

        return back()->with('success', 'Member berhasil di-approve.');
    }


    public function destroyMember($id)
    {
    $member = Member::findOrFail($id);

    // hapus file dari storage
    Storage::disk('public')->delete($member->ijazah_file);
    Storage::disk('public')->delete($member->str_file);
    Storage::disk('public')->delete($member->foto_file);

    // hapus user terkait (jika sudah ada)
    if ($member->user) {
        $member->user->delete();
    }

    // hapus member
    $member->delete();

    return back()->with('success', 'Member dan semua filenya berhasil dihapus.');
    }


    public function dashboard()
    {
        $user = auth()->user();

        if ($user->division === 'Pendidikan dan Pengembangan SDM') {
            return view('admin.dashboard-pendidikan');
        }

        // default: dashboard keanggotaan
        return view('admin.dashboard');
    }


    public function approvedMembers(Request $request)
    {
        $query = Member::where('status','approved');

        if ($request->search) {
            $query->where(function($q) use ($request){
                $q->where('name','like','%'.$request->search.'%')
                ->orWhere('email','like','%'.$request->search.'%')
                ->orWhere('nap','like','%'.$request->search.'%');
            });
        }

        if ($request->gender) {
            $query->where('gender', $request->gender);
        }

        $members = $query->orderBy('joined_at','desc')->paginate(10);

        return view('admin.members.approved', compact('members'));
    }

    public function downloadZip(Request $request)
    {
        $ids = $request->member_ids ?? [];

        if (empty($ids)) {
            return back()->with('error','Pilih minimal satu member.');
        }

        $members = Member::whereIn('id',$ids)->get();

        $zip = new ZipArchive;
        $fileName = 'dokumen_members_'.time().'.zip';
        $zipPath = storage_path('app/public/'.$fileName);

        $zip->open($zipPath, ZipArchive::CREATE);

        foreach ($members as $m) {
            if ($m->ijazah_file) $zip->addFile(storage_path('app/public/'.$m->ijazah_file), 'ijazah/'.$m->name.'.pdf');
            if ($m->str_file) $zip->addFile(storage_path('app/public/'.$m->str_file), 'str/'.$m->name.'.pdf');
            if ($m->foto_file) $zip->addFile(storage_path('app/public/'.$m->foto_file), 'foto/'.$m->name.'.jpg');
        }

        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function viewFile($memberId, $type)
    {
        $user = auth()->user();

        // hanya admin / keanggotaan
        abort_unless($user && in_array($user->role, ['admin']), 403);

        $member = Member::findOrFail($memberId);

        $path = match ($type) {
            'ijazah' => $member->ijazah_file,
            'str'    => $member->str_file,
            'foto'   => $member->foto_file,
            default  => abort(404),
        };

        if (!$path || !Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $fullPath = storage_path('app/public/'.$path);
        // $fullPath = storage_path('public/storage/'.$path);

        return response()->make(
            file_get_contents($fullPath),
            200,
            [
                'Content-Type'        => mime_content_type($fullPath),
                'Content-Disposition' => 'inline; filename="'.basename($fullPath).'"',
            ]
        );

    }

}
