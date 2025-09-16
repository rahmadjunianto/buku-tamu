<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FixGuestbookUuidMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if new_id column exists and drop it first
        if (Schema::hasColumn('guestbook', 'new_id')) {
            Schema::table('guestbook', function (Blueprint $table) {
                $table->dropColumn('new_id');
            });
        }
        
        // Create new table with UUID
        Schema::create('guestbook_new', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->string('telepon')->nullable();
            $table->string('instansi')->nullable();
            $table->text('keperluan');
            $table->unsignedBigInteger('bidang');
            $table->timestamp('check_in_at')->nullable();
            $table->timestamp('check_out_at')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->timestamps();
            
            $table->foreign('bidang')->references('id')->on('bidang');
        });
        
        // Copy data from old table to new table with UUIDs
        $guests = DB::table('guestbook')->get();
        foreach ($guests as $guest) {
            DB::table('guestbook_new')->insert([
                'id' => Str::uuid()->toString(),
                'nama' => $guest->nama,
                'telepon' => $guest->telepon,
                'instansi' => $guest->instansi,
                'keperluan' => $guest->keperluan,
                'bidang' => $guest->bidang,
                'check_in_at' => $guest->check_in_at,
                'check_out_at' => $guest->check_out_at,
                'duration_minutes' => $guest->duration_minutes,
                'created_at' => $guest->created_at,
                'updated_at' => $guest->updated_at,
            ]);
        }
        
        // Drop old table and rename new table
        Schema::dropIfExists('guestbook');
        Schema::rename('guestbook_new', 'guestbook');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Create old table structure
        Schema::create('guestbook_old', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('telepon')->nullable();
            $table->string('instansi')->nullable();
            $table->text('keperluan');
            $table->unsignedBigInteger('bidang');
            $table->timestamp('check_in_at')->nullable();
            $table->timestamp('check_out_at')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->timestamps();
            
            $table->foreign('bidang')->references('id')->on('bidang');
        });
        
        // Copy data back (this will lose UUID relationship)
        $guests = DB::table('guestbook')->get();
        foreach ($guests as $guest) {
            DB::table('guestbook_old')->insert([
                'nama' => $guest->nama,
                'telepon' => $guest->telepon,
                'instansi' => $guest->instansi,
                'keperluan' => $guest->keperluan,
                'bidang' => $guest->bidang,
                'check_in_at' => $guest->check_in_at,
                'check_out_at' => $guest->check_out_at,
                'duration_minutes' => $guest->duration_minutes,
                'created_at' => $guest->created_at,
                'updated_at' => $guest->updated_at,
            ]);
        }
        
        // Drop UUID table and rename back
        Schema::dropIfExists('guestbook');
        Schema::rename('guestbook_old', 'guestbook');
    }
}
