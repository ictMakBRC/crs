<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreateWagonjwViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW `tat_per_entryb`  AS SELECT `wagonjwas`.`pat_no` AS `PatientNo`, `wagonjwas`.`lab_no` AS `LabNo`, 
            `wagonjwas`.`result` AS `Result`, 
            date_format(`wagonjwas`.`created_at`,'%Y-%m-%d') AS `DateCreated`, 
            date_format(`wagonjwas`.`created_at`,'%Y-%m') AS `MonthCreated`, 
            date_format(`wagonjwas`.`created_at`,'%Y-%v') AS `WeekCreated`,            
            date_format(`wagonjwas`.`created_at`,'%Y') AS `YearCreated`, quarter(`wagonjwas`.`created_at`) AS `Myquarter`, 
            timestampdiff(MINUTE,`wagonjwas`.`created_at`,`wagonjwas`.`accessioned_at`) AS `EntryToReceipt`, 
            timestampdiff(MINUTE,`wagonjwas`.`accessioned_at`,`wagonjwas`.`entered_at`) AS `ReceiptToVerification`, 
            timestampdiff(MINUTE,`wagonjwas`.`entered_at`,`wagonjwas`.`result_added_at`) AS `VerificationToResult`, 
            timestampdiff(MINUTE,`wagonjwas`.`accessioned_at`,`wagonjwas`.`result_added_at`) AS `ReceiptToResult`, 
            CASE ReceiptToResult
            WHEN ReceiptToResult > 1440 THEN 'out'  
            ELSE 'in'
            END AS class 
            timestampdiff(MINUTE,`wagonjwas`.`created_at`,`wagonjwas`.`result_added_at`) AS `EntryToResult` FROM `wagonjwas` ;

          
        ");
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
   
    public function down()

    {

        DB::statement('DROP VIEW IF EXISTS `tat_per_entry`;');

    }
}
