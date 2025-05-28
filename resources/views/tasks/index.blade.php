<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク管理</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">タスク管理</h1>

        <!-- タスク作成フォーム -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-bold mb-2">タイトル</label>
                    <input type="text" name="title" id="title" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-bold mb-2">説明</label>
                    <textarea name="description" id="description" class="w-full px-3 py-2 border rounded-lg" rows="3"></textarea>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">タスクを追加</button>
            </form>
        </div>

        <!-- タスク一覧 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">タスク一覧</h2>
            @if($tasks->isEmpty())
                <p class="text-gray-500">タスクがありません</p>
            @else
                <div class="space-y-4">
                    @foreach($tasks as $task)
                        <div class="flex items-center justify-between p-4 border rounded-lg {{ $task->is_completed ? 'bg-gray-50' : 'bg-white' }}">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold {{ $task->is_completed ? 'line-through text-gray-500' : '' }}">
                                    {{ $task->title }}
                                </h3>
                                @if($task->description)
                                    <p class="text-gray-600 mt-1">{{ $task->description }}</p>
                                @endif
                            </div>
                            <div class="flex space-x-2">
                                <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 rounded-lg {{ $task->is_completed ? 'bg-gray-500 hover:bg-gray-600' : 'bg-green-500 hover:bg-green-600' }} text-white">
                                        {{ $task->is_completed ? '未完了に戻す' : '完了にする' }}
                                    </button>
                                </form>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('このタスクを削除してもよろしいですか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white">
                                        削除
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</body>
</html> 