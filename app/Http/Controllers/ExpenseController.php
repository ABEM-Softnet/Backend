use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index()
    {
        // Retrieve all expense entries
        $expenses = Expense::all();
        return response()->json($expenses);
    }

    public function store(Request $request)
    {
        // Create a new expense entry
        $expense = Expense::create($request->all());
        return response()->json($expense, 201);
    }

    public function getTotalExpense(Request $request)
    {
        // Get total expenses for the current week
        $totalExpense = Expense::whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])->sum('amount');
        
        return response()->json(['total_expense' => $totalExpense]);
    }

    public function getExpenseByTypeAndTime(Request $request)
    {
        // Group expenses by type and time
        $expenseData = Expense::select('type', \DB::raw('YEAR(date) as year'), \DB::raw('MONTH(date) as month'), \DB::raw('SUM(amount) as total_amount'))
            ->groupBy('type', 'year', 'month')
            ->get();
        
        return response()->json($expenseData);
    }
}