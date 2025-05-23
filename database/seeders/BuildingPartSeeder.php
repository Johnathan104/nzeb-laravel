<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BuildingPart;

class BuildingPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data for mekanikal
        $slides_mekanikal = [
            ["url" => "/Simanteb/panel.png", "title" => "Panel", "pemeriksaan" => "3 bulanan", "pemliharaan" => "6 bulanan", "perawatan" => "rehabilitasi", "tipe" => "Pekerjaan Tata Udara"],
            ["url" => "/Simanteb/air-conditioner.png", "title" => "Air Conditioner", "pemeriksaan" => "bulanan", "pemliharaan" => "6 bulanan", "perawatan" => "rehabilitasi", "tipe" => "Pekerjaan Tata Udara"],
            ["url" => "/Simanteb/lift-guru.png", "title" => "Lift Guru", "pemeriksaan" => "3 bulanan", "pemliharaan" => "tahunan", "perawatan" => "rehabilitasi", "tipe" => "Pekerjaan Transportasi Vertikal"],
            ["url" => "/Simanteb/ups.png", "title" => "UPS", "pemeriksaan" => "tahunan", "pemliharaan" => "tahunan", "perawatan" => "rehabilitasi", "tipe" => "Power Supply"],
            ["url" => "/Simanteb/solar-panel.png", "title" => "Solar Panel", "pemeriksaan" => "bulanan", "pemliharaan" => "bulanan", "perawatan" => "restorasi", "tipe" => "Power Supply"],
            ["url" => "/Simanteb/panel-beban.png", "title" => "Panel Beban", "pemeriksaan" => "mingguan", "pemliharaan" => "bulanan", "perawatan" => "rehabilitasi", "tipe" => "Power Supply"],
            ["url" => "/Simanteb/sistem-penerangan.png", "title" => "Sistem Penerangan", "pemeriksaan" => "harian", "pemliharaan" => "3 bulanan", "perawatan" => "restorasi", "tipe" => "Power Supply"],
            ["url" => "/Simanteb/kontrol-penerangan.png", "title" => "Sistem Kontrol Penerangan", "pemeriksaan" => "bulanan", "pemliharaan" => "3 bulanan", "perawatan" => "rehabilitasi", "tipe" => "Power Supply"],
            ["url" => "/Simanteb/stop-kontak.png", "title" => "Stop Kontak dan Saklar", "pemeriksaan" => "Mingguan", "pemliharaan" => "Bulanan", "perawatan" => "renovasi", "tipe" => "Power Supply"],
            ["url" => "/Simanteb/penangkal-petir.png", "title" => "Sistem Penangkal Petir", "pemeriksaan" => "Mingguan", "pemliharaan" => "Bulanan", "perawatan" => "restorasi", "tipe" => "Power Supply"],
            ["url" => "/Simanteb/fire-alarm.png", "title" => "Sistem Fire Alarm", "pemeriksaan" => "bulanan", "pemliharaan" => "6 Bulanan", "perawatan" => "rehabilitasi", "tipe" => "Sistem Elektronika"],
            ["url" => "/Simanteb/tata-suara.png", "title" => "Tata Suara", "pemeriksaan" => "bulanan", "pemliharaan" => "3 Bulanan", "perawatan" => "rehabilitasi", "tipe" => "Sistem Elektronika"],
            ["url" => "/Simanteb/sistem-internet.png", "title" => "Sistem Jaringan Internet", "pemeriksaan" => "6 bulanan", "pemliharaan" => "tahunan", "perawatan" => "rehabilitasi", "tipe" => "Sistem Elektronika"],
            ["url" => "/Simanteb/cctv.png", "title" => "CCTV", "pemeriksaan" => "bulanan", "pemliharaan" => "tahunan", "perawatan" => "rehabilitasi", "tipe" => "Sistem Elektronika"],
            ["url" => "/Simanteb/sistem-absensi.png", "title" => "Sistem Absensi", "pemeriksaan" => "bulanan", "pemliharaan" => "3 Bulanan", "perawatan" => "restorasi", "tipe" => "Sistem Elektronika"],
            ["url" => "/Simanteb/penguat-sinyal.png", "title" => "Sistem Penguat Sinyal", "pemeriksaan" => "bulanan", "pemliharaan" => "3 Bulanan", "perawatan" => "rehabilitasi", "tipe" => "Sistem Elektronika"],
        ];

        // Data for arsitektur
        $slides_arsitektur = [
            ["url" => "/Simanteb/plafon.png", "title" => "Plafon (Finishing Beton Expose)", "pemeriksaan" => "tahunan", "pemliharaan" => "tahunan", "perawatan" => "rehabilitasi", "tipe" => "Pekerjaan Plafon"],
            ["url" => "/Simanteb/plafon_gypsum.png", "title" => "Plafon Gypsum", "pemeriksaan" => "Bulanan", "pemliharaan" => "bulanan", "perawatan" => "rehabilitasi", "tipe" => "Pekerjaan Plafon"],
            ["url" => "/Simanteb/dindin_bata_interior.png", "title" => "Dinding Bata Cat Interior", "pemeriksaan" => "tahunan", "pemliharaan" => "tahunan", "perawatan" => "renovasi", "tipe" => "Pekerjaan Dinding"],
            ["url" => "/Simanteb/dinding_basah.png", "title" => "Dinding Bata Keramik Area Basah", "pemeriksaan" => "mingguan", "pemliharaan" => "mingguan", "perawatan" => "renovasi", "tipe" => "Pekerjaan Dinding"],
            ["url" => "/Simanteb/floor_hardener.png", "title" => "Lantai Floor Hardener", "pemeriksaan" => "mingguan", "pemliharaan" => "mingguan", "perawatan" => "renovasi", "tipe" => "Pekerjaan Lantai"],
            ["url" => "/Simanteb/lantai_keramik_kering.png", "title" => "Lantai Keramik Area Kering", "pemeriksaan" => "mingguan", "pemliharaan" => "mingguan", "perawatan" => "renovasi", "tipe" => "Pekerjaan Lantai"],
            ["url" => "/Simanteb/lantai_keramik_basah.png", "title" => "Lantai Keramik Area basah", "pemeriksaan" => "mingguan", "pemliharaan" => "mingguan", "perawatan" => "renovasi", "tipe" => "Pekerjaan Lantai"],
            ["url" => "/Simanteb/pintu_kayu.png", "title" => "Pintu Kayu dan Kusen Kayu", "pemeriksaan" => "Tahunan", "pemliharaan" => "3-5 tahunan", "perawatan" => "rehabilitasi", "tipe" => "Pekerjaan Pintu dan Jendela"],
            ["url" => "/Simanteb/pintu_pvc.png", "title" => "Pintu PVC", "pemeriksaan" => "Tahunan", "pemliharaan" => "3-5 tahunan", "perawatan" => "rehabilitasi", "tipe" => "Pekerjaan Pintu dan Jendela"],
            ["url" => "/Simanteb/jendela.png", "title" => "Jendela", "pemeriksaan" => "Tahunan", "pemliharaan" => "3-5 tahunan", "perawatan" => "rehabilitasi", "tipe" => "Pekerjaan Pintu dan Jendela"],
        ];

        // Data for struktur
        $slides_struktur = [
            ["url" => "/Simanteb/pondasi_dalam.png", "title" => "pondasi dalam", "pemeriksaan" => "3-5 tahunan", "pemliharaan" => "3-5 tahunan", "perawatan" => "rehabilitasi", "tipe" => "struktur bawah"],
            ["url" => "/Simanteb/pile_cap.png", "title" => "pile cap", "pemeriksaan" => "3-5 tahunan", "pemliharaan" => "3-5 tahunan", "perawatan" => "rehabilitasi", "tipe" => "struktur bawah"],
            ["url" => "/Simanteb/tie_beam.png", "title" => "tie beam", "pemeriksaan" => "tahunan", "pemliharaan" => "3-5 tahunan", "perawatan" => "rehabilitasi", "tipe" => "struktur bawah"],
            ["url" => "/Simanteb/kolom_struktur.png", "title" => "kolom struktur praktis", "pemeriksaan" => "tahunan", "pemliharaan" => "3-5 tahunan", "perawatan" => "rehabilitasi", "tipe" => "struktur atas"],
            ["url" => "/Simanteb/balok_induk_anak.png", "title" => "balok induk anak", "pemeriksaan" => "3-5 tahunan", "pemliharaan" => "3-5 tahunan", "perawatan" => "rehabilitasi", "tipe" => "struktur atas"],
            ["url" => "/Simanteb/pelat_lantai.png", "title" => "pelat lantai", "pemeriksaan" => "3-5 tahunan", "pemliharaan" => "3-5 tahunan", "perawatan" => "rehabilitasi", "tipe" => "struktur atas"],
            ["url" => "/Simanteb/tangga.png", "title" => "tangga", "pemeriksaan" => "3-5 tahunan", "pemliharaan" => "3-5 tahunan", "perawatan" => "rehabilitasi", "tipe" => "struktur atas"],
            ["url" => "/Simanteb/sheer_wall.png", "title" => "sheer wall", "pemeriksaan" => "3-5 tahunan", "pemliharaan" => "3-5 tahunan", "perawatan" => "rehabilitasi", "tipe" => "struktur atas"],
            ["url" => "/Simanteb/atap_duck_beton.png", "title" => "atap duck beton", "pemeriksaan" => "3-5 tahunan", "pemliharaan" => "3-5 tahunan", "perawatan" => "rehabilitasi", "tipe" => "struktur atas"],
        ];

        // Insert data into the database
        foreach ($slides_mekanikal as $item) {
            BuildingPart::create([
                'class' => 'mekanikal',
                'type' => $item['tipe'],
                'pemeriksaan' => $item['pemeriksaan'],
                'pemeliharaan' => $item['pemliharaan'],
                'perawatan' => $item['perawatan'],
                'title' => $item['title'],
                'url' => $item['url'],
                'locations' => [],
                'problems' => [],
            ]);
        }

        foreach ($slides_arsitektur as $item) {
            BuildingPart::create([
                'class' => 'arsitektur',
                'type' => $item['tipe'],
                'pemeriksaan' => $item['pemeriksaan'],
                'pemeliharaan' => $item['pemliharaan'],
                'perawatan' => $item['perawatan'],
                'title' => $item['title'],
                'url' => $item['url'],
                'locations' => [],
                'problems' => [],
            ]);
        }

        foreach ($slides_struktur as $item) {
            BuildingPart::create([
                'class' => 'struktur',
                'type' => $item['tipe'],
                'pemeriksaan' => $item['pemeriksaan'],
                'pemeliharaan' => $item['pemliharaan'],
                'perawatan' => $item['perawatan'],
                'title' => $item['title'],
                'url' => $item['url'],
                'locations' => [],
                'problems' => [],
            ]);
        }
    }
}
