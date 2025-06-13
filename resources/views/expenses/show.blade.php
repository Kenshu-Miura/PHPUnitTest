<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('支出詳細') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">金額</h3>
                        <p class="mt-1 text-sm text-gray-600">¥{{ number_format($expense->amount) }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">カテゴリー</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $expense->category }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">日付</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $expense->expense_date->format('Y/m/d') }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">メモ</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $expense->description ?? 'なし' }}</p>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <a href="{{ route('expenses.edit', $expense) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        編集
                    </a>

                    <form method="POST" action="{{ route('expenses.destroy', $expense) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500" onclick="return confirm('本当に削除しますか？')">
                            削除
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 