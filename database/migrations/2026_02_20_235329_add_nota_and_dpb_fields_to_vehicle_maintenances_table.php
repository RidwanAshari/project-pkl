// database/migrations/2026_02_20_235329_add_nota_and_dpb_fields_to_vehicle_maintenances_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotaAndDpbFieldsToVehicleMaintenancesTable extends Migration
{
    public function up()
    {
        Schema::table('vehicle_maintenances', function (Blueprint $table) {
            // Menambahkan kolom untuk nota dan status DPB
            $table->text('nota')->nullable(); 
            $table->enum('dpb_status', ['pending', 'approved', 'printed'])->default('pending'); 
        });
    }

    public function down()
    {
        Schema::table('vehicle_maintenances', function (Blueprint $table) {
            $table->dropColumn('nota');
            $table->dropColumn('dpb_status');
        });
    }
}