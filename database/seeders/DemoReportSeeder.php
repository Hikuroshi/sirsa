<?php

namespace Database\Seeders;

use App\Enums\AiStatus;
use App\Enums\ReportPriority;
use App\Enums\ReportStatus;
use App\Models\Category;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reporter = User::factory()->reporter()->create([
            'name' => 'Pelapor Demo',
            'username' => 'pelapordemo',
            'email' => 'pelapor@example.com',
        ]);

        $categories = collect([
            'Jalan dan Jembatan',
            'Drainase',
            'Penerangan Jalan',
            'Sampah dan Lingkungan',
            'Pelayanan Publik',
        ])->mapWithKeys(fn (string $name) => [$name => Category::factory()->create(['name' => $name])]);

        $admin = User::query()->where('username', 'testuser')->firstOrFail();

        $examples = [
            ['Jalan dan Jembatan', 'Jalan berlubang di dekat balai desa membuat pengendara harus menghindar dan berisiko jatuh saat malam hari.', ReportPriority::High, ReportStatus::Accepted, true],
            ['Drainase', 'Saluran air di sekitar pasar tersumbat sampah sehingga air meluap ke jalan setiap kali hujan deras.', ReportPriority::Medium, ReportStatus::Processing, false],
            ['Penerangan Jalan', 'Lampu penerangan di jalan menuju sekolah tidak menyala selama beberapa malam terakhir dan area menjadi gelap.', ReportPriority::High, ReportStatus::Completed, true],
            ['Sampah dan Lingkungan', 'Tumpukan sampah di lahan kosong dekat permukiman mulai menimbulkan bau dan mengundang serangga.', ReportPriority::Medium, ReportStatus::Rejected, false],
            ['Pelayanan Publik', 'Informasi jadwal pelayanan di kantor desa belum terlihat jelas sehingga warga sering datang di luar jam layanan.', ReportPriority::Low, ReportStatus::Accepted, true],
            ['Jalan dan Jembatan', 'Permukaan jembatan kecil di jalan desa terasa licin setelah hujan dan perlu diperiksa agar tidak membahayakan warga.', ReportPriority::Urgent, ReportStatus::Processing, true],
        ];

        foreach ($examples as [$categoryName, $description, $priority, $status, $hasAccount]) {
            $report = Report::factory()->create([
                'reporter_id' => $hasAccount ? $reporter->id : null,
                'reporter_name' => $hasAccount ? $reporter->name : fake()->name(),
                'category_id' => $categories[$categoryName]->id,
                'original_description' => $description,
                'description' => $description,
                'priority' => $priority,
                'status' => $status,
                'ai_status' => AiStatus::Disabled,
                'verified_by' => $status === ReportStatus::Accepted ? null : $admin->id,
                'verified_at' => $status === ReportStatus::Accepted ? null : now(),
            ]);

            $report->statusHistories()->create(['to_status' => ReportStatus::Accepted]);

            if ($status !== ReportStatus::Accepted) {
                $report->statusHistories()->create([
                    'changed_by' => $admin->id,
                    'from_status' => ReportStatus::Accepted,
                    'to_status' => $status === ReportStatus::Completed ? ReportStatus::Processing : $status,
                    'note' => 'Laporan telah ditinjau oleh petugas desa.',
                ]);
            }

            if ($status === ReportStatus::Completed) {
                $report->statusHistories()->create([
                    'changed_by' => $admin->id,
                    'from_status' => ReportStatus::Processing,
                    'to_status' => ReportStatus::Completed,
                    'note' => 'Penanganan laporan telah selesai.',
                ]);
            }
        }
    }
}
