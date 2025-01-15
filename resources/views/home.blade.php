@extends('layouts.main')

@section('title', 'MONALISA')

@section('styles')
    <style>
<style>
    :root {
        --primary-color: #2563eb;
        --secondary-color: #3b82f6;
        --accent-color: #60a5fa;
        --success-color: #10b981;
        --background-light: #f8fafc;
        --text-primary: #1e293b;
        --text-secondary: #475569;
    }

    /* Modern Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: var(--background-light);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--accent-color);
        border-radius: 4px;
    }

    /* Enhanced Hero Section */
    .hero-section {
        min-height: 90vh;
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        width: 200%;
        height: 200%;
        background: 
            radial-gradient(circle at 20% 20%, rgba(37, 99, 235, 0.1) 0%, transparent 25%),
            radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.1) 0%, transparent 25%),
            radial-gradient(circle at 50% 50%, rgba(96, 165, 250, 0.05) 0%, transparent 50%);
        animation: rotate 30s linear infinite;
    }

    /* Enhanced Cards */
    .stat-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        border-color: var(--accent-color);
    }

    /* Enhanced Feature Icons */
    .feature-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        color: white;
        font-size: 1.75rem;
        transform: rotate(-5deg);
        transition: transform 0.3s ease;
    }

    .card:hover .feature-icon {
        transform: rotate(0deg) scale(1.1);
    }

    /* Enhanced System Cards */
    .system-card {
        background: white;
        border-radius: 24px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        border: 1px solid rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
    }

    .system-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(59, 130, 246, 0.1));
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .system-card:hover::before {
        opacity: 1;
    }

    .system-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }

    /* Enhanced Sections */
    .section-title {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 2rem;
    }

    .section-subtitle {
        color: var(--text-secondary);
        font-size: 1.1rem;
        max-width: 800px;
        margin: 0 auto 3rem;
        line-height: 1.8;
    }

    /* Enhanced Animations */
    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(2deg); }
    }

    .animate-float {
        animation: float 6s ease-in-out infinite;
    }

    /* Enhanced Icons Grid */
    .icon-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 2.5rem;
        margin: 3rem 0;
    }

    .icon-item {
        text-align: center;
        padding: 1.5rem;
        background: white;
        border-radius: 16px;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .icon-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        border-color: var(--accent-color);
    }

    .icon-item img {
        width: 70px;
        height: 70px;
        margin-bottom: 1.2rem;
        transition: transform 0.3s ease;
    }

    .icon-item:hover img {
        transform: scale(1.1);
    }

    /* Enhanced Buttons */
    .btn-custom {
        padding: 1rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-custom::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0));
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }

    .btn-custom:hover::before {
        transform: translateX(0);
    }

    /* Responsive Improvements */
    @media (max-width: 768px) {
        .hero-section {
            min-height: auto;
            padding: 4rem 0;
        }

        .section-title {
            font-size: 2rem;
        }

        .icon-grid {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    <div class="hero-section d-flex align-items-center py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="display-4 fw-bold mb-4 animate__animated animate__fadeInLeft">
                        MONALISA
                        <span class="d-block text-primary fs-2 mt-2">Monitoring dan Evaluasi Statistik Sektoral</span>
                    </h1>
                    <p class="lead mb-4 animate__animated animate__fadeIn animate__delay-1s">
                        Tingkatkan kualitas data statistik Batam melalui sistem monitoring real-time dan evaluasi yang
                        komprehensif.
                    </p>
                    <div class="animate__animated animate__fadeInUp animate__delay-2s">
                        <a href="{{ url('/epss') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-pill">
                            Mulai Sekarang
                            <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('img/dataa.png') }}" alt="Ilustrasi"
                        class="img-fluid animate-float animate__animated animate__fadeInRight" style="max-width: 80%;">
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Overview -->
    <div class="py-5 bg-white">
        <div class="container">
            <h2 class="text-center mb-5">Statistik Overview</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="stat-card p-4 text-center h-100">
                        <div class="feature-icon mx-auto">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="h5 mb-3">Total Domains</h3>
                        <div class="display-6 text-primary mb-2">5</div>
                        <p class="text-muted">Active domains</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card p-4 text-center h-100">
                        <div class="feature-icon mx-auto">
                            <i class="fas fa-file-upload"></i>
                        </div>
                        <h3 class="h5 mb-3">Total Aspek</h3>
                        <div class="display-6 text-primary mb-2">19</div>
                        <p class="text-muted">Total Aspeks Tracked</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card p-4 text-center h-100">
                        <div class="feature-icon mx-auto">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="h5 mb-3">Total Indicators</h3>
                        <div class="display-6 text-primary mb-2">38</div>
                        <p class="text-muted">Total metrics tracked</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div class="about-section">
        <div class="container">
            <h2 class="text-center mb-5">Tentang Statistik Sektoral dan EPSS</h2>
            <p class="text-center mb-5">
                Statistik Sektoral adalah kumpulan data statistik yang bertujuan memenuhi kebutuhan spesifik kementerian
                atau lembaga pemerintah, baik dilakukan secara mandiri atau bersama dengan BPS. EPSS adalah kerangka kerja
                yang digunakan untuk mengevaluasi proses ini, menjamin kualitas dan efektivitas pengumpulan serta pengolahan
                data statistik sektoral.
            </p>
            <div class="row justify-content-center" data-aos="fade-up">
                <!-- Icon and text pairs go here, repeat this column structure for each icon -->
                <div class="col-6 col-md-2 mb-3">
                    <div class="icon-container d-flex justify-content-center mb-2">
                        <!-- Include your icon image here -->
                        <img src="{{ asset('img/sdi.png') }}" alt="Satu Data Indonesia" class="img-fluid">
                    </div>
                    <p class="text-center icon-text">Satu Data Indonesia</p>
                </div>
                <div class="col-6 col-md-2 mb-3">
                    <div class="icon-container d-flex justify-content-center mb-2">
                        <!-- Include your icon image here -->
                        <img src="{{ asset('img/kd.png') }}" alt="Kualitas Data" class="img-fluid">
                    </div>
                    <p class="text-center icon-text">Kualitas Data</p>
                </div>
                <div class="col-6 col-md-2 mb-3">
                    <div class="icon-container d-flex justify-content-center mb-2">
                        <!-- Include your icon image here -->
                        <img src="{{ asset('img/pbs.png') }}" alt="Proses Bisnis Statistik" class="img-fluid">
                    </div>
                    <p class="text-center icon-text">Proses Bisnis Statistik</p>
                </div>
                <div class="col-6 col-md-2 mb-3">
                    <div class="icon-container d-flex justify-content-center mb-2">
                        <!-- Include your icon image here -->
                        <img src="{{ asset('img/kelembagaan.png') }}" alt="Kelembagaan" class="img-fluid">
                    </div>
                    <p class="text-center icon-text">Kelembagaan</p>
                </div>
                <div class="col-6 col-md-2 mb-3">
                    <div class="icon-container d-flex justify-content-center mb-2">
                        <!-- Include your icon image here -->
                        <img src="{{ asset('img/sn.png') }}" alt="Statistik Nasional" class="img-fluid">
                    </div>
                    <p class="text-center icon-text">Statistik Nasional</p>
                </div>
                <!-- Repeat for other icons -->
            </div>
        </div>
    </div>



    <!-- Features Section -->
    <div class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Fitur Utama</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 h-100 shadow-sm">
                        <div class="card-body p-4">
                            <div class="feature-icon mb-3">
                                <i class="fas fa-upload"></i>
                            </div>
                            <h3 class="h5 mb-3">Upload Data</h3>
                            <p class="text-muted">Upload dan kelola data statistik dengan mudah dan aman</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 h-100 shadow-sm">
                        <div class="card-body p-4">
                            <div class="feature-icon mb-3">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <h3 class="h5 mb-3">Monitoring Real-time</h3>
                            <p class="text-muted">Pantau perkembangan data statistik secara real-time</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 h-100 shadow-sm">
                        <div class="card-body p-4">
                            <div class="feature-icon mb-3">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <h3 class="h5 mb-3">Evaluasi Otomatis</h3>
                            <p class="text-muted">Evaluasi kualitas data dengan sistem penilaian otomatis</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Integrated Systems Section -->
    <div class="integration-section">
        <div class="container">
            <h2 class="text-center mb-5">Sistem Terintegrasi</h2>
            <div class="row g-4">
                <!-- Romantik System -->
                <div class="col-md-6 col-lg-4">
                    <div class="system-card p-4">
                        <div class="system-icon mx-auto">
                            <i class="fas fa-heart fa-2x text-primary"></i>
                        </div>
                        <h3 class="h5 mb-3">Sistem Romantik</h3>
                        <p class="text-muted mb-4">Sistem Romantik digunakan untuk pelaporan dan rekomendasi acara
                            statistik, memastikan semua kegiatan statistik dasar dilaporkan secara tepat.</p>
                        <a href="https://romantik.web.bps.go.id/" target="_blank"
                            class="btn btn-outline-primary rounded-pill px-4">
                            Kunjungi Romantik
                            <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>

                <!-- INDAH System -->
                <div class="col-md-6 col-lg-4">
                    <div class="system-card p-4">
                        <div class="system-icon mx-auto">
                            <i class="fas fa-database fa-2x text-primary"></i>
                        </div>
                        <h3 class="h5 mb-3">Indonesia Data Hub (INDAH)</h3>
                        <p class="text-muted mb-4">Platform one stop collaboration untuk meningkatkan literasi data dan
                            value of statistics serta mendukung interoperabilitas data.</p>
                        <a href="https://indah.bps.go.id/" target="_blank"
                            class="btn btn-outline-primary rounded-pill px-4">
                            Kunjungi INDAH
                            <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Simbatik System -->
                <div class="col-md-6 col-lg-4">
                    <div class="system-card p-4">
                        <div class="system-icon mx-auto">
                            <i class="fas fa-chart-line fa-2x text-primary"></i>
                        </div>
                        <h3 class="h5 mb-3">Sistem Simbatik</h3>
                        <p class="text-muted mb-4">Platform untuk mengunggah dokumen dan indikator EPSS, memudahkan proses
                            dokumentasi dan verifikasi statistik sektoral.</p>
                        <a href="https://epss.web.bps.go.id/home" target="_blank"
                            class="btn btn-outline-primary rounded-pill px-4">
                            Kunjungi Simbatik
                            <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced scroll reveal animation
    const animateElements = document.querySelectorAll('.stat-card, .card, .system-card, .icon-item');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate__animated');
                
                // Randomize animation for more dynamic feel
                const animations = ['animate__fadeInUp', 'animate__fadeInLeft', 'animate__fadeInRight'];
                const randomAnimation = animations[Math.floor(Math.random() * animations.length)];
                
                entry.target.classList.add(randomAnimation);
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '50px'
    });

    animateElements.forEach(element => observer.observe(element));

    // Add smooth scroll behavior
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Add parallax effect to hero section
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.hero-section');
        
        parallaxElements.forEach(element => {
            const speed = 0.5;
            element.style.transform = `translateY(${scrolled * speed}px)`;
        });
    });
});
</script>
@endsection
