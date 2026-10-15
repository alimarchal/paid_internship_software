<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Adds the Bank of AJK employees (Muzaffarabad and Rawalakot regions) as shortlisted
 * candidates of batch "Batch-IBS-01". Safe to re-run: existing emails are skipped.
 * Initial password for every account: Password@2026
 */
return new class extends Migration
{
    private const BATCH = 'Batch-IBS-01';

    private const ORGANIZATION = 'Bank of Azad Jammu & Kashmir';

    /** region, name, qualification, designation, grade, PP/CP no, place of posting, cnic, contact, email */
    private function rows(): array
    {
        return [
            ['Muzaffarabad', 'Waqas Nabi', 'B.Com', 'Manager', 'AVP', 'PP-0452', 'District Complex Branch', '82203-4585089-5', '0345-5991149', 'manager0040@bankajk.com'],
            ['Muzaffarabad', 'Rukhsana Qureshi', 'BA/B.ED', 'Manager', 'AVP', 'CP-0630', 'Upper Adda Branch', '82203-5221833-0', '0301-5175339', 'manager0061@bankajk.com'],
            ['Muzaffarabad', 'Rabia Mehmood', 'MBA Finance', 'Manager', 'OG-I', 'PP-0445', 'Ladies Branch MZD', '82203-3577382-4', '0345-5185900', 'manager0053@bankajk.com'],
            ['Muzaffarabad', 'Naiza Kazmi', 'MBA', 'CRM', 'OG-III', 'PP-647', 'Ladies Branch MZD', '82203-72790192', '0310-9367126', 'operations00053@bankajk.com'],
            ['Muzaffarabad', 'Zaheer Ahmed Awan', 'BBA', 'Manager', 'OG-I', 'PP-0137', 'Brarkot Branch', '82202-6001781-7', '0315-3391495', 'manager0070@bankajk.com'],
            ['Muzaffarabad', 'Samina Toheed', 'M.Sc Socialogy', 'Operations Officer', 'OG-IV', 'PP-0658', 'Main Branch Muzaffarabad', '82203-0686055-6', '03030-888750', 'operations0001@bankajk.com'],
            ['Muzaffarabad', 'Malik Muhammad Asif', 'B.S Honours', 'Credit Officer', 'OG-I', 'PP-0302', 'Lower Plate Branch', '82203-2220283-1', '0344-9590193', 'manager0018@bankajk.com'],
            ['Muzaffarabad', 'Muhammad Shahbaz Rathore', 'BS', 'Operations Officer', 'OG-IV', 'PP-0663', 'Chakkar Branch', '82202-6227101-1', '0348-5111766', 'operations0022@bankajk.com'],
            ['Muzaffarabad', 'Sana Ajmal', 'MBA', 'Operations Officer', 'OG-III', 'PP-0644', 'Madina Market Branch', '82203-3919615-2', '033-65789156', 'operations0028@bankajk.com'],
            ['Muzaffarabad', 'Raja Muhammad Atiq Khan', 'MBA,MA', 'Credit Officer', 'OG-I', 'PP-0247', 'Madina Market Branch', '82203-1197633-3', '0346-5758776', 'manager0028@bankajk.com'],
            ['Muzaffarabad', 'Naeem Ahmed', 'MBA', 'Operations Officer', 'OG-I', 'PP-0407', 'Hattian bala Branch', '82202-0379180-9', '0345-0882963', 'operations0034@bankajk.com'],
            ['Muzaffarabad', 'Muhammad Faizan Latif', 'BS', 'Operations Officer', 'OG-III', 'CP-693', 'Gojra Bypass Branch', '82203-2760214-5', '0316-0851008', 'operations0067@bankajk.com'],
            ['Muzaffarabad', 'Aisha Imtiaz', 'M.SC Economic', 'Operations Officer', 'OG-II', 'PP-0525', 'PM House Road Branch', '82203-1690880-2', '0300-8339463', 'operations0077@bankajk.com'],
            ['Rawalakot', 'Muhammad Irfan', 'MBA', 'Manager', 'AVP', 'PP-054', 'Thorar Branch', '82101-0319185-3', '0345-5893813', 'rajairfanarif2100@gmail.com'],
            ['Rawalakot', 'Tayyeb Farooq', 'MA', 'Teller', 'OG-III', 'PP-0556', 'Main Branch Rawalakot', '82102-5444777-9', '0347-0543940', 'manager0006@bankajk.com'],
            ['Rawalakot', 'Muhammad Ajiab Abbasi', 'MBA', 'Manager', 'AVP', 'PP-0057', 'Balooch Branch', '82101-5896558-7', '0345-5939806', 'mhdajaibabbasi@gmail.com'],
            ['Rawalakot', 'Maknoon Shah', 'MBA', 'Credit Officer', 'OG-I', 'PP-075', 'Pallandri Branch', '82101-0314874-1', '0310-9449897', 'syedmaknoonfatmi548@gmail.com'],
            ['Rawalakot', 'Wajahat Khizer', 'BSCS', 'Operations Officer', 'OG-III', 'CP-705', 'Poniola', '82303-4584595-7', '0345-5549675', 'wjisardar333@gmail.com'],
            ['Rawalakot', 'Asad Safeer', 'B.Com', 'Operations Officer', 'OG-II', 'PP-389', 'Bagh Branch', '82101-8384285-3', '0308-8969523', 'asadsafeer447@gmail.com'],
            ['Rawalakot', 'Muhmmad Zubair Khan', 'MBA', 'Manager', 'OG-I', 'PP-361', 'Musliamabad Branch', '42501-1644376-1', '0313-9113243', 'khan.awan1979@gmail.com'],
            ['Rawalakot', 'Yasir Iqbal', 'M.Com', 'Operations Officer', 'OG-II', 'PP-458', 'Kahutta Branch', '82601-0345486-9', '0355-7190071', 'yasiriqbalfk@gmail.com'],
            ['Rawalakot', 'Humaira Javed', 'MBA', 'Manager', 'OG-I', 'PP-338', 'CMH Road Branch', '82303-8055665-2', '0371-9532408', 'humairajaved62@gmail.com'],
            ['Rawalakot', 'Shamaila Arif', 'MBA', 'Operations Manager', 'AVP', 'PP-263', 'Main Branch Rawalakot', '82303-6582611-0', '0345-0885387', 'malakhan.bajk47@gmail.com'],
            ['Rawalakot', 'Aneeka Farooq', 'MBA', 'Manager', 'AVP', 'PP-301', 'Khaigalla Branch', '82303-7301544-2', '0341-0182559', 'aneeqafarooq6@gmail.com'],
            ['Rawalakot', 'Nazia Khurshid', 'MBA', 'Operations Officer', 'OG-I', 'PP-371', 'PHS Branch', '82303-8638439-2', '0333-6755575', 'naziakhurshid41@gmail.com'],
        ];
    }

    public function up(): void
    {
        $now = now();
        $internRoleId = DB::table('roles')->where('name', 'Intern')->value('id');
        $decidedBy = DB::table('users')->where('email', 'dh_hrd@bankajk.com')->value('id');

        DB::table('batches')->insertOrIgnore(['name' => self::BATCH, 'created_at' => $now, 'updated_at' => $now]);

        $password = Hash::make('Password@2026');

        foreach ($this->rows() as [$region, $name, $qualification, $designation, $grade, $ppNo, $place, $cnic, $contact, $email]) {
            $email = strtolower(trim($email));
            if (DB::table('users')->where('email', $email)->exists()) {
                continue;
            }

            $digits = preg_replace('/\D/', '', $cnic);
            if (strlen($digits) === 13) {
                $cnic = substr($digits, 0, 5).'-'.substr($digits, 5, 7).'-'.substr($digits, 12);
            }

            $userId = DB::table('users')->insertGetId([
                'name' => trim($name),
                'email' => $email,
                'password' => $password,
                'email_verified_at' => $now,
                'cnic_number' => $cnic,
                'contact_number' => trim($contact),
                'district' => $region,
                'mailing_address' => trim($place),
                'batch_no' => self::BATCH,
                'profile_status' => 1,
                'status' => 'Shortlisted',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            if ($internRoleId) {
                DB::table('model_has_roles')->insert(['role_id' => $internRoleId, 'model_type' => 'App\\Models\\User', 'model_id' => $userId]);
            }

            DB::table('education')->insert([
                'user_id' => $userId,
                'education_level' => $qualification,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('experiences')->insert([
                'user_id' => $userId,
                'organization' => self::ORGANIZATION.' - '.$place,
                'designation' => $designation.' ('.$grade.', '.$ppNo.')',
                'government_private' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('comments')->insert([
                'user_id' => $userId,
                'user_id_comment_by' => $decidedBy,
                'comments' => 'Shortlisted - added from employee list ('.$region.' region)',
                'status' => 'Shortlisted',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        $ids = DB::table('users')->where('batch_no', self::BATCH)->pluck('id');
        DB::table('comments')->whereIn('user_id', $ids)->delete();
        DB::table('experiences')->whereIn('user_id', $ids)->delete();
        DB::table('education')->whereIn('user_id', $ids)->delete();
        DB::table('model_has_roles')->where('model_type', 'App\\Models\\User')->whereIn('model_id', $ids)->delete();
        DB::table('users')->whereIn('id', $ids)->delete();
        DB::table('batches')->where('name', self::BATCH)->delete();
    }
};
