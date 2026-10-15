<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Wajahat Khizer (Rawalakot, Poniola branch) was skipped by the previous migration because his
 * email already had an account in Batch-02. That account is moved into Batch-IBS-01 and given
 * the same bank-employee experience row; his existing paper and profile data are left untouched.
 */
return new class extends Migration
{
    private const BATCH = 'Batch-IBS-01';

    private const EMAIL = 'wjisardar333@gmail.com';

    public function up(): void
    {
        $user = DB::table('users')->where('email', self::EMAIL)->first();
        if (! $user || $user->batch_no === self::BATCH) {
            return;
        }

        $now = now();
        DB::table('batches')->insertOrIgnore(['name' => self::BATCH, 'created_at' => $now, 'updated_at' => $now]);

        DB::table('users')->where('id', $user->id)->update([
            'batch_no' => self::BATCH,
            'status' => 'Shortlisted',
            'profile_status' => 1,
            'updated_at' => $now,
        ]);

        if (! DB::table('education')->where('user_id', $user->id)->exists()) {
            DB::table('education')->insert(['user_id' => $user->id, 'education_level' => 'BSCS', 'created_at' => $now, 'updated_at' => $now]);
        }

        DB::table('experiences')->insert([
            'user_id' => $user->id,
            'organization' => 'Bank of Azad Jammu & Kashmir - Poniola',
            'designation' => 'Operations Officer (OG-III, CP-705)',
            'government_private' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('comments')->insert([
            'user_id' => $user->id,
            'user_id_comment_by' => DB::table('users')->where('email', 'dh_hrd@bankajk.com')->value('id'),
            'comments' => 'Shortlisted - added from employee list (Rawalakot region)',
            'status' => 'Shortlisted',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        $user = DB::table('users')->where('email', self::EMAIL)->first();
        if (! $user) {
            return;
        }

        DB::table('experiences')->where('user_id', $user->id)->where('organization', 'Bank of Azad Jammu & Kashmir - Poniola')->delete();
        DB::table('comments')->where('user_id', $user->id)->where('comments', 'like', 'Shortlisted - added from employee list%')->delete();
        DB::table('users')->where('id', $user->id)->update(['batch_no' => 'Batch-02']);
    }
};
