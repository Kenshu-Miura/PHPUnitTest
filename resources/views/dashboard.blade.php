<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ダッシュボード') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- 今月の支出概要 -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-4">今月の支出概要</h3>
                            <div class="text-3xl font-bold text-gray-900 mb-2">
                                ¥{{ number_format($monthlyTotal ?? 0) }}
                            </div>
                            <a href="{{ route('expenses.report') }}" class="text-blue-600 hover:text-blue-800">
                                詳細を見る →
                            </a>
                        </div>

                        <!-- クイックアクション -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-4">クイックアクション</h3>
                            <div class="space-y-4">
                                <a href="{{ route('expenses.index') }}" 
                                   class="block w-full text-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                                    支出を登録する
                                </a>
                                <a href="{{ route('expenses.report') }}" 
                                   class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-800 rounded-md hover:bg-gray-200">
                                    レポートを見る
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
