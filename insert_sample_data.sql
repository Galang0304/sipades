-- Insert sample jenis surat if not exists
INSERT IGNORE INTO jenis_surats (id, nama_surat, kode_surat, template, keterangan, is_active, created_at, updated_at) VALUES
(1, 'Surat Keterangan Domisili', 'SKD', 'Template', 'Domisili', 1, NOW(), NOW()),
(2, 'Surat Keterangan Tidak Mampu', 'SKTM', 'Template', 'Tidak Mampu', 1, NOW(), NOW()),
(3, 'Surat Keterangan Belum Menikah', 'SKBM', 'Template', 'Belum Menikah', 1, NOW(), NOW()),
(4, 'Surat Pindah', 'SP', 'Template', 'Pindah', 1, NOW(), NOW()),
(5, 'Surat Kematian', 'SK', 'Template', 'Kematian', 1, NOW(), NOW()),
(6, 'Surat Izin Usaha', 'SIU', 'Template', 'Izin Usaha', 1, NOW(), NOW()),
(7, 'Surat Keterangan Umum', 'SKU', 'Template', 'Umum', 1, NOW(), NOW()),
(8, 'Surat Keterangan Kelahiran', 'SKK', 'Template', 'Kelahiran', 1, NOW(), NOW());

-- Insert sample pengajuan surat data for statistics
INSERT INTO pengajuan_surats (user_id, jenis_surat_id, nik, keperluan, data_tambahan, status, keterangan_status, tanggal_pengajuan, tanggal_diproses, diproses_oleh, created_at, updated_at) VALUES

-- January 2025 data
(1, 1, '1234567890123456', 'Melamar pekerjaan', '{"keterangan":"Sample data"}', 'Selesai', 'Selesai diproses', '2025-01-05 09:00:00', '2025-01-06 10:00:00', 1, '2025-01-05 09:00:00', '2025-01-06 10:00:00'),
(1, 2, '1234567890123456', 'Mengurus beasiswa', '{"keterangan":"Sample data"}', 'Selesai', 'Selesai diproses', '2025-01-08 10:30:00', '2025-01-09 11:30:00', 1, '2025-01-08 10:30:00', '2025-01-09 11:30:00'),
(1, 3, '1234567890123456', 'Keperluan nikah', '{"keterangan":"Sample data"}', 'Diproses', 'Sedang diproses', '2025-01-12 14:15:00', '2025-01-13 15:15:00', 1, '2025-01-12 14:15:00', '2025-01-13 15:15:00'),
(1, 4, '1234567890123456', 'Pindah domisili', '{"keterangan":"Sample data"}', 'Menunggu', 'Menunggu proses', '2025-01-15 08:45:00', NULL, NULL, '2025-01-15 08:45:00', '2025-01-15 08:45:00'),
(1, 5, '1234567890123456', 'Administrasi', '{"keterangan":"Sample data"}', 'Selesai', 'Selesai diproses', '2025-01-18 11:20:00', '2025-01-19 12:20:00', 1, '2025-01-18 11:20:00', '2025-01-19 12:20:00'),
(1, 6, '1234567890123456', 'Izin usaha', '{"keterangan":"Sample data"}', 'Ditolak', 'Data tidak lengkap', '2025-01-22 13:30:00', '2025-01-23 14:30:00', 1, '2025-01-22 13:30:00', '2025-01-23 14:30:00'),
(1, 7, '1234567890123456', 'Keperluan bank', '{"keterangan":"Sample data"}', 'Selesai', 'Selesai diproses', '2025-01-25 16:10:00', '2025-01-26 17:10:00', 1, '2025-01-25 16:10:00', '2025-01-26 17:10:00'),
(1, 8, '1234567890123456', 'Kelahiran anak', '{"keterangan":"Sample data"}', 'Selesai', 'Selesai diproses', '2025-01-28 09:45:00', '2025-01-29 10:45:00', 1, '2025-01-28 09:45:00', '2025-01-29 10:45:00'),

-- February 2025 data
(1, 1, '1234567890123456', 'Melamar pekerjaan', '{"keterangan":"Sample data"}', 'Selesai', 'Selesai diproses', '2025-02-03 10:00:00', '2025-02-04 11:00:00', 1, '2025-02-03 10:00:00', '2025-02-04 11:00:00'),
(1, 2, '1234567890123456', 'Mengurus BPJS', '{"keterangan":"Sample data"}', 'Selesai', 'Selesai diproses', '2025-02-07 11:30:00', '2025-02-08 12:30:00', 1, '2025-02-07 11:30:00', '2025-02-08 12:30:00'),
(1, 3, '1234567890123456', 'Pendaftaran sekolah', '{"keterangan":"Sample data"}', 'Diproses', 'Sedang diproses', '2025-02-10 14:15:00', '2025-02-11 15:15:00', 1, '2025-02-10 14:15:00', '2025-02-11 15:15:00'),
(1, 4, '1234567890123456', 'Mengurus KTP', '{"keterangan":"Sample data"}', 'Selesai', 'Selesai diproses', '2025-02-14 08:45:00', '2025-02-15 09:45:00', 1, '2025-02-14 08:45:00', '2025-02-15 09:45:00'),
(1, 5, '1234567890123456', 'Keperluan rumah sakit', '{"keterangan":"Sample data"}', 'Menunggu', 'Menunggu proses', '2025-02-18 11:20:00', NULL, NULL, '2025-02-18 11:20:00', '2025-02-18 11:20:00'),
(1, 6, '1234567890123456', 'Mengurus SIM', '{"keterangan":"Sample data"}', 'Selesai', 'Selesai diproses', '2025-02-21 13:30:00', '2025-02-22 14:30:00', 1, '2025-02-21 13:30:00', '2025-02-22 14:30:00'),
(1, 7, '1234567890123456', 'Keperluan asuransi', '{"keterangan":"Sample data"}', 'Selesai', 'Selesai diproses', '2025-02-25 16:10:00', '2025-02-26 17:10:00', 1, '2025-02-25 16:10:00', '2025-02-26 17:10:00'),

-- March 2025 data
(1, 1, '1234567890123456', 'Melamar pekerjaan', '{"keterangan":"Sample data"}', 'Selesai', 'Selesai diproses', '2025-03-02 09:30:00', '2025-03-03 10:30:00', 1, '2025-03-02 09:30:00', '2025-03-03 10:30:00'),
(1, 2, '1234567890123456', 'Mengurus tanah', '{"keterangan":"Sample data"}', 'Diproses', 'Sedang diproses', '2025-03-05 11:45:00', '2025-03-06 12:45:00', 1, '2025-03-05 11:45:00', '2025-03-06 12:45:00'),
(1, 3, '1234567890123456', 'Keperluan hukum', '{"keterangan":"Sample data"}', 'Selesai', 'Selesai diproses', '2025-03-08 14:20:00', '2025-03-09 15:20:00', 1, '2025-03-08 14:20:00', '2025-03-09 15:20:00'),
(1, 4, '1234567890123456', 'Mengurus paspor', '{"keterangan":"Sample data"}', 'Menunggu', 'Menunggu proses', '2025-03-12 08:15:00', NULL, NULL, '2025-03-12 08:15:00', '2025-03-12 08:15:00'),
(1, 5, '1234567890123456', 'Keperluan administrasi', '{"keterangan":"Sample data"}', 'Selesai', 'Selesai diproses', '2025-03-15 10:50:00', '2025-03-16 11:50:00', 1, '2025-03-15 10:50:00', '2025-03-16 11:50:00'),
(1, 6, '1234567890123456', 'Keperluan usaha', '{"keterangan":"Sample data"}', 'Ditolak', 'Dokumen kurang', '2025-03-18 13:25:00', '2025-03-19 14:25:00', 1, '2025-03-18 13:25:00', '2025-03-19 14:25:00'),
(1, 7, '1234567890123456', 'Mengurus bank', '{"keterangan":"Sample data"}', 'Selesai', 'Selesai diproses', '2025-03-22 15:40:00', '2025-03-23 16:40:00', 1, '2025-03-22 15:40:00', '2025-03-23 16:40:00'),
(1, 8, '1234567890123456', 'Pendaftaran sekolah', '{"keterangan":"Sample data"}', 'Selesai', 'Selesai diproses', '2025-03-25 17:15:00', '2025-03-26 18:15:00', 1, '2025-03-25 17:15:00', '2025-03-26 18:15:00'),

-- April 2025 data (more data for better statistics)
(1, 1, '1234567890123456', 'Melamar pekerjaan', '{"keterangan":"Sample data"}', 'Selesai', 'Selesai diproses', '2025-04-02 09:00:00', '2025-04-03 10:00:00', 1, '2025-04-02 09:00:00', '2025-04-03 10:00:00'),
(1, 1, '1234567890123456', 'Melamar pekerjaan', '{"keterangan":"Sample data"}', 'Selesai', 'Selesai diproses', '2025-04-05 10:30:00', '2025-04-06 11:30:00', 1, '2025-04-05 10:30:00', '2025-04-06 11:30:00'),
(1, 2, '1234567890123456', 'Mengurus beasiswa', '{"keterangan":"Sample data"}', 'Selesai', 'Selesai diproses', '2025-04-08 11:45:00', '2025-04-09 12:45:00', 1, '2025-04-08 11:45:00', '2025-04-09 12:45:00'),
(1, 2, '1234567890123456', 'Mengurus beasiswa', '{"keterangan":"Sample data"}', 'Diproses', 'Sedang diproses', '2025-04-12 13:20:00', '2025-04-13 14:20:00', 1, '2025-04-12 13:20:00', '2025-04-13 14:20:00'),
(1, 3, '1234567890123456', 'Keperluan nikah', '{"keterangan":"Sample data"}', 'Selesai', 'Selesai diproses', '2025-04-15 14:35:00', '2025-04-16 15:35:00', 1, '2025-04-15 14:35:00', '2025-04-16 15:35:00'),
(1, 4, '1234567890123456', 'Pindah domisili', '{"keterangan":"Sample data"}', 'Menunggu', 'Menunggu proses', '2025-04-18 15:50:00', NULL, NULL, '2025-04-18 15:50:00', '2025-04-18 15:50:00'),
(1, 5, '1234567890123456', 'Administrasi', '{"keterangan":"Sample data"}', 'Selesai', 'Selesai diproses', '2025-04-22 16:25:00', '2025-04-23 17:25:00', 1, '2025-04-22 16:25:00', '2025-04-23 17:25:00'),
(1, 6, '1234567890123456', 'Izin usaha', '{"keterangan":"Sample data"}', 'Selesai', 'Selesai diproses', '2025-04-25 08:40:00', '2025-04-26 09:40:00', 1, '2025-04-25 08:40:00', '2025-04-26 09:40:00'),
(1, 7, '1234567890123456', 'Keperluan bank', '{"keterangan":"Sample data"}', 'Ditolak', 'Data tidak valid', '2025-04-28 10:15:00', '2025-04-29 11:15:00', 1, '2025-04-28 10:15:00', '2025-04-29 11:15:00');
