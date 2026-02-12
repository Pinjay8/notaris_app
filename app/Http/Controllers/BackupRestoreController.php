<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use function Flasher\Notyf\Prime\notyf;

class BackupRestoreController extends Controller
{
    /**
     * BACKUP DATA
     */
    public function backup(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date',
        ]);

        $notarisId = auth()->user()->notaris_id;

        $backup = [
            'meta' => [
                'user_id'     => auth()->id(),
                'notaris_id'  => $notarisId,
                'from_date'   => $request->start_date,
                'to_date'     => $request->end_date,
                'exported_at' => now()->toDateTimeString(),
            ],

            'notaris' => DB::table('notaris')->where('id', $notarisId)->first(),

            'clients' => DB::table('clients')->where('notaris_id', $notarisId)->get(),

            'subscriptions' => DB::table('subscriptions')
                ->where('user_id', auth()->id())->get(),

            'notary_consultations' => DB::table('notary_consultations')
                ->where('notaris_id', $notarisId)
                // ->whereBetween('created_at', [$request->start_date, $request->end_date])
                ->get(),

            "notary_client_documents" => DB::table('notary_client_documents')
                ->where('notaris_id', $notarisId)->get(),

            "notary_client_warkahs" => DB::table('notary_client_warkahs')
                ->where('notaris_id', $notarisId)->get(),



            'notary_akta_types' => DB::table('notary_akta_types')
                ->where('notaris_id', $notarisId)->get(),

            'notary_akta_transactions' => DB::table('notary_akta_transactions')
                ->where('notaris_id', $notarisId)
                // ->whereBetween('created_at', [$request->start_date, $request->end_date])
                ->get(),

            'notary_akta_documents' => DB::table('notary_akta_documents')
                ->where('notaris_id', $notarisId)->get(),

            'notary_akta_parties' => DB::table('notary_akta_parties')
                ->where('notaris_id', $notarisId)->get(),

            'notary_akta_logs' => DB::table('notary_akta_logs')
                ->where('notaris_id', $notarisId)->get(),

            'relaas_types' => DB::table('relaas_types')
                ->where('notaris_id', $notarisId)->get(),

            'notary_relaas_aktas' => DB::table('notary_relaas_aktas')
                ->where('notaris_id', $notarisId)
                // ->whereBetween('created_at', [$request->start_date, $request->end_date])
                ->get(),

            'notary_relaas_documents' => DB::table('notary_relaas_documents')
                ->where('notaris_id', $notarisId)->get(),

            'notary_relaas_parties' => DB::table('notary_relaas_parties')
                ->where('notaris_id', $notarisId)->get(),

            'notary_relaas_logs' => DB::table('notary_relaas_logs')
                ->where('notaris_id', $notarisId)->get(),

            'notary_legalisasis' => DB::table('notary_legalisasis')
                ->where('notaris_id', $notarisId)->get(),

            'notary_waarmerkings' => DB::table('notary_waarmerkings')
                ->where('notaris_id', $notarisId)->get(),

            'notary_letters' => DB::table('notary_letters')
                ->where('notaris_id', $notarisId)->get(),

            'pic_staff' => DB::table('pic_staff')
                ->where('notaris_id', $notarisId)->get(),

            'pic_documents' => DB::table('pic_documents')
                ->where('notaris_id', $notarisId),

            'pic_processes' => DB::table('pic_processes')
                ->where('notaris_id', $notarisId)->get(),

            'pic_hand_overs' => DB::table('pic_hand_overs')
                ->where('notaris_id', $notarisId)->get(),

            'notary_costs' => DB::table('notary_costs')
                ->where('notaris_id', $notarisId)->get(),

            'notary_paymentts' => DB::table('notary_paymentts')
                ->where('notaris_id', $notarisId)->get(),
        ];

        $fileName = 'backup-notaris-' . $notarisId . '-' . now()->format('Ymd_His') . '.json';

        // PASTIKAN FOLDER ADA
        if (!Storage::disk('local')->exists('backup')) {
            Storage::disk('local')->makeDirectory('backup');
        }

        Storage::disk('local')->put(
            'backup/' . $fileName,
            json_encode($backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        notyf()->success('Data berhasil di-backup');


        return response()->download(
            storage_path('app/backup/' . $fileName)
        );
    }


    public function restore(Request $request)
    {

        $request->validate([
            'file' => 'required|file|mimes:json',
        ]);

        $json = file_get_contents($request->file('file')->getRealPath());
        $data = json_decode($json, true);

        if (!$data || !isset($data['meta']['notaris_id'])) {
            throw new \Exception('File backup tidak valid');
        }


        if ($data['meta']['notaris_id'] !== auth()->user()->notaris_id) {
            notyf()->error('File backup bukan milik akun ini');
            return back();
        }

        DB::transaction(function () use ($data) {

            $notarisId = $data['meta']['notaris_id'];

            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            // TABLE YANG BERELASI DENGAN NOTARIS
            $tables = [
                'clients',
                // 'subscriptions',
                'notary_consultations',
                'notary_client_documents',
                'notary_client_warkahs',
                'notary_akta_types',
                'notary_akta_documents',
                'notary_akta_parties',
                'notary_akta_logs',
                'relaas_types',
                'notary_akta_transactions',
                'notary_relaas_aktas',
                'notary_relaas_parties',
                'notary_relaas_documents',
                'notary_relaas_logs',
                'notary_legalisasis',
                'notary_waarmerkings',
                'pic_staff',
                'pic_processes',
                'pic_documents',
                'pic_hand_overs',
                'notary_costs',
                'notary_paymentts',

            ];

            foreach ($tables as $table) {
                DB::table($table)->where('notaris_id', $notarisId)->delete();
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            /**
             * RESTORE NOTARIS
             */
            if (!empty($data['notaris'])) {
                DB::table('notaris')->updateOrInsert(
                    ['id' => $notarisId],
                    collect($data['notaris'])
                        ->except(['deleted_at'])
                        ->toArray()
                );
            }

            /**
             * RESTORE DATA RELASI
             */
            foreach ($tables as $table) {
                if (!empty($data[$table])) {
                    $rows = collect($data[$table])->map(function ($row) {
                        return collect($row)->except(['deleted_at'])->toArray();
                    })->toArray();

                    DB::table($table)->insert($rows);
                }
            }
        });

        notyf()->position('x', 'right')->position('y', 'top')->success('Restore berhasil');
        return back();
    }
}
