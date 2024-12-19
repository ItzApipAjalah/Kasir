public function up()
{
    Schema::create('transaction_details', function (Blueprint $table) {
        $table->id();
        $table->foreignId('transaction_id')->constrained();
        $table->foreignId('produk_id')->constrained();
        $table->integer('quantity');
        $table->decimal('harga', 10, 2);
        $table->decimal('total', 10, 2);  // Add this line if it doesn't exist
        $table->timestamps();
    });
}
