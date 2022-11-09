<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWagonjwasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wagonjwas', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id')->unique();
            $table->string('surname')->nullable();
            $table->string('given_name')->nullable();
            $table->string('other_name')->unique();
            $table->string('tube_photo')->nullable();
            $table->string('patient_photo')->nullable();
            $table->date('dob')->nullable();
            $table->string('nok_name')->nullable();
            $table->string('patient_email')->nullable();
            $table->foreignId('facility_type_id')->nullable();
            $table->foreignId('facility_id')->nullable();
            $table->string('who_tested')->nullable();//newww
            $table->string('test_reason')->nullable();
            $table->string('gender')->nullable();
            $table->float('age')->nullable();
            $table->integer('phone_number')->nullable();//is it an integer kweli??
            $table->string('nationality')->nullable();
            $table->string('patient_district')->nullable();
            $table->string('swab_district')->nullable();
            $table->dateTime('collection_date')->nullable();
            $table->string('sample_type')->nullable();
            $table->string('ever_been_positive')->nullable();
            $table->string('ever_been_vaccinated')->nullable();
            $table->string('vaccine_dose1')->nullable();
            $table->string('vaccine_dose2')->nullable();
            $table->string('vaccine_dose3')->nullable();
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->string('lab_no')->nullable();
            $table->dateTime('date_recieved')->nullable();
            $table->foreignId('accessioned_by')->nullable()->references('id')->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->dateTime('accessioned_at')->nullable();
            $table->foreignId('entered_by')->nullable()->references('id')->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->dateTime('entered_at')->nullable();
            $table->string('receipt_no')->nullable();
            $table->string('test_arm')->nullable()->default('Clinical');
            $table->string('result')->nullable();
            $table->string('worksheet_no')->nullable();
            $table->string('rds_test_type')->nullable();
            $table->string('test_type')->nullable();
            $table->string('test_kit')->nullable();
            $table->string('ct_value')->nullable();
            $table->string('target1')->nullable();
            $table->string('target2')->nullable();
            $table->string('target3')->nullable();
            $table->string('target4')->nullable();
            $table->string('platform')->nullable();
            $table->string('platform_range')->nullable();
            $table->string('results_approver_name')->nullable();
            $table->string('approver_signature')->nullable();
            $table->string('igg_result')->nullable();
            $table->string('igm_result')->nullable();
            $table->foreignId('result_added_by')->nullable()->references('id')->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->dateTime('result_added_at')->nullable();
            $table->string('tat')->nullable();
            $table->text('comment')->nullable();
            $table->dateTime('result_updated_at')->nullable();
            $table->string('status')->default('Collected');
            $table->string('entry_type')->default('External');
            $table->string('doc_type')->default('Passport');
            $table->string('doc_no')->nullable();//->default('doc_no');
            $table->string('ct_value2')->nullable();
            $table->string('ct_value3')->nullable();
            $table->string('ct_value4')->nullable();
            $table->string('duplicate')->nullable();
            $table->string('tvs_link')->nullable();
            $table->string('rds_success')->nullable();
            $table->string('rds_failure')->nullable();
            $table->string('print_count')->nullable();
            $table->string('import_batch')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wagonjwas');
    }
}
