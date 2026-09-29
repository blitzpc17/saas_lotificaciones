<x-app-layout>
    <div class="flex flex-col mb-8">
        <div>
            <h2 class="font-bold text-3xl text-slate-800 dark:text-white leading-tight">
                {{ __('Panel Principal') }}
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">Bienvenido de vuelta. Aquí tienes un resumen del rendimiento de tus ventas.</p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1 -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700 relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-brand-50 dark:bg-brand-900/20 opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Ventas Totales</p>
                    <h3 class="text-3xl font-bold text-slate-900 dark:text-white">${{ number_format($metrics['total_sales'], 2) }}</h3>
                </div>
                <div class="p-3 bg-brand-100 dark:bg-brand-900/50 rounded-xl text-brand-600 dark:text-brand-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700 relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-emerald-50 dark:bg-emerald-900/20 opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Cobros Realizados</p>
                    <h3 class="text-3xl font-bold text-slate-900 dark:text-white">${{ number_format($metrics['total_collected'], 2) }}</h3>
                </div>
                <div class="p-3 bg-emerald-100 dark:bg-emerald-900/50 rounded-xl text-emerald-600 dark:text-emerald-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700 relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-blue-50 dark:bg-blue-900/20 opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Lotes Vendidos</p>
                    <h3 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $metrics['lots_sold'] }}</h3>
                </div>
                <div class="p-3 bg-blue-100 dark:bg-blue-900/50 rounded-xl text-blue-600 dark:text-blue-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700 relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-amber-50 dark:bg-amber-900/20 opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Clientes Activos</p>
                    <h3 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $metrics['total_customers'] }}</h3>
                </div>
                <div class="p-3 bg-amber-100 dark:bg-amber-900/50 rounded-xl text-amber-600 dark:text-amber-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Tables Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Monthly Income Chart -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Ingresos Mensuales</h3>
            <div class="relative h-72 w-full">
                <canvas id="incomeChart"></canvas>
            </div>
        </div>

        @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('incomeChart').getContext('2d');
                
                // Set default font color based on theme
                Chart.defaults.color = document.documentElement.classList.contains('dark') ? '#94a3b8' : '#64748b';
                Chart.defaults.font.family = "'Outfit', sans-serif";

                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(79, 70, 229, 0.5)'); // brand-600
                gradient.addColorStop(1, 'rgba(79, 70, 229, 0.0)');

                const chartData = @json($chartData);

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: 'Ingresos ($)',
                            data: chartData.data,
                            borderColor: '#4f46e5', // brand 600
                            backgroundColor: gradient,
                            borderWidth: 3,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#4f46e5',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: document.documentElement.classList.contains('dark') ? '#1e293b' : '#ffffff',
                                titleColor: document.documentElement.classList.contains('dark') ? '#ffffff' : '#0f172a',
                                bodyColor: document.documentElement.classList.contains('dark') ? '#cbd5e1' : '#475569',
                                borderColor: document.documentElement.classList.contains('dark') ? '#334155' : '#e2e8f0',
                                borderWidth: 1,
                                padding: 10,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed.y !== null) {
                                            label += new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(context.parsed.y);
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)',
                                    drawBorder: false,
                                },
                                ticks: {
                                    callback: function(value, index, values) {
                                        if (value >= 1000) {
                                            return '$' + value / 1000 + 'k';
                                        }
                                        return '$' + value;
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false,
                                }
                            }
                        }
                    }
                });

                // Listen for dark mode changes to update chart colors
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.attributeName === "class") {
                            const isDark = document.documentElement.classList.contains('dark');
                            const chart = Chart.getChart("incomeChart");
                            if (chart) {
                                chart.options.scales.y.grid.color = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';
                                chart.options.plugins.tooltip.backgroundColor = isDark ? '#1e293b' : '#ffffff';
                                chart.options.plugins.tooltip.titleColor = isDark ? '#ffffff' : '#0f172a';
                                chart.options.plugins.tooltip.bodyColor = isDark ? '#cbd5e1' : '#475569';
                                chart.options.plugins.tooltip.borderColor = isDark ? '#334155' : '#e2e8f0';
                                Chart.defaults.color = isDark ? '#94a3b8' : '#64748b';
                                chart.update();
                            }
                        }
                    });
                });

                observer.observe(document.documentElement, { attributes: true });
            });
        </script>
        @endpush

        <!-- Recent Payments -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Últimos Pagos</h3>
                <a href="{{ route('payments.index') }}" class="text-sm text-brand-600 dark:text-brand-400 hover:text-brand-800 dark:hover:text-brand-300 font-medium">Ver todos</a>
            </div>
            <div class="space-y-4">
                @forelse($metrics['recent_payments'] as $payment)
                    <div class="flex items-center p-3 hover:bg-slate-50 dark:hover:bg-slate-700/50 rounded-xl transition-colors">
                        <div class="h-10 w-10 rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-3 flex-1 overflow-hidden">
                            <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">{{ $payment->contract->customer->first_name }} {{ $payment->contract->customer->last_name }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 truncate">Mz.{{ $payment->contract->lot->block }} Lt.{{ $payment->contract->lot->lot_number }}</p>
                        </div>
                        <div class="ml-3 flex-shrink-0 text-right">
                            <p class="text-sm font-bold text-emerald-600 dark:text-emerald-400">+${{ number_format($payment->amount, 2) }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ \Carbon\Carbon::parse($payment->payment_date)->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Aún no hay pagos registrados.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
