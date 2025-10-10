<?php
// resources/views/categories/index.blade.php - FINAL WORKING VERSION

// Pastikan $categories dikirim dari controller
use App\Http\Controllers\ProductCategoryController;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PawPal - Product Categories</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* CSS Disederhanakan */
        body { font-family: 'Quicksand', sans-serif; }
        @keyframes wobble { 0%, 100% { transform: rotate(0deg); } 15% { transform: rotate(-5deg); } 30% { transform: rotate(3deg); } }
        .wobble-hover:hover { animation: wobble 0.8s ease-in-out; }
        .card-hover:hover { transform: translateY(-8px) scale(1.02); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1); }
        .pawpal-gradient { background: linear-gradient(135deg, #fffcf9 0%, #fef3c7 20%, #fde68a 100%); }
        .coral-gradient { background: linear-gradient(135deg, #fecaca 0%, #fed7aa 100%); }
    </style>
</head>
<body class="min-h-full pawpal-gradient">
    <div class="bg-white/90 backdrop-blur-sm border-b border-orange-100 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <button id="addCategoryBtn" class="coral-gradient text-white px-6 py-2 rounded-full font-medium hover:shadow-lg transition-all duration-300 wobble-hover">
    + Add Category
</button>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold bg-gradient-to-r from-orange-600 to-pink-600 bg-clip-text text-transparent mb-2">Product Categories</h2>
        </div>

        <div id="categoriesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @forelse ($categories as $category)
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 shadow-lg border border-orange-100 card-hover">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-16 h-16 coral-gradient rounded-2xl flex items-center justify-center wobble-hover">
                            <span class="text-3xl">🏷️</span>
                        </div>
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Active</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $category->product_category_name }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ $category->description }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Products: N/A</span>
                        <div class="flex space-x-2">
                            <button onclick="openModal({{ json_encode($category) }})" class="p-2 text-orange-600 hover:bg-orange-100 rounded-xl transition-all duration-300 wobble-hover">✏️</button>
                            <button onclick="deleteCategory({{ $category->id }})" class="p-2 text-red-600 hover:bg-red-100 rounded-xl transition-all duration-300 wobble-hover">🗑️</button>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 col-span-full text-center">No categories found.</p>
            @endforelse
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg overflow-hidden border border-orange-100">
            <div class="px-6 py-4 coral-gradient border-b border-orange-200">
                <h3 class="text-lg font-semibold text-white">All Categories</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Products</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th></tr>
                    </thead>
                    <tbody class="bg-white/50 divide-y divide-gray-200">
                        @foreach ($categories as $category)
                            <tr class="hover:bg-orange-50/50 transition-all duration-300">
                                <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm font-medium text-gray-900">{{ $category->product_category_name }}</div></td>
                                <td class="px-6 py-4"><div class="text-sm text-gray-900">{{ $category->description }}</div></td>
                                <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm text-gray-900">N/A</div></td>
                                <td class="px-6 py-4 whitespace-nowrap"><span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Active</span></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button onclick="openModal({{ json_encode($category) }})" class="text-orange-600 hover:text-orange-900 transition-all duration-300 wobble-hover">Edit</button>
                                        <button onclick="deleteCategory({{ $category->id }})" class="text-red-600 hover:text-red-900 transition-all duration-300 wobble-hover">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="categoryModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 shadow-2xl transform transition-all duration-300 scale-95">
            <h3 id="modalTitle" class="text-2xl font-bold text-gray-800 mb-6">Add New Category</h3>
            <form id="categoryForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                    <input type="text" id="categoryName" class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-orange-400 focus:border-transparent transition-all duration-300" placeholder="e.g., Food & Treats" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="categoryDescription" class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-orange-400 focus:border-transparent transition-all duration-300" rows="3" placeholder="Brief description of the category"></textarea>
                </div>
                <div class="flex space-x-3">
                    <button type="button" id="cancelBtn" class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 rounded-2xl hover:bg-gray-50 transition-all duration-300">Cancel</button>
                    <button type="submit" class="flex-1 coral-gradient text-white px-6 py-3 rounded-2xl hover:shadow-lg transition-all duration-300 wobble-hover">Save Category</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let editingId = null;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // DOM elements
        const categoryModal = document.getElementById('categoryModal');
        const categoryForm = document.getElementById('categoryForm');
        
        // Event listeners
        document.getElementById('addCategoryBtn').addEventListener('click', () => openModal());
        document.getElementById('cancelBtn').addEventListener('click', () => closeModal());
        categoryForm.addEventListener('submit', handleSubmit);
        
        // Modal functions
        function openModal(category = null) {
            editingId = category ? category.id : null;
            document.getElementById('modalTitle').textContent = category ? 'Edit Category' : 'Add New Category';
            
            if (category) {
                // Mengambil data dari kolom DB yang benar untuk mengisi form
                document.getElementById('categoryName').value = category.product_category_name; 
                document.getElementById('categoryDescription').value = category.description;
            } else {
                categoryForm.reset();
            }
            
            categoryModal.classList.remove('hidden');
            categoryModal.classList.add('flex');
            setTimeout(() => {
                categoryModal.querySelector('.bg-white').classList.remove('scale-95');
                categoryModal.querySelector('.bg-white').classList.add('scale-100');
            }, 10);
        }

        function closeModal() {
            categoryModal.querySelector('.bg-white').classList.remove('scale-100');
            categoryModal.querySelector('.bg-white').classList.add('scale-95');
            setTimeout(() => {
                categoryModal.classList.add('hidden');
                categoryModal.classList.remove('flex');
            }, 300);
        }
        
        // FUNGSI CREATE/UPDATE (AJAX)
        function handleSubmit(e) {
            e.preventDefault();
            
            const name = document.getElementById('categoryName').value;
            const description = document.getElementById('categoryDescription').value;
            const url = editingId 
                ? '{{ url('categories') }}/' + editingId 
                : '{{ route('categories.store') }}';

           const data = {
    product_category_name: name,
    description: description,
    _token: csrfToken,
    ...(editingId && { _method: 'PUT' }) 
};

    console.log("DEBUG: URL", url); // 👈 tambahkan ini juga
    console.log("DEBUG: Data", data);
            
            const formData = new FormData();
formData.append('product_category_name', name);
formData.append('description', description);
formData.append('_token', csrfToken);
if (editingId) formData.append('_method', 'PUT');

fetch(url, {
    method: 'POST',
    body: formData
})

            .then(response => {
                if (!response.ok) {
                    return response.json().then(error => { throw error; });
                }
                return response.json();
            })
            .then(data => {
                alert(editingId ? 'Category updated successfully!' : 'Category added successfully!');
                closeModal();
                window.location.reload(); 
            })
            .catch(error => {
                const errorMsg = error.errors ? Object.values(error.errors).flat().join('\n') : error.message;
                alert('An error occurred:\n' + errorMsg);
                console.error('Error submitting form:', error);
            });
        }

        // FUNGSI DELETE (AJAX)
        function deleteCategory(id) {
            if (!confirm('Are you sure you want to delete this category?')) {
                return;
            }

            fetch('{{ url('categories') }}/' + id, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ _method: 'DELETE' })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(error => { throw error; });
                }
                return response.json();
            })
            .then(data => {
                alert('Category deleted successfully!');
                window.location.reload(); 
            })
            .catch(error => {
                alert('An error occurred during deletion.');
                console.error('Error deleting category:', error);
            });
        }
    </script>
</body>
</html>