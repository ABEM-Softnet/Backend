use Illuminate\Http\Request;
use App\Models\Revenue;
use App\Models\School;
use App\Models\Branch;

class RevenueController extends Controller
{
    public function index()
    {
        // Retrieve all revenue entries
        $revenues = Revenue::all();
        return response()->json($revenues);
    }

    public function store(Request $request)
    {
        // Create a new revenue entry
        $revenue = Revenue::create($request->all());
        return response()->json($revenue, 201);
    }

    public function getTotalRevenue(Request $request)
    {
        // Get total revenue for the current month
        $totalRevenue = Revenue::whereMonth('date', now()->month)->sum('amount');
        
        return response()->json(['total_revenue' => $totalRevenue]);
    }

    public function getRevenueForBranchOrSchool(Request $request, $schoolId, $branchId = null)
    {
        $school = School::findOrFail($schoolId);

        if ($branchId) {
            // If a branch ID is provided, get revenue for the specific branch
            $branch = Branch::where('school_id', $schoolId)->findOrFail($branchId);
            $revenue = $branch->revenues->sum('amount');
        } else {
            // If no branch ID is provided, get total revenue for the school
            $revenue = $school->revenues->sum('amount');
        }

        return response()->json(['revenue' => $revenue]);
    }

    public function getRevenueByTypeAndMethod(Request $request)
    {
        // Group revenues by type and payment method
        $revenueData = Revenue::select('type', 'payment_method', \DB::raw('SUM(amount) as total_amount'))
            ->groupBy('type', 'payment_method')
            ->get();
        
        return response()->json($revenueData);
    }
}