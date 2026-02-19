<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

use function Flasher\Notyf\Prime\notyf;

class BackupRestoreController extends Controller
{

    public function index()
    {

        return view('pages.DataManagement.index');
    }
    /**
     * BACKUP DATA
     */
    // public function backup(Request $request)
    // {
    //     $request->validate([
    //         'start_date' => 'required|date',
    //         'end_date'   => 'required|date',
    //     ]);

    //     $notarisId = auth()->user()->notaris_id;

    //     $backup = [
    //         'meta' => [
    //             'user_id'     => auth()->id(),
    //             'notaris_id'  => $notarisId,
    //             'from_date'   => $request->start_date,
    //             'to_date'     => $request->end_date,
    //             'exported_at' => now()->toDateTimeString(),
    //         ],

    //         'notaris' => DB::table('notaris')->where('id', $notarisId)->first(),

    //         'clients' => DB::table('clients')->where('notaris_id', $notarisId)->get(),

    //         'subscriptions' => DB::table('subscriptions')
    //             ->where('user_id', auth()->id())->get(),

    //         'notary_consultations' => DB::table('notary_consultations')
    //             ->where('notaris_id', $notarisId)
    //             // ->whereBetween('created_at', [$request->start_date, $request->end_date])
    //             ->get(),

    //         "documents" => DB::table('documents')
    //             ->where('notaris_id', $notarisId)->get(),

    //         "notary_client_warkahs" => DB::table('notary_client_warkahs')
    //             ->where('notaris_id', $notarisId)->get(),



    //         'notary_akta_types' => DB::table('notary_akta_types')
    //             ->where('notaris_id', $notarisId)->get(),

    //         'notary_akta_transactions' => DB::table('notary_akta_transactions')
    //             ->where('notaris_id', $notarisId)
    //             // ->whereBetween('created_at', [$request->start_date, $request->end_date])
    //             ->get(),

    //         'notary_akta_documents' => DB::table('notary_akta_documents')
    //             ->where('notaris_id', $notarisId)->get(),

    //         'notary_akta_parties' => DB::table('notary_akta_parties')
    //             ->where('notaris_id', $notarisId)->get(),

    //         'notary_akta_logs' => DB::table('notary_akta_logs')
    //             ->where('notaris_id', $notarisId)->get(),

    //         'relaas_types' => DB::table('relaas_types')
    //             ->where('notaris_id', $notarisId)->get(),

    //         'notary_relaas_aktas' => DB::table('notary_relaas_aktas')
    //             ->where('notaris_id', $notarisId)
    //             // ->whereBetween('created_at', [$request->start_date, $request->end_date])
    //             ->get(),

    //         'notary_relaas_documents' => DB::table('notary_relaas_documents')
    //             ->where('notaris_id', $notarisId)->get(),

    //         'notary_relaas_parties' => DB::table('notary_relaas_parties')
    //             ->where('notaris_id', $notarisId)->get(),

    //         'notary_relaas_logs' => DB::table('notary_relaas_logs')
    //             ->where('notaris_id', $notarisId)->get(),

    //         'notary_legalisasis' => DB::table('notary_legalisasis')
    //             ->where('notaris_id', $notarisId)->get(),

    //         'notary_waarmerkings' => DB::table('notary_waarmerkings')
    //             ->where('notaris_id', $notarisId)->get(),

    //         'notary_letters' => DB::table('notary_letters')
    //             ->where('notaris_id', $notarisId)->get(),

    //         'pic_staff' => DB::table('pic_staff')
    //             ->where('notaris_id', $notarisId)->get(),

    //         'pic_documents' => DB::table('pic_documents')
    //             ->where('notaris_id', $notarisId)->get(),

    //         'pic_processes' => DB::table('pic_processes')
    //             ->where('notaris_id', $notarisId)->get(),

    //         'pic_hand_overs' => DB::table('pic_hand_overs')
    //             ->where('notaris_id', $notarisId)->get(),

    //         'notary_costs' => DB::table('notary_costs')
    //             ->where('notaris_id', $notarisId)->get(),

    //         'notary_paymentts' => DB::table('notary_paymentts')
    //             ->where('notaris_id', $notarisId)->get(),
    //     ];

    //     $fileName = 'backup-notaris-' . $notarisId . '-' . now()->format('Ymd_His') . '.json';

    //     // PASTIKAN FOLDER ADA
    //     if (!Storage::disk('local')->exists('backup')) {
    //         Storage::disk('local')->makeDirectory('backup');
    //     }

    //     Storage::disk('local')->put(
    //         'backup/' . $fileName,
    //         json_encode($backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
    //     );

    //     notyf()->position('x', 'right')->position('y', 'top')->success('Backup berhasil');


    //     return response()->download(
    //         storage_path('app/backup/' . $fileName)
    //     );
    // }

    public function backup(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $notarisId = auth()->user()->notaris_id;

        $start = \Carbon\Carbon::parse($request->start_date)->startOfDay();
        $end   = \Carbon\Carbon::parse($request->end_date)->endOfDay();

        $backup = [
            'meta' => [
                'user_id'     => auth()->id(),
                'notaris_id'  => $notarisId,
                'from_date'   => $request->start_date,
                'to_date'     => $request->end_date,
                'exported_at' => now()->toDateTimeString(),
            ],

            /*
            |--------------------------------------------------------------------------
            | MASTER DATA (TETAP FULL)
            |--------------------------------------------------------------------------
            */
            'notaris' => DB::table('notaris')->where('id', $notarisId)->first(),

            'clients' => DB::table('clients')
                ->where('notaris_id', $notarisId)->get(),

            'subscriptions' => DB::table('subscriptions')
                ->where('user_id', auth()->id())->get(),

            'documents' => DB::table('documents')
                ->where('notaris_id', $notarisId)->get(),

            'notary_client_warkahs' => DB::table('notary_client_warkahs')
                ->where('notaris_id', $notarisId)->get(),

            'notary_akta_types' => DB::table('notary_akta_types')
                ->where('notaris_id', $notarisId)->get(),

            'relaas_types' => DB::table('relaas_types')
                ->where('notaris_id', $notarisId)->get(),

            'pic_staff' => DB::table('pic_staff')
                ->where('notaris_id', $notarisId)->get(),

            /*
            |--------------------------------------------------------------------------
            | DATA PERIODIK (PAKAI FILTER TANGGAL)
            |--------------------------------------------------------------------------
            */

            'notary_consultations' => DB::table('notary_consultations')
                ->where('notaris_id', $notarisId)
                ->whereBetween('created_at', [$start, $end])
                ->get(),

            'notary_akta_transactions' => DB::table('notary_akta_transactions')
                ->where('notaris_id', $notarisId)
                ->whereBetween('created_at', [$start, $end])
                ->get(),

            'notary_akta_documents' => DB::table('notary_akta_documents')
                ->where('notaris_id', $notarisId)
                ->whereBetween('created_at', [$start, $end])
                ->get(),

            'notary_akta_parties' => DB::table('notary_akta_parties')
                ->where('notaris_id', $notarisId)
                ->whereBetween('created_at', [$start, $end])
                ->get(),

            'notary_akta_logs' => DB::table('notary_akta_logs')
                ->where('notaris_id', $notarisId)
                ->whereBetween('created_at', [$start, $end])
                ->get(),

            'notary_relaas_aktas' => DB::table('notary_relaas_aktas')
                ->where('notaris_id', $notarisId)
                ->whereBetween('created_at', [$start, $end])
                ->get(),

            'notary_relaas_documents' => DB::table('notary_relaas_documents')
                ->where('notaris_id', $notarisId)
                ->whereBetween('created_at', [$start, $end])
                ->get(),

            'notary_relaas_parties' => DB::table('notary_relaas_parties')
                ->where('notaris_id', $notarisId)
                ->whereBetween('created_at', [$start, $end])
                ->get(),

            'notary_relaas_logs' => DB::table('notary_relaas_logs')
                ->where('notaris_id', $notarisId)
                ->whereBetween('created_at', [$start, $end])
                ->get(),

            'notary_legalisasis' => DB::table('notary_legalisasis')
                ->where('notaris_id', $notarisId)
                ->whereBetween('created_at', [$start, $end])
                ->get(),

            'notary_waarmerkings' => DB::table('notary_waarmerkings')
                ->where('notaris_id', $notarisId)
                ->whereBetween('created_at', [$start, $end])
                ->get(),

            'notary_letters' => DB::table('notary_letters')
                ->where('notaris_id', $notarisId)
                ->whereBetween('created_at', [$start, $end])
                ->get(),

            'pic_documents' => DB::table('pic_documents')
                ->where('notaris_id', $notarisId)
                ->whereBetween('created_at', [$start, $end])
                ->get(),

            'pic_processes' => DB::table('pic_processes')
                ->where('notaris_id', $notarisId)
                ->whereBetween('created_at', [$start, $end])
                ->get(),

            'pic_hand_overs' => DB::table('pic_hand_overs')
                ->where('notaris_id', $notarisId)
                ->whereBetween('created_at', [$start, $end])
                ->get(),

            'notary_costs' => DB::table('notary_costs')
                ->where('notaris_id', $notarisId)
                ->whereBetween('created_at', [$start, $end])
                ->get(),

            'notary_paymentts' => DB::table('notary_paymentts')
                ->where('notaris_id', $notarisId)
                ->whereBetween('created_at', [$start, $end])
                ->get(),
        ];

        $fileName = 'backup-notaris-' . $notarisId . '-' . now()->format('Ymd_His') . '.json';

        if (!Storage::disk('local')->exists('backup')) {
            Storage::disk('local')->makeDirectory('backup');
        }

        Storage::disk('local')->put(
            'backup/' . $fileName,
            json_encode($backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil Backup');

        return response()->download(
            storage_path('app/backup/' . $fileName)
        );
    }



    // public function restore(Request $request)
    // {

    //     $request->validate([
    //         'file' => 'required|file|mimes:json',
    //     ]);

    //     $json = file_get_contents($request->file('file')->getRealPath());
    //     $data = json_decode($json, true);

    //     if (!$data || !isset($data['meta']['notaris_id'])) {
    //         throw new \Exception('File backup tidak valid');
    //     }


    //     if ($data['meta']['notaris_id'] !== auth()->user()->notaris_id) {
    //         notyf()->error('File backup bukan milik akun ini');
    //         return back();
    //     }

    //     DB::transaction(function () use ($data) {

    //         $notarisId = $data['meta']['notaris_id'];

    //         DB::statement('SET FOREIGN_KEY_CHECKS=0');

    //         // TABLE YANG BERELASI DENGAN NOTARIS
    //         $tables = [
    //             'clients',
    //             'subscriptions',
    //             'notary_consultations',
    //             'notary_client_documents',
    //             'notary_client_warkahs',
    //             'notary_akta_types',
    //             'notary_akta_documents',
    //             'notary_akta_parties',
    //             'notary_akta_logs',
    //             'relaas_types',
    //             'notary_akta_transactions',
    //             'notary_relaas_aktas',
    //             'notary_relaas_parties',
    //             'notary_relaas_documents',
    //             'notary_relaas_logs',
    //             'notary_legalisasis',
    //             'notary_waarmerkings',
    //             'notary_letters',
    //             'pic_staff',
    //             'pic_processes',
    //             'pic_documents',
    //             'pic_hand_overs',
    //             'notary_costs',
    //             'notary_paymentts',

    //         ];

    //         foreach ($tables as $table) {
    //             DB::table($table)->where('notaris_id', $notarisId)->delete();
    //         }

    //         DB::statement('SET FOREIGN_KEY_CHECKS=1');

    //         /**
    //          * RESTORE NOTARIS
    //          */
    //         if (!empty($data['notaris'])) {
    //             DB::table('notaris')->updateOrInsert(
    //                 ['id' => $notarisId],
    //                 collect($data['notaris'])
    //                     ->except(['deleted_at'])
    //                     ->toArray()
    //             );
    //         }

    //         /**
    //          * RESTORE DATA RELASI
    //          */
    //         foreach ($tables as $table) {
    //             if (!empty($data[$table])) {
    //                 $rows = collect($data[$table])->map(function ($row) {
    //                     return collect($row)->except(['deleted_at'])->toArray();
    //                 })->toArray();

    //                 DB::table($table)->insert($rows);
    //             }
    //         }
    //     });

    //     notyf()->position('x', 'right')->position('y', 'top')->success('Restore berhasil');
    //     return back();
    // }

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

        $notarisId = $data['meta']['notaris_id'];

        if ($notarisId !== auth()->user()->notaris_id) {
            notyf()->error('File backup bukan milik akun ini');
            return back();
        }

        DB::transaction(function () use ($data, $notarisId) {

            /**
             * 1️⃣ RESTORE NOTARIS (SAFE UPSERT)
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
             * 2️⃣ UNIQUE KEY MAP
             * WAJIB sesuai business unique key masing-masing table
             */
            $uniqueKeyMap = [
                'clients' => ['id'],
                'subscriptions' => ['id'],
                'notary_consultations' => ['id'],
                'documents' => ['id'],
                'notary_client_warkahs' => ['id'],
                'notary_akta_types' => ['id'],
                'notary_akta_documents' => ['id'],
                'notary_akta_parties' => ['id'],
                'notary_akta_logs' => ['id'],
                'relaas_types' => ['id'],
                'notary_akta_transactions' => ['transaction_code'],
                'notary_relaas_aktas' => ['id'],
                'notary_relaas_parties' => ['id'],
                'notary_relaas_documents' => ['id'],
                'notary_relaas_logs' => ['id'],
                'notary_legalisasis' => ['id'],
                'notary_waarmerkings' => ['id'],
                'notary_letters' => ['id'],
                'pic_staff' => ['id'],
                'pic_processes' => ['id'],
                'pic_documents' => ['id'],
                'pic_hand_overs' => ['id'],
                'notary_costs' => ['payment_code'],
                'notary_paymentts' => ['id'],
            ];

            /**
             * 3️⃣ RESTORE RELASI (UPSERT BATCH)
             */
            foreach ($uniqueKeyMap as $table => $uniqueColumns) {

                if (empty($data[$table])) {
                    continue;
                }

                $hasNotarisColumn = Schema::hasColumn($table, 'notaris_id');

                $rows = collect($data[$table])
                    ->map(function ($row) use ($notarisId, $hasNotarisColumn) {

                        $row = collect($row)
                            ->except(['deleted_at'])
                            ->toArray();

                        if ($hasNotarisColumn) {
                            $row['notaris_id'] = $notarisId;
                        }

                        return $row;
                    })
                    ->toArray();

                // $rows = collect($data[$table])
                //     ->map(function ($row) use ($notarisId) {
                //         return collect($row)
                //             ->except(['deleted_at'])
                //             ->put('notaris_id', $notarisId)
                //             ->toArray();
                //     })
                //     ->toArray();

                if (empty($rows)) {
                    continue;
                }

                $updateColumns = array_diff(
                    array_keys($rows[0]),
                    $uniqueColumns
                );

                DB::table($table)->upsert(
                    $rows,
                    $uniqueColumns,
                    $updateColumns
                );
            }
        });

        notyf()
            ->position('x', 'right')
            ->position('y', 'top')
            ->success('Restore berhasil');

        return back();
    }


    // public function restore(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|file|mimes:json',
    //     ]);

    //     try {

    //         $json = file_get_contents($request->file('file')->getRealPath());
    //         $data = json_decode($json, true);

    //         if (!$data || !isset($data['meta']['notaris_id'])) {
    //             throw new \Exception('File backup tidak valid');
    //         }

    //         $notarisId = $data['meta']['notaris_id'];

    //         // VALIDASI KEPEMILIKAN
    //         if ($notarisId !== auth()->user()->notaris_id) {
    //             notyf()
    //                 ->position('x', 'right')
    //                 ->position('y', 'top')
    //                 ->error('File backup bukan milik akun ini');
    //             return back();
    //         }

    //         DB::transaction(function () use ($data, $notarisId) {

    //             DB::statement('SET FOREIGN_KEY_CHECKS=0');

    //             $tables = [
    //                 'clients',
    //                 'notary_consultations',
    //                 'notary_client_documents',
    //                 'notary_client_warkahs',
    //                 'notary_akta_types',
    //                 'notary_akta_documents',
    //                 'notary_akta_parties',
    //                 'notary_akta_logs',
    //                 'relaas_types',
    //                 'notary_akta_transactions',
    //                 'notary_relaas_aktas',
    //                 'notary_relaas_parties',
    //                 'notary_relaas_documents',
    //                 'notary_relaas_logs',
    //                 'notary_legalisasis',
    //                 'notary_waarmerkings',
    //                 'pic_staff',
    //                 'pic_processes',
    //                 'pic_documents',
    //                 'pic_hand_overs',
    //                 'notary_costs',
    //                 'notary_paymentts',
    //             ];

    //             foreach ($tables as $table) {
    //                 DB::table($table)
    //                     ->where('notaris_id', $notarisId)
    //                     ->delete();
    //             }

    //             DB::statement('SET FOREIGN_KEY_CHECKS=1');

    //             // RESTORE NOTARIS
    //             if (!empty($data['notaris'])) {
    //                 DB::table('notaris')->updateOrInsert(
    //                     ['id' => $notarisId],
    //                     collect($data['notaris'])
    //                         ->except(['deleted_at'])
    //                         ->toArray()
    //                 );
    //             }

    //             // INSERT ULANG
    //             foreach ($tables as $table) {

    //                 if (!empty($data[$table])) {

    //                     $rows = collect($data[$table])
    //                         ->map(
    //                             fn($row) =>
    //                             collect($row)
    //                                 ->except(['deleted_at'])
    //                                 ->toArray()
    //                         )
    //                         ->toArray();

    //                     DB::table($table)->insert($rows);
    //                 }
    //             }
    //         });

    //         notyf()
    //             ->position('x', 'right')
    //             ->position('y', 'top')
    //             ->success('Restore berhasil');

    //         return back();
    //     } catch (\Illuminate\Database\QueryException $e) {

    //         notyf()
    //             ->position('x', 'right')
    //             ->position('y', 'top')
    //             ->error('Restore gagal (Database Error): ' . $e->getMessage());

    //         return back();
    //     } catch (\Throwable $e) {

    //         notyf()
    //             ->position('x', 'right')
    //             ->position('y', 'top')
    //             ->error('Restore gagal: ' . $e->getMessage());

    //         return back();
    //     }
    // }

    // public function restore(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|file|mimes:json',
    //     ]);

    //     try {

    //         $json = file_get_contents($request->file('file')->getRealPath());
    //         $data = json_decode($json, true);

    //         if (!$data || !isset($data['meta']['notaris_id'])) {
    //             throw new \Exception('File backup tidak valid');
    //         }

    //         $notarisId = $data['meta']['notaris_id'];

    //         if ($notarisId !== auth()->user()->notaris_id) {
    //             notyf()->position('x', 'right')->position('y', 'top')
    //                 ->error('File backup bukan milik akun ini');
    //             return back();
    //         }

    //         DB::transaction(function () use ($data, $notarisId) {

    //             $tables = [
    //                 'clients' => ['client_code'],
    //                 'notary_akta_transactions' => ['transaction_code'],
    //                 'notary_relaas_aktas' => ['transaction_code'],
    //                 // 'notary_costs' => ['payment_code'],
    //             ];

    //             /**
    //              * RESTORE NOTARIS (UPsert)
    //              */
    //             if (!empty($data['notaris'])) {
    //                 DB::table('notaris')->updateOrInsert(
    //                     ['id' => $notarisId],
    //                     collect($data['notaris'])
    //                         ->except(['deleted_at'])
    //                         ->toArray()
    //                 );
    //             }

    //             /**
    //              * MERGE RESTORE (UPSERT)
    //              */
    //             foreach ($tables as $table => $uniqueColumns) {

    //                 if (!empty($data[$table])) {

    //                     $rows = collect($data[$table])
    //                         ->map(function ($row) {
    //                             return collect($row)
    //                                 ->except(['deleted_at'])
    //                                 ->toArray();
    //                         })
    //                         ->toArray();

    //                     $updateColumns = array_diff(
    //                         array_keys($rows[0]),
    //                         $uniqueColumns
    //                     );

    //                     DB::table($table)->upsert(
    //                         $rows,
    //                         $uniqueColumns,
    //                         $updateColumns
    //                     );
    //                 }
    //             }
    //         });

    //         notyf()->position('x', 'right')->position('y', 'top')
    //             ->success('Restore berhasil');

    //         return back();
    //     } catch (\Illuminate\Database\QueryException $e) {

    //         notyf()->position('x', 'right')->position('y', 'top')
    //             ->error('Database error: ' . $e->getMessage());

    //         return back();
    //     } catch (\Throwable $e) {

    //         notyf()->position('x', 'right')->position('y', 'top')
    //             ->error('Restore gagal: ' . $e->getMessage());

    //         return back();
    //     }
    // }
}
