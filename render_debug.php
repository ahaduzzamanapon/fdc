<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Producer;
use Illuminate\Support\Facades\View;

$producer = Producer::find(24);
if ($producer) {
    App::setLocale('bn');
    $html = View::make('producers.show_fields', ['producer' => $producer])->render();
    file_put_contents('debug_show_fields.html', $html);
    echo "Rendered HTML saved to debug_show_fields.html\n";
} else {
    echo "Producer 24 not found\n";
}
