namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        // logika untuk menampilkan laporan
        return view('laporan.index');
    }
}