<x-filament::page>
    <div class="space-y-8">
        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <x-filament::card>
                <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Domains</div>
                    <div class="p-2 bg-primary-50 dark:bg-primary-900 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-500" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-3xl font-bold">{{ count($domains) }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Active domains</div>
                </div>
            </x-filament::card>

            <x-filament::card>
                <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Average Score</div>
                    <div class="p-2 bg-success-50 dark:bg-success-900 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success-500" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-3xl font-bold">
                        {{ number_format(collect($domains)->flatMap(fn($domain) => collect($domain['indicators'])->pluck('value'))->average(), 1) }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Out of 5.0</div>
                </div>
            </x-filament::card>

            <x-filament::card>
                <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Indicators</div>
                    <div class="p-2 bg-warning-50 dark:bg-warning-900 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-warning-500" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd"
                                d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-3xl font-bold">
                        {{ collect($domains)->sum(fn($domain) => count($domain['indicators'])) }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-4">Total metrics tracked</div>
                </div>
            </x-filament::card>
        </div>

        {{-- Spider Charts --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mt-6 mb-6 bg-gray-100 dark:bg-gray-800">
            @foreach ($domains as $domain)
                <x-filament::card>
                    <h2 class="text-lg font-medium mb-4 text-black dark:text-white">{{ $domain['domain'] }}</h2>
                    <div class="text-gray-500 dark:text-gray-400 bg-gray-200 dark:bg-gray-800"
                        id="chart-{{ $loop->index }}" style="height: 400px;">
                    </div>
                </x-filament::card>
            @endforeach
        </div>



    </div>

    {{-- Include ApexCharts --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            const domains = @json($domains);
            const isDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

            // Function to split long indicator names into arrays
            function splitIntoArray(name, wordsPerLine = 3) {
                const words = name.split(' ');
                const lines = [];
                for (let i = 0; i < words.length; i += wordsPerLine) {
                    lines.push(words.slice(i, i + wordsPerLine).join(' '));
                }
                return lines; // Return as an array for multiline labels
            }

            domains.forEach((domain, index) => {
                const categories = domain.indicators.map((indicator, i) => {
                    // Logic for domain "Statistik Nasional"
                    if (domain.domain === "Statistik Nasional") {
                        // Split all indicators into arrays of 3 words each
                        return splitIntoArray(indicator.name, 4);
                    } else {
                        // For other domains, do not split the first indicator; split the rest
                        return i === 0 ? indicator.name : splitIntoArray(indicator.name, 3);
                    }
                });

                const options = {
                    plotOptions: {
                        radar: {
                            polygons: {
                                strokeColor: '#e8e8e8',
                                fill: {
                                    colors: ['#f8f8f8', '#fff']
                                }
                            }
                        }
                    },
                    series: [{
                        name: 'Score',
                        data: domain.indicators.map(i => i.value)
                    }],
                    chart: {
                        height: 600, // Chart height
                        type: 'radar',
                        toolbar: {
                            show: true,
                            tools: {
                                download: true,
                                selection: false,
                                zoom: false,
                                zoomin: false,
                                zoomout: false,
                                pan: false,
                                reset: false
                            }
                        },
                        dropShadow: {
                            enabled: true,
                            blur: 1,
                            left: 1,
                            top: 1
                        },
                    },
                    stroke: {
                        width: 2,
                        curve: 'smooth'
                    },
                    fill: {
                        opacity: 0.3,
                        colors: ['#00E396']
                    },
                    markers: {
                        size: 5,
                        hover: {
                            size: 8
                        }
                    },
                    xaxis: {
                        categories: categories, // Updated categories logic
                        labels: {
                            style: {
                                fontSize: '12px',
                                fontWeight: 800,
                                color: isDarkMode ? '#9CA3AF' :
                                    '#6B7280' // Tailwind color for text-gray-500
                            }
                        }
                    },

                    yaxis: {
                        min: 0,
                        max: 7, // Set the maximum to 7 for better spacing
                        tickAmount: 7, // Ensure there are 7 ticks (0-7)
                        labels: {
                            formatter: function(value) {
                                // Display values within 0-5 only
                                return value > 5 ? '' : value.toFixed(1);
                            },
                            style: {
                                fontSize: '11px', // Increase font size for y-axis labels
                                fontWeight: 600, // Optional: Make it bold for better visibility
                                color: '#6B7280' // Tailwind color for text-gray-500
                            }
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function(value) {
                                return value.toFixed(1) + ' / 5.0';
                            }
                        }
                    },
                    theme: {
                        palette: 'palette1', // Optional: Adjust the chart palette if needed
                    }
                };

                const chart = new ApexCharts(document.querySelector(`#chart-${index}`), options);
                chart.render();
            });
        });
    </script>




    {{-- <style>
        .apexcharts-title-text {
            fill: var(--tw-text-gray-500);
        }

        .apexcharts-xaxis text {
            fill: var(--tw-text-gray-500);
        }

        .dark .apexcharts-title-text {
            fill: var(--tw-text-gray-400);
        }

        .dark .apexcharts-xaxis text {
            fill: var(--tw-text-gray-400);
        }
    </style> --}}





</x-filament::page>
