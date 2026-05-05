<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KerjaLu - The Premium Gig Economy Platform</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="font-sans antialiased text-gray-900 bg-blue-950 overflow-x-hidden selection:bg-blue-500 selection:text-white">

    <!-- Background Effects -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-600 rounded-full mix-blend-multiply filter blur-[128px] opacity-70 animate-blob"></div>
        <div class="absolute top-[20%] right-[-10%] w-[40%] h-[40%] bg-sky-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-[-20%] left-[20%] w-[40%] h-[40%] bg-blue-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-70 animate-blob animation-delay-4000"></div>
    </div>

    <!-- Navigation -->
    <nav class="relative z-50 w-full px-6 py-6 sm:px-12 flex justify-between items-center backdrop-blur-sm bg-blue-950/50 border-b border-white/10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                <i class="fas fa-bolt text-white text-xl"></i>
            </div>
            <span class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-white tracking-tight">KerjaLu</span>
        </div>

        @if (Route::has('login'))
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-white bg-white/10 hover:bg-white/20 px-5 py-2.5 rounded-full backdrop-blur-md border border-white/10 transition-all shadow-lg hover:shadow-blue-500/20">
                        Enter Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-300 hover:text-white transition-colors">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 px-6 py-2.5 rounded-full shadow-lg shadow-blue-500/30 transition-transform hover:-translate-y-0.5">
                            Join Now
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </nav>

    <!-- Hero Section -->
    <main class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 py-20 lg:py-32 flex flex-col lg:flex-row items-center gap-16">
        
        <!-- Text Content -->
        <div class="w-full lg:w-1/2 text-center lg:text-left">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-500/10 border border-blue-400/30 text-blue-100 font-semibold text-sm mb-8 shadow-inner">
                <span class="flex h-2 w-2 relative">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                </span>
                The Future of Work is Here
            </div>
            
            <h1 class="text-5xl lg:text-7xl font-extrabold text-white leading-tight mb-6 tracking-tight">
                Connect. <br />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-sky-200 to-blue-300">Collaborate.</span> <br />
                Conquer.
            </h1>
            
            <p class="text-lg lg:text-xl text-gray-400 mb-10 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                KerjaLu is the ultimate gig economy platform designed to seamlessly connect top-tier freelancers with innovative employers. Build your portfolio, hire the best talent, and get work done.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-blue-950 font-bold rounded-xl shadow-[0_0_40px_rgba(255,255,255,0.3)] hover:shadow-[0_0_60px_rgba(255,255,255,0.5)] transition-all transform hover:-translate-y-1 text-lg flex items-center justify-center gap-2">
                    Start Hiring <i class="fas fa-arrow-right"></i>
                </a>
                <a href="{{ route('register') }}" class="px-8 py-4 bg-white/5 border border-white/10 hover:bg-white/10 text-white font-bold rounded-xl backdrop-blur-md transition-all transform hover:-translate-y-1 text-lg flex items-center justify-center gap-2">
                    Find Work <i class="fas fa-briefcase"></i>
                </a>
            </div>
            
            <!-- Trust Indicators -->
            <div class="mt-12 pt-8 border-t border-white/10 flex items-center justify-center lg:justify-start gap-8 opacity-70 grayscale">
                <span class="font-bold text-xl tracking-wider text-white">TRUSTED BY</span>
                <i class="fab fa-aws text-3xl text-white"></i>
                <i class="fab fa-stripe text-3xl text-white"></i>
                <i class="fab fa-github text-3xl text-white"></i>
            </div>
        </div>

        <!-- Hero Image -->
        <div class="w-full lg:w-1/2 relative">
            <div class="absolute inset-0 bg-gradient-to-tr from-blue-500 to-sky-400 rounded-3xl filter blur-3xl opacity-30 animate-pulse"></div>
            <div class="relative rounded-3xl overflow-hidden border border-white/10 shadow-2xl glass-effect p-2 bg-white/5 backdrop-blur-xl transform hover:scale-[1.02] transition-transform duration-500">
                <!-- Using the generated image -->
                <img src="{{ asset('images/hero.png') }}" alt="Gig Economy Illustration" class="w-full h-auto rounded-2xl shadow-inner object-cover border border-white/5" />
            </div>
            
            <!-- Floating Elements -->
            <div class="absolute -bottom-6 -left-6 bg-white/10 backdrop-blur-lg border border-white/20 p-4 rounded-2xl shadow-xl flex items-center gap-4 animate-bounce" style="animation-duration: 3s;">
                <div class="w-12 h-12 rounded-full bg-blue-500/20 flex items-center justify-center text-sky-300">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
                <div>
                    <p class="text-white font-bold">Project Approved</p>
                    <p class="text-sm text-gray-400">Just now</p>
                </div>
            </div>
            <div class="absolute -top-6 -right-6 bg-white/10 backdrop-blur-lg border border-white/20 p-4 rounded-2xl shadow-xl flex items-center gap-4 animate-bounce" style="animation-duration: 4s;">
                <div class="w-12 h-12 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-200">
                    <i class="fas fa-wallet text-2xl"></i>
                </div>
                <div>
                    <p class="text-white font-bold">$1,200 Paid</p>
                    <p class="text-sm text-gray-400">Secure escrow</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Features Section -->
    <section class="relative z-10 py-24 bg-blue-950/80 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">How <span class="text-sky-300">KerjaLu</span> Works</h2>
                <p class="text-gray-400 text-lg max-w-2xl mx-auto">A frictionless experience engineered for speed, security, and quality. Whether you're hiring or working, we've got you covered.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white/5 border border-white/10 p-8 rounded-3xl backdrop-blur-md hover:bg-white/10 transition-colors group">
                    <div class="w-16 h-16 rounded-2xl bg-blue-500/20 flex items-center justify-center mb-6 text-sky-300 group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-plus text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">1. Create an Account</h3>
                    <p class="text-gray-400 leading-relaxed">Choose your path. Sign up seamlessly as an Employer looking for talent, or a Freelancer ready to tackle new challenges.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white/5 border border-white/10 p-8 rounded-3xl backdrop-blur-md hover:bg-white/10 transition-colors group">
                    <div class="w-16 h-16 rounded-2xl bg-sky-500/20 flex items-center justify-center mb-6 text-sky-300 group-hover:scale-110 transition-transform">
                        <i class="fas fa-search text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">2. Post or Apply</h3>
                    <p class="text-gray-400 leading-relaxed">Employers post detailed gigs with budgets. Freelancers browse the marketplace and submit custom pitches in one click.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white/5 border border-white/10 p-8 rounded-3xl backdrop-blur-md hover:bg-white/10 transition-colors group">
                    <div class="w-16 h-16 rounded-2xl bg-blue-400/20 flex items-center justify-center mb-6 text-blue-200 group-hover:scale-110 transition-transform">
                        <i class="fas fa-handshake text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">3. Collaborate & Earn</h3>
                    <p class="text-gray-400 leading-relaxed">Employers review applications and accept the best fit. Work begins instantly through our streamlined, role-based dashboard.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="relative z-10 py-8 border-t border-white/10 text-center bg-blue-950">
        <p class="text-gray-500 text-sm">
            &copy; {{ date('Y') }} KerjaLu Platform. Built with Laravel & Tailwind CSS. All rights reserved.
        </p>
    </footer>

    <!-- Add custom keyframes for animation -->
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</body>
</html>
