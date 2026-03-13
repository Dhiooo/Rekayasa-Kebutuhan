<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Services\AlumniTrackingService;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    protected AlumniTrackingService $trackingService;

    public function __construct(AlumniTrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    /**
     * Display the dashboard with statistics.
     */
    public function index()
    {
        $stats = [
            'total' => Alumni::count(),
            'tracked' => Alumni::where('status', 'Teridentifikasi (Scholar/Web)')->count(),
            'need_verification' => Alumni::where('status', 'Perlu Verifikasi Manual')->count(),
            'not_found' => Alumni::where('status', 'Data Tidak Ditemukan')->count(),
            'untracked' => Alumni::where('status', 'Belum Dilacak')->count(),
        ];

        return view('alumni.dashboard', compact('stats'));
    }

    /**
     * Display the Master Data Alumni list with search.
     */
    public function master(Request $request)
    {
        $query = Alumni::query();
        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('study_program', 'like', "%{$search}%");
        }

        $alumnis = $query->latest()->get();

        return view('alumni.index', compact('alumnis'));
    }

    /**
     * Display the specified alumni profile.
     */
    public function show($id)
    {
        $alumni = Alumni::findOrFail($id);
        return view('alumni.show', compact('alumni'));
    }

    /**
     * Display the tracking management interface.
     */
    public function tracking()
    {
        $stats = [
            'total' => Alumni::count(),
            'tracked' => Alumni::where('status', 'Teridentifikasi (Scholar/Web)')->count(),
            'need_verification' => Alumni::where('status', 'Perlu Verifikasi Manual')->count(),
            'not_found' => Alumni::where('status', 'Data Tidak Ditemukan')->count(),
            'untracked' => Alumni::where('status', 'Belum Dilacak')->count(),
        ];

        $alumnis = Alumni::whereIn('status', ['Belum Dilacak', 'Perlu Verifikasi Manual', 'Data Tidak Ditemukan'])
                        ->latest()
                        ->get();
                        
        return view('alumni.tracking', compact('alumnis', 'stats'));
    }

    /**
     * Track a specific alumni.
     */
    public function track($id)
    {
        $alumni = Alumni::findOrFail($id);
        
        $this->trackingService->track($alumni);

        return redirect()->back()->with('success', "Pelacakan untuk {$alumni->name} berhasil diselesaikan.");
    }

    public function trackAll()
    {
        $untrackedAlumnis = Alumni::where('status', 'Belum Dilacak')->get();
        $count = 0;

        foreach ($untrackedAlumnis as $alumni) {
            $this->trackingService->track($alumni);
            $count++;
        }

        return redirect()->back()->with('success', "Berhasil melacak {$count} alumni dalam antrian.");
    }

    /**
     * Show the form for creating a new alumni.
     */
    public function create()
    {
        return view('alumni.create');
    }

    /**
     * Store a newly created alumni in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'study_program' => 'required|string|max:255',
            'graduation_year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
        ]);

        Alumni::create($validated);

        return redirect()->route('alumni.index')->with('success', 'Data alumni berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified alumni.
     */
    public function edit($id)
    {
        $alumni = Alumni::findOrFail($id);
        return view('alumni.edit', compact('alumni'));
    }

    /**
     * Update the specified alumni in storage.
     */
    public function update(Request $request, $id)
    {
        $alumni = Alumni::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'study_program' => 'required|string|max:255',
            'graduation_year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
        ]);

        $alumni->update($validated);

        return redirect()->route('alumni.index')->with('success', 'Data alumni berhasil diperbarui.');
    }

    /**
     * Remove the specified alumni from storage.
     */
    public function destroy($id)
    {
        $alumni = Alumni::findOrFail($id);
        $alumni->delete();

        return redirect()->route('alumni.master')->with('success', 'Data alumni berhasil dihapus dari sistem.');
    }

    /**
     * Manually verify the tracking result of an alumni.
     */
    public function verify(Request $request, $id)
    {
        $alumni = Alumni::findOrFail($id);

        $action = $request->input('action'); // 'valid' or 'reject'

        if ($action === 'valid') {
            $alumni->status = 'Teridentifikasi (Scholar/Web)';
        } elseif ($action === 'reject') {
            $alumni->status = 'Data Tidak Ditemukan';
            $alumni->confidence_score = 0;
            $alumni->best_link = null;
        }

        $alumni->save();

        return redirect()->back()->with('success', 'Verifikasi manual berhasil disimpan.');
    }
}
