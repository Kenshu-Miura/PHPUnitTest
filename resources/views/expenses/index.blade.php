<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>家計簿</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">家計簿</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- 支出登録フォーム -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <form action="{{ route('expenses.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="amount" class="block text-gray-700 font-bold mb-2">金額</label>
                        <input type="number" name="amount" id="amount" step="0.01" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                    <div class="mb-4">
                        <label for="expense_date" class="block text-gray-700 font-bold mb-2">日付</label>
                        <input type="date" name="expense_date" id="expense_date" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                    <div class="mb-4">
                        <label for="category" class="block text-gray-700 font-bold mb-2">カテゴリー</label>
                        <select name="category" id="category" class="w-full px-3 py-2 border rounded-lg" required>
                            <option value="">選択してください</option>
                            <option value="食費">食費</option>
                            <option value="交通費">交通費</option>
                            <option value="日用品">日用品</option>
                            <option value="光熱費">光熱費</option>
                            <option value="その他">その他</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-bold mb-2">説明</label>
                        <input type="text" name="description" id="description" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">支出を登録</button>
            </form>
        </div>

        <!-- 支出一覧 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">支出一覧</h2>
            @if($expenses->isEmpty())
                <p class="text-gray-500">支出記録がありません</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">日付</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">カテゴリー</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">説明</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">金額</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">操作</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($expenses as $expense)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $expense->expense_date->format('Y/m/d') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $expense->category }}</td>
                                    <td class="px-6 py-4">{{ $expense->description }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">¥{{ number_format($expense->amount) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('expenses.destroy', $expense) }}" method="POST" onsubmit="return confirm('この支出を削除してもよろしいですか？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">削除</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</body>
</html> 