<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            支出レポート
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- 年月選択フォーム -->
                    <form method="GET" action="{{ route('expenses.report') }}" class="mb-6">
                        <div class="flex items-center space-x-4">
                            <input type="month" 
                                   name="year_month" 
                                   value="{{ $yearMonth }}" 
                                   class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                表示
                            </button>
                        </div>
                    </form>

                    <!-- 月次合計 -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">月次合計</h3>
                        <div class="text-3xl font-bold text-gray-900">
                            ¥{{ number_format($monthlyTotal) }}
                        </div>
                    </div>

                    <!-- カテゴリー別グラフ -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">カテゴリー別支出</h3>
                        <div class="relative" style="height: 300px;">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>

                    <!-- 過去6ヶ月の推移 -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">過去6ヶ月の推移</h3>
                        <div class="relative" style="height: 300px;">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // デバッグ情報
            console.log('Category Data:', {!! json_encode($categoryTotals) !!});
            console.log('Monthly Data:', {!! json_encode($monthlyTotals) !!});

            // カテゴリー別グラフ
            const categoryCtx = document.getElementById('categoryChart');
            console.log('Category Canvas:', categoryCtx);

            if (!categoryCtx) {
                console.error('Category chart canvas not found');
                return;
            }

            const categoryData = {
                labels: {!! json_encode($categoryTotals->pluck('category')) !!},
                datasets: [{
                    label: '支出金額',
                    data: {!! json_encode($categoryTotals->pluck('total')) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1
                }]
            };

            try {
                new Chart(categoryCtx, {
                    type: 'bar',
                    data: categoryData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return '¥' + value.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error creating category chart:', error);
            }

            // 月次推移グラフ
            const monthlyCtx = document.getElementById('monthlyChart');
            console.log('Monthly Canvas:', monthlyCtx);

            if (!monthlyCtx) {
                console.error('Monthly chart canvas not found');
                return;
            }

            const monthlyData = {
                labels: {!! json_encode($monthlyTotals->pluck('month')) !!},
                datasets: [{
                    label: '月次支出',
                    data: {!! json_encode($monthlyTotals->pluck('total')) !!},
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.1,
                    fill: true
                }]
            };

            try {
                new Chart(monthlyCtx, {
                    type: 'line',
                    data: monthlyData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return '¥' + value.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error creating monthly chart:', error);
            }
        });
    </script>
    @endpush
</x-app-layout> 