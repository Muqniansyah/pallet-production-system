        <?php

        use App\Http\Controllers\ProfileController;
        use Illuminate\Support\Facades\Route;
        // controller
        use App\Http\Controllers\Admin\ClientController;
        use App\Http\Controllers\Client\MeetController;
        use App\Http\Controllers\Admin\AdminMeetingController;
        use App\Http\Controllers\Client\MeetingRequestController;
        use App\Http\Controllers\Admin\HppController;
        use App\Http\Controllers\Admin\OrderController as AdminOrderController;
        use App\Http\Controllers\Client\OrderController;
        use App\Http\Controllers\Client\PalletRequestController;
        use App\Http\Controllers\Admin\PalletRequestController as AdminPalletRequestController;
        use App\Http\Controllers\Client\DashboardController;
        use App\Http\Controllers\Client\InformasiController;
        use App\Http\Controllers\Client\ReferensiController;
        use App\Http\Controllers\Client\PaletDesignController;

        Route::get('/', function () {
            return view('sipalet');
        });

        // WAJIB: dashboard fallback (biar Breeze tidak error) - redirect dashboard
        Route::get('/dashboard', function () {
            if (auth()->user()->role === 'admin') {
                return redirect('/admin/dashboard');
            }
            return redirect('/client/dashboard');
        })->middleware(['auth'])->name('dashboard');


        // ADMIN dashboard
        Route::middleware(['auth', 'isAdmin'])->prefix('admin')->group(function () {

            Route::get('/dashboard', function () {
                return view('admin.dashboard');
            });

            // client
            Route::get('/client', [ClientController::class, 'index']);
            Route::patch('/client/{id}/role', [ClientController::class, 'updateRole'])
                ->name('admin.client.updateRole');

            // meet
            Route::get('/meeting', [AdminMeetingController::class, 'index']);
            Route::post('/meeting/{id}/approve', [AdminMeetingController::class, 'approve']);
            Route::post('/meeting/{id}/reject', [AdminMeetingController::class, 'reject']);

            // hpp
            Route::get('/hpp', [HppController::class, 'index'])->name('admin.hpp');
            // hpp upload
            Route::post('/hpp/upload', [HppController::class, 'store'])->name('admin.hpp.store');

            // order
            Route::post('/orders', [AdminOrderController::class, 'store'])->name('admin.orders.store');
            Route::post('/orders/{id}/{status}', [AdminOrderController::class, 'updateStatus'])
                ->name('admin.orders.updateStatus');

            // pallet request
            Route::get('/pallet-request', [AdminPalletRequestController::class, 'index'])
                ->name('admin.pallet.index');

            Route::post('/pallet-request/{id}/approve', [AdminPalletRequestController::class, 'approve']);
            Route::post('/pallet-request/{id}/reject', [AdminPalletRequestController::class, 'reject']);
        });


        // CLIENT dashboard
        Route::middleware(['auth'])->prefix('client')->group(function () {

            // dashboard
            Route::get('/dashboard', [DashboardController::class, 'index']);

            // meet
            Route::get('/meet', [MeetController::class, 'index']);
            Route::get('/meeting-request', [MeetingRequestController::class, 'index']);
            Route::post('/meeting-request', [MeetingRequestController::class, 'store']);

            // request palet
            Route::get('/pallet-request', [PalletRequestController::class, 'index'])
                ->name('client.pallet.index');
            Route::post('/pallet-request', [PalletRequestController::class, 'store'])
                ->name('client.pallet.store');

            // order
            Route::get('/orders', [OrderController::class, 'index'])
                ->name('client.orders');

            Route::post('/orders/{id}/deal', [OrderController::class, 'setDeal'])
                ->name('client.orders.deal');

            // Reference
            Route::get('/referensi', [ReferensiController::class, 'index']);

            // informasi
            Route::get('/informasi', [InformasiController::class, 'index']);

            // Route untuk menerima data real-time dari Netlify (tidak perlu auth agar iframe bisa kirim)
            Route::post('/palet/sync', [PaletDesignController::class, 'sync'])
                ->name('client.palet.sync');

            // Route untuk mengambil data (perlu login)
            Route::get('/palet/designs', [PaletDesignController::class, 'index'])
                ->name('client.palet.index');
        });


        // PROFILE
        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

        require __DIR__ . '/auth.php';
