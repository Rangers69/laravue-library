<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Catalog;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\Member;
use App\Models\User;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $members = Member::with('user')->get();
        // $books = Book::with('publisher')->get();
        // $publisher = Publisher::with('books')->get();
        // $author = Author::with('books')->get();
        // $catalog = Catalog::with('books')->get();
        // $transaction = Transaction::with('transactionDetail')->get();
        // $transactionDetail = TransactionDetail::with('transaction')->get();


        //no 1
        $data1 = Member::select('*')
                    ->join('users','users.member_id','=','members.id')
                    ->get();

        //no 2
        $data2 = Member::select('*','members.name','members.id','members.email')
                    ->leftJoin('users','users.member_id','=','members.id')
                    ->where('users.id','=',NULL)
                    ->get();

         //coba 2
         $coba2 = Member::select('*')
                    ->whereNotIn('id',function($query)
                    {$query
                    ->select('member_id')->from('users');
                    })->get();
        
        //no 3
        $data3 = Transaction::select('members.id','members.name')
                    ->rightJoin('members','members.id','=','transactions.member_id')
                    ->where('transactions.member_id',NULL)
                    ->get();
        
        //coba 3
        $coba3 = Member::select('members.id','members.name')
                    ->whereNotIn('id',function($query)
                    {$query
                    ->select('member_id')->from('transactions');
                    })->get();

        //no 4
        $data4 = Member::select('members.id','members.name','members.phone_number')
                    ->join('transactions','transactions.member_id','=','members.id')
                    ->orderBy('members.id','asc')
                    ->get();

        //coba 4
        $coba4 = Member::select('members.id','members.name','members.phone_number')
                    ->whereIn('id',function($query)
                    {$query
                        ->select('member_id')->from('transactions');
                    })
                    ->orderBy('members.id','asc')
                    ->get();

        //no5 
        $data5 = Member::select('members.id', 'members.name', 'members.phone_number', DB::raw('COUNT(*) as transaction_member_count'))
                    ->join('transactions', 'members.id', 'transactions.member_id')
                    ->groupBy('members.id', 'members.name', 'members.phone_number')
                    ->having('transaction_member_count', '>', 1)
                    ->get();

        //no 6
        $data6 = Member::select('members.id','members.name','members.phone_number','members.address','transactions.date_start','transactions.date_end')
                    ->join('transactions','transactions.member_id','members.id')
                    ->get();

        //no 7 
        $data7 = Member::select('members.id','members.name','members.phone_number','members.address','transactions.date_start','transactions.date_end')
                  ->join('transactions','transactions.member_id','members.id')
                  ->whereMonth('date_end', 12)
                  ->get();

        //no 8         
        $data8 = Member::select('members.id','members.name','members.phone_number','members.address','transactions.date_start','transactions.date_end')
                  ->join('transactions','transactions.member_id','members.id')
                  ->whereMonth('date_start', 12)
                  ->get();


         //no 9         
         $data9 = Member::select('members.id','members.name','members.phone_number','members.address','transactions.date_start','transactions.date_end')
                ->join('transactions','transactions.member_id','members.id')
                ->whereMonth('date_start', 12)
                ->WhereMonth('date_end', 12)
                ->get();

        //no 10
        $data10 = Member::select('members.name','members.phone_number','members.address','transactions.date_start','transactions.date_end')
                ->join('transactions','transactions.member_id','members.id')
                ->where('address', '=', 'bandung')
                ->get();

        //no 11
        $data11 = Member::select('members.name','members.phone_number','members.address','transactions.date_start','transactions.date_end')
                ->join('transactions','transactions.member_id','members.id')
                ->where('address', '=', 'bandung')
                ->where('gender', '=', 'male')
                ->get();

        //no 12
        $data12 = Member::select('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end', 'books.isbn', 'transaction_details.qty')
                    ->join('transactions', 'members.id', 'transactions.member_id')
                    ->join('transaction_details', 'transactions.id', 'transaction_details.transaction_id')
                    ->join('books', 'books.id', 'transaction_details.book_id')
                    ->groupBy('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end', 'books.isbn', 'transaction_details.qty')
                    ->where('transaction_details.qty', '>', 1)
                    ->get();
        
        //no13
        $data13 = Member::select('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end', 'books.isbn', 'transaction_details.qty', 'books.title', 'books.price', DB::raw('SUM(transaction_details.qty * books.price) as total_price'))
                    ->join('transactions', 'members.id', 'transactions.member_id')
                    ->join('transaction_details', 'transactions.id', 'transaction_details.transaction_id')
                    ->join('books', 'books.id', 'transaction_details.book_id')
                    ->groupBy('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end', 'books.isbn', 'transaction_details.qty', 'books.title', 'books.price')
                    ->get();

        //no 14
        $data14 = Member::select('members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end', 'books.isbn', 'transaction_details.qty', 'books.title', 'publishers.name AS publisher_name', 'authors.name AS author_name', 'catalogs.name AS catalog_name')
                    ->join('transactions', 'members.id', 'transactions.member_id')
                    ->join('transaction_details', 'transactions.id', 'transaction_details.transaction_id')
                    ->join('books', 'books.id', 'transaction_details.book_id')
                    ->join('publishers', 'publishers.id', 'books.publisher_id')
                    ->join('authors', 'authors.id', 'books.author_id')
                    ->join('catalogs', 'catalogs.id', 'books.catalog_id')
                    ->get();

        //no 15
        $data15 = Catalog::select('catalogs.*', 'books.title AS book_title')
                    ->join('books', 'catalogs.id', 'books.catalog_id')
                    ->get();

        //no 16
        $data16 = Book::select('books.*', 'publishers.name AS publisher_name')
                    ->rightjoin('publishers', 'publishers.id', 'books.publisher_id')
                    ->get();

        //no 17
        $data17 = Book::select(DB::raw('COUNT(books.author_id) as total_author'))
                    ->join('authors', 'authors.id', 'books.author_id')
                    ->where('authors.name', 'Angie Kohler')
                    ->get();

        //no 18
        $data18 = Book::where('price', '>=', 17000)->get();

        $data19 = Book::select('books.*')
                    ->join('publishers','publishers.id', 'books.publisher_id')
                    ->where('publishers.name', 'Kallie Robel')
                    ->where('books.qty', '>', 10)
                    ->get();

        $data20 = Member::whereMonth('created_at', 12)->get();

        // return $data20;

        $all_members = Member::count();
        $all_books = Book::count();
        $all_transactions = Transaction::whereMonth('date_start', date('m'))->count();
        $all_publishers = Publisher::count();

        $label_donut = Publisher::orderBy('publisher_id')->join('books', 'books.publisher_id', 'publishers.id')->groupBy('publishers.name')->pluck('publishers.name');
        $data_donut = Book::select(DB::raw("COUNT(publisher_id) as total"))->groupBy('publisher_id')->orderBy('publisher_id')->pluck('total');

        $label_pie = Catalog::orderBy('catalog_id')->join('books', 'books.catalog_id', 'catalogs.id')->groupBy('catalogs.name')->pluck('catalogs.name');
        $data_pie = Book::select(DB::raw("COUNT(catalog_id) as total"))->groupBy('catalog_id')->orderBy('catalog_id')->pluck('total');

        // return $data_pie;
       

        $label_bar = ['Transactions',];
        $data_bar = [];

        foreach ($label_bar as $key => $value) {
            $data_bar[$key]['label'] = $label_bar[$key];
            $data_bar[$key]['backgroundColor'] = 'rgba(60, 141, 138, 0.9)';
            $data_month = [];

            foreach (range(1, 12) as $month) {
                $data_month[] = Transaction::select(DB::raw("COUNT(*) as total"))->whereMonth('date_start', $month)->first()->total;
            }

            $data_bar[$key]['data'] = $data_month;
        }

    
        return view('admin.dashboard',compact('all_members','all_books','all_transactions','all_publishers','data_donut','label_donut','data_bar','label_pie','data_pie'));
    }
}
