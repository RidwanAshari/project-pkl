public function up() {
    Schema::table('vehicle_details', function (Blueprint $table) {
        $table->string('jabatan')->nullable()->after('nama_pemilik');
        $table->string('nomor_plat')->nullable()->after('alamat');
    });
}